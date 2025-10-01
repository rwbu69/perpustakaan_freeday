<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    use HasFactory;

    protected $table = 'peminjam';
    protected $primaryKey = 'idPeminjam';

    protected $fillable = [
        'nama',
        'alamat',
    ];

    /**
     * Relationship with Transaksi
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'idPeminjam', 'idPeminjam');
    }
}
