@extends('layouts.app')

@section('title', 'Daftar Akun Baru - Garuda-Hub')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-black text-slate-900">Buat Akun Garuda-Hub</h1>
        <p class="text-sm text-slate-500 mt-1">Pilih peran Anda dan mulai berkolaborasi</p>
    </div>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Andi Pratama"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('nama') border-red-500 @enderror">
            @error('nama') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="andi@example.com"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('email') border-red-500 @enderror">
            @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Peran Akun</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50">
                    <input type="radio" name="role" value="klien" class="text-indigo-600 focus:ring-indigo-500" {{ old('role', 'klien') === 'klien' ? 'checked' : '' }}>
                    <span class="ml-2 text-sm font-semibold text-slate-700">Klien</span>
                </label>
                <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50">
                    <input type="radio" name="role" value="developer" class="text-indigo-600 focus:ring-indigo-500" {{ old('role') === 'developer' ? 'checked' : '' }}>
                    <span class="ml-2 text-sm font-semibold text-slate-700">Developer</span>
                </label>
            </div>
            @error('role') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kata Sandi (Min. 6 Karakter)</label>
            <input type="password" name="password" required placeholder="••••••••"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('password') border-red-500 @enderror">
            @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required placeholder="••••••••"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>

        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md transition">
            Daftar Sekarang
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
        Sudah memiliki akun? <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Masuk</a>
    </div>
</div>
@endsection
