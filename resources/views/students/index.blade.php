<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

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
            max-width: 1250px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
        }

        h2 {
            margin-top: 0;
            color: #1f2937;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
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
            font-size: 24px;
            font-weight: bold;
        }

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
        }

        .add-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 10px;
            margin-bottom: 20px;
        }

        input,
        select {
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            font-size: 14px;
        }

        button,
        .btn {
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px 14px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .primary {
            background: #2563eb;
        }

        .green {
            background: #16a34a;
        }

        .red {
            background: #dc2626;
        }

        .orange {
            background: #f59e0b;
        }

        .gray {
            background: #64748b;
        }

        .dark-red {
            background: #7f1d1d;
        }

        .purple {
            background: #7c3aed;
        }

        .filter-section {
            padding: 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 10px;
            align-items: end;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .export-section {
            margin-bottom: 20px;
        }

        .export-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #e2e8f0;
            padding: 11px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .sort-link {
            color: #1e293b;
            text-decoration: none;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .checkbox {
            width: 18px;
            height: 18px;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            text-decoration: none;
            color: #334155;
        }

        .pagination .active-page {
            background: #2563eb;
            color: white;
        }

        .bulk-section {
            display: flex;
            gap: 10px;
            align-items: center;
            margin: 15px 0;
            padding: 12px;
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 7px;
            flex-wrap: wrap;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,.6);
            z-index: 1000;
            padding: 20px;
        }

        .modal-content {
            max-width: 500px;
            margin: 8% auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        .modal-content input {
            width: 100%;
            margin-bottom: 15px;
        }

        .modal-content label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        @media(max-width:1000px) {

            .stats {
                grid-template-columns: repeat(2,1fr);
            }

            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media(max-width:600px) {

            body {
                padding: 15px;
            }

            .container {
                padding: 15px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .add-form,
            .filter-grid {
                grid-template-columns: 1fr;
            }

            .export-buttons,
            .action-buttons {
                flex-direction: column;
            }

        }

        @media print {

            .no-print {
                display: none !important;
            }

            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                max-width: 100%;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h2>🎓 Student Data Management</h2>

    @if(session('success'))

        <div class="alert success">
            {{ session('success') }}
        </div>

    @endif

    @if($errors->any())

        <div class="alert error">

            <strong>Please fix the following:</strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

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
                Active
            </div>

            <div class="stat-value">
                {{ $activeStudents }}
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-title">
                Inactive
            </div>

            <div class="stat-value">
                {{ $inactiveStudents }}
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
                This Week
            </div>

            <div class="stat-value">
                {{ $studentsThisWeek }}
            </div>

        </div>

    </div>


    <!-- =====================================================
         Add Student
    ====================================================== -->

    <form
        method="POST"
        action="{{ route('students.store') }}"
        class="add-form no-print"
    >

        @csrf

        <input
            type="text"
            name="name"
            placeholder="Student Name"
            value="{{ old('name') }}"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Student Email"
            value="{{ old('email') }}"
            required
        >

        <button
            type="submit"
            class="primary"
        >
            ➕ Add Student
        </button>

    </form>


    <!-- =====================================================
         Filters
    ====================================================== -->

    <div class="filter-section no-print">

        <strong>🔎 Student Filters</strong>

        <form
            method="GET"
            action="{{ route('students.index') }}"
        >

            <div class="filter-grid">

                <div class="field">

                    <label>
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="ID, name or email"
                    >

                </div>

                <div class="field">

                    <label>
                        Status
                    </label>

                    <select name="status">

                        <option value="">
                            All
                        </option>

                        <option
                            value="active"
                            {{ $status === 'active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            {{ $status === 'inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>

                    </select>

                </div>

                <div class="field">

                    <label>
                        From Date
                    </label>

                    <input
                        type="date"
                        name="from_date"
                        value="{{ $fromDate }}"
                    >

                </div>

                <div class="field">

                    <label>
                        To Date
                    </label>

                    <input
                        type="date"
                        name="to_date"
                        value="{{ $toDate }}"
                    >

                </div>

                <div class="field">

                    <label>
                        Per Page
                    </label>

                    <select name="per_page">

                        @foreach([5,10,25,50] as $number)

                            <option
                                value="{{ $number }}"
                                {{ $perPage == $number ? 'selected' : '' }}
                            >
                                {{ $number }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            <div class="filter-actions">

                <button
                    type="submit"
                    class="primary"
                >
                    🔍 Apply Filters
                </button>

                <a
                    href="{{ route('students.index') }}"
                    class="btn gray"
                >
                    ✖ Clear Filters
                </a>

            </div>

        </form>

    </div>


    <!-- =====================================================
         Export
    ====================================================== -->

    <div class="export-section no-print">

        <strong>📥 Export / Report</strong>

        <div class="export-buttons">

            <a
                class="btn green"
                href="{{ route('students.csv', request()->query()) }}"
            >
                ⬇ CSV
            </a>

            <a
                class="btn red"
                href="{{ route('students.pdf', request()->query()) }}"
            >
                📄 PDF
            </a>

            <a
                class="btn purple"
                target="_blank"
                href="{{ route('students.print', request()->query()) }}"
            >
                🖨 Print
            </a>

            <button
                type="submit"
                form="selected-export-form"
                name="export_type"
                value="csv"
                class="green"
            >
                ☑ Selected CSV
            </button>

            <button
                type="submit"
                form="selected-export-form"
                name="export_type"
                value="pdf"
                class="red"
            >
                ☑ Selected PDF
            </button>

        </div>

        <div style="margin-top:10px">

            Selected:
            <strong id="selectedCount">0</strong>

        </div>

    </div>


    <!-- =====================================================
         Bulk Status + Delete
    ====================================================== -->

    <div class="bulk-section no-print">

        <strong>
            Selected:
            <span id="bulkSelectedCount">0</span>
        </strong>


        <form
            method="POST"
            action="{{ route('students.bulkStatus') }}"
            id="bulk-status-form"
        >

            @csrf

            @method('PUT')

            <div id="bulkStatusInputs"></div>

            <input
                type="hidden"
                name="status"
                id="bulkStatusValue"
            >

            <button
                type="button"
                class="btn green"
                onclick="bulkStatus('active')"
            >
                🟢 Activate
            </button>

            <button
                type="button"
                class="btn orange"
                onclick="bulkStatus('inactive')"
            >
                🔴 Deactivate
            </button>

        </form>


        <form
            method="POST"
            action="{{ route('students.bulkDelete') }}"
            id="bulk-delete-form"
        >

            @csrf

            @method('DELETE')

            <div id="bulkDeleteInputs"></div>

            <button
                type="submit"
                class="btn dark-red"
            >
                🗑 Bulk Delete
            </button>

        </form>

    </div>


    <!-- =====================================================
         Selected Export Form
    ====================================================== -->

    <form
        method="POST"
        id="selected-export-form"
    >

        @csrf

        <div id="selectedInputs"></div>

    </form>


    <!-- =====================================================
         Student Table
    ====================================================== -->

    <div class="table-wrapper">

        <table>

            <thead>

            <tr>

                <th class="no-print">

                    <input
                        type="checkbox"
                        id="selectAll"
                        class="checkbox"
                    >

                </th>

                <th>

                    <a
                        class="sort-link"
                        href="{{ route('students.index', array_merge(request()->query(), [
                            'sort' => 'id',
                            'direction' => ($sort === 'id' && $direction === 'asc') ? 'desc' : 'asc'
                        ])) }}"
                    >
                        ID
                        @if($sort === 'id')
                            {{ $direction === 'asc' ? '↑' : '↓' }}
                        @endif
                    </a>

                </th>

                <th>

                    <a
                        class="sort-link"
                        href="{{ route('students.index', array_merge(request()->query(), [
                            'sort' => 'name',
                            'direction' => ($sort === 'name' && $direction === 'asc') ? 'desc' : 'asc'
                        ])) }}"
                    >
                        Name

                        @if($sort === 'name')
                            {{ $direction === 'asc' ? '↑' : '↓' }}
                        @endif

                    </a>

                </th>

                <th>

                    <a
                        class="sort-link"
                        href="{{ route('students.index', array_merge(request()->query(), [
                            'sort' => 'email',
                            'direction' => ($sort === 'email' && $direction === 'asc') ? 'desc' : 'asc'
                        ])) }}"
                    >
                        Email

                        @if($sort === 'email')
                            {{ $direction === 'asc' ? '↑' : '↓' }}
                        @endif

                    </a>

                </th>

                <th>

                    <a
                        class="sort-link"
                        href="{{ route('students.index', array_merge(request()->query(), [
                            'sort' => 'status',
                            'direction' => ($sort === 'status' && $direction === 'asc') ? 'desc' : 'asc'
                        ])) }}"
                    >
                        Status

                        @if($sort === 'status')
                            {{ $direction === 'asc' ? '↑' : '↓' }}
                        @endif

                    </a>

                </th>

                <th>

                    <a
                        class="sort-link"
                        href="{{ route('students.index', array_merge(request()->query(), [
                            'sort' => 'created_at',
                            'direction' => ($sort === 'created_at' && $direction === 'asc') ? 'desc' : 'asc'
                        ])) }}"
                    >
                        Created At

                        @if($sort === 'created_at')
                            {{ $direction === 'asc' ? '↑' : '↓' }}
                        @endif

                    </a>

                </th>

                <th class="no-print">
                    Action
                </th>

            </tr>

            </thead>


            <tbody>

            @forelse($students as $s)

                <tr>

                    <td class="no-print">

                        <input
                            type="checkbox"
                            class="student-checkbox checkbox"
                            value="{{ $s->id }}"
                        >

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

                        <span
                            class="badge {{ $s->status === 'active' ? 'active' : 'inactive' }}"
                        >
                            {{ ucfirst($s->status) }}
                        </span>

                    </td>

                    <td>
                        {{ $s->created_at->format('d M Y, h:i A') }}
                    </td>

                    <td class="no-print">

                        <div class="action-buttons">

                            <!-- Edit -->

                            <button
                                type="button"
                                class="orange"
                                onclick="openEditModal(
                                    {{ $s->id }},
                                    @js($s->name),
                                    @js($s->email)
                                )"
                            >
                                ✏ Edit
                            </button>


                            <!-- Status -->

                            <form
                                method="POST"
                                action="{{ route('students.status', $s->id) }}"
                            >

                                @csrf

                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="{{ $s->status === 'active' ? 'inactive' : 'active' }}"
                                >

                                <button
                                    type="submit"
                                    class="{{ $s->status === 'active' ? 'orange' : 'green' }}"
                                >
                                    {{ $s->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>

                            </form>


                            <!-- Delete -->

                            <form
                                method="POST"
                                action="{{ route('students.delete', $s->id) }}"
                                onsubmit="return confirm('Delete this student?')"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="red"
                                >
                                    🗑 Delete
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="empty"
                    >
                        🎓 No students found.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    <!-- =====================================================
         Pagination
    ====================================================== -->

    <div class="pagination no-print">

        @if($students->onFirstPage())

            <span>
                Previous
            </span>

        @else

            <a href="{{ $students->previousPageUrl() }}">
                Previous
            </a>

        @endif


        @foreach($students->getUrlRange(
            max(1, $students->currentPage() - 2),
            min($students->lastPage(), $students->currentPage() + 2)
        ) as $page => $url)

            @if($page == $students->currentPage())

                <span class="active-page">
                    {{ $page }}
                </span>

            @else

                <a href="{{ $url }}">
                    {{ $page }}
                </a>

            @endif

        @endforeach


        @if($students->hasMorePages())

            <a href="{{ $students->nextPageUrl() }}">
                Next
            </a>

        @else

            <span>
                Next
            </span>

        @endif

    </div>


    <div
        style="margin-top:10px"
        class="no-print"
    >

        Showing
        <strong>{{ $students->firstItem() ?? 0 }}</strong>
        -
        <strong>{{ $students->lastItem() ?? 0 }}</strong>
        of
        <strong>{{ $students->total() }}</strong>
        students

    </div>

</div>


<!-- =========================================================
     Edit Modal
========================================================= -->

<div
    id="editModal"
    class="modal"
>

    <div class="modal-content">

        <h3>
            ✏ Edit Student
        </h3>

        <form
            method="POST"
            id="editStudentForm"
        >

            @csrf

            @method('PUT')

            <label>
                Name
            </label>

            <input
                type="text"
                name="name"
                id="editName"
                required
            >

            <label>
                Email
            </label>

            <input
                type="email"
                name="email"
                id="editEmail"
                required
            >

            <button
                type="submit"
                class="primary"
            >
                💾 Update
            </button>

            <button
                type="button"
                class="gray"
                onclick="closeEditModal()"
            >
                Cancel
            </button>

        </form>

    </div>

</div>


<script>

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

    const bulkStatusInputs =
        document.getElementById('bulkStatusInputs');

    const bulkStatusValue =
        document.getElementById('bulkStatusValue');

    const exportForm =
        document.getElementById('selected-export-form');


    /*
    |--------------------------------------------------------------------------
    | Get Selected IDs
    |--------------------------------------------------------------------------
    */

    function getSelectedStudents()
    {
        return Array.from(
            document.querySelectorAll(
                '.student-checkbox:checked'
            )
        ).map(
            checkbox => checkbox.value
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Counts
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
                checkbox => {
                    checkbox.checked =
                        selectAll.checked;
                }
            );

            updateSelectedCount();
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Individual Selection
    |--------------------------------------------------------------------------
    */

    checkboxes.forEach(
        checkbox => {

            checkbox.addEventListener(
                'change',
                updateSelectedCount
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Selected Export
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
                    'Please select at least one student.'
                );

                return;
            }

            const exportType =
                event.submitter.value;

            if (exportType === 'csv') {

                exportForm.action =
                    "{{ route('students.selected.csv') }}";

            } else {

                exportForm.action =
                    "{{ route('students.selected.pdf') }}";

            }

            selectedInputs.innerHTML = '';

            selected.forEach(
                id => {

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
    | Bulk Status
    |--------------------------------------------------------------------------
    */

    function bulkStatus(status)
    {
        const selected =
            getSelectedStudents();

        if (selected.length === 0) {

            alert(
                'Please select at least one student.'
            );

            return;
        }

        const action =
            status === 'active'
                ? 'activate'
                : 'deactivate';

        if (!confirm(
            'Are you sure you want to ' +
            action +
            ' ' +
            selected.length +
            ' student(s)?'
        )) {
            return;
        }

        bulkStatusInputs.innerHTML = '';

        selected.forEach(
            id => {

                const input =
                    document.createElement('input');

                input.type = 'hidden';

                input.name = 'student_ids[]';

                input.value = id;

                bulkStatusInputs.appendChild(input);

            }
        );

        bulkStatusValue.value =
            status;

        document
            .getElementById('bulk-status-form')
            .submit();
    }


    /*
    |--------------------------------------------------------------------------
    | Bulk Delete
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('bulk-delete-form')
        .addEventListener(
            'submit',
            function (event) {

                const selected =
                    getSelectedStudents();

                if (selected.length === 0) {

                    event.preventDefault();

                    alert(
                        'Please select at least one student.'
                    );

                    return;
                }

                if (!confirm(
                    'Delete ' +
                    selected.length +
                    ' selected student(s)?'
                )) {

                    event.preventDefault();

                    return;
                }

                bulkDeleteInputs.innerHTML = '';

                selected.forEach(
                    id => {

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
    | Edit Modal
    |--------------------------------------------------------------------------
    */

    function openEditModal(
        id,
        name,
        email
    ) {

        document
            .getElementById('editModal')
            .style.display = 'block';

        document
            .getElementById('editName')
            .value = name;

        document
            .getElementById('editEmail')
            .value = email;

        document
            .getElementById('editStudentForm')
            .action =
            "{{ url('/students/update') }}/" + id;
    }


    /*
    |--------------------------------------------------------------------------
    | Close Modal
    |--------------------------------------------------------------------------
    */

    function closeEditModal()
    {
        document
            .getElementById('editModal')
            .style.display = 'none';
    }


    /*
    |--------------------------------------------------------------------------
    | Outside Click
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


    updateSelectedCount();

</script>

</body>

</html>