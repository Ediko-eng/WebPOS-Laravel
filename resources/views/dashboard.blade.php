@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $userNum }}</h3>
                            <p>Utilizador</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        @if (auth()->user()->level == 1)
                        <a href="{{ route('user.index') }}" class="small-box-footer">Informasaun Detaillu
                            <i class="fas fa-arrow-circle-right"></i></a>
                        @else
                        <a href="#" class="small-box-footer">&nbsp;</a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $supplierNum }}</h3>
                            <p>Supplier</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('supplier.index') }}" class="small-box-footer">Informasaun Detaillu
                            <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $customerNum }}</h3>
                            <p>Kliente</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                        <a href="{{ route('customer.index') }}" class="small-box-footer">Informasaun Detaillu
                            <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $brgNum }}</h3>
                            <p>Sasan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('barang.index') }}" class="small-box-footer">Informasaun Detaillu
                            <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-exclamation-triangle text-warning"></i> Stock Menus</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Kodigu Sasan</th>
                                        <th>Naran Sasan</th>
                                        <th>Stock</th>
                                        <th>Minimu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lowStock as $brg)
                                    <tr>
                                        <td>{{ $brg->id_barang }}</td>
                                        <td>{{ $brg->nama_barang }}</td>
                                        <td><span class="badge badge-danger">{{ $brg->stock }}</span></td>
                                        <td>{{ $brg->stock_minimal }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">La wain stock menus</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-dollar-sign text-success"></i> Omzet Fa'an</h3>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="text-success" style="font-size:2.5rem;">{{ number_format($omzet, 0, ',', '.') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
