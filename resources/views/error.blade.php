@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pájina Erru</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="error-template">
                <h1>Aih!</h1>
                <h2>403 Labele Asesu</h2>
                <p class="text-muted">
                    Ita-boot la iha permissaun atu hela iha ne'e. Favor kontaktu Administrator.
                </p>
                <div class="error-actions">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-home"></i> Tamba Dashboard
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
