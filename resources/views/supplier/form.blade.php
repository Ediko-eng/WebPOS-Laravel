@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Supplier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
                        <li class="breadcrumb-item active">{{ isset($supplier) ? 'Hadia Supplier' : 'Aumenta Supplier' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card" style="max-width:700px;">
                <form action="{{ isset($supplier) ? route('supplier.update') : route('supplier.store') }}" method="post">
                    @csrf
                    @if (isset($supplier))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $supplier->id_supplier }}">
                    @endif

                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pen fa-sm"></i>
                            {{ isset($supplier) ? 'Hadia Supplier' : 'Input Supplier' }}</h3>
                        <button type="submit" name="{{ isset($supplier) ? 'update' : 'simpan' }}"
                                class="btn btn-primary btn-sm float-right">
                            <i class="fas fa-save"></i> {{ isset($supplier) ? 'Koreksi' : 'Rai' }}
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

                        <div class="form-group">
                            <label for="nama">Naran Supplier *</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                   value="{{ old('nama', $supplier->nama ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="telpon">Nu. Telefone *</label>
                            <input type="text" name="telpon" id="telpon" class="form-control"
                                   value="{{ old('telpon', $supplier->telpon ?? '') }}"
                                   pattern="[0-9]{5,}" title="minimu 5 numbru" required>
                        </div>
                        <div class="form-group">
                            <label for="ketr">Deskripsaun</label>
                            <textarea name="ketr" id="ketr" class="form-control" rows="1">{{ old('ketr', $supplier->deskripsi ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Enderesu</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $supplier->alamat ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kamba
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
