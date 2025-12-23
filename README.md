# PHP_Laravel12_Export_Data_in_PDF_CSV

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel">
  <img src="https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge&logo=php">
  <img src="https://img.shields.io/badge/CSV-Export-success?style=for-the-badge">
  <img src="https://img.shields.io/badge/PDF-Export-red?style=for-the-badge">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql">
</p>

---

##  Overview

This project is a **Student CRUD application built in Laravel 12** that allows:

- Creating and deleting students
- Exporting student data to **CSV**
- Exporting student data to **PDF**
- Simple Blade-based UI
- Clean MVC structure

---

##  Features

- Laravel 12
- Student CRUD (Create, Read, Delete)
- CSV Export using **maatwebsite/excel**
- PDF Export using **barryvdh/laravel-dompdf**
- Blade Views
- MySQL Database
- Beginner friendly

---

##  Folder Structure

```text
student-crud/
│
├── app/
│   ├── Exports/
│   │   └── StudentsExport.php
│   ├── Http/
│   │   └── Controllers/
│   │       └── StudentController.php
│   └── Models/
│       └── Student.php
│
├── database/
│   └── migrations/
│       └── xxxx_create_students_table.php
│
├── resources/
│   └── views/
│       └── students/
│           ├── index.blade.php
│           └── pdf.blade.php
│
├── routes/
│   └── web.php
│
├── .env
├── composer.json
├── artisan
└── README.md
```

---

##  STEP 1: Installation

```bash
composer create-project laravel/laravel student-crud
```

---

##  STEP 2: Database Setup

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=export
DB_USERNAME=root
DB_PASSWORD=
```

Create database in phpMyAdmin:

```
export
```

---

##  STEP 3: Install Required Packages

```bash
composer require maatwebsite/excel

composer require barryvdh/laravel-dompdf
```

---

##  STEP 4: Model + Migration

```bash
php artisan make:model Student -m
```

```php
Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->timestamps();
});
```

Run migration:

```bash
php artisan migrate
```

---

##  STEP 5: Student Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'email'];
}
```

---

##  STEP 6: Export Class (CSV)

```bash
php artisan make:export StudentsExport
```

```php
<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Student::select('id','name','email','created_at')->get();
    }

    public function headings(): array
    {
        return ['ID','Name','Email','Created At'];
    }
}
```

---

##  STEP 7: Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('id','asc')->get();
        return view('students.index', compact('students'));
    }

    public function store(Request $request)
    {
        Student::create($request->only('name','email'));
        return back();
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return back();
    }

    public function exportCSV()
    {
        return Excel::download(new StudentsExport, 'students.csv');
    }

    public function exportPDF()
    {
        $students = Student::all();
        $pdf = Pdf::loadView('students.pdf', compact('students'));
        return $pdf->download('students.pdf');
    }
}
```

---

##  STEP 8: Routes

```php
use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class,'index']);
Route::post('/students/store', [StudentController::class,'store'])->name('students.store');
Route::delete('/students/delete/{id}', [StudentController::class,'destroy'])->name('students.delete');
Route::get('/students/export-csv', [StudentController::class,'exportCSV'])->name('students.csv');
Route::get('/students/export-pdf', [StudentController::class,'exportPDF'])->name('students.pdf');
```

---

##  STEP 9: index.blade.php

```html
<!DOCTYPE html>
<html>
<head>
    <title>Student Data</title>
</head>
<body>

<h2>🎓 Student Data</h2>

<form method="POST" action="{{ route('students.store') }}">
    @csrf
    <input name="name" placeholder="Name" required>
    <input name="email" placeholder="Email" required>
    <button>Add</button>
</form>

<br>

<a href="{{ route('students.csv') }}">⬇ Export CSV</a>
<a href="{{ route('students.pdf') }}">📄 Export PDF</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>

    @foreach($students as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->name }}</td>
        <td>{{ $s->email }}</td>
        <td>
            <form method="POST" action="{{ route('students.delete',$s->id) }}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Delete this student?')">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</body>
</html>
```

---

##  STEP 10: pdf.blade.php

```html
<!DOCTYPE html>
<html>
<head>
    <title>Students List</title>
</head>
<body>

<h2 style="text-align:center;">Students List</h2>

<table width="100%" border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
    </tr>

    @foreach($students as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->name }}</td>
        <td>{{ $s->email }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
```

---

##  STEP 11: Run Project

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000/students
```
##  Screen Shot

Index Page:

<img width="1103" height="528" alt="Screenshot 2025-12-23 120635" src="https://github.com/user-attachments/assets/e328be17-5ed7-4d92-a110-3a5b701becbc" />

CSV:-

<img width="464" height="172" alt="Screenshot 2025-12-23 114559" src="https://github.com/user-attachments/assets/b03efa2e-9edd-4448-9368-eedf7d3d8a4c" />

PDF:-

<img width="823" height="398" alt="Screenshot 2025-12-23 114610" src="https://github.com/user-attachments/assets/16ba82e9-5fdb-4809-83e6-0837290bcc40" />
