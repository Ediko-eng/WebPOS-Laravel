@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kliente</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Kliente</a></li>
                        <li class="breadcrumb-item active">{{ isset($customer) ? 'Hadia Kliente' : 'Aumenta Kliente' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card" style="max-width:700px;">
                <form action="{{ isset($customer) ? route('customer.update') : route('customer.store') }}" method="post">
                    @csrf
                    @if (isset($customer))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $customer->id_customer }}">
                    @endif

                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pen fa-sm"></i>
                            {{ isset($customer) ? 'Hadia Kliente' : 'Input Kliente' }}</h3>
                        <button type="submit" name="{{ isset($customer) ? 'update' : 'simpan' }}"
                                class="btn btn-primary btn-sm float-right">
                            <i class="fas fa-save"></i> {{ isset($customer) ? 'Koreksi' : 'Rai' }}
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
                            <label for="nama">Naran Kliente *</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                   value="{{ old('nama', $customer->nama ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="telpon">Nu. Telefone *</label>
                            <input type="text" name="telpon" id="telpon" class="form-control"
                                   value="{{ old('telpon', $customer->telpon ?? '') }}"
                                   pattern="[0-9]{5,}" title="minimu 5 numbru" required>
                        </div>
                        <div class="form-group">
                            <label for="ketr">Deskripsaun</label>
                            <textarea name="ketr" id="ketr" class="form-control" rows="1">{{ old('ketr', $customer->deskripsi ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Enderesu</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $customer->alamat ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kamba
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
