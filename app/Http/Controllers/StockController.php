<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Barang::orderBy('id_barang')->get();

        return view('stock.index', compact('stocks'));
    }
}
