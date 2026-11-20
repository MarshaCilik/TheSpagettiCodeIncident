@extends('layouts.app')

@section('title', 'Katalog Proyek Lelang - Garuda-Hub')

@section('content')
<div class="space-y-6">
    <!-- Hero / Header Section -->
    <div class="bg-gradient-to-r from-indigo-700 via-indigo-600 to-blue-600 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Temukan Proyek & Tawarkan Solusi Anda</h1>
            <p class="mt-2 text-indigo-100 max-w-xl text-sm md:text-base leading-relaxed">
                Platform lelang proyek IT terpercaya mahasiswa: hubungkan kebutuhan klien dengan talenta software engineer terbaik.
            </p>
        </div>
        @auth
            @if(Auth::user()->isClient())
                <a href="{{ route('projects.create') }}" class="px-6 py-3 bg-white text-indigo-700 hover:bg-slate-100 font-bold rounded-xl shadow-md transition whitespace-nowrap">
                    + Buat Proyek Baru
                </a>
            @endif
        @endauth
    </div>

    <!-- Search & Filter Form -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('projects.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul proyek atau kata kunci..." 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>
            <div>
                <select name="kategori" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Semua Status</option>
                    <option value="terbuka" {{ request('status') == 'terbuka' ? 'selected' : '' }}>Terbuka</option>
                    <option value="ditutup" {{ request('status') == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Project Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-lg transition duration-200">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                            {{ $project->kategori }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $project->status === 'terbuka' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $project->status }}
                        </span>
                    </div>

                    <h2 class="text-lg font-bold text-slate-900 line-clamp-1 hover:text-indigo-600">
                        <a href="{{ route('projects.show', $project) }}">{{ $project->judul }}</a>
                    </h2>

                    <p class="mt-2 text-sm text-slate-500 line-clamp-3">
                        {{ $project->deskripsi }}
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex justify-between items-center text-xs text-slate-500 mb-2">
                        <span>Klien: <strong class="text-slate-700">{{ $project->client->nama }}</strong></span>
                        <span>{{ $project->bids->count() }} Tawaran Masuk</span>
                    </div>

                    <div class="flex justify-between items-end">
                        <div>
                            <div class="text-xs text-slate-400">Estimasi Budget:</div>
                            <div class="text-sm font-extrabold text-indigo-600">
                                Rp {{ number_format($project->budget_min, 0, ',', '.') }} - {{ number_format($project->budget_max, 0, ',', '.') }}
                            </div>
                        </div>
                        <a href="{{ route('projects.show', $project) }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-700 rounded-lg text-xs font-bold transition">
                            Detail &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center bg-white rounded-2xl border border-slate-200">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="mt-4 text-base font-semibold text-slate-600">Tidak ada proyek yang cocok dengan pencarian Anda.</p>
                <a href="{{ route('projects.index') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:underline">Reset Filter</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $projects->links() }}
    </div>
</div>
@endsection
