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
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Utilizadores</a></li>
                        <li class="breadcrumb-item active">{{ isset($user) ? 'Hadia Utilizador' : 'Aumenta Utilizador' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card" style="max-width:700px;">
                <form action="{{ isset($user) ? route('user.update') : route('user.store') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @if (isset($user))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $user->userid }}">
                    <input type="hidden" name="oldImg" value="{{ $user->foto }}">
                    @endif

                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pen fa-sm"></i>
                            {{ isset($user) ? 'Hadia Utilizador' : 'Input Utilizador' }}</h3>
                        <button type="submit" name="{{ isset($user) ? 'koreksi' : 'simpan' }}"
                                class="btn btn-primary btn-sm float-right">
                            <i class="fas fa-save"></i> {{ isset($user) ? 'Koreksi' : 'Rai' }}
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm float-right mr-1">
                            <i class="fas fa-times"></i> Reset
                        </button>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="username">Username *</label>
                            <input type="text" name="username" id="username" class="form-control"
                                   value="{{ old('username', $user->username ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="fullname">Naran Kompletu *</label>
                            <input type="text" name="fullname" id="fullname" class="form-control"
                                   value="{{ old('fullname', $user->fullname ?? '') }}" required>
                        </div>

                        @unless (isset($user))
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password2">Konfirma Password *</label>
                            <input type="password" name="password2" id="password2" class="form-control" required>
                        </div>
                        @endunless

                        @if (isset($user))
                        <div class="form-group">
                            <label for="newPassword">Password Foun</label>
                            <input type="password" name="newPassword" id="newPassword" class="form-control"
                                   autocomplete="new-password">
                            <span class="text-sm">Hakarak troka password, hakama password foun iha ne'e. Husi ita troka,
                                password atual sei manas.</span>
                        </div>
                        <div class="form-group">
                            <label for="newPassword2">Konfirma Password Foun</label>
                            <input type="password" name="newPassword2" id="newPassword2" class="form-control"
                                   autocomplete="new-password">
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="level">Level Utilizador *</label>
                            <select name="level" id="level" class="form-control" required>
                                <option value="">--- Pilih Level ---</option>
                                <option value="1" {{ old('level', $user->level ?? '') == 1 ? 'selected' : '' }}>Administrator</option>
                                <option value="2" {{ old('level', $user->level ?? '') == 2 ? 'selected' : '' }}>Supervisor</option>
                                <option value="3" {{ old('level', $user->level ?? '') == 3 ? 'selected' : '' }}>Operator</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Endresu</label>
                            <textarea name="address" id="address" class="form-control" rows="2">{{ old('address', $user->address ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <img src="{{ asset('asset/image/' . ($user->foto ?? 'default.png')) }}"
                                 class="img-circle mb-2" width="100" alt="foto"><br>
                            <input type="file" class="form-control" name="image">
                            <span class="text-sm">Type File Gambar JPG | PNG | GIF</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kamba
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
