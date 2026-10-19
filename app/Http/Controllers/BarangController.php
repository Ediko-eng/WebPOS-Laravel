<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::orderBy('id_barang')->get();

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $barang = new Barang();
        $barang->id_barang = Barang::generateId();

        return view('barang.form', compact('barang'));
    }

    public function edit(Request $request)
    {
        $barang = Barang::findOrFail($request->query('id'));

        return view('barang.form', compact('barang'));
    }

    public function store(Request $request)
    {
        $isEdit = $request->filled('oldImg');

        $validated = $request->validate([
            'barcode' => 'required|string|max:20',
            'name' => 'required|string|max:100',
            'satuan' => 'required|string|max:20',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'stock_minimal' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3072',
        ]);

        $kode = $request->input('kode');

        $cek = Barang::where('barcode', $validated['barcode']);
        if ($isEdit) {
            $cek->where('id_barang', '!=', $kode);
        }
        if ($cek->exists()) {
            return back()->withErrors(['barcode' => 'Kodigu barcode nee iha tiha ona.'])->withInput();
        }

        $gambar = $isEdit ? $request->input('oldImg') : 'default-brg.png';

        if ($request->hasFile('image')) {
            $ext = strtolower($request->file('image')->getClientOriginalExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                return back()->withErrors(['image' => 'File neebe mak ita upload laos gambar.'])->withInput();
            }
            $fileName = $kode . '-' . rand(10, 1000) . '.' . $ext;
            $request->file('image')->move(public_path('asset/image'), $fileName);

            if ($isEdit && $gambar && $gambar !== 'default-brg.png') {
                @unlink(public_path('asset/image/' . $gambar));
            }
            $gambar = $fileName;
        } elseif (!$isEdit) {
            $gambar = 'default-brg.png';
        }

        $data = [
            'barcode' => $validated['barcode'],
            'nama_barang' => $validated['name'],
            'harga_beli' => $validated['harga_beli'],
            'harga_jual' => $validated['harga_jual'],
            'satuan' => $validated['satuan'],
            'stock_minimal' => $validated['stock_minimal'],
            'gambar' => $gambar,
        ];

        if ($isEdit) {
            Barang::where('id_barang', $kode)->update($data);

            return redirect()->route('barang.index')->with('success', 'Dadus Sasan hadia ho susesu.');
        }

        $data['id_barang'] = $kode;
        $data['stock'] = 0;
        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Sasan Aumenta ho Susesu.');
    }

    public function destroy(Request $request)
    {
        $barang = Barang::findOrFail($request->query('id'));

        if ($barang->gambar && $barang->gambar !== 'default-brg.png') {
            @unlink(public_path('asset/image/' . $barang->gambar));
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Dadus Sasan hamoos ho susesu.');
    }
}
