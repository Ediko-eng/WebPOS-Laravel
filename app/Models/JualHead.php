<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['no_jual', 'tgl_jual', 'customer', 'total', 'keterangan', 'jml_bayar', 'kembalian'])]
class JualHead extends Model
{
    protected $table = 'tbl_jual_head';

    protected $primaryKey = 'no_jual';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $casts = [
        'tgl_jual' => 'date',
        'total' => 'integer',
        'jml_bayar' => 'integer',
        'kembalian' => 'integer',
    ];

    public function details()
    {
        return $this->hasMany(JualDetail::class, 'no_jual', 'no_jual');
    }

    public static function generateNo(): string
    {
        $max = self::max('no_jual');
        if (!$max) {
            return 'PJ0001';
        }
        $no = (int) substr($max, 2, 4) + 1;
        return 'PJ' . sprintf('%04d', $no);
    }

    public static function totalJual(string $nojual): int
    {
        return (int) JualDetail::where('no_jual', $nojual)->sum('jml_harga');
    }
}
