<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('id_supplier')->get();

        return view('supplier.data', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.form');
    }

    public function edit(Request $request)
    {
        $supplier = Supplier::findOrFail($request->query('id'));

        return view('supplier.form', compact('supplier'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:256',
            'telpon' => 'required|string|min:5|regex:/^[0-9]+$/',
            'ketr' => 'nullable|string|max:256',
            'alamat' => 'nullable|string',
        ], [
            'telpon.regex' => 'Telefone iha dadus laose.',
            'telpon.min' => 'Telefone tenke iha minima 5 nian hakarak.',
        ]);

        Supplier::create([
            'nama' => $validated['nama'],
            'telpon' => $validated['telpon'],
            'deskripsi' => $validated['ketr'] ?? '',
            'alamat' => $validated['alamat'] ?? '',
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier Aumenta ona..');
    }

    public function update(Request $request)
    {
        $supplier = Supplier::findOrFail($request->input('id'));

        $validated = $request->validate([
            'nama' => 'required|string|max:256',
            'telpon' => 'required|string|min:5|regex:/^[0-9]+$/',
            'ketr' => 'nullable|string|max:256',
            'alamat' => 'nullable|string',
        ]);

        $supplier->update([
            'nama' => $validated['nama'],
            'telpon' => $validated['telpon'],
            'deskripsi' => $validated['ketr'] ?? '',
            'alamat' => $validated['alamat'] ?? '',
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier hadia ho susesu..');
    }

    public function destroy(Request $request)
    {
        $supplier = Supplier::findOrFail($request->query('id'));
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier Hamoos ho susesu..');
    }
}
