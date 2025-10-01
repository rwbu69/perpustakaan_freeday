<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger untuk mengurangi stok buku ketika transaksi dibuat
        DB::unprepared('
            CREATE TRIGGER kurangi_stok_buku 
            AFTER INSERT ON transaksi 
            FOR EACH ROW 
            BEGIN 
                UPDATE buku 
                SET stok = stok - 1 
                WHERE idBuku = NEW.idBuku;
                
                INSERT INTO log (aksi, deskripsi, user_id, created_at, updated_at)
                VALUES ("Peminjaman Buku", CONCAT("Buku dengan ID ", NEW.idBuku, " dipinjam oleh peminjam ID ", NEW.idPeminjam), NULL, NOW(), NOW());
            END
        ');

        // Trigger untuk menghitung denda ketika buku dikembalikan
        DB::unprepared('
            CREATE TRIGGER hitung_denda_buku 
            BEFORE UPDATE ON transaksi 
            FOR EACH ROW 
            BEGIN 
                DECLARE selisih_hari INT;
                
                IF NEW.tglKembali IS NOT NULL AND OLD.tglKembali IS NULL THEN
                    SET selisih_hari = DATEDIFF(NEW.tglKembali, NEW.tglPinjam);
                    
                    IF selisih_hari > 7 THEN
                        SET NEW.denda = (selisih_hari - 7) * 5000;
                    ELSE
                        SET NEW.denda = 0;
                    END IF;
                    
                    UPDATE buku 
                    SET stok = stok + 1 
                    WHERE idBuku = NEW.idBuku;
                    
                    INSERT INTO log (aksi, deskripsi, user_id, created_at, updated_at)
                    VALUES ("Pengembalian Buku", CONCAT("Buku dengan ID ", NEW.idBuku, " dikembalikan dengan denda Rp ", NEW.denda), NULL, NOW(), NOW());
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS kurangi_stok_buku');
        DB::unprepared('DROP TRIGGER IF EXISTS hitung_denda_buku');
    }
};
