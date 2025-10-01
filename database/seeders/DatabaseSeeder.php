<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjam;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Perpustakaan',
            'username' => 'admin',
            'email' => 'admin@perpustakaan.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Biasa',
            'username' => 'user',
            'email' => 'user@perpustakaan.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        // Create sample books
        $bukus = [
            ['judul' => 'Laskar Pelangi', 'stok' => 5],
            ['judul' => 'Bumi Manusia', 'stok' => 3],
            ['judul' => 'Ayat-Ayat Cinta', 'stok' => 4],
            ['judul' => 'Perahu Kertas', 'stok' => 2],
            ['judul' => 'Sang Pemimpi', 'stok' => 6],
            ['judul' => 'Negeri 5 Menara', 'stok' => 3],
            ['judul' => 'Dilan 1990', 'stok' => 4],
            ['judul' => 'Milea', 'stok' => 2],
            ['judul' => 'Habibie & Ainun', 'stok' => 5],
            ['judul' => 'Edensor', 'stok' => 3],
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }

        // Create sample peminjam
        $peminjams = [
            ['nama' => 'Ahmad Rizki', 'alamat' => 'Jl. Merdeka No. 123, Jakarta'],
            ['nama' => 'Siti Nurhaliza', 'alamat' => 'Jl. Sudirman No. 456, Bandung'],
            ['nama' => 'Budi Santoso', 'alamat' => 'Jl. Thamrin No. 789, Surabaya'],
            ['nama' => 'Dewi Sartika', 'alamat' => 'Jl. Pahlawan No. 321, Yogyakarta'],
            ['nama' => 'Eko Prasetyo', 'alamat' => 'Jl. Diponegoro No. 654, Semarang'],
        ];

        foreach ($peminjams as $peminjam) {
            Peminjam::create($peminjam);
        }
    }
}
