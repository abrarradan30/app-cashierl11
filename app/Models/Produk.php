<?php

namespace App\Models;

use App\Models\DetailTransaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = ['kode', 'nama', 'harga', 'stok'];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
