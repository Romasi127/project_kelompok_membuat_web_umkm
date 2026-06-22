@extends('layouts.app')

@section('title', 'Daftar Admin - Seafood 2000')

@section('content')
<div class="max-w-md mx-auto my-16 px-4">
    <div class="bg-slate-900 text-slate-100 rounded-3xl border border-slate-800 shadow-2xl p-8 relative overflow-hidden">
        
        <!-- Background accents -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-teal-500/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-rose-500/10 rounded-full blur-2xl"></div>
        
        <div class="text-center mb-8 relative z-10">
            <span class="inline-flex items-center justify-center p-2.5 bg-slate-800 rounded-2xl border border-slate-700 mb-4 text-teal-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-9 1.5h.008v.008H3v-.008Zm3 0h.008v.008H6v-.008Zm3 0h.008v.008H9v-.008ZM4 6h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z" />
                </svg>
            </span>
            <h2 class="text-2xl font-black text-white">Daftar Admin Baru</h2>
            <p class="text-slate-400 text-xs mt-2 font-semibold tracking-wider uppercase">SEAFOOD 2000</p>
        </div>

        <form action="{{ route('admin.register') }}" method="POST" class="space-y-6 relative z-10">
            @csrf

            <div>
                <label for="name" class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:bg-slate-800/80 focus:border-teal-500 focus:ring-4 focus:ring-teal-900/50 outline-none transition-all text-sm @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-rose-400 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">Email Admin</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:bg-slate-800/80 focus:border-teal-500 focus:ring-4 focus:ring-teal-900/50 outline-none transition-all text-sm @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-rose-400 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:bg-slate-800/80 focus:border-teal-500 focus:ring-4 focus:ring-teal-900/50 outline-none transition-all text-sm @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-rose-400 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:bg-slate-800/80 focus:border-teal-500 focus:ring-4 focus:ring-teal-900/50 outline-none transition-all text-sm">
            </div>

            <div class="bg-amber-950/20 border border-amber-500/20 rounded-xl p-3 text-xs text-amber-300 font-medium">
                ⚠️ Pendaftaran akun administrator baru harus dilakukan dengan persetujuan manajemen Seafood 2000.
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-900 font-black py-3.5 px-4 rounded-xl transition-all hover:scale-[1.01] active:scale-100 text-sm tracking-wider uppercase">
                Daftar Akun Admin
            </button>
        </form>

        <div class="border-t border-slate-800/80 mt-8 pt-6 text-center relative z-10 flex flex-col gap-2">
            <p class="text-xs text-slate-400">Sudah punya akun admin? <a href="{{ route('admin.login') }}" class="font-bold text-teal-400 hover:text-teal-300">Login Sistem</a></p>
            <a href="{{ route('menu.index') }}" class="text-xs font-bold text-slate-500 hover:text-white transition-colors mt-2 flex items-center justify-center gap-1.5">
                &larr; Kembali ke Menu Utama
            </a>
        </div>
    </div>
</div>
@endsection
