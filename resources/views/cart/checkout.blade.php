@extends('layouts.app')

@section('title', 'Checkout Pembayaran - Seafood 2000')

@section('content')
<div class="max-w-4xl mx-auto my-12 px-4">
    <h1 class="text-3xl font-extrabold text-slate-800 mb-8">Checkout Pesanan</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Forms area -->
        <form action="{{ route('order.store') }}" method="POST" id="checkout-form" class="lg:col-span-2 space-y-6">
            @csrf

            <!-- Customer Details Card -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-5">
                <h2 class="text-lg font-bold text-slate-800 border-b border-slate-50 pb-3">Informasi Pelanggan</h2>
                
                <div>
                    <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Pemesan</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', Auth::user()->name) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm">
                </div>

                <div>
                    <label for="table_number" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nomor Meja (Opsional)</label>
                    <select name="table_number" id="table_number"
                            class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-100 outline-none transition-all text-sm font-semibold">
                        <option value="">Takeaway / Bungkus</option>
                        @for($i=1; $i<=20; $i++)
                            <option value="Meja {{ $i }}">Meja {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Payment Method Card -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Pilih Metode Pembayaran</h2>
                    <p class="text-slate-400 text-xs mt-1">Silakan pilih salah satu metode pembayaran di bawah ini.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- QRIS -->
                    <label class="payment-tile border border-slate-200 hover:border-teal-500 hover:bg-teal-50/10 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer transition-all relative select-none">
                        <input type="radio" name="payment_method" value="QRIS" checked class="hidden" onclick="selectPayment('qris')">
                        <div class="tile-icon text-slate-500 text-2xl">
                            📱
                        </div>
                        <span class="text-xs font-bold text-slate-800">QRIS</span>
                    </label>

                    <!-- DANA -->
                    <label class="payment-tile border border-slate-200 hover:border-teal-500 hover:bg-teal-50/10 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer transition-all relative select-none">
                        <input type="radio" name="payment_method" value="DANA" class="hidden" onclick="selectPayment('dana')">
                        <div class="tile-icon text-slate-500 text-2xl">
                            💙
                        </div>
                        <span class="text-xs font-bold text-slate-800">DANA</span>
                    </label>

                    <!-- ShopeePay -->
                    <label class="payment-tile border border-slate-200 hover:border-teal-500 hover:bg-teal-50/10 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer transition-all relative select-none">
                        <input type="radio" name="payment_method" value="ShopeePay" class="hidden" onclick="selectPayment('shopeepay')">
                        <div class="tile-icon text-slate-500 text-2xl">
                            🧡
                        </div>
                        <span class="text-xs font-bold text-slate-800">ShopeePay</span>
                    </label>

                    <!-- Transfer Bank -->
                    <label class="payment-tile border border-slate-200 hover:border-teal-500 hover:bg-teal-50/10 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer transition-all relative select-none">
                        <input type="radio" name="payment_method" value="Transfer Bank" class="hidden" onclick="selectPayment('transfer')">
                        <div class="tile-icon text-slate-500 text-2xl">
                            🏦
                        </div>
                        <span class="text-xs font-bold text-slate-800">Transfer Bank</span>
                    </label>
                </div>

                <!-- Payment Details Display -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                             <!-- QRIS instruction -->
                    <div id="pay-qris" class="payment-instruction space-y-3">
                        <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider">Scan & Bayar dengan QRIS</h4>

                        {{-- QRIS Card Realistis --}}
                        <div class="flex flex-col items-center">
                            <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md overflow-hidden w-64">

                                {{-- Header QRIS --}}
                                <div class="bg-red-600 px-4 py-2 flex items-center justify-between">
                                    <span class="text-white font-black text-base tracking-widest">QRIS</span>
                                    <div class="flex gap-1 items-center">
                                        <div class="w-4 h-4 rounded-full bg-yellow-400 opacity-90"></div>
                                        <div class="w-4 h-4 rounded-full bg-yellow-300 opacity-70 -ml-2"></div>
                                    </div>
                                </div>

                                {{-- Merchant Info --}}
                                <div class="bg-red-50 px-4 py-1.5 border-b border-red-100">
                                    <p class="text-red-800 font-black text-sm tracking-wide">SEAFOOD 2000</p>
                                    <p class="text-red-600 text-[10px] font-semibold">Jl. Ringroad - Medan</p>
                                </div>

                                {{-- QR Code Area --}}
                                <div class="p-4 flex flex-col items-center bg-white">
                                    <div class="border-4 border-slate-800 rounded-xl p-2 bg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="w-44 h-44">
                                            {{-- Background --}}
                                            <rect width="200" height="200" fill="white"/>

                                            {{-- Corner Square TL --}}
                                            <rect x="10" y="10" width="60" height="60" fill="#1e293b" rx="4"/>
                                            <rect x="18" y="18" width="44" height="44" fill="white" rx="2"/>
                                            <rect x="26" y="26" width="28" height="28" fill="#1e293b" rx="2"/>

                                            {{-- Corner Square TR --}}
                                            <rect x="130" y="10" width="60" height="60" fill="#1e293b" rx="4"/>
                                            <rect x="138" y="18" width="44" height="44" fill="white" rx="2"/>
                                            <rect x="146" y="26" width="28" height="28" fill="#1e293b" rx="2"/>

                                            {{-- Corner Square BL --}}
                                            <rect x="10" y="130" width="60" height="60" fill="#1e293b" rx="4"/>
                                            <rect x="18" y="138" width="44" height="44" fill="white" rx="2"/>
                                            <rect x="26" y="146" width="28" height="28" fill="#1e293b" rx="2"/>

                                            {{-- Data modules (pola titik-titik QR) --}}
                                            <rect x="80" y="10" width="8" height="8" fill="#1e293b"/>
                                            <rect x="96" y="10" width="8" height="8" fill="#1e293b"/>
                                            <rect x="112" y="10" width="8" height="8" fill="#1e293b"/>
                                            <rect x="80" y="26" width="8" height="8" fill="#1e293b"/>
                                            <rect x="104" y="26" width="8" height="8" fill="#1e293b"/>
                                            <rect x="88" y="42" width="8" height="8" fill="#1e293b"/>
                                            <rect x="112" y="42" width="8" height="8" fill="#1e293b"/>
                                            <rect x="80" y="58" width="8" height="8" fill="#1e293b"/>
                                            <rect x="96" y="58" width="8" height="8" fill="#1e293b"/>

                                            <rect x="10" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="26" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="50" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="10" y="96" width="8" height="8" fill="#1e293b"/>
                                            <rect x="42" y="96" width="8" height="8" fill="#1e293b"/>
                                            <rect x="18" y="112" width="8" height="8" fill="#1e293b"/>
                                            <rect x="34" y="112" width="8" height="8" fill="#1e293b"/>
                                            <rect x="58" y="112" width="8" height="8" fill="#1e293b"/>

                                            <rect x="130" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="154" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="178" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="138" y="96" width="8" height="8" fill="#1e293b"/>
                                            <rect x="162" y="96" width="8" height="8" fill="#1e293b"/>
                                            <rect x="146" y="112" width="8" height="8" fill="#1e293b"/>
                                            <rect x="170" y="112" width="8" height="8" fill="#1e293b"/>

                                            <rect x="80" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="96" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="112" y="80" width="8" height="8" fill="#1e293b"/>
                                            <rect x="80" y="96" width="8" height="8" fill="#1e293b"/>
                                            <rect x="104" y="96" width="8" height="8" fill="#1e293b"/>
                                            <rect x="112" y="96" width="8" height="8" fill="#1e293b"/>
                                            <rect x="88" y="112" width="8" height="8" fill="#1e293b"/>
                                            <rect x="96" y="112" width="8" height="8" fill="#1e293b"/>
                                            <rect x="112" y="112" width="8" height="8" fill="#1e293b"/>

                                            <rect x="80" y="130" width="8" height="8" fill="#1e293b"/>
                                            <rect x="96" y="130" width="8" height="8" fill="#1e293b"/>
                                            <rect x="120" y="130" width="8" height="8" fill="#1e293b"/>
                                            <rect x="88" y="146" width="8" height="8" fill="#1e293b"/>
                                            <rect x="104" y="146" width="8" height="8" fill="#1e293b"/>
                                            <rect x="80" y="162" width="8" height="8" fill="#1e293b"/>
                                            <rect x="112" y="162" width="8" height="8" fill="#1e293b"/>
                                            <rect x="96" y="178" width="8" height="8" fill="#1e293b"/>

                                            <rect x="130" y="130" width="8" height="8" fill="#1e293b"/>
                                            <rect x="154" y="130" width="8" height="8" fill="#1e293b"/>
                                            <rect x="178" y="130" width="8" height="8" fill="#1e293b"/>
                                            <rect x="138" y="146" width="8" height="8" fill="#1e293b"/>
                                            <rect x="162" y="146" width="8" height="8" fill="#1e293b"/>
                                            <rect x="146" y="162" width="8" height="8" fill="#1e293b"/>
                                            <rect x="170" y="162" width="8" height="8" fill="#1e293b"/>
                                            <rect x="130" y="178" width="8" height="8" fill="#1e293b"/>
                                            <rect x="162" y="178" width="8" height="8" fill="#1e293b"/>

                                            {{-- Center Logo --}}
                                            <rect x="84" y="84" width="32" height="32" fill="white" rx="4"/>
                                            <rect x="86" y="86" width="28" height="28" fill="#dc2626" rx="3"/>
                                            <text x="100" y="101" font-size="9" font-weight="bold" fill="white" text-anchor="middle" font-family="Arial">QRIS</text>
                                        </svg>
                                    </div>
                                </div>

                                {{-- NMID & Footer --}}
                                <div class="px-4 pb-3 text-center">
                                    <p class="text-[9px] text-slate-500 font-mono">NMID: ID1023456789012345</p>
                                    <div class="mt-2 flex items-center justify-center gap-2">
                                        <span class="text-[9px] text-slate-400 font-semibold">Didukung oleh:</span>
                                        <span class="text-[9px] font-black text-blue-600">DANA</span>
                                        <span class="text-[9px] font-black text-orange-500">ShopeePay</span>
                                        <span class="text-[9px] font-black text-slate-700">GoPay</span>
                                        <span class="text-[9px] font-black text-blue-800">OVO</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="bg-red-50 border border-red-100 rounded-xl p-3 text-xs text-red-800 space-y-1">
                            <p class="font-bold">📱 Cara Pembayaran QRIS:</p>
                            <ol class="list-decimal ml-4 space-y-1 text-red-700">
                                <li>Buka aplikasi m-banking / e-wallet Anda</li>
                                <li>Pilih menu <strong>Scan QR / QRIS</strong></li>
                                <li>Arahkan kamera ke QR Code di atas</li>
                                <li>Masukkan nominal tagihan & konfirmasi</li>
                                <li>Tunjukkan bukti bayar ke kasir</li>
                            </ol>
                        </div>
                    </div>      </div>

                    <!-- DANA instruction -->
                    <div id="pay-dana" class="payment-instruction hidden space-y-3">
                        <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider">Langkah Pembayaran DANA</h4>
                        <div class="bg-white rounded-xl p-4 border border-slate-100 flex items-center gap-3">
                            <span class="text-3xl">💙</span>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold">Nomor Akun DANA</p>
                                <p class="text-base font-bold text-slate-800">0858 3370 9981</p>
                                <p class="text-xs text-teal-600 font-medium">a/n SEAFOOD 2000</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">Silakan transfer nominal total tagihan ke nomor DANA di atas dan selesaikan pesanan Anda.</p>
                    </div>

                    <!-- ShopeePay instruction -->
                    <div id="pay-shopeepay" class="payment-instruction hidden space-y-3">
                        <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider">Langkah Pembayaran ShopeePay</h4>
                        <div class="bg-white rounded-xl p-4 border border-slate-100 flex items-center gap-3">
                            <span class="text-3xl">🧡</span>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold">Nomor ShopeePay</p>
                                <p class="text-base font-bold text-slate-800">0858 3370 9981</p>
                                <p class="text-xs text-teal-600 font-medium">a/n SEAFOOD 2000</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">Silakan kirim saldo ShopeePay ke akun nomor di atas dan selesaikan pemesanan.</p>
                    </div>

                    <!-- Transfer instruction -->
                    <div id="pay-transfer" class="payment-instruction hidden space-y-3">
                        <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider">Langkah Pembayaran Transfer Bank</h4>
                        <div class="bg-white rounded-xl p-4 border border-slate-100 space-y-2.5">
                            <div>
                                <p class="text-xs text-slate-400 font-semibold">Nama Bank</p>
                                <p class="text-sm font-bold text-slate-800">Bank Mandiri</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold">Nomor Rekening</p>
                                <p class="text-base font-black text-slate-800 tracking-wide">106-00-1234567-8</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold">Nama Pemilik Rekening</p>
                                <p class="text-sm font-bold text-slate-800">Seafood 2000</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">Silakan lakukan transfer antar bank ke rekening Mandiri tertera di atas sejumlah total tagihan pesanan.</p>
                    </div>

                </div>
            </div>

        </form>

        <!-- Right Summary panel -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-6 h-fit space-y-6">
            <h3 class="font-extrabold text-slate-800 text-lg border-b border-slate-50 pb-3">Daftar Belanja</h3>
            
            <div class="space-y-4 max-h-60 overflow-y-auto pr-1">
                @foreach($cart as $item)
                    <div class="flex justify-between items-center text-xs">
                        <div class="min-w-0 flex-grow pr-3">
                            <p class="font-bold text-slate-800 truncate">{{ $item['name'] }}</p>
                            <p class="text-slate-400 font-medium">
                                {{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}
                                @if($item['cooking_option'])
                                    | {{ $item['cooking_option'] }}
                                @endif
                            </p>
                        </div>
                        <span class="font-bold text-slate-800 text-right whitespace-nowrap">
                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-slate-100 pt-4 flex justify-between items-center text-slate-800">
                <span class="font-bold text-sm">Total Tagihan</span>
                <span class="font-black text-xl text-teal-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <button type="button" onclick="document.getElementById('checkout-form').submit()"
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md shadow-teal-600/10 text-center text-sm block hover:scale-[1.01]">
                Buat Pesanan & Bayar
            </button>
        </div>

    </div>
</div>

<script>
    function selectPayment(method) {
        // Hide all instructions
        document.querySelectorAll('.payment-instruction').forEach(el => el.classList.add('hidden'));
        
        // Show selected instruction
        document.getElementById('pay-' + method).classList.remove('hidden');

        // Reset tile styles
        document.querySelectorAll('.payment-tile').forEach(el => {
            el.classList.remove('border-teal-500', 'bg-teal-50/10');
            el.classList.add('border-slate-200');
        });

        // Highlight selected tile
        event.currentTarget.classList.remove('border-slate-200');
        event.currentTarget.classList.add('border-teal-500', 'bg-teal-50/10');
    }

    // Initialize active tile styling
    document.addEventListener('DOMContentLoaded', () => {
        const activeRadio = document.querySelector('input[name="payment_method"]:checked');
        if (activeRadio) {
            activeRadio.closest('.payment-tile').classList.add('border-teal-500', 'bg-teal-50/10');
        }
    });
</script>
@endsection
