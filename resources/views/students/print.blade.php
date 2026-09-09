<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Student Print Report</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        h2 {
            text-align: center;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 9px;
        }

        th {
            background: #eee;
        }

        .active {
            color: green;
            font-weight: bold;
        }

        .inactive {
            color: red;
            font-weight: bold;
        }

        .print-btn {
            padding: 10px 15px;
            margin-bottom: 20px;
        }

        @media print {

            .print-btn {
                display: none;
            }

        }

    </style>

</head>

<body>

<button
    class="print-btn"
    onclick="window.print()"
>
    🖨 Print
</button>

<h2>
    🎓 Student Report
</h2>

<div class="info">

    <strong>Total:</strong>
    {{ $students->count() }}

    @if(!empty($search))

        |
        <strong>Search:</strong>
        {{ $search }}

    @endif

    @if(!empty($status))

        |
        <strong>Status:</strong>
        {{ ucfirst($status) }}

    @endif

    @if(!empty($fromDate))

        |
        <strong>From:</strong>
        {{ $fromDate }}

    @endif

    @if(!empty($toDate))

        |
        <strong>To:</strong>
        {{ $toDate }}

    @endif

</div>

<table>

    <thead>

    <tr>

        <th>ID</th>

        <th>Name</th>

        <th>Email</th>

        <th>Status</th>

        <th>Created At</th>

    </tr>

    </thead>

    <tbody>

    @forelse($students as $student)

        <tr>

            <td>
                {{ $student->id }}
            </td>

            <td>
                {{ $student->name }}
            </td>

            <td>
                {{ $student->email }}
            </td>

            <td>

                <span
                    class="{{ $student->status === 'active' ? 'active' : 'inactive' }}"
                >
                    {{ ucfirst($student->status) }}
                </span>

            </td>

            <td>
                {{ $student->created_at->format('d M Y, h:i A') }}
            </td>

        </tr>

    @empty

        <tr>

            <td colspan="5">
                No students found.
            </td>

        </tr>

    @endforelse

    </tbody>

</table>

</body>

</html>