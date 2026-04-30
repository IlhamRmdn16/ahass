<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Unit Entry</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header-container { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-wrapper { text-align: center; margin-bottom: 15px; }
        .date-text { text-align: left; font-weight: bold; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; }
        .text-center { text-align: center; }
        .ceklis { font-family: 'DejaVu Sans', sans-serif; }
    </style>
</head>
<body>
    @php
        $imagePath = public_path('image/logo.png');
        $logoSrc = '';
        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $logoSrc = 'data:image/png;base64,' . $imageData;
        }
    @endphp

    <div class="header-container">
        <div class="logo-wrapper">
            @if($logoSrc)
                <img src="{{ $logoSrc }}" style="height: 60px; width: auto; object-fit: contain;" alt="Logo Surya Wijaya">
            @else
                <h1 style="margin: 0; color: #e11d48;">SURYA WIJAYA</h1>
            @endif
        </div>
        <p class="date-text">UNIT ENTRY HARI / TANGGAL: {{ \Carbon\Carbon::parse($date ?? now())->translatedFormat('l, d F Y') }}</p>
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
                <td class="text-center ceklis">{!! $entry->is_daya_auto ? '&#10004;' : '-' !!}</td>
                <td>{{ $entry->reason ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>