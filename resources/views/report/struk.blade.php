<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $head->no_jual }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 13px; width: 240px; margin: 0 auto; padding: 10px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; }
        .right { text-align: right; }
        .header { text-align: center; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="bold" style="font-size:16px;">SI POS Kasir</div>
        <div class="line"></div>
        <div>No Nota: <b>{{ $head->no_jual }}</b></div>
        <div>{{ $head->tgl_jual->format('d/m/Y') }}</div>
        <div>Kasir: {{ $user->username }}</div>
        <div class="line"></div>
    </div>

    <table>
        @foreach ($details as $d)
        <tr>
            <td colspan="2">{{ $d->nama_brg }}</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;{{ $d->qty }} x {{ number_format($d->harga_jual, 0, ',', '.') }}</td>
            <td class="right">{{ number_format($d->jml_harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td class="bold">Total</td>
            <td class="right bold">{{ number_format($head->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Selu</td>
            <td class="right">{{ number_format($head->jml_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Volta (Kembalian)</td>
            <td class="right">{{ number_format($head->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    @if ($head->customer)
    <div>Kliente: {{ $head->customer }}</div>
    @endif
    @if ($head->keterangan)
    <div>Ket: {{ $head->keterangan }}</div>
    @endif

    <div class="center" style="margin-top:10px;">
        <div>Obrigadu/a</div>
        <div class="bold">Barak bele Kompras ona..!</div>
    </div>

    <script>
        setTimeout(function() { window.print(); }, 1000);
    </script>
</body>
</html>
