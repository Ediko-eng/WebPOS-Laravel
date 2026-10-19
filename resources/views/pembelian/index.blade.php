@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Maksosak Sasan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Aumenta Maksosak</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="container-fluid">
            <form action="" method="get">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-outline card-warning p-3">
                            <div class="form-group row mb-2">
                                <label for="noNota" class="col-sm-2 col-form-label">No Nota</label>
                                <div class="col-sm-4">
                                    <input type="text" name="nobeli" class="form-control" id="noNota"
                                           value="{{ $noBeli }}" readonly>
                                </div>
                                <label for="tglNota" class="col-sm-2 col-form-label">Tgl Nota</label>
                                <div class="col-sm-4">
                                    <input type="date" name="tgl" id="tglNota" class="form-control"
                                           value="{{ $tgl }}" onchange="this.form.submit()" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="kodeBrg" class="col-sm-2 col-form-label">Sasan</label>
                                <div class="col-sm-10">
                                    <select name="pilihbrg" id="kodeBrg" class="form-control"
                                            onchange="var tgl=document.getElementById('tglNota').value;
                                            window.location='{{ route('pembelian.index') }}?pilihbrg='+this.value+'&tgl='+tgl;">
                                        <option value="">--- Pilih Sasan ---</option>
                                        @foreach ($barangs as $b)
                                        <option value="{{ $b->id_barang }}"
                                            {{ $selectedBarang && $selectedBarang->id_barang == $b->id_barang ? 'selected' : '' }}>
                                            {{ $b->id_barang }} - {{ $b->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-outline card-danger pt-3 px-3 pb-2">
                            <h6 class="font-weight-bold text-right">Total Sosa</h6>
                            <h1 class="font-weight-bold text-right" style="font-size: 40pt;">
                                <input type="hidden" name="total" id="total" value="{{ $total }}">
                                {{ number_format($total, 0, ',', '.') }}
                            </h1>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('pembelian.add') }}" method="post">
                @csrf
                <input type="hidden" name="nobeli" value="{{ $noBeli }}">
                <input type="hidden" name="tglNota" value="{{ $tgl }}">
                <div class="card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" name="kodeBrg" value="{{ $selectedBarang->id_barang ?? '' }}">
                                <label for="namaBrg">Naran Sasan</label>
                                <input type="text" name="namaBrg" class="form-control form-control-sm"
                                       id="namaBrg" value="{{ $selectedBarang->nama_barang ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" class="form-control form-control-sm"
                                       id="stok" value="{{ $selectedBarang->stock ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="satuan">Unidade</label>
                                <input type="text" name="satuan" class="form-control form-control-sm"
                                       id="satuan" value="{{ $selectedBarang->satuan ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="harga">Folin Sosa</label>
                                <input type="number" name="harga" class="form-control form-control-sm"
                                       id="harga" value="{{ $selectedBarang->harga_beli ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="qty">Kuantidade *</label>
                                <input type="number" name="qty" id="qty" class="form-control form-control-sm"
                                       value="1" min="1" required oninput="hitungTotal()">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="jmlHarga">Total Folin</label>
                                <input type="text" name="jmlHarga" id="jmlHarga"
                                       class="form-control form-control-sm" readonly
                                       value="{{ ($selectedBarang->harga_beli ?? 0) * 1 }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <button type="submit" name="addbrg" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tamba Sasan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card mt-3">
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kodigu Sasan</th>
                                <th>Naran Sasan</th>
                                <th>Folin</th>
                                <th>Kuantidade</th>
                                <th>Total Folin</th>
                                <th class="text-center">Operasaun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($details as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $d->kode_brg }}</td>
                                <td>{{ $d->nama_brg }}</td>
                                <td>{{ number_format($d->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ $d->qty }}</td>
                                <td>{{ number_format($d->jml_harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pembelian.delete', ['idbrg' => $d->kode_brg, 'idbeli' => $d->no_beli, 'qty' => $d->qty, 'tgl' => $tgl]) }}"
                                       class="btn btn-danger btn-sm btn-hapus" title="Hamoos">
                                        <i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">La iha sasan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <form action="{{ route('pembelian.simpan') }}" method="post">
                @csrf
                <input type="hidden" name="nobeli" value="{{ $noBeli }}">
                <input type="hidden" name="tglNota" value="{{ $tgl }}">
                <input type="hidden" name="total" value="{{ $total }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="suplier">Supplier</label>
                                    <select name="suplier" id="suplier" class="form-control" required>
                                        <option value="">--- Pilih Supplier ---</option>
                                        @foreach ($suppliers as $sup)
                                        <option value="{{ $sup->nama }}">{{ $sup->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="ketr">Keterangan</label>
                                    <textarea name="ketr" id="ketr" class="form-control" rows="1"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-3 text-right">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" name="simpan" class="btn btn-success btn-block">
                                        <i class="fas fa-save"></i> Simpan Maksosak
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    function hitungTotal() {
        var harga = parseInt(document.getElementById('harga').value || 0);
        var qty = parseInt(document.getElementById('qty').value || 0);
        document.getElementById('jmlHarga').value = (harga * qty);
    }

    $(document).ready(function() {
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
                title: 'Hapus Sasan?',
                text: 'Ita-boot hakarak hamoos sasan nee tiha?',
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
