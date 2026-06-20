@extends('layouts.admin')

@section('page_title', 'Kelola Pesanan Masuk')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <!-- Stats Overview Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

        <!-- Total Hari Ini -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col justify-between border-t-4 border-t-teal-500 lg:col-span-1">
            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Pesanan Hari Ini</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-2xl font-black text-slate-800">{{ $stats['orders_today'] }}</span>
                <span class="text-xs text-slate-500 font-semibold">transaksi</span>
            </div>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="bg-teal-600 p-5 rounded-3xl shadow-md flex flex-col justify-between lg:col-span-1 text-white">
            <span class="text-teal-200 text-[10px] font-black uppercase tracking-wider">Pendapatan Hari Ini</span>
            <div class="mt-2">
                <span class="text-sm font-black leading-tight">
                    Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}
                </span>
                <p class="text-[9px] text-teal-300 mt-1">pesanan selesai</p>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col justify-between border-l-4 border-l-amber-500">
            <span class="text-amber-600 text-[10px] font-black uppercase tracking-wider">Pending</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-2xl font-black text-amber-600">{{ $stats['pending'] }}</span>
                <span class="text-xs text-slate-500 font-semibold">pesanan</span>
            </div>
        </div>

        <!-- Diproses -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col justify-between border-l-4 border-l-blue-500">
            <span class="text-blue-600 text-[10px] font-black uppercase tracking-wider">Diproses</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-2xl font-black text-blue-600">{{ $stats['diproses'] }}</span>
                <span class="text-xs text-slate-500 font-semibold">antrean</span>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col justify-between border-l-4 border-l-teal-500">
            <span class="text-teal-600 text-[10px] font-black uppercase tracking-wider">Selesai</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-2xl font-black text-teal-600">{{ $stats['selesai'] }}</span>
                <span class="text-xs text-slate-500 font-semibold">disajikan</span>
            </div>
        </div>

        <!-- Dibatalkan -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col justify-between border-l-4 border-l-red-400">
            <span class="text-red-500 text-[10px] font-black uppercase tracking-wider">Dibatalkan</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-2xl font-black text-red-500">{{ $stats['dibatalkan'] }}</span>
                <span class="text-xs text-slate-500 font-semibold">pesanan</span>
            </div>
        </div>

    </div>

    <!-- Filter and Action Row -->
    <div class="flex flex-wrap items-center gap-2">
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none flex-1">
            <a href="{{ route('admin.orders') }}"
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ !$statusFilter ? 'bg-slate-800 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                Semua ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'pending']) }}"
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $statusFilter === 'pending' ? 'bg-amber-600 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                Pending ({{ $stats['pending'] }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'diproses']) }}"
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $statusFilter === 'diproses' ? 'bg-blue-600 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                Diproses ({{ $stats['diproses'] }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'selesai']) }}"
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $statusFilter === 'selesai' ? 'bg-teal-600 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                Selesai ({{ $stats['selesai'] }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'dibatalkan']) }}"
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $statusFilter === 'dibatalkan' ? 'bg-red-500 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                Dibatalkan ({{ $stats['dibatalkan'] }})
            </a>
        </div>

        <!-- Hapus Semua Button -->
        @if($stats['total'] > 0)
        <form action="{{ route('admin.orders.destroyAll') }}" method="POST"
              onsubmit="return confirm('⚠️ PERINGATAN!\n\nAnda akan menghapus SEMUA ({{ $stats['total'] }}) pesanan secara permanen.\nData tidak bisa dikembalikan!\n\nLanjutkan?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-full transition-all shadow-md hover:shadow-lg whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                Hapus Semua
            </button>
        </form>
        @endif
    </div>

    <!-- Orders Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black uppercase text-slate-400 tracking-wider">
                        <th class="py-4 px-6">ID Pesanan</th>
                        <th class="py-4 px-6">Pelanggan & Meja</th>
                        <th class="py-4 px-6">Item Yang Dipesan</th>
                        <th class="py-4 px-6">Total Harga</th>
                        <th class="py-4 px-6">Pembayaran</th>
                        <th class="py-4 px-6">Status Pesanan</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-4 px-6 font-bold text-slate-800">
                                #{{ $order->id }}
                                <p class="text-[9px] text-slate-400 font-medium mt-0.5">
                                    {{ $order->created_at->setTimezone('Asia/Jakarta')->format('d M H:i') }}
                                </p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800 text-sm leading-snug">{{ $order->customer_name }}</p>
                                <span class="text-slate-500 font-medium text-[10px]">
                                    {{ $order->table_number ?? 'Bungkus / Takeaway' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <ul class="space-y-1 max-w-xs">
                                    @foreach($order->items as $item)
                                        <li class="text-slate-600">
                                            <strong class="text-slate-800">{{ $item->quantity }}x</strong>
                                            {{ $item->menu->name }}
                                            @if($item->cooking_option)
                                                <span class="text-teal-600 font-bold text-[9px]">({{ $item->cooking_option }})</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-4 px-6 font-extrabold text-slate-800 text-sm">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800">{{ $order->payment_method }}</p>

                                <!-- Payment status badge -->
                                @if($order->payment)
                                    <span class="inline-block mt-1 font-bold text-[9px] uppercase px-2 py-0.5 rounded
                                                {{ $order->payment->status === 'paid' ? 'bg-teal-50 text-teal-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ $order->payment->status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                    </span>
                                @else
                                    <span class="text-slate-400">Tidak ada info</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                            class="px-2.5 py-1.5 rounded-lg border outline-none font-bold text-xs cursor-pointer transition-all
                                                   {{ $order->status === 'pending' ? 'bg-amber-50 border-amber-300 text-amber-800 focus:ring-amber-200' : '' }}
                                                   {{ $order->status === 'diproses' ? 'bg-blue-50 border-blue-300 text-blue-800 focus:ring-blue-200' : '' }}
                                                   {{ $order->status === 'selesai' ? 'bg-teal-50 border-teal-300 text-teal-800 focus:ring-teal-200' : '' }}
                                                   {{ $order->status === 'dibatalkan' ? 'bg-red-50 border-red-300 text-red-800 focus:ring-red-200' : '' }}">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </form>
                            </td>
                            <!-- Tombol Hapus -->
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus pesanan #{{ $order->id }} dari {{ $order->customer_name }}?\nData tidak bisa dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            title="Hapus pesanan ini"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-600 hover:text-white transition-all opacity-60 group-hover:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-3 text-slate-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                                </svg>
                                <p class="font-semibold">Tidak ada transaksi pesanan dengan status ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    <!-- Info Auto-Hapus -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <div>
            <p class="text-xs font-bold text-amber-800">Auto-Hapus Pesanan Aktif</p>
            <p class="text-[11px] text-amber-700 mt-0.5">
                Pesanan dari hari sebelumnya akan <strong>otomatis dihapus setiap tengah malam (00:00 WIB)</strong>
                melalui Laravel Scheduler. Pendapatan tercatat di
                <a href="{{ route('admin.revenue') }}" class="underline font-bold hover:text-amber-900">Laporan Pendapatan</a>.
            </p>
        </div>
    </div>

</div>
@endsection
