<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Guest & Visitor Log</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; margin: 24px; color: #1f2937; }
        h1 { font-size: 20px; margin-bottom: 2px; }
        .subtitle { color: #6b7280; font-size: 12px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; text-transform: uppercase; font-size: 10px; letter-spacing: .03em; }
        .status-in { color: #047857; font-weight: bold; }
        .status-out { color: #6b7280; }
        .toolbar { margin-bottom: 16px; }
        .toolbar button {
            padding: 8px 16px; background: #1f2937; color: #fff; border: none; border-radius: 6px;
            font-size: 12px; text-transform: uppercase; letter-spacing: .05em; cursor: pointer;
        }
        @media print {
            .toolbar { display: none; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button onclick="window.print()">Print</button>
    </div>

    <h1>Guest &amp; Visitor Log</h1>
    <div class="subtitle">Nilimbag: {{ now()->format('M d, Y h:i A') }} &middot; Kabuuang tala: {{ $visitors->count() }}</div>

    <table>
        <thead>
            <tr>
                <th>Pangalan</th>
                <th>Pinanggalingan</th>
                <th>Bibisitahin</th>
                <th>Layunin</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Katayuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($visitors as $visitor)
                <tr>
                    <td>{{ $visitor->name }}</td>
                    <td>{{ $visitor->address }}</td>
                    <td>{{ $visitor->person_to_visit }}</td>
                    <td>{{ $visitor->purpose }}</td>
                    <td>{{ $visitor->time_in->format('M d, Y h:i A') }}</td>
                    <td>{{ $visitor->time_out ? $visitor->time_out->format('M d, Y h:i A') : '—' }}</td>
                    <td class="{{ $visitor->time_out ? 'status-out' : 'status-in' }}">
                        {{ $visitor->time_out ? 'Nakalabas' : 'Nasa Loob' }}
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Walang tala.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>