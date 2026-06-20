@extends('layouts.admin')

@section('page_title', 'Laporan Pendapatan')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    {{-- Filter Bulan --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800">Laporan Pendapatan</h2>
            <p class="text-xs text-slate-500 mt-0.5">Rekap pendapatan dari pesanan yang telah selesai</p>
        </div>
        <form method="GET" action="{{ route('admin.revenue') }}" class="flex items-center gap-2">
            <label for="month" class="text-xs font-bold text-slate-500 uppercase tracking-wide">Bulan:</label>
            <input
                id="month"
                type="month"
                name="month"
                value="{{ $month }}"
                max="{{ now()->format('Y-m') }}"
                onchange="this.form.submit()"
                class="px-3 py-2 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-teal-300 bg-white shadow-sm"
            >
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4">

        {{-- Pendapatan Bulan Ini --}}
        <div class="bg-teal-600 p-5 rounded-3xl shadow-md flex flex-col justify-between text-white">
            <span class="text-teal-200 text-[10px] font-black uppercase tracking-wider">Pendapatan Bulan Ini</span>
            <div class="mt-3">
                <p class="text-2xl font-black leading-tight">Rp {{ number_format($summary['revenue_this_month'], 0, ',', '.') }}</p>
                <p class="text-teal-300 text-[10px] mt-1">{{ $summary['orders_this_month'] }} pesanan selesai</p>
            </div>
        </div>

        {{-- Pendapatan Hari Ini --}}
        <div class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col justify-between border-t-4 border-t-blue-500">
            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Pendapatan Hari Ini</span>
            <div class="mt-3">
                <p class="text-xl font-black text-slate-800 leading-tight">Rp {{ number_format($summary['revenue_today'], 0, ',', '.') }}</p>
                <p class="text-slate-400 text-[10px] mt-1">{{ $summary['orders_today'] }} pesanan selesai</p>
            </div>
        </div>

        {{-- Total Semua Waktu --}}
        <div class="bg-white p-5 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col justify-between border-t-4 border-t-amber-500">
            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Total Semua Waktu</span>
            <div class="mt-3">
                <p class="text-xl font-black text-slate-800 leading-tight">Rp {{ number_format($summary['revenue_all_time'], 0, ',', '.') }}</p>
                @if($summary['best_day'])
                    <p class="text-slate-400 text-[10px] mt-1">
                        Terbaik: {{ \Carbon\Carbon::parse($summary['best_day']->date)->translatedFormat('d M Y') }}
                    </p>
                @endif
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Tabel Rekap Harian --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-black text-slate-800 text-sm">
                    Rekap Harian —
                    <span class="text-teal-600">{{ $targetDate->translatedFormat('F Y') }}</span>
                </h3>
                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">{{ $dailyRevenue->count() }} hari ada transaksi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black uppercase text-slate-400 tracking-wider">
                            <th class="py-3 px-6">Tanggal</th>
                            <th class="py-3 px-6 text-right">Pesanan</th>
                            <th class="py-3 px-6 text-right">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($dailyRevenue as $row)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3 px-6 font-semibold text-slate-700">
                                    {{ \Carbon\Carbon::parse($row->date)->translatedFormat('l, d M Y') }}
                                </td>
                                <td class="py-3 px-6 text-right text-slate-500 font-bold">{{ $row->order_count }}</td>
                                <td class="py-3 px-6 text-right font-extrabold text-slate-800">
                                    Rp {{ number_format($row->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-2 text-slate-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                    </svg>
                                    <p class="font-semibold text-xs">Tidak ada data pendapatan untuk bulan ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sidebar: Menu Terlaris + Rekap Bulanan --}}
        <div class="space-y-6">

            {{-- Menu Terlaris --}}
            <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-black text-slate-800 text-sm">🏆 Menu Terlaris Bulan Ini</h3>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($topMenus as $index => $menu)
                        <div class="px-5 py-3 flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-black flex-shrink-0
                                {{ $index === 0 ? 'bg-amber-400 text-white' : ($index === 1 ? 'bg-slate-300 text-slate-700' : ($index === 2 ? 'bg-orange-300 text-white' : 'bg-slate-100 text-slate-500')) }}">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-grow min-w-0">
                                <p class="font-bold text-slate-800 text-xs truncate">{{ $menu->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $menu->total_qty }} porsi terjual</p>
                            </div>
                            <span class="text-xs font-extrabold text-teal-600 whitespace-nowrap">
                                Rp {{ number_format($menu->total_revenue, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <p class="px-5 py-6 text-center text-xs text-slate-400">Belum ada data menu terjual.</p>
                    @endforelse
                </div>
            </div>

            {{-- Rekap Bulanan --}}
            <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-black text-slate-800 text-sm">📅 12 Bulan Terakhir</h3>
                </div>
                <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto">
                    @forelse($monthlyRevenue as $row)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-slate-700 text-xs">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $row->month)->translatedFormat('F Y') }}
                                </p>
                                <p class="text-[10px] text-slate-400">{{ $row->order_count }} pesanan</p>
                            </div>
                            <span class="text-xs font-extrabold text-slate-800">
                                Rp {{ number_format($row->total, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <p class="px-5 py-6 text-center text-xs text-slate-400">Belum ada data bulanan.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- Hari Terbaik --}}
    @if($summary['best_day'])
    <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
        </svg>
        <div>
            <p class="text-xs font-bold text-amber-800">Hari Paling Ramai Sepanjang Waktu</p>
            <p class="text-[11px] text-amber-700 mt-0.5">
                Tanggal <strong>{{ \Carbon\Carbon::parse($summary['best_day']->date)->translatedFormat('d F Y') }}</strong>
                dengan pendapatan
                <strong>Rp {{ number_format($summary['best_day']->total, 0, ',', '.') }}</strong>.
            </p>
        </div>
    </div>
    @endif

</div>
@endsection
