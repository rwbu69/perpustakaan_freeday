@extends('layouts.app')

@section('title', 'Tambah Buku - Sistem Perpustakaan')

@section('content')
<div class="page-header">
    <h1>Tambah Buku Baru</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <x-card title="Form Tambah Buku">
            <form action="{{ route('buku.store') }}" method="POST">
                @csrf
                
                <x-form-input 
                    name="judul" 
                    label="Judul Buku" 
                    value="{{ old('judul') }}" 
                    placeholder="Masukkan judul buku"
                    required="true" />

                <x-form-input 
                    type="number" 
                    name="stok" 
                    label="Stok" 
                    value="{{ old('stok', 1) }}" 
                    placeholder="Jumlah stok buku"
                    required="true" />

                <div class="d-flex gap-2">
                    <x-button type="submit" variant="primary">
                        Simpan
                    </x-button>
                    <x-button variant="secondary" href="{{ route('buku.index') }}">
                        Kembali
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
