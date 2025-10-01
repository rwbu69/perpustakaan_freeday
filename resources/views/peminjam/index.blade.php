@extends('layouts.app')

@section('title', 'Daftar Peminjam - Sistem Perpustakaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>👥 Daftar Peminjam</h1>
    @if(Auth::user()->isAdmin())
        <a href="{{ route('peminjam.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Peminjam
        </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Total Pinjaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjams as $peminjam)
                        <tr>
                            <td>{{ $peminjam->idPeminjam }}</td>
                            <td>{{ $peminjam->nama }}</td>
                            <td>{{ Str::limit($peminjam->alamat, 50) }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $peminjam->transaksis->count() }} transaksi
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('peminjam.show', $peminjam) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('peminjam.edit', $peminjam) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('peminjam.destroy', $peminjam) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus peminjam ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data peminjam</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $peminjams->links() }}
    </div>
</div>
@endsection