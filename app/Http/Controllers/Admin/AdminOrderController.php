<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');

        $query = Order::with(['items.menu', 'payment'])->orderBy('created_at', 'desc');

        if (in_array($statusFilter, ['pending', 'diproses', 'selesai', 'dibatalkan'])) {
            $query->where('status', $statusFilter);
        }

        $orders = $query->paginate(15);

        // Calculate statistics for the dashboard
        $stats = [
            'total'       => Order::count(),
            'pending'     => Order::where('status', 'pending')->count(),
            'diproses'    => Order::where('status', 'diproses')->count(),
            'selesai'     => Order::where('status', 'selesai')->count(),
            'dibatalkan'  => Order::where('status', 'dibatalkan')->count(),
            'revenue'     => Order::where('status', 'selesai')->sum('total_price'),
            // Pendapatan hari ini saja
            'revenue_today' => Order::where('status', 'selesai')
                                ->whereDate('created_at', today())
                                ->sum('total_price'),
            'orders_today'  => Order::whereDate('created_at', today())->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'statusFilter'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan',
        ]);

        $order = Order::with('payment')->findOrFail($id);
        $order->status = $request->status;
        $order->save();

        // If status is 'selesai' (completed), we automatically mark the payment as 'paid'
        if ($request->status === 'selesai' && $order->payment) {
            $order->payment->status = 'paid';
            $order->payment->paid_at = now();
            $order->payment->save();
        }

        return redirect()->route('admin.orders')->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        // Hapus relasi dulu agar tidak ada orphan data
        $order->items()->delete();
        if ($order->payment) {
            $order->payment()->delete();
        }
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Pesanan #' . $id . ' berhasil dihapus.');
    }

    public function destroyAll()
    {
        // Hapus semua order items, payments, lalu orders
        OrderItem::query()->delete();
        Payment::query()->delete();
        Order::query()->delete();

        return redirect()->route('admin.orders')->with('success', 'Semua pesanan berhasil dihapus.');
    }

    /**
     * Halaman Laporan Pendapatan Harian
     */
    public function revenue(Request $request)
    {
        // Ambil filter bulan/tahun dari query, default bulan ini
        $month = $request->query('month', now()->format('Y-m'));

        try {
            $targetDate = \Carbon\Carbon::createFromFormat('Y-m', $month);
        } catch (\Exception $e) {
            $targetDate = now();
        }

        // Rekap harian dalam bulan yang dipilih
        $dailyRevenue = Order::where('status', 'selesai')
            ->whereYear('created_at', $targetDate->year)
            ->whereMonth('created_at', $targetDate->month)
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total, COUNT(*) as order_count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // Rekap bulanan (12 bulan terakhir)
        $monthlyRevenue = Order::where('status', 'selesai')
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('strftime("%Y-%m", created_at) as month, SUM(total_price) as total, COUNT(*) as order_count')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        // Statistik ringkasan bulan ini
        $summary = [
            'revenue_this_month' => Order::where('status', 'selesai')
                ->whereYear('created_at', $targetDate->year)
                ->whereMonth('created_at', $targetDate->month)
                ->sum('total_price'),
            'orders_this_month'  => Order::where('status', 'selesai')
                ->whereYear('created_at', $targetDate->year)
                ->whereMonth('created_at', $targetDate->month)
                ->count(),
            'revenue_today'      => Order::where('status', 'selesai')
                ->whereDate('created_at', today())
                ->sum('total_price'),
            'orders_today'       => Order::where('status', 'selesai')
                ->whereDate('created_at', today())
                ->count(),
            'revenue_all_time'   => Order::where('status', 'selesai')->sum('total_price'),
            'best_day'           => Order::where('status', 'selesai')
                ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
                ->groupBy('date')
                ->orderBy('total', 'desc')
                ->first(),
        ];

        // Menu terlaris (berdasarkan qty terjual bulan ini)
        $topMenus = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->where('orders.status', 'selesai')
            ->whereYear('orders.created_at', $targetDate->year)
            ->whereMonth('orders.created_at', $targetDate->month)
            ->selectRaw('menus.name, SUM(order_items.quantity) as total_qty, SUM(order_items.quantity * order_items.price) as total_revenue')
            ->groupBy('menus.name')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        return view('admin.revenue.index', compact(
            'dailyRevenue',
            'monthlyRevenue',
            'summary',
            'topMenus',
            'month',
            'targetDate'
        ));
    }
}
