@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Relatoriu Maksosak</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Relatoriu Maksosak</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie fa-sm"></i> Dadus Maksosak</h3>
                    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#mdlPeriodeBeli">
                        <i class="fas fa-print"></i> Cetak Relatoriu
                    </button>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Sosa</th>
                                <th>Data Sosa</th>
                                <th>Supplier</th>
                                <th>Total Sosa</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelian as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $p->no_beli }}</td>
                                <td>{{ $p->tgl_beli->format('d-m-Y') }}</td>
                                <td>{{ $p->supplier }}</td>
                                <td>{{ number_format($p->total, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('relatoriu.maksosak.detail', ['id' => $p->no_beli, 'tgl' => $p->tgl_beli->format('d-m-Y')]) }}"
                                       class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i></a>
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

<div class="modal fade" id="mdlPeriodeBeli" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Relatoriu Maksosak</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tgl1">Data Komesa</label>
                    <input type="date" id="tgl1" class="form-control" value="{{ date('Y-m-01') }}">
                </div>
                <div class="form-group">
                    <label for="tgl2">Data Termina</label>
                    <input type="date" id="tgl2" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kansela</button>
                <button type="button" class="btn btn-primary" onclick="printDoc()">Cetak</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function printDoc() {
        var t1 = document.getElementById('tgl1').value;
        var t2 = document.getElementById('tgl2').value;
        window.open('{{ route("report.beli") }}?tgl1=' + t1 + '&tgl2=' + t2, '_blank', 'width=900,height=600');
    }
</script>
@endpush
