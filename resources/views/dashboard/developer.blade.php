@extends('layouts.app')

@section('title', 'Dashboard Developer - Garuda-Hub')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Dashboard Developer</h1>
            <p class="text-sm text-slate-500">Pantau seluruh riwayat penawaran dan proyek yang Anda menangkan</p>
        </div>
        <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-sm transition">
            Jelajahi Proyek Lelang
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold uppercase text-slate-400">Total Penawaran Diajukan</div>
                <div class="text-3xl font-black text-slate-900 mt-1">{{ $totalBids }}</div>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-xs font-bold uppercase text-slate-400">Lelang Dimenangkan</div>
                <div class="text-3xl font-black text-emerald-600 mt-1">{{ $wonBids }}</div>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
        </div>
    </div>

    <!-- My Bids List -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Riwayat Penawaran Saya</h2>
        <div class="divide-y divide-slate-100">
            @forelse($myBids as $bid)
                <div class="py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('projects.show', $bid->project) }}" class="text-base font-bold text-slate-900 hover:text-indigo-600">
                                {{ $bid->project->judul }}
                            </a>
                            @if($bid->is_winner)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">🏆 Menang</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $bid->project->status === 'terbuka' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $bid->project->status === 'terbuka' ? 'Menunggu Seleksi' : 'Selesai' }}
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            Klien: <strong>{{ $bid->project->client->nama }}</strong> • Tawaran Anda: <strong class="text-indigo-600">Rp {{ number_format($bid->harga, 0, ',', '.') }}</strong> ({{ $bid->durasi }} hari)
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('projects.show', $bid->project) }}" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold rounded-lg text-xs transition">
                            Lihat Proyek
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 text-sm">
                    Anda belum mengajukan tawaran pada proyek apapun.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
