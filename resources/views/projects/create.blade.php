@extends('layouts.app')

@section('title', 'Pasang Proyek Baru - Garuda-Hub')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
    <h1 class="text-2xl font-black text-slate-900 mb-2">Pasang Proyek Lelang Baru</h1>
    <p class="text-sm text-slate-500 mb-6">Lengkapi detail proyek Anda agar para developer dapat memberikan tawaran terbaik.</p>

    <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Proyek</label>
            <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Aplikasi Absensi Karyawan Berbasis Web"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('judul') border-red-500 @enderror">
            @error('judul') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori</label>
                <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="Web">Web Development</option>
                    <option value="Mobile">Mobile App</option>
                    <option value="Desain">UI/UX Design</option>
                    <option value="Data">Data & Database</option>
                    <option value="AI">Artificial Intelligence</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Batas Akhir Lelang</label>
                <input type="date" name="batas_lelang" value="{{ old('batas_lelang', date('Y-m-d', strtotime('+30 days'))) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('batas_lelang') border-red-500 @enderror">
                @error('batas_lelang') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Budget Minimum (Rp)</label>
                <input type="number" name="budget_min" value="{{ old('budget_min') }}" required min="0" placeholder="5000000"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('budget_min') border-red-500 @enderror">
                @error('budget_min') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Budget Maksimum (Rp)</label>
                <input type="number" name="budget_max" value="{{ old('budget_max') }}" required min="0" placeholder="10000000"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('budget_max') border-red-500 @enderror">
                @error('budget_max') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Deskripsi Lengkap & Spesifikasi</label>
            <textarea name="deskripsi" rows="5" required placeholder="Jelaskan ruang lingkup pekerjaan, modul utama, dan teknologi yang diharapkan..."
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md transition">Publikasikan Proyek</button>
        </div>
    </form>
</div>
@endsection
