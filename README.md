# 📚 Sistem Perpustakaan Digital

Sistem manajemen perpustakaan berbasis web yang dikembangkan menggunakan Laravel untuk mengelola buku, peminjam, dan transaksi peminjaman dengan fitur otomatis pengelolaan stok dan perhitungan denda.

## 🌟 Fitur Utama

- **Manajemen Buku**: CRUD (Create, Read, Update, Delete) data buku dengan tracking stok otomatis
- **Manajemen Peminjam**: Pendaftaran dan pengelolaan data peminjam
- **Transaksi Peminjaman**: Sistem peminjaman dan pengembalian buku
- **Perhitungan Denda Otomatis**: Denda Rp 5.000/hari untuk keterlambatan > 7 hari
- **Role-based Access**: Sistem admin dan user dengan hak akses berbeda
- **Dashboard Interaktif**: Statistik dan aktivitas sistem real-time
- **Responsive Design**: Antarmuka modern yang mobile-friendly

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Database**: MySQL dengan Database Triggers
- **Frontend**: Bootstrap 5 + Custom CSS
- **Authentication**: Laravel Built-in Auth dengan Username
- **Components**: Custom Blade Components

## 📊 Entity Relationship Diagram (ERD)

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│      USERS      │     │      BUKU       │     │    PEMINJAM     │
├─────────────────┤     ├─────────────────┤     ├─────────────────┤
│ id (PK)         │     │ idBuku (PK)     │     │ idPeminjam (PK) │
│ name            │     │ judul           │     │ nama            │
│ username (UQ)   │     │ stok            │     │ alamat          │
│ password        │     │ created_at      │     │ created_at      │
│ role            │     │ updated_at      │     │ updated_at      │
│ created_at      │     └─────────────────┘     └─────────────────┘
│ updated_at      │              │                       │
└─────────────────┘              │                       │
         │                       │                       │
         │                       │                       │
         │        ┌─────────────────────────────────────┐│
         │        │           TRANSAKSI                 ││
         │        ├─────────────────────────────────────┤│
         │        │ idTransaksi (PK)                    ││
         └────────┤ user_id (FK) → users.id             ││
                  │ idBuku (FK) → buku.idBuku           │┘
                  │ idPeminjam (FK) → peminjam.idPeminjam
                  │ tglPinjam                           │
                  │ tglKembali (nullable)               │
                  │ denda                               │
                  │ created_at                          │
                  │ updated_at                          │
                  └─────────────────────────────────────┘
                                   │
                                   │
                    ┌─────────────────────────────────────┐
                    │              LOG                    │
                    ├─────────────────────────────────────┤
                    │ id (PK)                             │
                    │ user_id (FK) → users.id             │
                    │ aksi                                │
                    │ deskripsi                           │
                    │ created_at                          │
                    │ updated_at                          │
                    └─────────────────────────────────────┘
```

## 🔄 Flowchart Sistem

### 1. Flowchart Login dan Autentikasi

```
    [START]
       │
       ▼
 ┌─────────────┐
 │ Halaman     │
 │ Login       │
 └─────────────┘
       │
       ▼
 ┌─────────────┐
 │ Input       │
 │ Username &  │
 │ Password    │
 └─────────────┘
       │
       ▼
 ┌─────────────┐      ❌ [GAGAL]
 │ Validasi    │─────────────────┐
 │ Kredensial  │                 │
 └─────────────┘                 │
       │ ✅ [BERHASIL]            │
       ▼                         │
 ┌─────────────┐                 │
 │ Cek Role    │                 │
 │ User        │                 │
 └─────────────┘                 │
    │         │                  │
    ▼         ▼                  │
┌────────┐ ┌────────┐             │
│ Admin  │ │ User   │             │
│ Access │ │ Access │             │
└────────┘ └────────┘             │
    │         │                  │
    └─────────┼─────────▼         │
              ▼                   │
        ┌─────────────┐           │
        │ Dashboard   │           │
        └─────────────┘           │
              │                   │
              ▼                   │
            [END]                 │
                                  │
            ┌─────────────┐ ◄─────┘
            │ Error       │
            │ Message     │
            └─────────────┘
                  │
                  ▼
                [END]
```

### 2. Flowchart Manajemen Buku

```
      [START]
         │
         ▼
   ┌─────────────┐
   │ Dashboard   │
   │ Admin       │
   └─────────────┘
         │
         ▼
   ┌─────────────┐
   │ Menu        │
   │ Kelola Buku │
   └─────────────┘
         │
    ┌────┴────┐
    ▼         ▼
┌────────┐ ┌────────┐
│ Tambah │ │ Lihat  │
│ Buku   │ │ Daftar │
└────────┘ └────────┘
    │         │
    ▼         ▼
┌─────────────┐ ┌─────────────┐
│ Form Input: │ │ Tabel Buku  │
│ - Judul     │ │ + Aksi:     │
│ - Stok      │ │ - Edit      │
└─────────────┘ │ - Hapus     │
    │           │ - Detail    │
    ▼           └─────────────┘
┌─────────────┐       │
│ Validasi    │       ▼
│ Input       │ ┌─────────────┐
└─────────────┘ │ Update/     │
    │           │ Delete      │
    ▼           │ Proses      │
┌─────────────┐ └─────────────┘
│ Simpan ke   │       │
│ Database    │       ▼
└─────────────┘ ┌─────────────┐
    │           │ Konfirmasi  │
    ▼           │ & Redirect  │
┌─────────────┐ └─────────────┘
│ Log         │       │
│ Aktivitas   │       ▼
└─────────────┘     [END]
    │
    ▼
  [END]
```

### 3. Flowchart Transaksi Peminjaman

```
        [START]
           │
           ▼
    ┌─────────────┐
    │ Halaman     │
    │ Transaksi   │
    └─────────────┘
           │
           ▼
    ┌─────────────┐
    │ Pilih Buku  │
    │ (Stok > 0)  │
    └─────────────┘
           │
           ▼
    ┌─────────────┐
    │ Pilih       │
    │ Peminjam    │
    └─────────────┘
           │
           ▼
    ┌─────────────┐
    │ Set Tanggal │
    │ Pinjam      │
    └─────────────┘
           │
           ▼
    ┌─────────────┐
    │ Validasi    │
    │ Form        │
    └─────────────┘
           │ ✅
           ▼
    ┌─────────────┐
    │ TRIGGER:    │
    │ Kurangi     │
    │ Stok Buku   │
    └─────────────┘
           │
           ▼
    ┌─────────────┐
    │ Simpan      │
    │ Transaksi   │
    └─────────────┘
           │
           ▼
    ┌─────────────┐
    │ Log         │
    │ Aktivitas   │
    └─────────────┘
           │
           ▼
         [END]

    ═══ PROSES PENGEMBALIAN ═══

        [START]
           │
           ▼
    ┌─────────────┐
    │ Lihat       │
    │ Transaksi   │
    │ Aktif       │
    └─────────────┘
           │
           ▼
    ┌─────────────┐
    │ Klik        │
    │ "Kembalikan"│
    └─────────────┘
           │
           ▼
    ┌─────────────┐
    │ Set Tanggal │
    │ Kembali     │
    └─────────────┘
           │
           ▼
    ┌─────────────┐      ❌ [≤ 7 HARI]
    │ TRIGGER:    │─────────────────┐
    │ Hitung      │                 │
    │ Denda       │                 │
    └─────────────┘                 │
           │ ✅ [> 7 HARI]          │
           ▼                        │
    ┌─────────────┐                 │
    │ Denda =     │                 │
    │ (hari - 7)  │                 │
    │ × Rp 5000   │                 │
    └─────────────┘                 │
           │                        │
           └────────┬────────────────┘
                    ▼
            ┌─────────────┐
            │ Update      │
            │ Transaksi   │
            │ + Tambah    │
            │ Stok Buku   │
            └─────────────┘
                    │
                    ▼
                  [END]
```

## 🚀 Alur Aplikasi (App Flow)

### 1. Proses Menambah Buku

1. **Login sebagai Admin**
   - Username: `admin`
   - Password: `admin123`

2. **Navigasi ke Daftar Buku**
   - Dashboard → Menu "Daftar Buku"
   - Atau klik "Tambah Buku" di dashboard

3. **Form Input Buku**
   ```
   ┌─────────────────────────────┐
   │ Form Tambah Buku            │
   ├─────────────────────────────┤
   │ Judul Buku: [____________]  │
   │ Stok:       [____]          │
   │                             │
   │ [Simpan] [Kembali]          │
   └─────────────────────────────┘
   ```

4. **Validasi & Penyimpanan**
   - Sistem memvalidasi input
   - Data disimpan ke tabel `buku`
   - Log aktivitas tercatat
   - Redirect ke halaman daftar buku

### 2. Proses Transaksi Peminjaman

1. **Akses Transaksi**
   - Login sebagai Admin/User
   - Dashboard → "Transaksi" → "Tambah Transaksi"

2. **Form Transaksi**
   ```
   ┌─────────────────────────────────────┐
   │ Form Transaksi Peminjaman           │
   ├─────────────────────────────────────┤
   │ Pilih Buku: [▼ Dropdown Buku]      │
   │             (Menampilkan stok)      │
   │                                     │
   │ Pilih Peminjam: [▼ Dropdown]       │
   │                                     │
   │ Tanggal Pinjam: [2025-10-01]       │
   │                                     │
   │ [Simpan Transaksi] [Kembali]        │
   └─────────────────────────────────────┘
   ```

3. **Proses Otomatis (Database Trigger)**
   ```sql
   -- Trigger kurangi_stok_buku
   DELIMITER $$
   CREATE TRIGGER kurangi_stok_buku 
   AFTER INSERT ON transaksi
   FOR EACH ROW
   BEGIN
       UPDATE buku 
       SET stok = stok - 1 
       WHERE idBuku = NEW.idBuku;
   END$$
   ```

4. **Konfirmasi & Log**
   - Transaksi tersimpan
   - Stok buku berkurang otomatis
   - Log aktivitas tercatat
   - Notifikasi berhasil

### 3. Proses Pengembalian Buku

1. **Lihat Transaksi Aktif**
   - Menu "Transaksi" → Daftar transaksi
   - Filter: Status "Belum Dikembalikan"

2. **Klik Tombol Kembalikan**
   ```
   ┌─────────────────────────────────┐
   │ Detail Transaksi                │
   ├─────────────────────────────────┤
   │ Buku: Judul Buku               │
   │ Peminjam: Nama Peminjam        │
   │ Tgl Pinjam: 2025-09-20         │
   │ Status: Sedang Dipinjam        │
   │                                │
   │ Tanggal Kembali: [2025-10-01]  │
   │                                │
   │ [Proses Pengembalian]          │
   └─────────────────────────────────┘
   ```

3. **Perhitungan Denda Otomatis**
   ```sql
   -- Trigger hitung_denda_buku
   DELIMITER $$
   CREATE TRIGGER hitung_denda_buku 
   BEFORE UPDATE ON transaksi
   FOR EACH ROW
   BEGIN
       IF NEW.tglKembali IS NOT NULL AND OLD.tglKembali IS NULL THEN
           SET @selisih_hari = DATEDIFF(NEW.tglKembali, OLD.tglPinjam);
           IF @selisih_hari > 7 THEN
               SET NEW.denda = (@selisih_hari - 7) * 5000;
           ELSE
               SET NEW.denda = 0;
           END IF;
       END IF;
   END$$
   ```

## 📋 Instalasi dan Setup

### 1. Requirements
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM (opsional)

### 2. Langkah Instalasi

```bash
# Clone repository
git clone [repository-url]
cd perpustakaanfrida

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Setup database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations & seeders
php artisan migrate --seed

# Start development server
php artisan serve
```

### 3. Login Credentials

**Admin:**
- Username: `admin`
- Password: `admin123`

**User:**
- Username: `user`
- Password: `user123`

## 🗂️ Struktur Database

### Tabel Users
| Field | Type | Description |
|-------|------|-------------|
| id | bigint(PK) | Primary key |
| name | varchar(255) | Nama lengkap |
| username | varchar(255) | Username unik |
| password | varchar(255) | Password ter-hash |
| role | enum('admin','user') | Role pengguna |

### Tabel Buku
| Field | Type | Description |
|-------|------|-------------|
| idBuku | bigint(PK) | Primary key |
| judul | varchar(255) | Judul buku |
| stok | int | Jumlah stok buku |

### Tabel Peminjam
| Field | Type | Description |
|-------|------|-------------|
| idPeminjam | bigint(PK) | Primary key |
| nama | varchar(255) | Nama peminjam |
| alamat | text | Alamat peminjam |

### Tabel Transaksi
| Field | Type | Description |
|-------|------|-------------|
| idTransaksi | bigint(PK) | Primary key |
| user_id | bigint(FK) | ID user yang input |
| idBuku | bigint(FK) | ID buku yang dipinjam |
| idPeminjam | bigint(FK) | ID peminjam |
| tglPinjam | date | Tanggal peminjaman |
| tglKembali | date(nullable) | Tanggal pengembalian |
| denda | decimal(10,2) | Jumlah denda |

### Tabel Log
| Field | Type | Description |
|-------|------|-------------|
| id | bigint(PK) | Primary key |
| user_id | bigint(FK) | ID user |
| aksi | varchar(255) | Jenis aksi |
| deskripsi | text | Deskripsi aktivitas |

## 🔧 Fitur Teknis

### Database Triggers
1. **kurangi_stok_buku**: Otomatis mengurangi stok saat ada transaksi baru
2. **hitung_denda_buku**: Otomatis menghitung denda keterlambatan

### Custom Blade Components
- `<x-button>`: Komponen tombol dengan berbagai varian
- `<x-card>`: Komponen kartu dengan header opsional
- `<x-table>`: Komponen tabel responsif
- `<x-form-input>`: Komponen input form dengan validasi
- `<x-form-select>`: Komponen dropdown/select
- `<x-alert>`: Komponen notifikasi/alert
- `<x-modal>`: Komponen modal dialog

### Role-based Access Control
- **Admin**: Full access (CRUD semua data)
- **User**: Read-only access (view data saja)

## 📱 Screenshots

### Dashboard
```
┌─────────────────────────────────────────┐
│ 📊 Dashboard Sistem Perpustakaan        │
├─────────────────────────────────────────┤
│ ┌────────┐ ┌────────┐ ┌────────┐ ┌────┐│
│ │ Total  │ │ Total  │ │ Buku   │ │Tot.││
│ │ Buku   │ │Peminjam│ │Dipinjam│ │Tra.││
│ │   25   │ │   15   │ │   8    │ │ 45 ││
│ └────────┘ └────────┘ └────────┘ └────┘│
│                                         │
│ 🔧 Menu Admin                          │
│ [Tambah Buku] [Tambah Peminjam] [+Tran]│
│                                         │
│ 📋 Aktivitas Terbaru                   │
│ ┌─────────────────────────────────────┐ │
│ │ 01/10 10:30 │ CREATE │ Tambah buku  │ │
│ │ 01/10 10:25 │ UPDATE │ Edit peminja │ │
│ └─────────────────────────────────────┘ │
└─────────────────────────────────────────┘
```

## 📞 Support

Untuk pertanyaan atau bantuan teknis, silakan hubungi tim pengembang.

## 📄 License

Sistem ini dikembangkan untuk keperluan akademik dan komersial. Silakan sesuaikan dengan kebutuhan Anda.

---

**Dikembangkan dengan ❤️ menggunakan Laravel & Bootstrap**
