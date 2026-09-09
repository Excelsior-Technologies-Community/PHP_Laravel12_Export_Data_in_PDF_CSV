<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Students Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
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
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f1f5f9;
            border: 1px solid #000;
            padding: 7px;
            text-align: left;
        }

        td {
            border: 1px solid #000;
            padding: 7px;
        }

        .active {
            color: green;
            font-weight: bold;
        }

        .inactive {
            color: red;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <h2>
        🎓 Students Report
    </h2>

    <div class="subtitle">

        @if(!empty($search))

        Search:
        <strong>{{ $search }}</strong>

        @endif

        @if(!empty($status))

        |
        Status:
        <strong>{{ ucfirst($status) }}</strong>

        @endif

        @if(!empty($fromDate))

        |
        From:
        <strong>{{ $fromDate }}</strong>

        @endif

        @if(!empty($toDate))

        |
        To:
        <strong>{{ $toDate }}</strong>

        @endif

    </div>

    <div class="summary">

        <strong>Total:</strong>
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

                <th>Status</th>

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

                    <span
                        class="{{ $s->status === 'active' ? 'active' : 'inactive' }}">
                        {{ ucfirst($s->status) }}
                    </span>

                </td>

                <td>
                    {{ $s->created_at->format('d M Y, h:i A') }}
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