<?php

namespace App\Models;

use App\Models\DetailTransaksi;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode', 'total', 'status'];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
