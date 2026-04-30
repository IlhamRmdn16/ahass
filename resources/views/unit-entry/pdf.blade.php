<!DOCTYPE html>
<html>
<head>
    <title>Laporan Unit Entry</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #e11d48; }
        .header p { margin: 5px 0 0; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { bg-color: #f3f4f6; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SURYA WIJAYA</h1>
        <p>UNIT ENTRY HARI / TANGGAL: {{ \Carbon\Carbon::parse($date ?? now())->translatedFormat('l, d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Polisi</th>
                <th>Type Motor</th>
                <th>Jam</th>
                <th>Mekanik</th>
                <th>JP</th>
                <th>No. Telp</th>
                <th>Daya Auto</th>
                <th>Alasan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $index => $entry)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td style="text-transform: uppercase;">{{ $entry->police_number }}</td>
                <td>{{ $entry->motor_type }}</td>
                <td>{{ \Carbon\Carbon::parse($entry->entry_time)->format('H:i') }}</td>
                <td>{{ $entry->mechanic->name }}</td>
                <td>{{ $entry->jobType->code }}</td>
                <td>{{ $entry->phone_number ?? '-' }}</td>
                <td class="text-center">{{ $entry->is_daya_auto ? 'V' : '-' }}</td>
                <td>{{ $entry->reason ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>