<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    // Fetch data for CSV export
    public function collection()
    {
        return Student::select('id','name','email','created_at')->get();
    }

    // Define CSV column headings
    public function headings(): array
    {
        return ['ID','Name','Email','Created At'];
    }
}
