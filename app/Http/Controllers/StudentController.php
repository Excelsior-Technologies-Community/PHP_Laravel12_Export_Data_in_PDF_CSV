<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class StudentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display Students
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $status = $request->input(
            'status',
            ''
        );

        $fromDate = $request->input(
            'from_date',
            ''
        );

        $toDate = $request->input(
            'to_date',
            ''
        );

        $sort = $request->input(
            'sort',
            'id'
        );

        $direction = $request->input(
            'direction',
            'asc'
        );

        $perPage = (int) $request->input(
            'per_page',
            5
        );

        /*
        |--------------------------------------------------------------------------
        | Allowed Values
        |--------------------------------------------------------------------------
        */

        $allowedSorts = [
            'id',
            'name',
            'email',
            'created_at',
            'status',
        ];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        if (!in_array(
            $direction,
            ['asc', 'desc'],
            true
        )) {
            $direction = 'asc';
        }

        $allowedPerPage = [
            5,
            10,
            25,
            50,
        ];

        if (!in_array(
            $perPage,
            $allowedPerPage,
            true
        )) {
            $perPage = 5;
        }

        /*
        |--------------------------------------------------------------------------
        | Student Query
        |--------------------------------------------------------------------------
        */

        $query = Student::query();

        /*
        |--------------------------------------------------------------------------
        | Search ID / Name / Email
        |--------------------------------------------------------------------------
        */

        if (!empty($search)) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'id',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $search . '%'
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $status,
                ['active', 'inactive'],
                true
            )
        ) {
            $query->where(
                'status',
                $status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | From Date
        |--------------------------------------------------------------------------
        */

        if (!empty($fromDate)) {

            $query->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        /*
        |--------------------------------------------------------------------------
        | To Date
        |--------------------------------------------------------------------------
        */

        if (!empty($toDate)) {

            $query->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $students = $query
            ->orderBy(
                $sort,
                $direction
            )
            ->paginate($perPage)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalStudents = Student::count();

        $activeStudents = Student::where(
            'status',
            'active'
        )->count();

        $inactiveStudents = Student::where(
            'status',
            'inactive'
        )->count();

        $studentsToday = Student::whereDate(
            'created_at',
            today()
        )->count();

        $studentsThisWeek = Student::whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )->count();

        $latestStudent = Student::latest(
            'created_at'
        )->first();

        $searchSuggestions = Student::query()
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return view(
            'students.index',
            compact(
                'students',
                'search',
                'status',
                'fromDate',
                'toDate',
                'sort',
                'direction',
                'perPage',
                'totalStudents',
                'activeStudents',
                'inactiveStudents',
                'studentsToday',
                'studentsThisWeek',
                'latestStudent',
                'searchSuggestions'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:students,email',
            ],
        ]);

        $validated['status'] = 'active';

        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with(
                'success',
                'Student added successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:students,email,' . $student->id,
            ],
        ]);

        $student->update($validated);

        return redirect()
            ->route('students.index')
            ->with(
                'success',
                'Student updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Change Status
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        Request $request,
        $id
    ) {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $student->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Student status updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Delete
    |--------------------------------------------------------------------------
    */

    public function bulkDelete(
        Request $request
    ) {
        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'integer|exists:students,id',
        ]);

        $count = Student::whereIn(
            'id',
            $validated['student_ids']
        )->delete();

        return redirect()
            ->route('students.index')
            ->with(
                'success',
                $count .
                ' student(s) deleted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Status Update
    |--------------------------------------------------------------------------
    */

    public function bulkStatus(
        Request $request
    ) {
        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',

            'student_ids.*' => [
                'integer',
                'exists:students,id',
            ],

            'status' => 'required|in:active,inactive',
        ]);

        $count = Student::whereIn(
            'id',
            $validated['student_ids']
        )->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('students.index')
            ->with(
                'success',
                $count .
                ' student(s) status updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Single Student
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        return redirect()
            ->route('students.index')
            ->with(
                'success',
                'Student deleted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CSV Export
    |--------------------------------------------------------------------------
    */

    public function exportCSV(
        Request $request
    ) {
        return Excel::download(
            new StudentsExport(
                [],
                $request->input('search', ''),
                $request->input('status', ''),
                $request->input('from_date', ''),
                $request->input('to_date', ''),
                $request->input('sort', 'id'),
                $request->input('direction', 'asc')
            ),
            'students.csv'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PDF Export
    |--------------------------------------------------------------------------
    */

    public function exportPDF(
        Request $request
    ) {
        $search = $request->input(
            'search',
            ''
        );

        $status = $request->input(
            'status',
            ''
        );

        $fromDate = $request->input(
            'from_date',
            ''
        );

        $toDate = $request->input(
            'to_date',
            ''
        );

        $sort = $request->input(
            'sort',
            'id'
        );

        $direction = $request->input(
            'direction',
            'asc'
        );

        $query = Student::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (!empty($search)) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'id',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $search . '%'
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $status,
                ['active', 'inactive'],
                true
            )
        ) {
            $query->where(
                'status',
                $status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        if (!empty($fromDate)) {

            $query->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if (!empty($toDate)) {

            $query->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $allowedSorts = [
            'id',
            'name',
            'email',
            'created_at',
            'status',
        ];

        if (!in_array(
            $sort,
            $allowedSorts,
            true
        )) {
            $sort = 'id';
        }

        if (!in_array(
            $direction,
            ['asc', 'desc'],
            true
        )) {
            $direction = 'asc';
        }

        $students = $query
            ->orderBy(
                $sort,
                $direction
            )
            ->get();

        $pdf = Pdf::loadView(
            'students.pdf',
            compact(
                'students',
                'search',
                'status',
                'fromDate',
                'toDate',
                'sort',
                'direction'
            )
        );

        return $pdf->download(
            'students.pdf'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Selected CSV
    |--------------------------------------------------------------------------
    */

    public function exportSelectedCSV(
        Request $request
    ) {
        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'integer|exists:students,id',
        ]);

        return Excel::download(
            new StudentsExport(
                $validated['student_ids']
            ),
            'selected-students.csv'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Selected PDF
    |--------------------------------------------------------------------------
    */

    public function exportSelectedPDF(
        Request $request
    ) {
        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'integer|exists:students,id',
        ]);

        $students = Student::whereIn(
            'id',
            $validated['student_ids']
        )
            ->orderBy('id', 'asc')
            ->get();

        $search = '';

        $status = '';

        $fromDate = '';

        $toDate = '';

        $sort = 'id';

        $direction = 'asc';

        $pdf = Pdf::loadView(
            'students.pdf',
            compact(
                'students',
                'search',
                'status',
                'fromDate',
                'toDate',
                'sort',
                'direction'
            )
        );

        return $pdf->download(
            'selected-students.pdf'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Selected Print Report
    |--------------------------------------------------------------------------
    */

    public function printSelectedReport(
        Request $request
    ) {
        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'integer|exists:students,id',
        ]);

        $students = Student::whereIn(
            'id',
            $validated['student_ids']
        )
            ->orderBy('id', 'asc')
            ->get();

        return view('students.print', [
            'students' => $students,
            'search' => '',
            'status' => '',
            'fromDate' => '',
            'toDate' => '',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Print Report
    |--------------------------------------------------------------------------
    */

    public function printReport(
        Request $request
    ) {
        $search = $request->input(
            'search',
            ''
        );

        $status = $request->input(
            'status',
            ''
        );

        $fromDate = $request->input(
            'from_date',
            ''
        );

        $toDate = $request->input(
            'to_date',
            ''
        );

        $sort = $request->input(
            'sort',
            'id'
        );

        $direction = $request->input(
            'direction',
            'asc'
        );

        $query = Student::query();

        if (!empty($search)) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'id',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $search . '%'
                );

            });
        }

        if (
            in_array(
                $status,
                ['active', 'inactive'],
                true
            )
        ) {
            $query->where(
                'status',
                $status
            );
        }

        if (!empty($fromDate)) {

            $query->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if (!empty($toDate)) {

            $query->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $allowedSorts = [
            'id',
            'name',
            'email',
            'created_at',
            'status',
        ];

        if (!in_array(
            $sort,
            $allowedSorts,
            true
        )) {
            $sort = 'id';
        }

        if (!in_array(
            $direction,
            ['asc', 'desc'],
            true
        )) {
            $direction = 'asc';
        }

        $students = $query
            ->orderBy(
                $sort,
                $direction
            )
            ->get();

        return view(
            'students.print',
            compact(
                'students',
                'search',
                'status',
                'fromDate',
                'toDate',
                'sort',
                'direction'
            )
        );
    }
}