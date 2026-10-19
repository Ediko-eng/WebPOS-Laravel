<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BeliDetail;
use App\Models\BeliHead;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $tgl = $request->query('tgl', date('Y-m-d'));
        $noBeli = BeliHead::generateNo();

        $details = BeliDetail::where('no_beli', $noBeli)->orderBy('id')->get();
        $total = BeliDetail::where('no_beli', $noBeli)->sum('jml_harga');

        $suppliers = Supplier::orderBy('nama')->get();
        $barangs = Barang::orderBy('id_barang')->get();

        $selectedBarang = null;
        if ($request->query('pilihbrg')) {
            $selectedBarang = Barang::find($request->query('pilihbrg'));
        }

        return view('pembelian.index', compact(
            'tgl',
            'noBeli',
            'details',
            'total',
            'suppliers',
            'barangs',
            'selectedBarang'
        ));
    }

    public function addBarang(Request $request)
    {
        $request->validate([
            'nobeli' => 'required|string',
            'tglNota' => 'required|date',
            'kodeBrg' => 'required|string',
            'namaBrg' => 'required|string',
            'qty' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
        ]);

        $no = $request->input('nobeli');
        $kode = $request->input('kodeBrg');
        $qty = $request->input('qty');
        $harga = $request->input('harga');

        $exists = BeliDetail::where('no_beli', $no)
            ->where('kode_brg', $kode)
            ->exists();

        if ($exists) {
            return redirect()->route('pembelian.index', ['tgl' => $request->input('tglNota')])
                ->with('error', 'Sasan nee iha tiha ona, ita-boot tenke hamoos uluk karik hakarak hadia nia kuantidade...');
        }

        DB::transaction(function () use ($request, $no, $kode, $qty, $harga) {
            BeliDetail::create([
                'no_beli' => $no,
                'tgl_beli' => $request->input('tglNota'),
                'kode_brg' => $kode,
                'nama_brg' => $request->input('namaBrg'),
                'qty' => $qty,
                'harga_beli' => $harga,
                'jml_harga' => $qty * $harga,
            ]);

            Barang::where('id_barang', $kode)->increment('stock', $qty);
        });

        return redirect()->route('pembelian.index', ['tgl' => $request->input('tglNota')]);
    }

    public function deleteBarang(Request $request)
    {
        $idbrg = $request->query('idbrg');
        $idbeli = $request->query('idbeli');
        $qty = (int) $request->query('qty', 0);
        $tgl = $request->query('tgl');

        DB::transaction(function () use ($idbrg, $idbeli, $qty) {
            BeliDetail::where('kode_brg', $idbrg)
                ->where('no_beli', $idbeli)
                ->delete();

            Barang::where('id_barang', $idbrg)->decrement('stock', $qty);
        });

        return redirect()->route('pembelian.index', ['tgl' => $tgl]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nobeli' => 'required|string',
            'tglNota' => 'required|date',
            'total' => 'required|integer',
            'suplier' => 'required|string',
        ]);

        $details = BeliDetail::where('no_beli', $request->input('nobeli'))->get();

        if ($details->isEmpty()) {
            return redirect()->route('pembelian.index', ['tgl' => $request->input('tglNota')])
                ->with('error', 'Seidauk iha sasan nebee aumenta.');
        }

        $total = BeliDetail::where('no_beli', $request->input('nobeli'))->sum('jml_harga');

        BeliHead::create([
            'no_beli' => $request->input('nobeli'),
            'tgl_beli' => $request->input('tglNota'),
            'supplier' => $request->input('suplier'),
            'total' => $total,
            'keterangan' => $request->input('ketr', ''),
        ]);

        return redirect()->route('pembelian.index')
            ->with('success', 'Dadus sosa save ho susesu');
    }
}
