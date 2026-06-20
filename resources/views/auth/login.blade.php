@extends('layouts.app')

@section('title', 'Masuk - Seafood 2000')

@section('content')
<div class="max-w-md mx-auto my-16 px-4">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800">Selamat Datang</h2>
            <p class="text-slate-500 text-sm mt-2">Silakan masuk ke akun Anda untuk memesan menu favorit.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Kata Sandi</label>
                </div>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-teal-600 border-slate-300 rounded focus:ring-teal-500">
                <label for="remember" class="ml-2.5 text-sm text-slate-600 font-medium select-none">Ingat saya</label>
            </div>

            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md shadow-teal-600/10 hover:shadow-lg hover:scale-[1.01] active:scale-100 text-sm">
                Masuk Sekarang
            </button>
        </form>

        <div class="border-t border-slate-100 mt-8 pt-6 text-center">
            <p class="text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-teal-600 hover:text-teal-700">Daftar Akun</a></p>
        </div>
    </div>
</div>
@endsection
