@extends('layouts.app')

@section('title', 'Detail Buku - Sistem Perpustakaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>📖 Detail Buku</h1>
    <a href="{{ route('buku.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $buku->judul }}</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID Buku</th>
                        <td>{{ $buku->idBuku }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>{{ $buku->judul }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>
                            <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $buku->stok }} buku
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $buku->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui</th>
                        <td>{{ $buku->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                @if(Auth::user()->isAdmin())
                    <div class="mt-3">
                        <a href="{{ route('buku.edit', $buku) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Riwayat Peminjaman</h6>
            </div>
            <div class="card-body">
                @forelse($buku->transaksis()->with('peminjam')->latest()->take(5)->get() as $transaksi)
                    <div class="border-bottom pb-2 mb-2">
                        <small class="text-muted">{{ $transaksi->tglPinjam->format('d/m/Y') }}</small><br>
                        <strong>{{ $transaksi->peminjam->nama }}</strong><br>
                        @if($transaksi->tglKembali)
                            <span class="badge bg-success">Dikembalikan</span>
                        @else
                            <span class="badge bg-warning">Dipinjam</span>
                        @endif
                    </div>
                @empty
                    <p class="text-muted">Belum ada riwayat peminjaman</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection