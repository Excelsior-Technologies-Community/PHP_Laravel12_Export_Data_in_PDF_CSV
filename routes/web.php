<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/students',
    [StudentController::class, 'index']
)->name('students.index');


/*
|--------------------------------------------------------------------------
| Create
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
| Delete Single Student
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
| Export All / Filtered
|--------------------------------------------------------------------------
*/

Route::get(
    '/students/export-csv',
    [StudentController::class, 'exportCSV']
)->name('students.csv');

Route::get(
    '/students/export-pdf',
    [StudentController::class, 'exportPDF']
)->name('students.pdf');


/*
|--------------------------------------------------------------------------
| Export Selected
|--------------------------------------------------------------------------
*/

Route::post(
    '/students/export-selected-csv',
    [StudentController::class, 'exportSelectedCSV']
)->name('students.selected.csv');

Route::post(
    '/students/export-selected-pdf',
    [StudentController::class, 'exportSelectedPDF']
)->name('students.selected.pdf');