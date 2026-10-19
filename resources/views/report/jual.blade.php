<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Relatoriu Makfa'an {{ $tgl1 }} - {{ $tgl2 }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #444; color: #fff; }
        .no-print { margin-bottom: 15px; }
        h3 { text-align: center; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <h3>Relatoriu Makfa'an</h3>
    <p style="text-align:center;">Periodu: {{ $tgl1 }} s/d {{ $tgl2 }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Data Fa'an</th>
                <th>ID Fa'an</th>
                <th>Kliente</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualan as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->tgl_jual->format('d-m-Y') }}</td>
                <td>{{ $p->no_jual }}</td>
                <td>{{ $p->customer }}</td>
                <td>{{ number_format($p->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;">La iha dadus</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
