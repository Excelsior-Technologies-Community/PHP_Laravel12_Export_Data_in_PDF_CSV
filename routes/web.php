<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

// Show students page
Route::get('/students', [StudentController::class,'index']);

// Store student
Route::post('/students/store', [StudentController::class,'store'])->name('students.store');

// Delete student
Route::delete('/students/delete/{id}', [StudentController::class,'destroy'])->name('students.delete');

// Export CSV
Route::get('/students/export-csv', [StudentController::class,'exportCSV'])->name('students.csv');

// Export PDF
Route::get('/students/export-pdf', [StudentController::class,'exportPDF'])->name('students.pdf');
