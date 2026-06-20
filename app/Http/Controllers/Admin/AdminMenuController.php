<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('category')->orderBy('name')->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        // Bersihkan format rupiah dari harga sebelum validasi
        $request->merge([
            'price' => str_replace(['.', ',', ' '], '', $request->input('price', '0')),
        ]);

        $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|string|max:100',
            'price'           => 'required|numeric|min:0',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'cooking_options' => 'nullable|string',
        ]);

        $imagePath = '/images/pecel_lele.png';

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $imagePath = '/images/' . $imageName;
        }

        // Parse cooking options dari JSON [{name, price}]
        $cookingOptions = null;
        if ($request->filled('cooking_options')) {
            $decoded = json_decode($request->cooking_options, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $cookingOptions = array_values(array_filter(array_map(function ($item) {
                    if (isset($item['name']) && trim($item['name']) !== '') {
                        return [
                            'name'  => trim($item['name']),
                            'price' => isset($item['price']) ? (int) $item['price'] : 0,
                        ];
                    }
                    return null;
                }, $decoded)));
                if (empty($cookingOptions)) $cookingOptions = null;
            }
        }

        Menu::create([
            'name'            => $request->name,
            'category'        => $request->category,
            'price'           => (int) $request->price,
            'description'     => $request->description,
            'image'           => $imagePath,
            'cooking_options' => $cookingOptions,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        // Bersihkan format rupiah dari harga sebelum validasi
        $request->merge([
            'price' => str_replace(['.', ',', ' '], '', $request->input('price', '0')),
        ]);

        $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|string|max:100',
            'price'           => 'required|numeric|min:0',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'cooking_options' => 'nullable|string',
        ]);

        $imagePath = $menu->image;

        if ($request->hasFile('image')) {
            if ($menu->image && !str_starts_with($menu->image, '/images/pecel_lele.png') && !str_starts_with($menu->image, '/images/ikan_bakar.png') && !str_starts_with($menu->image, '/images/udang_asam_manis.png') && !str_starts_with($menu->image, '/images/cumi_goreng_tepung.png') && !str_starts_with($menu->image, '/images/es_teh_manis.png') && !str_starts_with($menu->image, '/images/seafood_banner.png')) {
                $oldPath = public_path(ltrim($menu->image, '/'));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $imagePath = '/images/' . $imageName;
        }

        // Parse cooking options dari JSON [{name, price}]
        $cookingOptions = null;
        if ($request->filled('cooking_options')) {
            $decoded = json_decode($request->cooking_options, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $cookingOptions = array_values(array_filter(array_map(function ($item) {
                    if (isset($item['name']) && trim($item['name']) !== '') {
                        return [
                            'name'  => trim($item['name']),
                            'price' => isset($item['price']) ? (int) $item['price'] : 0,
                        ];
                    }
                    return null;
                }, $decoded)));
                if (empty($cookingOptions)) $cookingOptions = null;
            }
        }

        $menu->update([
            'name'            => $request->name,
            'category'        => $request->category,
            'price'           => (int) $request->price,
            'description'     => $request->description,
            'image'           => $imagePath,
            'cooking_options' => $cookingOptions,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Delete old image if it's not a default one
        if ($menu->image && !str_starts_with($menu->image, '/images/pecel_lele.png') && !str_starts_with($menu->image, '/images/ikan_bakar.png') && !str_starts_with($menu->image, '/images/udang_asam_manis.png') && !str_starts_with($menu->image, '/images/cumi_goreng_tepung.png') && !str_starts_with($menu->image, '/images/es_teh_manis.png') && !str_starts_with($menu->image, '/images/seafood_banner.png')) {
            $oldPath = public_path(ltrim($menu->image, '/'));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
