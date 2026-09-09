<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Student Data Management</title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 30px;
            margin: 0;
            color: #333;
        }


        .container {
            max-width: 1150px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }


        h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #1f2937;
        }


        /* =====================================================
           Statistics
        ===================================================== */

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }


        .stat-card {
            padding: 18px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }


        .stat-title {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 8px;
        }


        .stat-value {
            font-size: 25px;
            font-weight: bold;
            color: #1e293b;
        }


        .latest-name {
            font-size: 18px;
            font-weight: bold;
            word-break: break-word;
        }


        /* =====================================================
           Alerts
        ===================================================== */

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }


        .success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }


        .error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }


        .error ul {
            margin: 5px 0 0 20px;
        }


        /* =====================================================
           Add Student
        ===================================================== */

        .add-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }


        .add-form input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
        }


        .add-form input:focus {
            border-color: #2563eb;
        }


        .add-form button {
            width: auto;
            min-width: 130px;
            padding: 11px 18px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }


        .add-form button:hover {
            background: #1d4ed8;
        }


        /* =====================================================
           Search
        ===================================================== */

        .search-section {
            padding: 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            margin-bottom: 20px;
        }


        .search-form {
            display: flex;
            gap: 10px;
        }


        .search-form input {
            flex: 1;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
        }


        .search-btn {
            background: #2563eb;
            padding: 10px 16px;
        }


        .search-btn:hover {
            background: #1d4ed8;
        }


        .clear-btn {
            background: #64748b;
            text-decoration: none;
            color: white;
            padding: 10px 16px;
            border-radius: 5px;
        }


        .clear-btn:hover {
            background: #475569;
        }


        /* =====================================================
           Buttons
        ===================================================== */

        button {
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }


        button:hover {
            opacity: 0.9;
        }


        .csv {
            background: #16a34a;
        }


        .pdf {
            background: #dc2626;
        }


        .selected-csv {
            background: #15803d;
        }


        .selected-pdf {
            background: #b91c1c;
        }


        .edit-btn {
            background: #f59e0b;
            padding: 7px 11px;
            font-size: 13px;
        }


        .edit-btn:hover {
            background: #d97706;
        }


        .delete-btn {
            background: #dc2626;
            padding: 7px 11px;
            font-size: 13px;
        }


        .delete-btn:hover {
            background: #991b1b;
        }


        .bulk-delete-btn {
            background: #7f1d1d;
            padding: 9px 14px;
            font-size: 14px;
        }


        .bulk-delete-btn:hover {
            background: #450a0a;
        }


        /* =====================================================
           Export Section
        ===================================================== */

        .export-section {
            margin-bottom: 20px;
        }


        .export-title {
            font-weight: bold;
            margin-bottom: 10px;
        }


        .export-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }


        .export-buttons a,
        .export-buttons button {
            text-decoration: none;
            padding: 9px 14px;
            font-size: 14px;
        }


        .selected-count {
            margin-top: 10px;
            font-size: 14px;
            color: #475569;
        }


        /* =====================================================
           Bulk Actions
        ===================================================== */

        .bulk-action-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 15px;
            margin-bottom: 15px;
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 7px;
        }


        .bulk-info {
            color: #9a3412;
            font-size: 14px;
        }


        /* =====================================================
           Table
        ===================================================== */

        .table-wrapper {
            overflow-x: auto;
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }


        table th,
        table td {
            border: 1px solid #e2e8f0;
            padding: 11px;
            text-align: left;
        }


        table th {
            background: #f1f5f9;
            font-weight: bold;
        }


        table tr:nth-child(even) {
            background: #f8fafc;
        }


        table tr:hover {
            background: #f1f5f9;
        }


        .checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }


        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }


        /* =====================================================
           Empty State
        ===================================================== */

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }


        /* =====================================================
           Edit Modal
        ===================================================== */

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            padding: 20px;
        }


        .modal-content {
            width: 100%;
            max-width: 500px;
            background: #fff;
            margin: 7% auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }


        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }


        .modal-header h3 {
            margin: 0;
            color: #1f2937;
        }


        .close-btn {
            background: transparent;
            color: #64748b;
            font-size: 25px;
            padding: 0;
        }


        .close-btn:hover {
            color: #dc2626;
        }


        .edit-form-group {
            margin-bottom: 15px;
        }


        .edit-form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: bold;
            color: #334155;
        }


        .edit-form-group input {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            font-size: 14px;
        }


        .edit-form-group input:focus {
            outline: none;
            border-color: #2563eb;
        }


        .update-btn {
            width: 100%;
            background: #2563eb;
            padding: 11px;
            font-size: 14px;
            font-weight: bold;
        }


        .update-btn:hover {
            background: #1d4ed8;
        }


        /* =====================================================
           Responsive
        ===================================================== */

        @media (max-width: 850px) {

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }


            .add-form {
                grid-template-columns: 1fr;
            }


            .add-form button {
                width: 100%;
            }


            .search-form {
                flex-direction: column;
            }


            .search-form button,
            .clear-btn {
                width: 100%;
                text-align: center;
            }


            .bulk-action-section {
                flex-direction: column;
                align-items: stretch;
            }


            .bulk-delete-btn {
                width: 100%;
            }

        }


        @media (max-width: 500px) {

            body {
                padding: 15px;
            }


            .container {
                padding: 15px;
            }


            .stats {
                grid-template-columns: 1fr;
            }


            .export-buttons {
                flex-direction: column;
            }


            .export-buttons a,
            .export-buttons button {
                width: 100%;
                text-align: center;
            }


            .action-buttons {
                flex-direction: column;
            }


            .action-buttons button,
            .action-buttons form {
                width: 100%;
            }


            .action-buttons form button {
                width: 100%;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <h2>🎓 Student Data Management</h2>


    <!-- =====================================================
         Success Message
    ====================================================== -->

    @if(session('success'))

        <div class="alert success">
            {{ session('success') }}
        </div>

    @endif


    <!-- =====================================================
         Validation Errors
    ====================================================== -->

    @if($errors->any())

        <div class="alert error">

            <strong>Please fix the following errors:</strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- =====================================================
         Statistics
    ====================================================== -->

    <div class="stats">


        <div class="stat-card">

            <div class="stat-title">
                Total Students
            </div>

            <div class="stat-value">
                {{ $totalStudents }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-title">
                Added Today
            </div>

            <div class="stat-value">
                {{ $studentsToday }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-title">
                Added This Week
            </div>

            <div class="stat-value">
                {{ $studentsThisWeek }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-title">
                Latest Student
            </div>

            @if($latestStudent)

                <div class="latest-name">
                    {{ $latestStudent->name }}
                </div>

            @else

                <div class="latest-name">
                    No students
                </div>

            @endif

        </div>


    </div>


    <!-- =====================================================
         Add Student
    ====================================================== -->

    <form
        method="POST"
        action="{{ route('students.store') }}"
        class="add-form">

        @csrf

        <input
            type="text"
            name="name"
            placeholder="Student Name"
            value="{{ old('name') }}"
            required>


        <input
            type="email"
            name="email"
            placeholder="Student Email"
            value="{{ old('email') }}"
            required>


        <button type="submit">
            ➕ Add Student
        </button>

    </form>


    <!-- =====================================================
         Search
    ====================================================== -->

    <div class="search-section">

        <div class="export-title">
            🔎 Search Students
        </div>


        <form
            method="GET"
            action="{{ route('students.index') }}"
            class="search-form">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Search by name or email...">


            <button
                type="submit"
                class="search-btn">

                Search

            </button>


            @if(!empty($search))

                <a
                    href="{{ route('students.index') }}"
                    class="clear-btn">

                    Clear

                </a>

            @endif

        </form>


        @if(!empty($search))

            <div class="selected-count">

                Search results for
                <strong>"{{ $search }}"</strong>:
                {{ $students->count() }} student(s)

            </div>

        @endif

    </div>


    <!-- =====================================================
         Export
    ====================================================== -->

    <div class="export-section">

        <div class="export-title">
            📥 Export Data
        </div>


        <div class="export-buttons">


            <a
                href="{{ route('students.csv', ['search' => $search]) }}"
                class="csv">

                ⬇ Export
                {{ !empty($search) ? 'Filtered ' : '' }}
                CSV

            </a>


            <a
                href="{{ route('students.pdf', ['search' => $search]) }}"
                class="pdf">

                📄 Export
                {{ !empty($search) ? 'Filtered ' : '' }}
                PDF

            </a>


            <button
                type="submit"
                form="selected-export-form"
                name="export_type"
                value="csv"
                class="selected-csv">

                ☑ Export Selected CSV

            </button>


            <button
                type="submit"
                form="selected-export-form"
                name="export_type"
                value="pdf"
                class="selected-pdf">

                ☑ Export Selected PDF

            </button>


        </div>


        <div class="selected-count">

            Selected Students:
            <strong id="selectedCount">0</strong>

        </div>

    </div>


    <!-- =====================================================
         Bulk Delete
    ====================================================== -->

    <div class="bulk-action-section">

        <div class="bulk-info">

            🗑️
            <strong id="bulkSelectedCount">0</strong>
            student(s) selected for bulk action.

        </div>


        <form
            method="POST"
            action="{{ route('students.bulkDelete') }}"
            id="bulk-delete-form">

            @csrf

            @method('DELETE')

            <div id="bulkDeleteInputs"></div>


            <button
                type="submit"
                class="bulk-delete-btn">

                🗑 Delete Selected Students

            </button>

        </form>

    </div>


    <!-- =====================================================
         Selected Export Form
    ====================================================== -->

    <form
        method="POST"
        id="selected-export-form">

        @csrf

        <div id="selectedInputs"></div>

    </form>


    <!-- =====================================================
         Students Table
    ====================================================== -->

    <div class="table-wrapper">

        <table>

            <thead>

            <tr>

                <th style="width: 50px;">

                    <input
                        type="checkbox"
                        id="selectAll"
                        class="checkbox">

                </th>

                <th>ID</th>

                <th>Name</th>

                <th>Email</th>

                <th>Created At</th>

                <th>Action</th>

            </tr>

            </thead>


            <tbody>


            @forelse($students as $s)


                <tr>


                    <td>

                        <input
                            type="checkbox"
                            class="student-checkbox checkbox"
                            value="{{ $s->id }}">

                    </td>


                    <td>
                        {{ $s->id }}
                    </td>


                    <td>
                        {{ $s->name }}
                    </td>


                    <td>
                        {{ $s->email }}
                    </td>


                    <td>
                        {{ $s->created_at->format('d M Y, h:i A') }}
                    </td>


                    <td>

                        <div class="action-buttons">


                            <!-- Edit -->

                            <button
                                type="button"
                                class="edit-btn"
                                onclick="openEditModal(
                                    {{ $s->id }},
                                    @js($s->name),
                                    @js($s->email)
                                )">

                                ✏️ Edit

                            </button>


                            <!-- Delete -->

                            <form
                                method="POST"
                                action="{{ route('students.delete', $s->id) }}"
                                onsubmit="return confirm(
                                    'Are you sure you want to delete this student?'
                                );">

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="delete-btn">

                                    🗑 Delete

                                </button>

                            </form>


                        </div>

                    </td>


                </tr>


            @empty


                <tr>

                    <td
                        colspan="6"
                        class="empty">


                        @if(!empty($search))

                            🔎 No students found for
                            <strong>"{{ $search }}"</strong>.

                        @else

                            🎓 No students available.

                        @endif


                    </td>

                </tr>


            @endforelse


            </tbody>

        </table>

    </div>


</div>


<!-- =========================================================
     Edit Student Modal
========================================================= -->

<div
    id="editModal"
    class="modal">


    <div class="modal-content">


        <div class="modal-header">

            <h3>
                ✏️ Edit Student
            </h3>


            <button
                type="button"
                class="close-btn"
                onclick="closeEditModal()">

                &times;

            </button>

        </div>


        <form
            method="POST"
            id="editStudentForm">

            @csrf

            @method('PUT')


            <div class="edit-form-group">

                <label>
                    Student Name
                </label>

                <input
                    type="text"
                    name="name"
                    id="editName"
                    required>

            </div>


            <div class="edit-form-group">

                <label>
                    Student Email
                </label>

                <input
                    type="email"
                    name="email"
                    id="editEmail"
                    required>

            </div>


            <button
                type="submit"
                class="update-btn">

                💾 Update Student

            </button>


        </form>

    </div>

</div>


<!-- =========================================================
     JavaScript
========================================================= -->

<script>


    /*
    |--------------------------------------------------------------------------
    | Selection Elements
    |--------------------------------------------------------------------------
    */

    const selectAll =
        document.getElementById('selectAll');

    const checkboxes =
        document.querySelectorAll('.student-checkbox');

    const selectedCount =
        document.getElementById('selectedCount');

    const bulkSelectedCount =
        document.getElementById('bulkSelectedCount');

    const selectedInputs =
        document.getElementById('selectedInputs');

    const bulkDeleteInputs =
        document.getElementById('bulkDeleteInputs');

    const exportForm =
        document.getElementById('selected-export-form');

    const bulkDeleteForm =
        document.getElementById('bulk-delete-form');


    /*
    |--------------------------------------------------------------------------
    | Get Selected Students
    |--------------------------------------------------------------------------
    */

    function getSelectedStudents()
    {
        return Array.from(
            document.querySelectorAll(
                '.student-checkbox:checked'
            )
        ).map(function (checkbox) {

            return checkbox.value;

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Update Selection Count
    |--------------------------------------------------------------------------
    */

    function updateSelectedCount()
    {
        const selected =
            getSelectedStudents();


        selectedCount.textContent =
            selected.length;


        bulkSelectedCount.textContent =
            selected.length;


        /*
        |--------------------------------------------------------------------------
        | Select All State
        |--------------------------------------------------------------------------
        */

        if (checkboxes.length > 0) {

            selectAll.checked =
                selected.length === checkboxes.length;

        } else {

            selectAll.checked = false;

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Select All
    |--------------------------------------------------------------------------
    */

    selectAll.addEventListener(
        'change',
        function () {

            checkboxes.forEach(
                function (checkbox) {

                    checkbox.checked =
                        selectAll.checked;

                }
            );


            updateSelectedCount();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Individual Checkbox
    |--------------------------------------------------------------------------
    */

    checkboxes.forEach(
        function (checkbox) {

            checkbox.addEventListener(
                'change',
                updateSelectedCount
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Selected CSV/PDF Export
    |--------------------------------------------------------------------------
    */

    exportForm.addEventListener(
        'submit',
        function (event) {


            const selected =
                getSelectedStudents();


            if (selected.length === 0) {

                event.preventDefault();

                alert(
                    'Please select at least one student to export.'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Export Type
            |--------------------------------------------------------------------------
            */

            const exportType =
                event.submitter.value;


            if (exportType === 'csv') {

                exportForm.action =
                    "{{ route('students.selected.csv') }}";

            } else {

                exportForm.action =
                    "{{ route('students.selected.pdf') }}";

            }


            /*
            |--------------------------------------------------------------------------
            | Clear Existing Inputs
            |--------------------------------------------------------------------------
            */

            selectedInputs.innerHTML = '';


            /*
            |--------------------------------------------------------------------------
            | Add Selected IDs
            |--------------------------------------------------------------------------
            */

            selected.forEach(
                function (id) {

                    const input =
                        document.createElement('input');

                    input.type = 'hidden';

                    input.name = 'student_ids[]';

                    input.value = id;

                    selectedInputs.appendChild(input);

                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Bulk Delete
    |--------------------------------------------------------------------------
    */

    bulkDeleteForm.addEventListener(
        'submit',
        function (event) {


            const selected =
                getSelectedStudents();


            /*
            |--------------------------------------------------------------------------
            | Nothing Selected
            |--------------------------------------------------------------------------
            */

            if (selected.length === 0) {

                event.preventDefault();

                alert(
                    'Please select at least one student to delete.'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Confirmation
            |--------------------------------------------------------------------------
            */

            const confirmed =
                confirm(
                    'Are you sure you want to delete ' +
                    selected.length +
                    ' selected student(s)? This action cannot be undone.'
                );


            if (!confirmed) {

                event.preventDefault();

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Remove Old Inputs
            |--------------------------------------------------------------------------
            */

            bulkDeleteInputs.innerHTML = '';


            /*
            |--------------------------------------------------------------------------
            | Add Student IDs
            |--------------------------------------------------------------------------
            */

            selected.forEach(
                function (id) {

                    const input =
                        document.createElement('input');

                    input.type = 'hidden';

                    input.name = 'student_ids[]';

                    input.value = id;

                    bulkDeleteInputs.appendChild(input);

                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Edit Student Modal
    |--------------------------------------------------------------------------
    */

    function openEditModal(
        id,
        name,
        email
    ) {

        const modal =
            document.getElementById('editModal');

        const form =
            document.getElementById('editStudentForm');

        const nameInput =
            document.getElementById('editName');

        const emailInput =
            document.getElementById('editEmail');


        /*
        |--------------------------------------------------------------------------
        | Set Form Action
        |--------------------------------------------------------------------------
        */

        form.action =
            "{{ url('/students/update') }}/" + id;


        /*
        |--------------------------------------------------------------------------
        | Fill Existing Data
        |--------------------------------------------------------------------------
        */

        nameInput.value =
            name;

        emailInput.value =
            email;


        /*
        |--------------------------------------------------------------------------
        | Show Modal
        |--------------------------------------------------------------------------
        */

        modal.style.display =
            'block';

    }


    /*
    |--------------------------------------------------------------------------
    | Close Edit Modal
    |--------------------------------------------------------------------------
    */

    function closeEditModal()
    {
        document.getElementById(
            'editModal'
        ).style.display = 'none';
    }


    /*
    |--------------------------------------------------------------------------
    | Close Modal When Clicking Outside
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'click',
        function (event) {

            const modal =
                document.getElementById('editModal');


            if (event.target === modal) {

                closeEditModal();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initial Count
    |--------------------------------------------------------------------------
    */

    updateSelectedCount();

</script>


</body>

</html>