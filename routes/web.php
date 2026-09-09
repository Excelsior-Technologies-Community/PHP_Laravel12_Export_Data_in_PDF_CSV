<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


/*
|--------------------------------------------------------------------------
| Student List
|--------------------------------------------------------------------------
*/

Route::get(
    '/students',
    [StudentController::class, 'index']
)->name('students.index');


/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
*/

Route::post(
    '/students/store',
    [StudentController::class, 'store']
)->name('students.store');


/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/

Route::put(
    '/students/update/{id}',
    [StudentController::class, 'update']
)->name('students.update');


/*
|--------------------------------------------------------------------------
| Delete
|--------------------------------------------------------------------------
*/

Route::delete(
    '/students/delete/{id}',
    [StudentController::class, 'destroy']
)->name('students.delete');


/*
|--------------------------------------------------------------------------
| Bulk Delete
|--------------------------------------------------------------------------
*/

Route::delete(
    '/students/bulk-delete',
    [StudentController::class, 'bulkDelete']
)->name('students.bulkDelete');


/*
|--------------------------------------------------------------------------
| Student Status
|--------------------------------------------------------------------------
*/

Route::put(
    '/students/status/{id}',
    [StudentController::class, 'updateStatus']
)->name('students.status');


/*
|--------------------------------------------------------------------------
| Bulk Status
|--------------------------------------------------------------------------
*/

Route::put(
    '/students/bulk-status',
    [StudentController::class, 'bulkStatus']
)->name('students.bulkStatus');


/*
|--------------------------------------------------------------------------
| CSV Export
|--------------------------------------------------------------------------
*/

Route::get(
    '/students/export-csv',
    [StudentController::class, 'exportCSV']
)->name('students.csv');


/*
|--------------------------------------------------------------------------
| PDF Export
|--------------------------------------------------------------------------
*/

Route::get(
    '/students/export-pdf',
    [StudentController::class, 'exportPDF']
)->name('students.pdf');


/*
|--------------------------------------------------------------------------
| Selected CSV
|--------------------------------------------------------------------------
*/

Route::post(
    '/students/export-selected-csv',
    [StudentController::class, 'exportSelectedCSV']
)->name('students.selected.csv');


/*
|--------------------------------------------------------------------------
| Selected PDF
|--------------------------------------------------------------------------
*/

Route::post(
    '/students/export-selected-pdf',
    [StudentController::class, 'exportSelectedPDF']
)->name('students.selected.pdf');


/*
|--------------------------------------------------------------------------
| Print Report
|--------------------------------------------------------------------------
*/

Route::get(
    '/students/print',
    [StudentController::class, 'printReport']
)->name('students.print');