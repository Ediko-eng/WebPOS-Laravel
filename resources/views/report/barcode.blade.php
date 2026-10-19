<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Barcode</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; padding: 10px; }
        .barcode-item { text-align: center; margin-bottom: 10px; page-break-inside: avoid; }
        .barcode-item img { width: 200px; }
        .barcode-text { font-size: 12px; margin-top: 2px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:center;margin-bottom:10px;">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    @foreach ($barcodes as $b64)
    <div class="barcode-item">
        @if ($b64)
        <img src="data:image/png;base64,{{ $b64 }}" alt="barcode">
        @endif
        <div class="barcode-text">{{ $barcode }}</div>
    </div>
    @endforeach
</body>
</html>
