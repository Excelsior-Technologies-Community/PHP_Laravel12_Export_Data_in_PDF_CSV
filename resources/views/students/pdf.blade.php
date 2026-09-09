<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Students List</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 15px;
        }

        .summary {
            margin-bottom: 15px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background-color: #f1f5f9;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        table td {
            border: 1px solid #000;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

    </style>

</head>

<body>

    <h2>🎓 Students List</h2>


    @if(!empty($search))

        <div class="subtitle">
            Search Results For:
            <strong>{{ $search }}</strong>
        </div>

    @else

        <div class="subtitle">
            Student Data Report
        </div>

    @endif


    <div class="summary">

        <strong>Total Students:</strong>
        {{ $students->count() }}

        &nbsp;&nbsp;&nbsp;

        <strong>Generated:</strong>
        {{ now()->format('d M Y, h:i A') }}

    </div>


    <table>

        <thead>

        <tr>

            <th>ID</th>

            <th>Name</th>

            <th>Email</th>

            <th>Created At</th>

        </tr>

        </thead>


        <tbody>

        @forelse($students as $s)

            <tr>

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

            </tr>

        @empty

            <tr>

                <td colspan="4">
                    No students found.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</body>

</html>