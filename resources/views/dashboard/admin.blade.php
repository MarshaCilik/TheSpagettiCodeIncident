@extends('layouts.app')

@section('title', 'Admin Panel - Garuda-Hub')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900">Admin Panel Garuda-Hub</h1>
        <p class="text-sm text-slate-500">Ringkasan statistik lelang proyek seluruh platform</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="text-xs font-bold uppercase text-slate-400">Total Proyek</div>
            <div class="text-3xl font-black text-slate-900 mt-1">{{ $totalProjects }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="text-xs font-bold uppercase text-slate-400">Lelang Terbuka</div>
            <div class="text-3xl font-black text-emerald-600 mt-1">{{ $openProjects }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="text-xs font-bold uppercase text-slate-400">Total Penawaran (Bids)</div>
            <div class="text-3xl font-black text-indigo-600 mt-1">{{ $totalBids }}</div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Proyek Terbaru</h2>
        <div class="divide-y divide-slate-100">
            @foreach($recentProjects as $project)
                <div class="py-3 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-slate-800">{{ $project->judul }}</div>
                        <div class="text-xs text-slate-500">Klien: {{ $project->client->nama }} • Status: {{ $project->status }} • {{ $project->bids->count() }} tawaran</div>
                    </div>
                    <a href="{{ route('projects.show', $project) }}" class="px-3 py-1 bg-slate-100 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-bold transition">
                        Kelola
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
