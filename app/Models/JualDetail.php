<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['no_jual', 'tgl_jual', 'barcode', 'nama_brg', 'qty', 'harga_jual', 'jml_harga'])]
class JualDetail extends Model
{
    protected $table = 'tbl_jual_detail';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = false;

    protected $casts = [
        'tgl_jual' => 'date',
        'qty' => 'integer',
        'harga_jual' => 'integer',
        'jml_harga' => 'integer',
    ];

    public function head()
    {
        return $this->belongsTo(JualHead::class, 'no_jual', 'no_jual');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barcode', 'barcode');
    }
}
