<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'idTransaksi';

    protected $fillable = [
        'idBuku',
        'idPeminjam',
        'tglPinjam',
        'tglKembali',
        'denda',
    ];

    protected $casts = [
        'tglPinjam' => 'date',
        'tglKembali' => 'date',
    ];

    /**
     * Relationship with Buku
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'idBuku', 'idBuku');
    }

    /**
     * Relationship with Peminjam
     */
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'idPeminjam', 'idPeminjam');
    }
}
