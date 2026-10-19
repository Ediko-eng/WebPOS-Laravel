@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Maksosak {{ $head->no_beli }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('relatoriu.maksosak') }}">Relatoriu Maksosak</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle fa-sm"></i>
                        {{ $head->no_beli }} - {{ $head->tgl_beli->format('d-m-Y') }} - {{ $head->supplier }}</h3>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kodigu Sasan</th>
                                <th>Naran Sasan</th>
                                <th>Folin Sosa</th>
                                <th>Qty</th>
                                <th>Total Folin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $d->kode_brg }}</td>
                                <td>{{ $d->nama_brg }}</td>
                                <td>{{ number_format($d->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ $d->qty }}</td>
                                <td>{{ number_format($d->jml_harga, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <th>{{ number_format($head->total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
