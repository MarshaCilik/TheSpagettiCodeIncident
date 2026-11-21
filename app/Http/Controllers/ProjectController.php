<?php

namespace App\Http\Controllers;

/**
 * ProjectController - Mengelola Lelang Proyek IT
 * Mahasiswa : Marsha Hafiz Devara
 * NIM       : 252410102057
 * Keamanan  : Eloquent ORM (Anti-SQLi) & Blade Output Encoding (Anti-Stored XSS)
 */

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Tampilkan katalog proyek lelang (dengan fitur filter & pencarian).
     */
    public function index(Request $request)
    {
        $query = Project::with(['client', 'bids']);

        // Search berdasarkan judul atau deskripsi
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $projects = $query->latest()->paginate(9)->withQueryString();
        $categories = Project::select('kategori')->distinct()->pluck('kategori');

        return view('projects.index', compact('projects', 'categories'));
    }

    /**
     * Tampilkan form pembuatan proyek baru (hanya klien & admin).
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role === 'developer') {
            return redirect()->route('projects.index')->with('error', 'Hanya akun Klien yang dapat memasang proyek.');
        }

        return view('projects.create');
    }

    /**
     * Simpan proyek baru ke database via Eloquent.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'developer') {
            abort(403, 'Aksi tidak diizinkan untuk developer.');
        }

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'kategori' => ['required', 'string', 'max:50'],
            'budget_min' => ['required', 'numeric', 'min:0'],
            'budget_max' => ['required', 'numeric', 'gte:budget_min'],
            'batas_lelang' => ['required', 'date', 'after_or_equal:today'],
            'deskripsi' => ['required', 'string'],
        ]);

        $project = Project::create([
            'client_id' => $user->id,
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'budget_min' => $validated['budget_min'],
            'budget_max' => $validated['budget_max'],
            'batas_lelang' => $validated['batas_lelang'],
            'deskripsi' => $validated['deskripsi'],
            'status' => 'terbuka',
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Proyek berhasil dipublikasikan!');
    }

    /**
     * Tampilkan detail proyek lelang beserta daftar penawaran (bids).
     */
    public function show(Project $project)
    {
        $project->load(['client', 'bids.developer', 'winningBid.developer']);
        $user = Auth::user();

        $userBid = null;
        if ($user && $user->isDeveloper()) {
            $userBid = $project->bids->firstWhere('developer_id', $user->id);
        }

        return view('projects.show', compact('project', 'userBid'));
    }

    /**
     * Form edit proyek (hanya pemilik proyek atau admin).
     */
    public function edit(Project $project)
    {
        $user = Auth::user();
        if ($user->id !== $project->client_id && !$user->isAdmin()) {
            abort(403, 'Anda bukan pemilik proyek ini.');
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update data proyek via Eloquent.
     */
    public function update(Request $request, Project $project)
    {
        $user = Auth::user();
        if ($user->id !== $project->client_id && !$user->isAdmin()) {
            abort(403, 'Anda bukan pemilik proyek ini.');
        }

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'kategori' => ['required', 'string', 'max:50'],
            'budget_min' => ['required', 'numeric', 'min:0'],
            'budget_max' => ['required', 'numeric', 'gte:budget_min'],
            'batas_lelang' => ['required', 'date'],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', 'in:terbuka,ditutup'],
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Data proyek berhasil diperbarui.');
    }

    /**
     * Hapus proyek (hanya pemilik proyek atau admin).
     */
    public function destroy(Project $project)
    {
        $user = Auth::user();
        if ($user->id !== $project->client_id && !$user->isAdmin()) {
            abort(403, 'Anda tidak berhak menghapus proyek ini.');
        }

        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Proyek berhasil dihapus.');
    }
}
