<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'menu_id'        => 'required|exists:menus,id',
            'quantity'       => 'required|integer|min:1',
            'cooking_option' => 'nullable|string',
        ]);

        $menu          = Menu::findOrFail($request->menu_id);
        $cookingOption = $request->cooking_option;
        $quantity      = $request->quantity;

        // Tentukan harga berdasarkan pilihan masakan
        $price = $menu->price; // default harga menu
        if ($cookingOption && $menu->cooking_options) {
            foreach ($menu->cooking_options as $option) {
                // Format baru: array of {name, price}
                if (is_array($option) && isset($option['name']) && $option['name'] === $cookingOption) {
                    $price = (int) ($option['price'] ?? $menu->price);
                    break;
                }
            }
        }

        // Generate a unique key for the item based on menu_id and cooking option
        $key  = $menu->id . '_' . md5($cookingOption ?? '');
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'menu_id'        => $menu->id,
                'name'           => $menu->name,
                'price'          => $price,
                'image'          => $menu->image,
                'quantity'       => $quantity,
                'cooking_option' => $cookingOption,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', $menu->name . ' berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Jumlah pesanan berhasil diperbarui.');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan di keranjang.');
    }

    public function remove($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan di keranjang.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('warning', 'Keranjang belanja Anda masih kosong.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.checkout', compact('cart', 'total'));
    }
}
