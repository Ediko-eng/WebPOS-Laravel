<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['no_beli', 'tgl_beli', 'kode_brg', 'nama_brg', 'qty', 'harga_beli', 'jml_harga'])]
class BeliDetail extends Model
{
    protected $table = 'tbl_beli_detail';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = false;

    protected $casts = [
        'tgl_beli' => 'date',
        'qty' => 'integer',
        'harga_beli' => 'integer',
        'jml_harga' => 'integer',
    ];

    public function head()
    {
        return $this->belongsTo(BeliHead::class, 'no_beli', 'no_beli');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_brg', 'id_barang');
    }
}
