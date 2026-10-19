<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\JualHead;
use App\Models\Supplier;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $userNum = User::count();
        $supplierNum = Supplier::count();
        $customerNum = Customer::count();
        $brgNum = Barang::count();

        $lowStock = Barang::whereColumn('stock', '<', 'stock_minimal')->get();

        $omzet = JualHead::sum('total');

        return view('dashboard', compact(
            'userNum',
            'supplierNum',
            'customerNum',
            'brgNum',
            'lowStock',
            'omzet'
        ));
    }
}
