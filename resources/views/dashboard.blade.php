@extends('layouts.app')

@section('title', 'Dashboard - Sistem Perpustakaan')

@section('content')
<div class="page-header">
    <div class="row m-5">
        <div class="col-12">
            <h1>Dashboard Sistem Perpustakaan</h1>
            <p class="lead">Selamat datang, {{ $user->name }}! 
                @if($user->isAdmin())
                    <span class="badge bg-admin">Administrator</span>
                @else
                    <span class="badge bg-primary">User</span>
                @endif
            </p>
        </div>
    </div>
</div>

<div class="row m-5">
    <div class="col-md-3">
        <x-card class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ \App\Models\Buku::count() }}</h3>
                    <p>Total Buku</p>
                </div>
            </div>
            <div class="mt-3">
                <x-button variant="light" size="sm" href="{{ route('buku.index') }}" class="text-dark">
                    Lihat Detail
                </x-button>
            </div>
        </x-card>
    </div>

    <div class="col-md-3">
        <x-card class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ \App\Models\Peminjam::count() }}</h3>
                    <p>Total Peminjam</p>
                </div>
            </div>
            <div class="mt-3">
                <x-button variant="light" size="sm" href="{{ route('peminjam.index') }}" class="text-dark">
                    Lihat Detail
                </x-button>
            </div>
        </x-card>
    </div>

    <div class="col-md-3">
        <x-card class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ \App\Models\Transaksi::whereNull('tglKembali')->count() }}</h3>
                    <p>Buku Dipinjam</p>
                </div>
            </div>
            <div class="mt-3">
                <x-button variant="light" size="sm" href="{{ route('transaksi.index') }}" class="text-dark">
                    Lihat Detail
                </x-button>
            </div>
        </x-card>
    </div>

    <div class="col-md-3">
        <x-card class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ \App\Models\Transaksi::count() }}</h3>
                    <p>Total Transaksi</p>
                </div>
            </div>
            <div class="mt-3">
                <x-button variant="light" size="sm" href="{{ route('transaksi.index') }}" class="text-dark">
                    Lihat Detail
                </x-button>
            </div>
        </x-card>
    </div>
</div>

@if($user->isAdmin())
<div class="row m-5">
    <div class="col-12">
        <h2>Menu Admin</h2>
        <div class="row">
            <div class="col-md-4">
                <x-card>
                    <div class="text-center">
                        <h5>Tambah Buku</h5>
                        <p class="text-muted">Tambah buku baru ke perpustakaan</p>
                        <x-button variant="primary" href="{{ route('buku.create') }}">
                            Tambah Buku
                        </x-button>
                    </div>
                </x-card>
            </div>
            <div class="col-md-4">
                <x-card>
                    <div class="text-center">
                        <h5>Tambah Peminjam</h5>
                        <p class="text-muted">Daftarkan peminjam baru</p>
                        <x-button variant="success" href="{{ route('peminjam.create') }}">
                            Tambah Peminjam
                        </x-button>
                    </div>
                </x-card>
            </div>
            <div class="col-md-4">
                <x-card>
                    <div class="text-center">
                        <h5>Transaksi Baru</h5>
                        <p class="text-muted">Buat transaksi peminjaman baru</p>
                        <x-button variant="warning" href="{{ route('transaksi.create') }}">
                            Buat Transaksi
                        </x-button>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row m-5">
    <div class="col-12">
        <x-card title="Aktivitas Terbaru">
            <x-table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Aksi</th>
                        <th>Deskripsi</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Log::with('user')->latest()->take(10)->get() as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="badge bg-secondary">{{ $log->aksi }}</span></td>
                            <td>{{ $log->deskripsi }}</td>
                            <td>{{ $log->user ? $log->user->name : 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada aktivitas</td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table>
        </x-card>
    </div>
</div>
@endsection
