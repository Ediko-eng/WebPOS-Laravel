<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\JualDetail;
use App\Models\JualHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $tgl = $request->query('tgl', date('Y-m-d'));
        $nojual = JualHead::generateNo();

        $details = JualDetail::where('no_jual', $nojual)->orderBy('id')->get();
        $total = JualDetail::where('no_jual', $nojual)->sum('jml_harga');

        $customers = Customer::orderBy('nama')->get();

        $selectedBarang = null;
        $barcodeError = null;
        if ($request->query('barcode')) {
            $selectedBarang = Barang::where('barcode', $request->query('barcode'))->first();
            if (!$selectedBarang) {
                $barcodeError = 'Sasan ho Barcode ida nee, laiha..';
            }
        }

        return view('penjualan.index', compact(
            'tgl',
            'nojual',
            'details',
            'total',
            'customers',
            'selectedBarang',
            'barcodeError'
        ));
    }

    public function addBarang(Request $request)
    {
        $request->validate([
            'nojual' => 'required|string',
            'tglNota' => 'required|date',
            'barcode' => 'required|string',
            'namaBrg' => 'required|string',
            'qty' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $no = $request->input('nojual');
        $barcode = $request->input('barcode');
        $qty = $request->input('qty');
        $stok = $request->input('stok');
        $tgl = $request->input('tglNota');

        $exists = JualDetail::where('no_jual', $no)
            ->where('barcode', $barcode)
            ->exists();

        if ($exists) {
            return redirect()->route('penjualan.index', ['tgl' => $tgl])
                ->with('error', 'Sasan nee iha tiha ona, ita-boot tenke hamoos uluk karik hakarak hadia nia kuantidade...');
        }

        if ($qty > $stok) {
            return redirect()->route('penjualan.index', ['tgl' => $tgl])
                ->with('error', 'Stok sasan la tos atu faan.');
        }

        DB::transaction(function () use ($request, $no, $barcode, $qty) {
            JualDetail::create([
                'no_jual' => $no,
                'tgl_jual' => $request->input('tglNota'),
                'barcode' => $barcode,
                'nama_brg' => $request->input('namaBrg'),
                'qty' => $qty,
                'harga_jual' => $request->input('harga'),
                'jml_harga' => $qty * $request->input('harga'),
            ]);

            Barang::where('barcode', $barcode)->decrement('stock', $qty);
        });

        return redirect()->route('penjualan.index', ['tgl' => $tgl]);
    }

    public function deleteBarang(Request $request)
    {
        $barcode = $request->query('barcode');
        $idjual = $request->query('idjual');
        $qty = (int) $request->query('qty', 0);
        $tgl = $request->query('tgl');

        DB::transaction(function () use ($barcode, $idjual, $qty) {
            JualDetail::where('barcode', $barcode)
                ->where('no_jual', $idjual)
                ->delete();

            Barang::where('barcode', $barcode)->increment('stock', $qty);
        });

        return redirect()->route('penjualan.index', ['tgl' => $tgl]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nojual' => 'required|string',
            'tglNota' => 'required|date',
            'total' => 'required|integer',
            'customer' => 'required|string',
            'bayar' => 'required|integer|min:0',
        ]);

        $details = JualDetail::where('no_jual', $request->input('nojual'))->get();

        if ($details->isEmpty()) {
            return redirect()->route('penjualan.index', ['tgl' => $request->input('tglNota')])
                ->with('error', 'Seidauk iha sasan nebee aumenta.');
        }

        $total = JualDetail::where('no_jual', $request->input('nojual'))->sum('jml_harga');
        $bayar = $request->input('bayar');
        $kembalian = $bayar - $total;

        JualHead::create([
            'no_jual' => $request->input('nojual'),
            'tgl_jual' => $request->input('tglNota'),
            'customer' => $request->input('customer'),
            'total' => $total,
            'keterangan' => $request->input('ketr', ''),
            'jml_bayar' => $bayar,
            'kembalian' => max(0, $kembalian),
        ]);

        $nota = $request->input('nojual');

        return redirect()->route('penjualan.index')
            ->with('success', 'Dadus faan save ho susesu')
            ->with('open_struk', $nota);
    }

    public function struk(Request $request)
    {
        $nota = $request->query('nota');
        $head = JualHead::where('no_jual', $nota)->firstOrFail();
        $details = JualDetail::where('no_jual', $nota)->get();
        $user = auth()->user();

        return view('report.struk', compact('head', 'details', 'user'));
    }
}
