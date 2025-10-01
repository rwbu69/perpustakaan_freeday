@extends('layouts.app')

@section('title', 'Detail Transaksi - Sistem Perpustakaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>📋 Detail Transaksi</h1>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Transaksi</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID Transaksi</th>
                        <td>{{ $transaksi->idTransaksi }}</td>
                    </tr>
                    <tr>
                        <th>Buku</th>
                        <td>{{ $transaksi->buku->judul }}</td>
                    </tr>
                    <tr>
                        <th>Peminjam</th>
                        <td>{{ $transaksi->peminjam->nama }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Peminjam</th>
                        <td>{{ $transaksi->peminjam->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pinjam</th>
                        <td>{{ $transaksi->tglPinjam->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali</th>
                        <td>
                            @if($transaksi->tglKembali)
                                {{ $transaksi->tglKembali->format('d/m/Y') }}
                            @else
                                <span class="badge bg-warning">Belum dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Durasi Pinjam</th>
                        <td>
                            @if($transaksi->tglKembali)
                                {{ $transaksi->tglPinjam->diffInDays($transaksi->tglKembali) }} hari
                            @else
                                {{ $transaksi->tglPinjam->diffInDays(now()) }} hari (sedang berjalan)
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Denda</th>
                        <td>
                            @if($transaksi->denda > 0)
                                <span class="text-danger fw-bold">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-success">Rp 0</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($transaksi->tglKembali)
                                <span class="badge bg-success">Dikembalikan</span>
                            @else
                                <span class="badge bg-warning">Dipinjam</span>
                                @if($transaksi->tglPinjam->diffInDays(now()) > 7)
                                    <span class="badge bg-danger ms-1">Terlambat</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui</th>
                        <td>{{ $transaksi->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                @if(Auth::user()->isAdmin() && !$transaksi->tglKembali)
                    <div class="mt-3">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" 
                                data-bs-target="#kembalikanModal">
                            <i class="fas fa-undo"></i> Kembalikan Buku
                        </button>
                    </div>

                    <!-- Modal Kembalikan -->
                    <div class="modal fade" id="kembalikanModal" tabindex="-1">
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
                                            <label for="tglKembali" class="form-label">Tanggal Kembali</label>
                                            <input type="date" class="form-control" 
                                                   id="tglKembali" 
                                                   name="tglKembali" 
                                                   value="{{ date('Y-m-d') }}" 
                                                   min="{{ $transaksi->tglPinjam->format('Y-m-d') }}" 
                                                   required>
                                        </div>
                                        
                                        @php
                                            $daysDiff = $transaksi->tglPinjam->diffInDays(now());
                                            $potentialFine = $daysDiff > 7 ? ($daysDiff - 7) * 5000 : 0;
                                        @endphp
                                        
                                        @if($potentialFine > 0)
                                            <div class="alert alert-warning">
                                                <strong>Perhatian:</strong> Jika dikembalikan hari ini, denda yang akan dikenakan adalah sekitar <strong>Rp {{ number_format($potentialFine, 0, ',', '.') }}</strong>
                                            </div>
                                        @endif
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
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informasi Tambahan</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-clock text-warning"></i> <strong>Batas peminjaman:</strong> 7 hari</li>
                    <li><i class="fas fa-money-bill text-danger"></i> <strong>Denda keterlambatan:</strong> Rp 5.000/hari</li>
                    @if(!$transaksi->tglKembali)
                        <li><i class="fas fa-calendar text-info"></i> <strong>Batas kembali:</strong> {{ $transaksi->tglPinjam->addDays(7)->format('d/m/Y') }}</li>
                        @if($transaksi->tglPinjam->diffInDays(now()) > 7)
                            <li><i class="fas fa-exclamation-triangle text-danger"></i> <strong>Terlambat:</strong> {{ $transaksi->tglPinjam->diffInDays(now()) - 7 }} hari</li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>

        @if($transaksi->tglKembali)
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">✅ Buku Sudah Dikembalikan</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Dikembalikan pada:</strong> {{ $transaksi->tglKembali->format('d/m/Y') }}</p>
                    <p class="mb-1"><strong>Durasi peminjaman:</strong> {{ $transaksi->tglPinjam->diffInDays($transaksi->tglKembali) }} hari</p>
                    @if($transaksi->denda > 0)
                        <p class="mb-0 text-danger"><strong>Denda dibayar:</strong> Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</p>
                    @else
                        <p class="mb-0 text-success"><strong>Tidak ada denda</strong></p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
