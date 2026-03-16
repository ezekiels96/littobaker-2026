<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    private function cartTotal(array $cart): float
    {
        return array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
    }

    private function cartCount(array $cart): int
    {
        return array_sum(array_column($cart, 'quantity'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'menu_id'  => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1|max:100',
            'notes'    => 'nullable|string|max:500',
        ]);

        $menu = Menu::with('images')->findOrFail($request->menu_id);
        $cart = session('cart', []);
        $key  = (string) $request->menu_id;

        $unitLabel = match($menu->quantity_type) {
            'dozen'  => 'dozen',
            'pieces' => 'pieces',
            'order'  => 'order',
            default  => $menu->quantity_type,
        };

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += (int) $request->quantity;
            if ($request->filled('notes')) {
                $cart[$key]['notes'] = $request->notes;
            }
        } else {
            $cart[$key] = [
                'id'            => $menu->id,
                'title'         => $menu->title,
                'price'         => (float) $menu->price,
                'quantity_type' => $unitLabel,
                'image'         => $menu->images->first()?->image_url ?? null,
                'quantity'      => (int) $request->quantity,
                'notes'         => $request->notes ?? '',
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success'    => true,
            'cart_count' => $this->cartCount($cart),
            'cart_total' => $this->cartTotal($cart),
            'message'    => 'Added to cart! ♡',
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate(['menu_id' => 'required']);

        $cart = session('cart', []);
        $key  = (string) $request->menu_id;
        unset($cart[$key]);
        session(['cart' => $cart]);

        return response()->json([
            'success'    => true,
            'cart_count' => $this->cartCount($cart),
            'cart_total' => $this->cartTotal($cart),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'menu_id'  => 'required',
            'quantity' => 'required|integer|min:0|max:100',
            'notes'    => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);
        $key  = (string) $request->menu_id;

        if ((int) $request->quantity <= 0) {
            unset($cart[$key]);
        } elseif (isset($cart[$key])) {
            $cart[$key]['quantity'] = (int) $request->quantity;
            if ($request->filled('notes')) {
                $cart[$key]['notes'] = $request->notes;
            }
        }

        session(['cart' => $cart]);

        return response()->json([
            'success'    => true,
            'cart_count' => $this->cartCount($cart),
            'cart_total' => $this->cartTotal($cart),
        ]);
    }

    public function clear()
    {
        session()->forget('cart');
        return response()->json(['success' => true, 'cart_count' => 0, 'cart_total' => 0.0]);
    }

    public function get()
    {
        $cart  = session('cart', []);
        return response()->json([
            'cart'  => array_values($cart),
            'count' => $this->cartCount($cart),
            'total' => $this->cartTotal($cart),
        ]);
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'date'    => 'nullable|string|max:100',
            'message' => 'nullable|string|max:1000',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 422);
        }

        $total = $this->cartTotal($cart);

        Mail::to(['ezekielsung96@gmail.com', 'nguyenjoanne98@gmail.com'])->send(new \App\Mail\OrderMail(array_merge($data, [
            'cart'  => $cart,
            'total' => $total,
        ])));

        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => "Order sent! We'll be in touch soon ♡",
        ]);
    }
}
