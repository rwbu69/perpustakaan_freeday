<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\Peminjam;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar transaksi
     */
    public function index()
    {
        $transaksis = Transaksi::with(['buku', 'peminjam'])->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Tampilkan form tambah transaksi
     */
    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('transaksi.index')->with('error', 'Hanya admin yang dapat membuat transaksi.');
        }
        
        $bukus = Buku::where('stok', '>', 0)->get();
        $peminjams = Peminjam::all();
        
        return view('transaksi.create', compact('bukus', 'peminjams'));
    }

    /**
     * Simpan transaksi baru
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('transaksi.index')->with('error', 'Hanya admin yang dapat membuat transaksi.');
        }

        $request->validate([
            'idBuku' => 'required|exists:buku,idBuku',
            'idPeminjam' => 'required|exists:peminjam,idPeminjam',
            'tglPinjam' => 'required|date',
        ]);

        // Cek stok buku
        $buku = Buku::find($request->idBuku);
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        $transaksi = Transaksi::create([
            'idBuku' => $request->idBuku,
            'idPeminjam' => $request->idPeminjam,
            'tglPinjam' => $request->tglPinjam,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi peminjaman berhasil dibuat.');
    }

    /**
     * Tampilkan detail transaksi
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['buku', 'peminjam']);
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Proses pengembalian buku
     */
    public function kembalikan(Request $request, Transaksi $transaksi)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('transaksi.index')->with('error', 'Hanya admin yang dapat memproses pengembalian.');
        }

        if ($transaksi->tglKembali) {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $request->validate([
            'tglKembali' => 'required|date|after_or_equal:' . $transaksi->tglPinjam,
        ]);

        $transaksi->update([
            'tglKembali' => $request->tglKembali,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    /**
     * Hapus transaksi (hanya jika belum dikembalikan)
     */
    public function destroy(Transaksi $transaksi)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('transaksi.index')->with('error', 'Hanya admin yang dapat menghapus transaksi.');
        }

        if ($transaksi->tglKembali) {
            return back()->with('error', 'Tidak dapat menghapus transaksi yang sudah dikembalikan.');
        }

        // Kembalikan stok buku
        $buku = $transaksi->buku;
        $buku->increment('stok');

        // Log aktivitas
        Log::create([
            'aksi' => 'Hapus Transaksi',
            'deskripsi' => 'Menghapus transaksi peminjaman buku: ' . $buku->judul,
            'user_id' => Auth::id(),
        ]);

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
