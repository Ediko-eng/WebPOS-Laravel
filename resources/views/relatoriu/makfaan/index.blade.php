@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Relatoriu Makfa'an</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Relatoriu Makfa'an</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line fa-sm"></i> Dadus Makfa'an</h3>
                    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#mdlPeriodeJual">
                        <i class="fas fa-print"></i> Cetak Relatoriu
                    </button>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Fa'an</th>
                                <th>Data Fa'an</th>
                                <th>Barcode</th>
                                <th>Naran Sasan</th>
                                <th>Kuantidade</th>
                                <th>Folin Fa'an</th>
                                <th>Total Folin</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $p->no_jual }}</td>
                                <td>{{ $p->tgl_jual->format('d-m-Y') }}</td>
                                <td>{{ $p->barcode }}</td>
                                <td>{{ $p->nama_brg }}</td>
                                <td>{{ $p->qty }}</td>
                                <td>{{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->jml_harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('relatoriu.makfaan.detail', ['id' => $p->no_jual, 'tgl' => $p->tgl_jual->format('d-m-Y')]) }}"
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

<!-- Modal Periode -->
<div class="modal fade" id="mdlPeriodeJual" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Relatoriu Makfa'an</h5>
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
        window.open('{{ route("report.jual") }}?tgl1=' + t1 + '&tgl2=' + t2, '_blank', 'width=900,height=600');
    }
</script>
@endpush
