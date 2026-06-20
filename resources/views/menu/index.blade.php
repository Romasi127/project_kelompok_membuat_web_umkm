@extends('layouts.app')

@section('title', 'Menu Hidangan - Seafood 2000')

@section('content')

<!-- Hero Section -->
<section class="relative h-[300px] md:h-[400px] overflow-hidden rounded-b-[40px] shadow-lg">
    <!-- Image background -->
    <img src="{{ asset('images/seafood_banner.png') }}" alt="Seafood 2000 Banner" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/40 to-transparent"></div>
    <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-12 max-w-7xl mx-auto">
        <span class="text-teal-400 text-xs md:text-sm font-extrabold uppercase tracking-wider mb-2">Medan - Sejak 2000</span>
        <h1 class="text-3xl md:text-5xl font-black text-white leading-tight">SEAFOOD 2000</h1>
        <p class="text-slate-200 text-sm md:text-base max-w-md mt-2">Hidangan Laut Segar & Nasi Uduk Khas Medan. Kualitas Bintang Lima, Harga Kaki Lima.</p>
        <p class="text-teal-300 text-xs mt-3 flex items-center gap-1.5 font-semibold">
            <span>📍 Jl. Ringroad - Medan</span>
            <span>•</span>
            <span>📞 0858 3370 9981</span>
        </p>
    </div>
</section>

<!-- Filter and Catalog Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    
    <!-- Search and Tabs Grid -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-200">
        
        <!-- Tabs category -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none">
            <a href="{{ route('menu.index') }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ !request('category') ? 'bg-teal-600 text-white shadow-md shadow-teal-600/15' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                Semua Menu
            </a>
            @foreach($categories as $category)
                <a href="{{ route('menu.index', ['category' => $category, 'search' => request('search')]) }}" 
                   class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ request('category') === $category ? 'bg-teal-600 text-white shadow-md shadow-teal-600/15' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>

        <!-- Search Bar -->
        <form action="{{ route('menu.index') }}" method="GET" class="relative w-full md:w-80">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lele, cumi, es teh..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-white border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-xs">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z" />
                </svg>
            </span>
            @if(request('search'))
                <a href="{{ route('menu.index', ['category' => request('category')]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-rose-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </a>
            @endif
        </form>

    </div>

    <!-- Menus Catalog Grid -->
    @if($menus->isEmpty())
        <div class="my-16 text-center">
            <div class="inline-flex p-4 bg-slate-100 rounded-full text-slate-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-700">Menu Tidak Ditemukan</h3>
            <p class="text-slate-400 text-sm mt-1">Silakan cari dengan kata kunci lain atau pilih kategori yang berbeda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
            @foreach($menus as $menu)
                <div class="bg-white rounded-3xl border border-slate-100 shadow-md hover:shadow-xl transition-all overflow-hidden flex flex-col group">
                    
                    <!-- Menu Image Container -->
                    <div class="h-52 overflow-hidden relative bg-slate-100 flex items-center justify-center">
                        <img src="{{ asset($menu->image ?? 'images/pecel_lele.png') }}" alt="{{ $menu->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-4 left-4 bg-teal-600 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md">
                            {{ $menu->category }}
                        </span>
                    </div>

                    <!-- Menu Details -->
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start gap-2 mb-2">
                                <h3 class="text-lg font-bold text-slate-800">{{ $menu->name }}</h3>

                                @php
                                    // Hitung range harga dari cooking_options
                                    $priceMin = $menu->price;
                                    $priceMax = $menu->price;
                                    if ($menu->cooking_options && count($menu->cooking_options) > 0) {
                                        $optPrices = collect($menu->cooking_options)
                                            ->map(fn($o) => is_array($o) ? (int)($o['price'] ?? $menu->price) : $menu->price)
                                            ->filter(fn($p) => $p > 0);
                                        if ($optPrices->isNotEmpty()) {
                                            $priceMin = $optPrices->min();
                                            $priceMax = $optPrices->max();
                                        }
                                    }
                                    $isRange = ($priceMin !== $priceMax);
                                @endphp

                                <span class="menu-price-display text-teal-600 font-extrabold text-base whitespace-nowrap text-right"
                                      data-base-price="{{ $menu->price }}"
                                      data-price-min="{{ $priceMin }}"
                                      data-price-max="{{ $priceMax }}">
                                    @if($isRange)
                                        Rp {{ number_format($priceMin, 0, ',', '.') }}<br>
                                        <span class="text-[11px] font-semibold text-slate-400">s/d</span>
                                        Rp {{ number_format($priceMax, 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($priceMin, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                            <p class="text-slate-500 text-xs leading-relaxed mb-6">
                                {{ $menu->description ?? 'Cita rasa laut khas khas Seafood 2000 dengan bahan bumbu rempah lokal segar.' }}
                            </p>
                        </div>

                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-4 pt-4 border-t border-slate-50">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            
                            <div class="flex gap-3">
                                <!-- Cooking Options Dropdown if exists -->
                                @if($menu->cooking_options)
                                    <div class="flex-grow">
                                        <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Masakan</label>
                                        <select name="cooking_option" required
                                                class="cooking-select w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all font-semibold"
                                                onchange="updateMenuPrice(this)">
                                            @foreach($menu->cooking_options as $option)
                                                @php
                                                    $optName  = is_array($option) ? ($option['name']  ?? $option) : $option;
                                                    $optPrice = is_array($option) ? ($option['price'] ?? $menu->price) : $menu->price;
                                                @endphp
                                                <option value="{{ $optName }}" data-price="{{ $optPrice }}">
                                                    {{ $optName }} — Rp {{ number_format($optPrice, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <!-- Quantity -->
                                <div class="{{ $menu->cooking_options ? 'w-20' : 'w-full' }}">
                                    <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Jumlah</label>
                                    <input type="number" name="quantity" value="1" min="1" required
                                           class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 text-center outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all font-bold">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-teal-50 hover:bg-teal-600 text-teal-700 hover:text-white font-bold py-2.5 px-4 rounded-xl transition-all text-xs flex items-center justify-center gap-1.5 border border-teal-200/50 hover:border-teal-600 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Tambah Keranjang
                            </button>
                        </form>

                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
function updateMenuPrice(selectEl) {
    const card      = selectEl.closest('.group');
    const priceSpan = card ? card.querySelector('.menu-price-display') : null;
    if (!priceSpan) return;

    const selectedOpt = selectEl.options[selectEl.selectedIndex];
    const price       = parseInt(selectedOpt.dataset.price) || parseInt(priceSpan.dataset.basePrice) || 0;

    // Animasi fade
    priceSpan.style.transition = 'opacity 0.15s';
    priceSpan.style.opacity    = '0';
    setTimeout(() => {
        priceSpan.innerHTML = 'Rp ' + price.toLocaleString('id-ID');
        priceSpan.style.opacity = '1';
    }, 150);
}

// TIDAK auto-update saat load → biarkan range harga tampil dulu
// Range hanya berubah setelah user memilih pilihan masakan
</script>
@endpush
