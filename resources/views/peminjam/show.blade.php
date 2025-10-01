@extends('layouts.app')

@section('title', 'Detail Peminjam - Sistem Perpustakaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>👤 Detail Peminjam</h1>
    <a href="{{ route('peminjam.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Peminjam</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="150">ID Peminjam</th>
                        <td>{{ $peminjam->idPeminjam }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $peminjam->nama }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $peminjam->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Terdaftar</th>
                        <td>{{ $peminjam->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui</th>
                        <td>{{ $peminjam->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                @if(Auth::user()->isAdmin())
                    <div class="mt-3">
                        <a href="{{ route('peminjam.edit', $peminjam) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('peminjam.destroy', $peminjam) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Yakin ingin menghapus peminjam ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Peminjaman</h5>
            </div>
            <div class="card-body">
                @forelse($transaksis as $transaksi)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-1">{{ $transaksi->buku->judul }}</h6>
                                <small class="text-muted">
                                    Pinjam: {{ $transaksi->tglPinjam->format('d/m/Y') }}
                                    @if($transaksi->tglKembali)
                                        | Kembali: {{ $transaksi->tglKembali->format('d/m/Y') }}
                                    @endif
                                </small>
                                @if($transaksi->denda > 0)
                                    <br><small class="text-danger">Denda: Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</small>
                                @endif
                            </div>
                            <div>
                                @if($transaksi->tglKembali)
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-warning">Dipinjam</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada riwayat peminjaman</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection