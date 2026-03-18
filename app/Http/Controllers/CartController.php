<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->syncCartWithStock($request);
        $summary = $this->buildSummary($cart);

        return view('cart.index', [
            'cart' => $cart,
            'subtotal' => $summary['subtotal'],
            'itemsCount' => $summary['items_count'],
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:9999',
        ]);

        if ($product->stock < 1) {
            return back()->withErrors(['quantity' => 'This product is out of stock.']);
        }

        $cart = $request->session()->get('cart', []);
        $productId = (string) $product->id;

        if (isset($cart[$productId])) {
            $newQty = $cart[$productId]['quantity'] + $validated['quantity'];

            if ($newQty > $product->stock) {
                return back()->withErrors(['quantity' => "Only {$product->stock} item(s) are available in stock."]);
            }

            $cart[$productId]['quantity'] = $newQty;
        } else {
            if ($validated['quantity'] > $product->stock) {
                return back()->withErrors(['quantity' => "Only {$product->stock} item(s) are available in stock."]);
            }

            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'stock' => (int) $product->stock,
                'quantity' => $validated['quantity'],
            ];
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:9999',
        ]);

        $cart = $request->session()->get('cart', []);
        $productId = (string) $product->id;

        if (isset($cart[$productId])) {
            if ($validated['quantity'] > $product->stock) {
                return back()->withErrors(['quantity' => "Only {$product->stock} item(s) are available in stock."]);
            }

            $cart[$productId]['quantity'] = $validated['quantity'];
            $cart[$productId]['stock'] = (int) $product->stock;
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $productId = (string) $product->id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function checkoutForm(Request $request): View|RedirectResponse
    {
        $cart = $this->syncCartWithStock($request);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('success', 'Your cart is empty.');
        }

        $summary = $this->buildSummary($cart);

        return view('checkout.index', [
            'cart' => $cart,
            'subtotal' => $summary['subtotal'],
            'itemsCount' => $summary['items_count'],
        ]);
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cart = $this->syncCartWithStock($request);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('success', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $orderNumber = 'ORD-'.now()->format('YmdHis').'-'.random_int(100, 999);

        try {
            DB::transaction(function () use ($cart, $request, $validated, $orderNumber): void {
                foreach ($cart as $item) {
                    $product = Product::query()->lockForUpdate()->find($item['product_id']);

                    if (!$product) {
                        throw new \RuntimeException('A product in your cart no longer exists.');
                    }

                    if ($product->stock < $item['quantity']) {
                        throw new \RuntimeException("Insufficient stock for {$product->name}. Available: {$product->stock}.");
                    }

                    Order::create([
                        'order_number' => $orderNumber,
                        'user_id' => $request->user()->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'status' => 'pending',
                        'customer_name' => $validated['customer_name'],
                        'phone' => $validated['phone'],
                        'address' => $validated['address'],
                        'city' => $validated['city'],
                        'payment_method' => 'cash',
                        'notes' => $validated['notes'] ?? null,
                        'unit_price' => $item['price'],
                        'total_price' => (float) $item['price'] * (int) $item['quantity'],
                    ]);

                    $product->decrement('stock', (int) $item['quantity']);
                }
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['stock' => $e->getMessage()]);
        }

        $request->session()->forget('cart');

        return redirect()->route('products.index')->with('success', "Order placed successfully. Order #: {$orderNumber}. Cash on delivery selected.");
    }

    public function reorder(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'You are not authorized to reorder this order.');
        }

        $orders = $order->order_number
            ? Order::query()
                ->where('user_id', $request->user()->id)
                ->where('order_number', $order->order_number)
                ->get()
            : collect([$order]);

        $cart = $request->session()->get('cart', []);

        foreach ($orders as $item) {
            $product = Product::query()->find($item->product_id);

            if (!$product) {
                continue;
            }

            if ($product->stock < 1) {
                continue;
            }

            $productId = (string) $product->id;
            $quantity = (int) $item->quantity;

            if (isset($cart[$productId])) {
                $maxQty = $product->stock;
                $cart[$productId]['quantity'] = min($maxQty, $cart[$productId]['quantity'] + $quantity);
            } else {
                $cart[$productId] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'image' => $product->image,
                    'stock' => (int) $product->stock,
                    'quantity' => min((int) $product->stock, $quantity),
                ];
            }
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Previous order items were added to your cart.');
    }

    /**
     * @param array<string, array<string, mixed>> $cart
     * @return array{subtotal: float, items_count: int}
     */
    private function buildSummary(array $cart): array
    {
        $subtotal = 0.0;
        $itemsCount = 0;

        foreach ($cart as $item) {
            $price = (float) ($item['price'] ?? 0);
            $qty = (int) ($item['quantity'] ?? 0);
            $subtotal += $price * $qty;
            $itemsCount += $qty;
        }

        return [
            'subtotal' => $subtotal,
            'items_count' => $itemsCount,
        ];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function syncCartWithStock(Request $request): array
    {
        $cart = $request->session()->get('cart', []);
        $synced = [];

        foreach ($cart as $item) {
            $productId = (int) ($item['product_id'] ?? 0);
            $product = Product::query()->find($productId);

            if (!$product || $product->stock < 1) {
                continue;
            }

            $qty = min((int) ($item['quantity'] ?? 1), (int) $product->stock);

            $synced[(string) $product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'stock' => (int) $product->stock,
                'quantity' => max(1, $qty),
            ];
        }

        $request->session()->put('cart', $synced);

        return $synced;
    }
}
