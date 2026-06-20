@extends('layouts.app')

@section('title', 'Daftar - Seafood 2000')

@section('content')
<div class="max-w-md mx-auto my-16 px-4">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800">Daftar Akun Baru</h2>
            <p class="text-slate-500 text-sm mt-2">Buat akun untuk mulai memesan makanan secara online.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm">
            </div>

            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md shadow-teal-600/10 hover:shadow-lg hover:scale-[1.01] active:scale-100 text-sm">
                Daftar Sekarang
            </button>
        </form>

        <div class="border-t border-slate-100 mt-8 pt-6 text-center">
            <p class="text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-teal-600 hover:text-teal-700">Masuk Akun</a></p>
        </div>
    </div>
</div>
@endsection
