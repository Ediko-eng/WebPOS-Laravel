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
                        <li class="breadcrumb-item active">Aumenta Sasan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list fa-sm"></i> Dadus Sasan</h3>
                    <a href="{{ route('barang.create') }}" class="mr-2 btn btn-sm btn-primary float-right">
                        <i class="fas fa-plus fa-sm"></i> Aumenta Sasan
                    </a>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>ID Sasan</th>
                                <th>Naran Sasan</th>
                                <th>Folin Sosa</th>
                                <th>Folin Fa'an</th>
                                <th style="width: 10%;" class="text-center">Operasaun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $brg)
                            <tr>
                                <td>
                                    <img src="{{ asset('asset/image/' . $brg->gambar) }}"
                                         alt="gambar barang" class="rounded-circle" width="60px">
                                </td>
                                <td>{{ $brg->id_barang }}</td>
                                <td>{{ $brg->nama_barang }}</td>
                                <td class="text-center">{{ number_format($brg->harga_beli, 0, ',', '.') }}</td>
                                <td class="text-center">{{ number_format($brg->harga_jual, 0, ',', '.') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-secondary btn-cetak-barcode"
                                            data-barcode="{{ $brg->barcode }}"
                                            data-nama="{{ $brg->nama_barang }}"
                                            title="Cetak Barcode"><i class="fas fa-barcode"></i></button>

                                    <a href="{{ route('barang.edit', ['id' => $brg->id_barang]) }}"
                                       class="btn btn-warning btn-sm" title="Hadi'a Sasan">
                                        <i class="fas fa-pen"></i></a>

                                    <a href="{{ route('barang.delete', ['id' => $brg->id_barang]) }}"
                                       class="btn btn-danger btn-sm btn-hapus"
                                       title="Hamoos Sasan"
                                       data-nama="{{ $brg->nama_barang }}">
                                        <i class="fas fa-trash"></i></a>
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

<!-- Modal Cetak Barcode -->
<div class="modal fade" id="mdlCetakBarcode" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-barcode"></i> Cetak Barcode</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Naran Sasan</label>
                    <input type="text" id="nmBrg" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Barcode</label>
                    <input type="text" id="barcodeVal" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Jumlah Cetak</label>
                    <input type="number" id="jmlCetak" class="form-control" min="1" max="10" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kansela</button>
                <button type="button" class="btn btn-primary" id="previewBarcode">Cetak</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-cetak-barcode').on('click', function() {
            $('#nmBrg').val($(this).data('nama'));
            $('#barcodeVal').val($(this).data('barcode'));
            $('#jmlCetak').val(1);
            $('#mdlCetakBarcode').modal('show');
        });

        $('#previewBarcode').on('click', function() {
            var barcode = $('#barcodeVal').val();
            var jml = parseInt($('#jmlCetak').val());
            if (jml >= 1 && jml <= 10) {
                window.open('{{ route("report.barcode") }}?barcode=' + barcode + '&jmlCetak=' + jml, '_blank');
            } else {
                Swal.fire('Error!', 'Total atu imprime tenke 1-10.', 'error');
            }
        });

        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var nama = $(this).data('nama');
            Swal.fire({
                title: 'Hapus Sasan?',
                text: 'Ita-boot hakarak hamoos "' + nama + '" ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hamoos',
                cancelButtonText: 'Kansela'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>
@endpush
