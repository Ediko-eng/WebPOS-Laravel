<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'telpon', 'deskripsi', 'alamat'])]
class Customer extends Model
{
    protected $table = 'tbl_customer';

    protected $primaryKey = 'id_customer';

    public $incrementing = true;

    public $timestamps = false;
}
