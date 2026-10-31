<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['customer', 'user'])
            ->latest('created_at')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create(): View
    {
        $customers = Customer::orderBy('id')->get();

        $products = Product::where('is_available', true)
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'order_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => [
                'required',
                'distinct',
                'exists:products,id',
            ],
            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $subtotal = 0;
            $items = [];

            foreach ($validated['products'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];

                if (! $product->is_available) {
                    throw ValidationException::withMessages([
                        'products' => "{$product->name} is not available.",
                    ]);
                }

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'products' => "Not enough stock for {$product->name}. Available: {$product->stock}.",
                    ]);
                }

                $unitPrice = (float) $product->price;
                $itemSubtotal = round($unitPrice * $quantity, 2);

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $itemSubtotal,
                ];

                $subtotal += $itemSubtotal;
            }

            $subtotal = round($subtotal, 2);

            $order = Order::create([
                'order_number' => 'CAFE-' . strtoupper(Str::random(8)),
                'customer_id' => $validated['customer_id'],
                'user_id' => auth()->id(),
                'order_date' => $validated['order_date'],
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    public function show(Order $order): View
    {
        $order->load(['customer', 'user', 'orderItems.product', 'payments']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,preparing,ready,completed,cancelled',
            ],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $order->update($validated);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        return redirect()
            ->route('orders.index')
            ->with('error', 'Orders cannot be deleted from this screen yet.');
    }
}
