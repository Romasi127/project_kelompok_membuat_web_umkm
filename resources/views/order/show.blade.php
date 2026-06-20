@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan #' . $order->id . ' - Seafood 2000')

@section('content')
<div class="max-w-xl mx-auto my-12 px-4">
    
    <!-- Success Banner -->
    <div class="text-center mb-8">
        <span class="inline-flex p-3 bg-teal-50 text-teal-600 rounded-full mb-3 shadow-sm shadow-teal-500/10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </span>
        <h1 class="text-2xl font-black text-slate-800">Pesanan Berhasil Dibuat!</h1>
        <p class="text-slate-400 text-xs mt-1.5 font-semibold">Silakan simpan struk pembayaran di bawah ini.</p>
    </div>

    <!-- Digital Receipt Card -->
    <div class="bg-white rounded-3xl border border-slate-200/60 shadow-xl overflow-hidden print:shadow-none print:border-none relative" id="receipt-card">
        
        <!-- Top decorative dot details for retro receipt vibe -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-500"></div>

        <div class="p-8 space-y-6">
            
            <!-- Restaurant Header -->
            <div class="text-center pb-6 border-b border-dashed border-slate-200">
                <h2 class="text-2xl font-black tracking-tight text-slate-800">SEAFOOD 2000</h2>
                <p class="text-slate-400 text-[10px] uppercase font-bold tracking-wider mt-1">Jl. Ringroad - Medan</p>
                <p class="text-slate-400 text-[10px] font-bold">HP: 0858 3370 9981</p>
            </div>

            <!-- Receipt Meta details -->
            <div class="grid grid-cols-2 gap-y-3 text-xs">
                <div>
                    <span class="text-slate-400 font-medium block">ID Pesanan</span>
                    <span class="font-bold text-slate-800">#{{ $order->id }}</span>
                </div>
                <div class="text-right">
                    <span class="text-slate-400 font-medium block">Tanggal & Waktu</span>
                    <span class="font-bold text-slate-800">{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</span>
                </div>
                <div>
                    <span class="text-slate-400 font-medium block">Nama Pemesan</span>
                    <span class="font-bold text-slate-800">{{ $order->customer_name }}</span>
                </div>
                <div class="text-right">
                    <span class="text-slate-400 font-medium block">Lokasi / Meja</span>
                    <span class="font-bold text-slate-800">{{ $order->table_number ?? 'Bungkus / Takeaway' }}</span>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="py-2.5 px-4 rounded-xl border flex items-center justify-between text-xs font-semibold
                        {{ $order->status === 'pending' ? 'bg-amber-50 border-amber-100 text-amber-800' : '' }}
                        {{ $order->status === 'diproses' ? 'bg-blue-50 border-blue-100 text-blue-800' : '' }}
                        {{ $order->status === 'selesai' ? 'bg-teal-50 border-teal-100 text-teal-800' : '' }}">
                <span>Status Pesanan:</span>
                <span class="uppercase tracking-wider font-extrabold">{{ $order->status }}</span>
            </div>

            <!-- Order Items Table -->
            <div class="space-y-3 pt-4 border-t border-dashed border-slate-200">
                <h3 class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Rincian Menu</h3>
                
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-start text-xs">
                            <div class="min-w-0 flex-grow pr-4">
                                <p class="font-bold text-slate-800 leading-snug">{{ $item->menu->name }}</p>
                                @if($item->cooking_option)
                                    <p class="text-[10px] text-teal-600 font-semibold mt-0.5">Masakan: {{ $item->cooking_option }}</p>
                                @endif
                                <p class="text-slate-400 text-[10px] mt-0.5">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <span class="font-bold text-slate-800 text-right">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pricing calculation -->
            <div class="pt-4 border-t border-dashed border-slate-200 space-y-2.5 text-xs">
                <div class="flex justify-between items-center text-slate-800 pt-1.5 font-bold">
                    <span class="text-sm">Total Pembayaran</span>
                    <span class="text-lg font-black text-teal-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment details -->
            <div class="pt-4 border-t border-slate-100 text-xs">
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Metode Pembayaran</span>
                    <span class="font-bold text-slate-800 uppercase">{{ $order->payment_method }}</span>
                </div>
                <div class="flex justify-between items-center mt-1.5">
                    <span class="text-slate-400 font-medium">Status Pembayaran</span>
                    <span class="font-bold {{ $order->payment && $order->payment->status === 'paid' ? 'text-teal-600' : 'text-amber-600' }} uppercase font-extrabold text-[10px]">
                        {{ $order->payment ? ($order->payment->status === 'paid' ? 'Lunas' : 'Menunggu Verifikasi') : 'Belum Bayar' }}
                    </span>
                </div>
            </div>

            <!-- Show instructions if payment is still pending -->
            @if($order->status === 'pending' && $order->payment && $order->payment->status !== 'paid')
                <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 text-xs text-amber-900 space-y-2 mt-4 print:hidden">
                    <p class="font-bold">Informasi Pembayaran:</p>
                    @if($order->payment_method === 'QRIS')
                        <p>Silakan scan kode QRIS restoran di meja kasir atau gunakan PDF di handphone Anda.</p>
                    @elseif($order->payment_method === 'DANA' || $order->payment_method === 'ShopeePay')
                        <p>Kirim dana ke nomor e-wallet: <strong class="text-slate-800">0858 3370 9981</strong> a/n Seafood 2000.</p>
                    @elseif($order->payment_method === 'Transfer Bank')
                        <p>Transfer ke rekening Mandiri: <strong class="text-slate-800">106-00-1234567-8</strong> a/n Seafood 2000.</p>
                    @endif
                    <p class="text-[10px] text-amber-700/80">Setelah melakukan transfer, silakan informasikan nama Anda ke pelayan/kasir agar pesanan segera diproses.</p>
                </div>
            @endif

        </div>

    </div>

    <!-- Print / PDF Buttons -->
    <div class="flex gap-4 mt-8 print:hidden">
        <!-- Print Button -->
        <button type="button" onclick="window.print()"
                class="flex-grow bg-slate-800 hover:bg-slate-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.821V21M3 16.5h18M18 16.5a3 3 0 1 0-6 0M6 8h12M6 8a3 3 0 1 0 0-6M18 8a3 3 0 1 0 0-6M6 8a3 3 0 1 1 0 6M18 8a3 3 0 1 1 0 6M12 16.5v4.5" />
            </svg>
            Cetak Struk
        </button>

        <!-- Download PDF Button -->
        <a href="{{ route('order.pdf', $order->id) }}"
           class="flex-grow bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 text-sm hover:scale-[1.01]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Unduh PDF
        </a>
    </div>

    <!-- Back to menu link -->
    <div class="text-center mt-6 print:hidden">
        <a href="{{ route('menu.index') }}" class="text-xs font-bold text-slate-400 hover:text-teal-600 transition-colors">
            &larr; Kembali Belanja / Tambah Menu
        </a>
    </div>

</div>

<!-- CSS for Print view -->
<style>
    @media print {
        header, footer, .print\:hidden, button, a {
            display: none !important;
        }
        body {
            background-color: white !important;
            color: black !important;
        }
        #receipt-card {
            border: none !important;
            box-shadow: none !important;
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>
@endsection
