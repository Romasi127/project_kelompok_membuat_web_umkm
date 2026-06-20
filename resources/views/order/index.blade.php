@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya - Seafood 2000')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800">Riwayat Pesanan Saya</h1>
        <p class="text-slate-400 text-sm mt-1">Semua pesanan yang pernah kamu buat di Seafood 2000.</p>
    </div>

    @if($orders->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-16 text-center">
            <div class="inline-flex p-5 bg-teal-50 text-teal-400 rounded-full mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-slate-700">Belum Ada Pesanan</h3>
            <p class="text-slate-400 text-sm mt-2 max-w-xs mx-auto">Kamu belum pernah memesan. Yuk, pesan hidangan laut segar kami sekarang!</p>
            <a href="{{ route('menu.index') }}"
               class="inline-flex items-center gap-2 mt-6 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md shadow-teal-600/20 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                Lihat Menu
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-md transition-all overflow-hidden">

                    {{-- Card Header --}}
                    <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100">
                        <div>
                            <p class="text-xs text-slate-400 font-semibold">ID Pesanan</p>
                            <p class="font-black text-slate-800 text-lg leading-tight">#{{ $order->id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-400 font-semibold">Tanggal Pesan</p>
                            <p class="font-bold text-slate-600 text-xs">
                                {{ $order->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>

                    <div class="px-6 py-4 space-y-3">

                        {{-- Status + Info Row --}}
                        <div class="flex flex-wrap items-center gap-3">
                            {{-- Status Badge --}}
                            @php
                                $statusConfig = [
                                    'pending'  => ['bg-amber-100 text-amber-800 border-amber-200', '⏳ Pending'],
                                    'diproses' => ['bg-blue-100 text-blue-800 border-blue-200',   '🍳 Sedang Diproses'],
                                    'selesai'  => ['bg-teal-100 text-teal-800 border-teal-200',   '✅ Selesai'],
                                    'dibatalkan' => ['bg-red-100 text-red-800 border-red-200',    '❌ Dibatalkan'],
                                ];
                                $cfg = $statusConfig[$order->status] ?? ['bg-slate-100 text-slate-700 border-slate-200', $order->status];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border text-xs font-bold {{ $cfg[0] }}">
                                {{ $cfg[1] }}
                            </span>

                            {{-- Meja / Takeaway --}}
                            <span class="text-xs text-slate-500 font-medium bg-slate-50 border border-slate-100 px-3 py-1 rounded-full">
                                🪑 {{ $order->table_number ?? 'Bungkus / Takeaway' }}
                            </span>

                            {{-- Payment --}}
                            @if($order->payment)
                                <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $order->payment->status === 'paid' ? 'bg-teal-50 text-teal-700 border-teal-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    💳 {{ $order->payment->status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            @endif
                        </div>

                        {{-- Items List --}}
                        <div class="bg-slate-50 rounded-2xl p-4 space-y-1.5">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-slate-700 font-semibold">
                                        <span class="font-black text-slate-800">{{ $item->quantity }}x</span>
                                        {{ $item->menu->name }}
                                        @if($item->cooking_option)
                                            <span class="text-teal-600 font-bold">({{ $item->cooking_option }})</span>
                                        @endif
                                    </span>
                                    <span class="font-bold text-slate-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total + Actions --}}
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Total</p>
                                <p class="font-black text-teal-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                {{-- Lihat Struk --}}
                                <a href="{{ route('order.show', $order->id) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-xl transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Lihat Struk
                                </a>

                                {{-- Cancel Button (hanya saat pending) --}}
                                @if($order->status === 'pending')
                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin membatalkan pesanan #{{ $order->id }}? Tindakan ini tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 text-xs font-bold bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-4 py-2 rounded-xl transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    @endif

</div>
@endsection
