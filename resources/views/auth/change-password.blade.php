@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Troka Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Troka Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card" style="max-width:500px;margin:0 auto;">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-key fa-sm"></i> Troka Password</h3>
                </div>
                <form action="{{ route('password.update') }}" method="post">
                    @csrf
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="curPass">Password Atual *</label>
                            <input type="password" name="curPass" id="curPass" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="newPass">Password Foun *</label>
                            <input type="password" name="newPass" id="newPass" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="confPass">Konfirma Password Foun *</label>
                            <input type="password" name="confPass" id="confPass" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Kansela
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
