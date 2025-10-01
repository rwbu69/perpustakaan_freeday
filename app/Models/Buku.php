<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'idBuku';

    protected $fillable = [
        'judul',
        'stok',
    ];

    /**
     * Relationship with Transaksi
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'idBuku', 'idBuku');
    }
}