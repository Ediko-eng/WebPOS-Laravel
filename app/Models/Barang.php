<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'id_barang',
    'barcode',
    'nama_barang',
    'harga_beli',
    'harga_jual',
    'stock',
    'satuan',
    'stock_minimal',
    'gambar',
])]
class Barang extends Model
{
    protected $table = 'tbl_barang';

    protected $primaryKey = 'id_barang';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $casts = [
        'harga_beli' => 'integer',
        'harga_jual' => 'integer',
        'stock' => 'integer',
        'stock_minimal' => 'integer',
    ];

    public function jualDetails()
    {
        return $this->hasMany(JualDetail::class, 'barcode', 'barcode');
    }

    public function beliDetails()
    {
        return $this->hasMany(BeliDetail::class, 'kode_brg', 'id_barang');
    }

    public function isLowStock(): bool
    {
        return $this->stock < $this->stock_minimal;
    }

    public static function generateId(): string
    {
        $max = self::max('id_barang');
        if (!$max) {
            return 'BRG-001';
        }
        $no = (int) substr($max, 4, 3) + 1;
        return 'BRG-' . sprintf('%03d', $no);
    }
}
