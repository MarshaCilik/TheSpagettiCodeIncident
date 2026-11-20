@extends('layouts.app')

@section('title', 'Dashboard Klien - Garuda-Hub')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Dashboard Klien</h1>
            <p class="text-sm text-slate-500">Kelola lelang proyek yang telah Anda publikasikan</p>
        </div>
        <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-sm transition">
            + Pasang Proyek Baru
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold uppercase text-slate-400">Total Proyek Dipasang</div>
                <div class="text-3xl font-black text-slate-900 mt-1">{{ $totalPosted }}</div>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold uppercase text-slate-400">Lelang Aktif (Terbuka)</div>
                <div class="text-3xl font-black text-emerald-600 mt-1">{{ $activePosted }}</div>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- My Projects List -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Daftar Proyek Saya</h2>
        <div class="divide-y divide-slate-100">
            @forelse($myProjects as $project)
                <div class="py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-bold uppercase px-2.5 py-0.5 rounded-full {{ $project->status === 'terbuka' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $project->status }}
                            </span>
                            <a href="{{ route('projects.show', $project) }}" class="text-base font-bold text-slate-900 hover:text-indigo-600">
                                {{ $project->judul }}
                            </a>
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            Batas lelang: {{ $project->batas_lelang->format('d M Y') }} • Masuk: <strong>{{ $project->bids->count() }} tawaran</strong>
                            @if($project->winningBid)
                                • Pemenang: <span class="font-bold text-emerald-600">{{ $project->winningBid->developer->nama }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('projects.show', $project) }}" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold rounded-lg text-xs transition">
                            Lihat Penawaran
                        </a>
                        <a href="{{ route('projects.edit', $project) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg text-xs transition">
                            Edit
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 text-sm">
                    Anda belum memasang proyek apapun. Silakan pasang proyek pertama Anda!
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
