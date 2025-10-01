@extends('layouts.app')

@section('title', 'Daftar Transaksi - Sistem Perpustakaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>📋 Daftar Transaksi Peminjaman</h1>
    @if(Auth::user()->isAdmin())
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Transaksi Baru
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
                        <th>Buku</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->idTransaksi }}</td>
                            <td>{{ $transaksi->buku->judul }}</td>
                            <td>{{ $transaksi->peminjam->nama }}</td>
                            <td>{{ $transaksi->tglPinjam->format('d/m/Y') }}</td>
                            <td>
                                @if($transaksi->tglKembali)
                                    {{ $transaksi->tglKembali->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($transaksi->denda > 0)
                                    <span class="text-danger">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-success">Rp 0</span>
                                @endif
                            </td>
                            <td>
                                @if($transaksi->tglKembali)
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-warning">Dipinjam</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                @if(Auth::user()->isAdmin() && !$transaksi->tglKembali)
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" 
                                            data-bs-target="#kembalikanModal{{ $transaksi->idTransaksi }}">
                                        <i class="fas fa-undo"></i> Kembalikan
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Kembalikan -->
                        @if(Auth::user()->isAdmin() && !$transaksi->tglKembali)
                        <div class="modal fade" id="kembalikanModal{{ $transaksi->idTransaksi }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Kembalikan Buku</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('transaksi.kembalikan', $transaksi) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <p>Kembalikan buku "<strong>{{ $transaksi->buku->judul }}</strong>" dari peminjam "<strong>{{ $transaksi->peminjam->nama }}</strong>"?</p>
                                            <div class="mb-3">
                                                <label for="tglKembali{{ $transaksi->idTransaksi }}" class="form-label">Tanggal Kembali</label>
                                                <input type="date" class="form-control" 
                                                       id="tglKembali{{ $transaksi->idTransaksi }}" 
                                                       name="tglKembali" 
                                                       value="{{ date('Y-m-d') }}" 
                                                       min="{{ $transaksi->tglPinjam->format('Y-m-d') }}" 
                                                       required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Kembalikan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $transaksis->links() }}
    </div>
</div>
@endsection
