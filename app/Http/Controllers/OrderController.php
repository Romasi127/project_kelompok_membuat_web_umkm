<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'nullable|string|max:50',
            'payment_method' => 'required|in:QRIS,DANA,ShopeePay,Transfer Bank',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong.');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Create Order
        $order = Order::create([
            'user_id' => Auth::check() && Auth::user()->isUser() ? Auth::id() : null,
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // Create Order Items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'cooking_option' => $item['cooking_option'],
            ]);
        }

        // Create Payment record
        Payment::create([
            'order_id' => $order->id,
            'method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // Clear Cart
        session()->forget('cart');

        return redirect()->route('order.show', $order->id)->with('success', 'Pemesanan berhasil dibuat! Silakan selesaikan pembayaran.');
    }

    public function myOrders()
    {
        $orders = Order::with(['items.menu', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('order.index', compact('orders'));
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // Pastikan hanya pemilik pesanan yang bisa cancel
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Hanya bisa cancel saat masih pending
        if ($order->status !== 'pending') {
            return redirect()->route('order.myOrders')
                ->with('error', 'Pesanan #' . $id . ' tidak bisa dibatalkan karena sudah diproses.');
        }

        $order->status = 'dibatalkan';
        $order->save();

        return redirect()->route('order.myOrders')
            ->with('success', 'Pesanan #' . $id . ' berhasil dibatalkan.');
    }

    public function show($id)
    {
        $order = Order::with(['items.menu', 'payment'])->findOrFail($id);

        // Optional check: restrict view to owner of the order if they are authenticated
        if (Auth::check() && Auth::user()->isUser() && $order->user_id !== null && $order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('order.show', compact('order'));
    }

    public function downloadPdf($id)
    {
        $order = Order::with(['items.menu', 'payment'])->findOrFail($id);

        if (Auth::check() && Auth::user()->isUser() && $order->user_id !== null && $order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $pdf = Pdf::loadView('order.receipt-pdf', compact('order'));
        return $pdf->download('Struk_Seafood2000_Order_' . $order->id . '.pdf');
    }
}
