@extends('layouts.app')

@section('title', 'Daftar Buku - Sistem Perpustakaan')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Daftar Buku</h1>
        @if(Auth::user()->isAdmin())
            <x-button variant="primary" href="{{ route('buku.create') }}">
                Tambah Buku
            </x-button>
        @endif
    </div>
</div>

<x-card title="Data Buku Perpustakaan">
    <x-table striped="true">
        <thead>
            <tr>
                <th>ID Buku</th>
                <th>Judul</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bukus as $buku)
                <tr>
                    <td>{{ $buku->idBuku }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>
                        <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $buku->stok }}
                        </span>
                    </td>
                    <td>
                        <x-button variant="info" size="sm" href="{{ route('buku.show', $buku) }}">
                            Detail
                        </x-button>
                        @if(Auth::user()->isAdmin())
                            <x-button variant="warning" size="sm" href="{{ route('buku.edit', $buku) }}">
                                Edit
                            </x-button>
                            <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" size="sm" 
                                        onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    Hapus
                                </x-button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data buku</td>
                </tr>
            @endforelse
        </tbody>
    </x-table>

    <div class="mt-3">
        {{ $bukus->links() }}
    </div>
</x-card>
@endsection
