<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected array $studentIds;

    protected string $search;

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct(
        array $studentIds = [],
        string $search = ''
    ) {
        $this->studentIds = $studentIds;
        $this->search = $search;
    }


    /*
    |--------------------------------------------------------------------------
    | Get Collection
    |--------------------------------------------------------------------------
    */

    public function collection()
    {
        $query = Student::query();

        /*
        |--------------------------------------------------------------------------
        | Selected Students
        |--------------------------------------------------------------------------
        */

        if (!empty($this->studentIds)) {
            $query->whereIn('id', $this->studentIds);
        }


        /*
        |--------------------------------------------------------------------------
        | Search Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where(
                    'name',
                    'like',
                    '%' . $this->search . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $this->search . '%'
                );
            });
        }


        return $query
            ->select(
                'id',
                'name',
                'email',
                'created_at'
            )
            ->orderBy('id', 'asc')
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | CSV Headings
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Created At'
        ];
    }
}