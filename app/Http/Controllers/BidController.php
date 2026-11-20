<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    /**
     * Simpan penawaran (bid) baru dari developer via Eloquent.
     */
    public function store(Request $request, Project $project)
    {
        $user = Auth::user();

        // Validasi otoritas: hanya developer yang bisa bid
        if (!$user->isDeveloper()) {
            return back()->with('error', 'Hanya akun Developer yang dapat mengajukan penawaran.');
        }

        // Proyek harus dalam keadaan terbuka
        if ($project->status !== 'terbuka') {
            return back()->with('error', 'Lelang untuk proyek ini telah ditutup.');
        }

        // Cek apakah developer sudah pernah menawar proyek ini sebelumnya
        $existingBid = Bid::where('project_id', $project->id)
            ->where('developer_id', $user->id)
            ->first();

        if ($existingBid) {
            return back()->with('error', 'Anda sudah mengajukan penawaran untuk proyek ini.');
        }

        $validated = $request->validate([
            'harga' => ['required', 'numeric', 'min:1'],
            'durasi' => ['required', 'integer', 'min:1'],
            'proposal' => ['required', 'string', 'min:10'],
        ]);

        Bid::create([
            'project_id' => $project->id,
            'developer_id' => $user->id,
            'harga' => $validated['harga'],
            'durasi' => $validated['durasi'],
            'proposal' => $validated['proposal'],
            'is_winner' => false,
        ]);

        return back()->with('success', 'Penawaran Anda berhasil diajukan!');
    }

    /**
     * Klien memilih tawaran pemenang lelang.
     */
    public function chooseWinner(Project $project, Bid $bid)
    {
        $user = Auth::user();

        // Validasi: hanya klien pemilik proyek atau admin yang dapat memilih pemenang
        if ($user->id !== $project->client_id && !$user->isAdmin()) {
            abort(403, 'Hanya pemilik proyek yang dapat memilih pemenang lelang.');
        }

        if ($bid->project_id !== $project->id) {
            abort(404, 'Penawaran tidak sesuai dengan proyek ini.');
        }

        // Reset semua pemenang pada proyek ini terlebih dahulu (jika ada)
        $project->bids()->update(['is_winner' => false]);

        // Tetapkan penawaran terpilih sebagai pemenang
        $bid->update(['is_winner' => true]);

        // Otomatis ubah status proyek menjadi ditutup
        $project->update(['status' => 'ditutup']);

        return back()->with('success', 'Selamat! Anda telah menetapkan pemenang lelang untuk proyek ini.');
    }

    /**
     * Developer membatalkan/menarik tawarannya (selama lelang terbuka dan belum menang).
     */
    public function destroy(Bid $bid)
    {
        $user = Auth::user();

        if ($user->id !== $bid->developer_id && !$user->isAdmin()) {
            abort(403, 'Anda tidak berhak menghapus penawaran ini.');
        }

        if ($bid->is_winner) {
            return back()->with('error', 'Penawaran yang sudah menang tidak dapat dibatalkan.');
        }

        $bid->delete();

        return back()->with('success', 'Penawaran berhasil ditarik.');
    }
}
