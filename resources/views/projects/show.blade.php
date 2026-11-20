@extends('layouts.app')

@section('title', $project->judul . ' - Garuda-Hub')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-2 text-sm text-slate-500">
        <a href="{{ route('projects.index') }}" class="hover:text-indigo-600">Katalog Proyek</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold truncate">{{ $project->judul }}</span>
    </div>

    <!-- Project Details Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-6">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                        {{ $project->kategori }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $project->status === 'terbuka' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        Status: {{ $project->status }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $project->judul }}</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Dipasang oleh <strong class="text-slate-700">{{ $project->client->nama }}</strong> • Batas Lelang: <strong class="text-slate-700">{{ $project->batas_lelang->format('d M Y') }}</strong>
                </p>
            </div>

            <div class="text-right">
                <div class="text-xs text-slate-400">Budget Penawaran</div>
                <div class="text-xl sm:text-2xl font-black text-indigo-600">
                    Rp {{ number_format($project->budget_min, 0, ',', '.') }} - {{ number_format($project->budget_max, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="py-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi Proyek</h3>
            <div class="text-slate-700 leading-relaxed whitespace-pre-line text-base">
                {{ $project->deskripsi }}
            </div>
        </div>

        @if(Auth::check() && (Auth::id() === $project->client_id || Auth::user()->isAdmin()))
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg text-sm transition">
                    Edit Proyek
                </a>
                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold rounded-lg text-sm transition">
                        Hapus Proyek
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Pemenang Lelang Highlight (Jika Ada) -->
    @if($project->winningBid)
        <div class="bg-emerald-50 border-2 border-emerald-300 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center space-x-3">
                <span class="p-2 bg-emerald-500 text-white rounded-xl">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                </span>
                <div>
                    <h3 class="text-lg font-bold text-emerald-900">Pemenang Lelang Ditetapkan!</h3>
                    <p class="text-sm text-emerald-700">
                        Pemenang: <strong>{{ $project->winningBid->developer->nama }}</strong> | Nilai Kontrak: <strong>Rp {{ number_format($project->winningBid->harga, 0, ',', '.') }}</strong> ({{ $project->winningBid->durasi }} hari)
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Pengajuan Penawaran (Khusus Developer Saat Status Terbuka) -->
    @auth
        @if(Auth::user()->isDeveloper() && $project->status === 'terbuka')
            @if($userBid)
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-base font-bold text-blue-900">Penawaran Anda Sudah Diajukan</h3>
                            <p class="text-sm text-blue-700 mt-1">
                                Harga: <strong>Rp {{ number_format($userBid->harga, 0, ',', '.') }}</strong> • Estimasi: <strong>{{ $userBid->durasi }} hari</strong>
                            </p>
                            <p class="text-xs text-blue-600 mt-2 italic">"{{ $userBid->proposal }}"</p>
                        </div>
                        <form action="{{ route('bids.destroy', $userBid) }}" method="POST" onsubmit="return confirm('Tarik penawaran Anda?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-600 hover:underline font-semibold">Tarik Penawaran</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Ajukan Penawaran (Bid) Anda</h3>
                    <form action="{{ route('bids.store', $project) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Harga Penawaran (Rp)</label>
                                <input type="number" name="harga" required min="1" value="{{ old('harga') }}" placeholder="Contoh: 7500000"
                                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Durasi Pengerjaan (Hari)</label>
                                <input type="number" name="durasi" required min="1" value="{{ old('durasi') }}" placeholder="Contoh: 30"
                                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Deskripsi Proposal & Strategi</label>
                            <textarea name="proposal" rows="3" required placeholder="Jelaskan keahlian dan bagaimana Anda akan menyelesaikan proyek ini..."
                                class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('proposal') }}</textarea>
                        </div>
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition">
                            Kirim Penawaran
                        </button>
                    </form>
                </div>
            @endif
        @endif
    @else
        <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 text-center">
            <p class="text-indigo-900 font-medium text-sm">Tertarik mengajukan penawaran pada proyek ini?</p>
            <div class="mt-3 space-x-3">
                <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-lg transition">Masuk untuk Menawar</a>
                <a href="{{ route('register') }}" class="inline-block px-4 py-2 bg-white hover:bg-slate-100 text-indigo-600 font-semibold text-xs rounded-lg transition border border-indigo-200">Daftar Akun Developer</a>
            </div>
        </div>
    @endauth

    <!-- Daftar Penawaran Masuk -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-900">Daftar Penawaran ({{ $project->bids->count() }})</h3>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($project->bids as $bid)
                <div class="py-4 flex flex-col md:flex-row md:items-center justify-between gap-4 {{ $bid->is_winner ? 'bg-emerald-50/50 -mx-6 px-6' : '' }}">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="font-bold text-slate-800">{{ $bid->developer->nama }}</span>
                            @if($bid->is_winner)
                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">🏆 Pemenang</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $bid->proposal }}</p>
                        <div class="text-xs text-slate-400">Durasi: {{ $bid->durasi }} hari • Diajukan: {{ $bid->created_at->diffForHumans() }}</div>
                    </div>

                    <div class="flex items-center md:flex-col md:items-end justify-between gap-2 whitespace-nowrap">
                        <span class="text-base font-extrabold text-indigo-600">Rp {{ number_format($bid->harga, 0, ',', '.') }}</span>

                        @if(Auth::check() && (Auth::id() === $project->client_id || Auth::user()->isAdmin()) && !$bid->is_winner && $project->status === 'terbuka')
                            <form action="{{ route('bids.chooseWinner', [$project, $bid]) }}" method="POST" onsubmit="return confirm('Pilih {{ $bid->developer->nama }} sebagai pemenang lelang?')">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition shadow-sm">
                                    Pilih Pemenang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 text-sm">
                    Belum ada penawaran yang diajukan untuk proyek ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
