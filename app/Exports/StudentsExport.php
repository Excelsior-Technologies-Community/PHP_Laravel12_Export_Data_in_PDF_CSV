<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected array $studentIds;

    protected string $search;

    protected string $status;

    protected string $fromDate;

    protected string $toDate;

    protected string $sort;

    protected string $direction;

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct(
        array $studentIds = [],
        string $search = '',
        string $status = '',
        string $fromDate = '',
        string $toDate = '',
        string $sort = 'id',
        string $direction = 'asc'
    ) {
        $this->studentIds = $studentIds;
        $this->search = $search;
        $this->status = $status;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->sort = $sort;
        $this->direction = $direction;
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
        | Search
        |--------------------------------------------------------------------------
        */

        if (!empty($this->search)) {
            $search = $this->search;

            $query->where(function ($q) use ($search) {

                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $this->status,
                ['active', 'inactive'],
                true
            )
        ) {
            $query->where(
                'status',
                $this->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | From Date
        |--------------------------------------------------------------------------
        */

        if (!empty($this->fromDate)) {
            $query->whereDate(
                'created_at',
                '>=',
                $this->fromDate
            );
        }

        /*
        |--------------------------------------------------------------------------
        | To Date
        |--------------------------------------------------------------------------
        */

        if (!empty($this->toDate)) {
            $query->whereDate(
                'created_at',
                '<=',
                $this->toDate
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Allowed Sorting Columns
        |--------------------------------------------------------------------------
        */

        $allowedSorts = [
            'id',
            'name',
            'email',
            'created_at',
            'status',
        ];

        if (!in_array($this->sort, $allowedSorts, true)) {
            $this->sort = 'id';
        }

        /*
        |--------------------------------------------------------------------------
        | Allowed Direction
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $this->direction,
            ['asc', 'desc'],
            true
        )) {
            $this->direction = 'asc';
        }

        /*
        |--------------------------------------------------------------------------
        | Return Data
        |--------------------------------------------------------------------------
        */

        return $query
            ->select(
                'id',
                'name',
                'email',
                'status',
                'created_at'
            )
            ->orderBy(
                $this->sort,
                $this->direction
            )
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
            'Status',
            'Created At',
        ];
    }
}