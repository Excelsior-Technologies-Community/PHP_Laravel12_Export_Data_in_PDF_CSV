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

        $query = Student::query();

        /*
        |--------------------------------------------------------------------------
        | Search by name or email
        |--------------------------------------------------------------------------
        */

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $students = $query
            ->orderBy('id', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalStudents = Student::count();

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

        $latestStudent = Student::latest('created_at')->first();

        return view('students.index', compact(
            'students',
            'search',
            'totalStudents',
            'studentsToday',
            'studentsThisWeek',
            'latestStudent'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Store New Student
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student added successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Update Student
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $student->update($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
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
            ->with('success', 'Student deleted successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Bulk Delete Students
    |--------------------------------------------------------------------------
    */

    public function bulkDelete(Request $request)
    {
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
                $count . ' student(s) deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Export All / Filtered Students as CSV
    |--------------------------------------------------------------------------
    */

    public function exportCSV(Request $request)
    {
        $search = $request->input('search', '');

        return Excel::download(
            new StudentsExport([], $search),
            'students.csv'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Export All / Filtered Students as PDF
    |--------------------------------------------------------------------------
    */

    public function exportPDF(Request $request)
    {
        $search = $request->input('search', '');

        $query = Student::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $students = $query
            ->orderBy('id', 'asc')
            ->get();

        $pdf = Pdf::loadView(
            'students.pdf',
            compact('students', 'search')
        );

        return $pdf->download('students.pdf');
    }


    /*
    |--------------------------------------------------------------------------
    | Export Selected Students as CSV
    |--------------------------------------------------------------------------
    */

    public function exportSelectedCSV(Request $request)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'integer|exists:students,id',
        ]);

        return Excel::download(
            new StudentsExport($validated['student_ids']),
            'selected-students.csv'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Export Selected Students as PDF
    |--------------------------------------------------------------------------
    */

    public function exportSelectedPDF(Request $request)
    {
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

        $pdf = Pdf::loadView(
            'students.pdf',
            compact('students', 'search')
        );

        return $pdf->download('selected-students.pdf');
    }
}