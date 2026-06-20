@extends('layouts.app')

@section('title', 'Keranjang Belanja - Seafood 2000')

@section('content')
<div class="max-w-4xl mx-auto my-12 px-4">
    <h1 class="text-3xl font-extrabold text-slate-800 mb-8 flex items-center gap-2.5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 text-teal-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
        </svg>
        Keranjang Belanja
    </h1>

    @if(empty($cart))
        <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-md">
            <div class="inline-flex p-4 bg-teal-50 text-teal-600 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 animate-bounce">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-700">Keranjang Anda Kosong</h3>
            <p class="text-slate-400 text-sm mt-1.5 mb-6">Anda belum menambahkan hidangan lezat ke keranjang Anda.</p>
            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-1.5 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md shadow-teal-600/10">
                Pilih Menu Makanan
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $key => $item)
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5 flex gap-4 items-center relative group">
                        
                        <!-- Thumbnail -->
                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-50 flex-shrink-0">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        </div>

                        <!-- Item details -->
                        <div class="flex-grow min-w-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm sm:text-base leading-snug truncate">{{ $item['name'] }}</h3>
                                    @if($item['cooking_option'])
                                        <span class="inline-block bg-teal-50 text-teal-700 text-[10px] font-bold px-2 py-0.5 rounded mt-1">
                                            Masakan: {{ $item['cooking_option'] }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Remove item -->
                                <form action="{{ route('cart.remove', $key) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-slate-400 hover:text-rose-500 p-1.5 rounded-lg hover:bg-rose-50 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <div class="flex justify-between items-center mt-4 pt-3 border-t border-slate-50">
                                <span class="text-slate-400 text-xs font-semibold">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }} / porsi
                                </span>
                                
                                <!-- Quantity controls -->
                                <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center gap-1.5">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                           onchange="this.form.submit()" 
                                           class="w-12 text-center text-xs font-extrabold text-slate-800 bg-slate-100 rounded-lg py-1 border-0 focus:ring-2 focus:ring-teal-500">
                                    <span class="text-slate-800 font-extrabold text-xs ml-2">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </span>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Order Summary Sidebar -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-6 h-fit">
                <h3 class="font-extrabold text-slate-800 text-lg mb-4">Ringkasan Pesanan</h3>
                <div class="space-y-3 pb-4 border-b border-slate-100 text-sm">
                    <div class="flex justify-between text-slate-500 font-medium">
                        <span>Total Item</span>
                        <span>{{ array_sum(array_column($cart, 'quantity')) }} porsi</span>
                    </div>
                </div>

                <div class="flex justify-between items-center py-4 text-slate-800">
                    <span class="font-bold">Total Pembayaran</span>
                    <span class="font-black text-xl text-teal-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <a href="{{ route('cart.checkout') }}" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md shadow-teal-600/10 block text-center text-sm mt-4 hover:scale-[1.01]">
                    Lanjutkan ke Pembayaran
                </a>
                
                <a href="{{ route('menu.index') }}" class="w-full bg-slate-50 hover:bg-slate-100 text-slate-600 font-semibold py-3 px-4 rounded-xl transition-all block text-center text-xs mt-3 border border-slate-200/50">
                    &larr; Tambah Menu Lagi
                </a>
            </div>

        </div>
    @endif
</div>
@endsection
