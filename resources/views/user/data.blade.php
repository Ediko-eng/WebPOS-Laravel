@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Utilizadores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dadus Utilizador</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list fa-sm"></i> Dadus Utilizador</h3>
                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary float-right">
                        <i class="fas fa-plus fa-sm"></i> Aumenta Utilizador
                    </a>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Username</th>
                                <th>Naran Kompletu</th>
                                <th>Endresu</th>
                                <th>Level Utilizador</th>
                                <th class="text-center">Operasaun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $i => $u)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <img src="{{ asset('asset/image/' . $u->foto) }}"
                                         class="img-circle" width="60px" alt="foto">
                                </td>
                                <td>{{ $u->username }}</td>
                                <td>{{ $u->fullname }}</td>
                                <td>{{ $u->address }}</td>
                                <td>
                                    @if ($u->level == 1)
                                    <span class="badge badge-danger">Administrator</span>
                                    @elseif ($u->level == 2)
                                    <span class="badge badge-warning">Supervisor</span>
                                    @else
                                    <span class="badge badge-info">Operator</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('user.edit', ['id' => $u->userid]) }}"
                                       class="btn btn-warning btn-sm" title="Hadia Utilizador">
                                        <i class="fas fa-pen"></i></a>
                                    <a href="{{ route('user.delete', ['id' => $u->userid]) }}"
                                       class="btn btn-danger btn-sm btn-hapus"
                                       title="Hamoos Utilizador" data-nama="{{ $u->username }}">
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
                title: 'Hapus Utilizador?',
                text: 'Ita boot hakarak hamoos "' + nama + '" ?',
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
