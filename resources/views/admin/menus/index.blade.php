@extends('layouts.admin')

@section('page_title', 'Kelelola Menu Makanan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Top actions bar -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-200/50">
        <p class="text-xs text-slate-500 font-semibold">Menampilkan daftar hidangan menu Seafood 2000.</p>
        <a href="{{ route('admin.menus.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-4 rounded-xl transition-all text-xs flex items-center gap-1.5 shadow-md shadow-teal-600/10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7-7H5" />
            </svg>
            Tambah Menu Baru
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black uppercase text-slate-400 tracking-wider">
                        <th class="py-4 px-6">Foto</th>
                        <th class="py-4 px-6">Nama Menu</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Harga</th>
                        <th class="py-4 px-6">Pilihan Masakan</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($menus as $menu)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 flex-shrink-0">
                                    <img src="{{ asset($menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800 text-sm leading-snug">{{ $menu->name }}</p>
                                <p class="text-slate-400 text-[10px] mt-0.5 max-w-xs truncate">{{ $menu->description ?? 'Tidak ada deskripsi.' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-slate-100 text-slate-600 font-bold px-2.5 py-1 rounded-full text-[10px] uppercase">
                                    {{ $menu->category }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-extrabold text-slate-800 text-sm">
                                @php
                                    $adminPrices = collect($menu->cooking_options ?? [])
                                        ->map(fn($o) => is_array($o) ? (int)($o['price'] ?? 0) : 0)
                                        ->filter(fn($p) => $p > 0);
                                    $adminMin = $adminPrices->isNotEmpty() ? $adminPrices->min() : $menu->price;
                                    $adminMax = $adminPrices->isNotEmpty() ? $adminPrices->max() : $menu->price;
                                @endphp
                                @if($adminPrices->isNotEmpty() && $adminMin !== $adminMax)
                                    <span class="text-teal-700">Rp {{ number_format($adminMin, 0, ',', '.') }}</span>
                                    <span class="text-slate-400 font-normal mx-0.5">–</span>
                                    <span class="text-teal-700">Rp {{ number_format($adminMax, 0, ',', '.') }}</span>
                                @else
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($menu->cooking_options)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($menu->cooking_options as $option)
                                            @php
                                                $oName  = is_array($option) ? ($option['name']  ?? $option) : $option;
                                                $oPrice = is_array($option) ? ($option['price'] ?? null) : null;
                                            @endphp
                                            <span class="bg-teal-50 text-teal-700 font-semibold px-2 py-0.5 rounded text-[9px]">
                                                {{ $oName }}
                                                @if($oPrice)
                                                    <span class="text-teal-500 font-normal">· Rp {{ number_format($oPrice, 0, ',', '.') }}</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400 font-medium">Bawaan (Tidak Ada Pilihan)</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 rounded-xl transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-xl transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Belum ada menu terdaftar. Silakan tambahkan menu baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($menus->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $menus->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
