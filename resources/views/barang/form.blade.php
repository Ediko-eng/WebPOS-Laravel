@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sasan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Sasan</a></li>
                        <li class="breadcrumb-item active">{{ $barang->exists ? 'Hadia Sasan' : 'Aumenta Sasan' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('barang.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($barang->exists)
                    <input type="hidden" name="oldImg" value="{{ $barang->gambar }}">
                    @endif

                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pen fa-sm"></i>
                            {{ $barang->exists ? 'Hadia Sasan' : 'Input Sasan' }}</h3>
                        <button type="submit" name="simpan" class="btn btn-primary btn-sm float-right">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm float-right mr-1">
                            <i class="fas fa-times"></i> Reset
                        </button>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-8 mb-3 pr-3">
                                <div class="form-group">
                                    <label for="kode">Kodigu Sasan</label>
                                    <input type="text" name="kode" class="form-control" id="kode"
                                           value="{{ old('kode', $barang->id_barang) }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="barcode">Barcode *</label>
                                    <input type="text" name="barcode" class="form-control" id="barcode"
                                           value="{{ old('barcode', $barang->barcode) }}"
                                           autocomplete="off" autofocus placeholder="barcode" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Naran Sasan *</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           value="{{ old('name', $barang->nama_barang) }}"
                                           autocomplete="off" placeholder="Naran Sasan" required>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Unidade</label>
                                    <select name="satuan" id="satuan" class="form-control" required>
                                        <option value="">---Unidade Sasan---</option>
                                        @foreach (['piece', 'botol', 'kaleng', 'pouch'] as $sat)
                                        <option value="{{ $sat }}"
                                            {{ old('satuan', $barang->satuan) == $sat ? 'selected' : '' }}>
                                            {{ ucfirst($sat) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="harga_beli">Folin Sosa *</label>
                                    <input type="number" name="harga_beli" class="form-control" id="harga_beli"
                                           value="{{ old('harga_beli', $barang->harga_beli) }}"
                                           autocomplete="off" placeholder="Folin Sosa" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_jual">Folin Fa'an *</label>
                                    <input type="number" name="harga_jual" class="form-control" id="harga_jual"
                                           value="{{ old('harga_jual', $barang->harga_jual) }}"
                                           autocomplete="off" placeholder="Folin Fa'an" required>
                                </div>
                                <div class="form-group">
                                    <label for="stock_minimal">Stock Minimu *</label>
                                    <input type="number" name="stock_minimal" class="form-control" id="stock_minimal"
                                           value="{{ old('stock_minimal', $barang->stock_minimal) }}"
                                           autocomplete="off" placeholder="Stock Minimu" required>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center px-3">
                                <img src="{{ asset('asset/image/' . ($barang->gambar ?: 'default-brg.png')) }}"
                                     class="profile-user-img mb-3 mt-4" alt="" style="width:200px;">
                                <input type="file" class="form-control" name="image">
                                <span class="text-sm">Type File Gambar JPG | PNG | GIF</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
