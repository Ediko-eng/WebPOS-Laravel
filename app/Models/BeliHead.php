<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['no_beli', 'tgl_beli', 'supplier', 'total', 'keterangan'])]
class BeliHead extends Model
{
    protected $table = 'tbl_beli_head';

    protected $primaryKey = 'no_beli';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $casts = [
        'tgl_beli' => 'date',
        'total' => 'integer',
    ];

    public function details()
    {
        return $this->hasMany(BeliDetail::class, 'no_beli', 'no_beli');
    }

    public static function generateNo(): string
    {
        $max = self::max('no_beli');
        if (!$max) {
            return 'PB0001';
        }
        $no = (int) substr($max, 2, 4) + 1;
        return 'PB' . sprintf('%04d', $no);
    }
}
