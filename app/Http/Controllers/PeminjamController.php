<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar peminjam
     */
    public function index()
    {
        $peminjams = Peminjam::paginate(10);
        return view('peminjam.index', compact('peminjams'));
    }

    /**
     * Tampilkan form tambah peminjam
     */
    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('peminjam.index')->with('error', 'Hanya admin yang dapat menambah peminjam.');
        }
        return view('peminjam.create');
    }

    /**
     * Simpan peminjam baru
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('peminjam.index')->with('error', 'Hanya admin yang dapat menambah peminjam.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $peminjam = Peminjam::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        // Log aktivitas
        Log::create([
            'aksi' => 'Tambah Peminjam',
            'deskripsi' => 'Menambahkan peminjam: ' . $peminjam->nama,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail peminjam
     */
    public function show(Peminjam $peminjam)
    {
        $transaksis = $peminjam->transaksis()->with('buku')->get();
        return view('peminjam.show', compact('peminjam', 'transaksis'));
    }

    /**
     * Tampilkan form edit peminjam
     */
    public function edit(Peminjam $peminjam)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('peminjam.index')->with('error', 'Hanya admin yang dapat mengedit peminjam.');
        }
        return view('peminjam.edit', compact('peminjam'));
    }

    /**
     * Update peminjam
     */
    public function update(Request $request, Peminjam $peminjam)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('peminjam.index')->with('error', 'Hanya admin yang dapat mengedit peminjam.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $peminjam->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        // Log aktivitas
        Log::create([
            'aksi' => 'Edit Peminjam',
            'deskripsi' => 'Mengedit peminjam: ' . $peminjam->nama,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil diperbarui.');
    }

    /**
     * Hapus peminjam
     */
    public function destroy(Peminjam $peminjam)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('peminjam.index')->with('error', 'Hanya admin yang dapat menghapus peminjam.');
        }

        $nama = $peminjam->nama;
        $peminjam->delete();

        // Log aktivitas
        Log::create([
            'aksi' => 'Hapus Peminjam',
            'deskripsi' => 'Menghapus peminjam: ' . $nama,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil dihapus.');
    }
}
