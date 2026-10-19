<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id_customer')->get();

        return view('customer.data', compact('customers'));
    }

    public function create()
    {
        return view('customer.form');
    }

    public function edit(Request $request)
    {
        $customer = Customer::findOrFail($request->query('id'));

        return view('customer.form', compact('customer'));
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

        Customer::create([
            'nama' => $validated['nama'],
            'telpon' => $validated['telpon'],
            'deskripsi' => $validated['ketr'] ?? '',
            'alamat' => $validated['alamat'] ?? '',
        ]);

        return redirect()->route('customer.index')->with('success', 'Kliente Aumenta ona..');
    }

    public function update(Request $request)
    {
        $customer = Customer::findOrFail($request->input('id'));

        $validated = $request->validate([
            'nama' => 'required|string|max:256',
            'telpon' => 'required|string|min:5|regex:/^[0-9]+$/',
            'ketr' => 'nullable|string|max:256',
            'alamat' => 'nullable|string',
        ]);

        $customer->update([
            'nama' => $validated['nama'],
            'telpon' => $validated['telpon'],
            'deskripsi' => $validated['ketr'] ?? '',
            'alamat' => $validated['alamat'] ?? '',
        ]);

        return redirect()->route('customer.index')->with('success', 'Kliente hadia ona..');
    }

    public function destroy(Request $request)
    {
        $customer = Customer::findOrFail($request->query('id'));
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Kliente hamoos ona..');
    }
}
