@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Relatoriu Stock</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Relatoriu Stock</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-warehouse fa-sm"></i> Dadus Stock</h3>
                    <a href="{{ route('report.stock') }}" target="_blank"
                       class="btn btn-sm btn-primary float-right">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kodigu Sasan</th>
                                <th>Naran Sasan</th>
                                <th>Unidade</th>
                                <th>Total Stock</th>
                                <th>Minimu Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $i => $s)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $s->id_barang }}</td>
                                <td>{{ $s->nama_barang }}</td>
                                <td>{{ $s->satuan }}</td>
                                <td>{{ $s->stock }}</td>
                                <td>{{ $s->stock_minimal }}</td>
                                <td>
                                    @if ($s->stock < $s->stock_minimal)
                                    <span class="badge badge-danger">Stock Menus</span>
                                    @else
                                    <span class="badge badge-success">Stock to ona</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
