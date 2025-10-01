@extends('layouts.app')

@section('title', 'Login - Sistem Perpustakaan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <x-card title="Login ke Sistem Perpustakaan">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <x-form-input 
                    name="username" 
                    label="Username" 
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    required="true" />

                <x-form-input 
                    type="password" 
                    name="password" 
                    label="Password" 
                    placeholder="Masukkan password"
                    required="true" />

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>

                <div class="d-grid">
                    <x-button type="submit" variant="primary" size="lg">
                        Login
                    </x-button>
                </div>
            </form>

            <div class="text-center mt-3">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </div>
        </x-card>
    </div>
</div>
@endsection
