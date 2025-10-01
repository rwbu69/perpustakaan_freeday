@extends('layouts.app')

@section('title', 'Tambah Transaksi - Sistem Perpustakaan')

@section('content')
<div class="page-header">
    <h1>Transaksi Peminjaman Baru</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <x-card title="Form Transaksi Peminjaman">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                
                @php
                    $bukuOptions = [];
                    foreach($bukus as $buku) {
                        $bukuOptions[$buku->idBuku] = $buku->judul . ' (Stok: ' . $buku->stok . ')';
                    }
                    
                    $peminjamOptions = [];
                    foreach($peminjams as $peminjam) {
                        $peminjamOptions[$peminjam->idPeminjam] = $peminjam->nama;
                    }
                @endphp

                <x-form-select 
                    name="idBuku" 
                    label="Pilih Buku" 
                    :options="$bukuOptions"
                    selected="{{ old('idBuku') }}"
                    placeholder="-- Pilih Buku --"
                    required="true" />

                <x-form-select 
                    name="idPeminjam" 
                    label="Pilih Peminjam" 
                    :options="$peminjamOptions"
                    selected="{{ old('idPeminjam') }}"
                    placeholder="-- Pilih Peminjam --"
                    required="true" />

                <x-form-input 
                    type="date" 
                    name="tglPinjam" 
                    label="Tanggal Pinjam" 
                    value="{{ old('tglPinjam', date('Y-m-d')) }}" 
                    required="true" />

                <div class="d-flex gap-2">
                    <x-button type="submit" variant="primary">
                        Simpan Transaksi
                    </x-button>
                    <x-button variant="secondary" href="{{ route('transaksi.index') }}">
                        Kembali
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <div class="col-md-4">
        <x-card title="Informasi Peminjaman">
            <ul class="list-unstyled">
                <li class="mb-2">
                    <span class="badge bg-warning">Batas Waktu</span>
                    <br><small class="text-muted">Batas peminjaman: 7 hari</small>
                </li>
                <li class="mb-2">
                    <span class="badge bg-danger">Denda</span>
                    <br><small class="text-muted">Denda keterlambatan: Rp 5.000/hari</small>
                </li>
                <li class="mb-2">
                    <span class="badge bg-info">Ketersediaan</span>
                    <br><small class="text-muted">Hanya buku dengan stok > 0 yang bisa dipinjam</small>
                </li>
            </ul>
        </x-card>
    </div>
</div>
@endsection