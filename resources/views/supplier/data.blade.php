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
                        <li class="breadcrumb-item active">Dadus Supplier</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list fa-sm"></i> Dadus Supplier</h3>
                    <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-primary float-right">
                        <i class="fas fa-plus fa-sm"></i> Aumenta Supplier
                    </a>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Naran</th>
                                <th>Nu. Telefone</th>
                                <th>Endresu</th>
                                <th>Deskrisaun</th>
                                <th class="text-center">Operasaun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $i => $sup)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $sup->nama }}</td>
                                <td>{{ $sup->telpon }}</td>
                                <td>{{ $sup->alamat }}</td>
                                <td>{{ $sup->deskripsi }}</td>
                                <td class="text-center">
                                    <a href="{{ route('supplier.edit', ['id' => $sup->id_supplier]) }}"
                                       class="btn btn-warning btn-sm" title="Hadia Supplier">
                                        <i class="fas fa-pen"></i></a>
                                    <a href="{{ route('supplier.delete', ['id' => $sup->id_supplier]) }}"
                                       class="btn btn-danger btn-sm btn-hapus"
                                       title="Hamoos Supplier" data-nama="{{ $sup->nama }}">
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var nama = $(this).data('nama');
            Swal.fire({
                title: 'Hapus Supplier?',
                text: 'Anda yakin akan menghapus "' + nama + '" ?',
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
