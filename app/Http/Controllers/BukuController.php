<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar buku
     */
    public function index()
    {
        $bukus = Buku::paginate(10);
        return view('buku.index', compact('bukus'));
    }

    /**
     * Tampilkan form tambah buku
     */
    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('buku.index')->with('error', 'Hanya admin yang dapat menambah buku.');
        }
        return view('buku.create');
    }

    /**
     * Simpan buku baru
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('buku.index')->with('error', 'Hanya admin yang dapat menambah buku.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $buku = Buku::create([
            'judul' => $request->judul,
            'stok' => $request->stok,
        ]);

        // Log aktivitas
        Log::create([
            'aksi' => 'Tambah Buku',
            'deskripsi' => 'Menambahkan buku: ' . $buku->judul,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail buku
     */
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    /**
     * Tampilkan form edit buku
     */
    public function edit(Buku $buku)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('buku.index')->with('error', 'Hanya admin yang dapat mengedit buku.');
        }
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update buku
     */
    public function update(Request $request, Buku $buku)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('buku.index')->with('error', 'Hanya admin yang dapat mengedit buku.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $buku->update([
            'judul' => $request->judul,
            'stok' => $request->stok,
        ]);

        // Log aktivitas
        Log::create([
            'aksi' => 'Edit Buku',
            'deskripsi' => 'Mengedit buku: ' . $buku->judul,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Hapus buku
     */
    public function destroy(Buku $buku)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('buku.index')->with('error', 'Hanya admin yang dapat menghapus buku.');
        }

        $judul = $buku->judul;
        $buku->delete();

        // Log aktivitas
        Log::create([
            'aksi' => 'Hapus Buku',
            'deskripsi' => 'Menghapus buku: ' . $judul,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
