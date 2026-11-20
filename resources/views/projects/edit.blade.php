@extends('layouts.app')

@section('title', 'Edit Proyek - Garuda-Hub')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
    <h1 class="text-2xl font-black text-slate-900 mb-2">Edit Data Proyek</h1>

    <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Proyek</label>
            <input type="text" name="judul" value="{{ old('judul', $project->judul) }}" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori</label>
                <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @foreach(['Web', 'Mobile', 'Desain', 'Data', 'AI'] as $cat)
                        <option value="{{ $cat }}" {{ (old('kategori', $project->kategori) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Batas Lelang</label>
                <input type="date" name="batas_lelang" value="{{ old('batas_lelang', $project->batas_lelang->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Status</label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="terbuka" {{ old('status', $project->status) == 'terbuka' ? 'selected' : '' }}>Terbuka</option>
                    <option value="ditutup" {{ old('status', $project->status) == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Budget Minimum (Rp)</label>
                <input type="number" name="budget_min" value="{{ old('budget_min', $project->budget_min) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Budget Maksimum (Rp)</label>
                <input type="number" name="budget_max" value="{{ old('budget_max', $project->budget_max) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Deskripsi Proyek</label>
            <textarea name="deskripsi" rows="5" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('deskripsi', $project->deskripsi) }}</textarea>
        </div>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('projects.show', $project) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
