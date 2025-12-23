<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class StudentController extends Controller
{
    // Show students list page
    public function index()
    {
        $students = Student::orderBy('id', 'asc')->get();
        return view('students.index', compact('students'));
    }

    // Store new student
    public function store(Request $request)
    {
        Student::create($request->only('name','email'));
        return back();
    }

    // Delete student
    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return back();
    }

    // Export students as CSV
    public function exportCSV()
    {
        return Excel::download(new StudentsExport, 'students.csv');
    }

    // Export students as PDF
    public function exportPDF()
    {
        $students = Student::all();
        $pdf = Pdf::loadView('students.pdf', compact('students'));
        return $pdf->download('students.pdf');
    }
}
