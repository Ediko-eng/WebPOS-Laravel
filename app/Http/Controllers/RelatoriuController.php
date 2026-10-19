<?php

namespace App\Http\Controllers;

use App\Models\BeliDetail;
use App\Models\BeliHead;
use App\Models\JualDetail;
use App\Models\JualHead;
use Illuminate\Http\Request;

class RelatoriuController extends Controller
{
    public function makfaan()
    {
        $penjualan = JualDetail::orderBy('no_jual', 'desc')->get();

        return view('relatoriu.makfaan.index', compact('penjualan'));
    }

    public function detailPenjualan(Request $request)
    {
        $id = $request->query('id');
        $tgl = $request->query('tgl');

        $head = JualHead::where('no_jual', $id)->firstOrFail();
        $details = JualDetail::where('no_jual', $id)->orderBy('id')->get();

        return view('relatoriu.makfaan.detail', compact('head', 'details', 'tgl'));
    }

    public function maksosak()
    {
        $pembelian = BeliHead::orderBy('no_beli', 'desc')->get();

        return view('relatoriu.maksosak.index', compact('pembelian'));
    }

    public function detailPembelian(Request $request)
    {
        $id = $request->query('id');
        $tgl = $request->query('tgl');

        $head = BeliHead::where('no_beli', $id)->firstOrFail();
        $details = BeliDetail::where('no_beli', $id)->orderBy('id')->get();

        return view('relatoriu.maksosak.detail', compact('head', 'details', 'tgl'));
    }
}
