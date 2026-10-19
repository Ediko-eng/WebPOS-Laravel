<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'telpon', 'deskripsi', 'alamat'])]
class Supplier extends Model
{
    protected $table = 'tbl_supplier';

    protected $primaryKey = 'id_supplier';

    public $incrementing = true;

    public $timestamps = false;
}
