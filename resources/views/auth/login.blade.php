@extends('layouts.app')

@section('title', 'Masuk - Garuda-Hub')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-black text-slate-900">Selamat Datang Kembali</h1>
        <p class="text-sm text-slate-500 mt-1">Masuk untuk mengelola lelang dan tawaran proyek Anda</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@example.com"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('email') border-red-500 @enderror">
            @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kata Sandi</label>
            <input type="password" name="password" required placeholder="••••••••"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded text-indigo-600 focus:ring-indigo-500">
                <span>Ingat saya</span>
            </label>
        </div>

        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md transition">
            Masuk ke Akun
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
        Belum memiliki akun? <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:underline">Daftar sekarang</a>
    </div>

    <div class="mt-4 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-500 space-y-1">
        <div class="font-bold text-slate-700">Akun Uji Coba (Password: password123):</div>
        <div>• Klien: <code>budi@example.com</code></div>
        <div>• Developer: <code>dewi@example.com</code></div>
        <div>• Admin: <code>admin@example.com</code></div>
    </div>
</div>
@endsection
