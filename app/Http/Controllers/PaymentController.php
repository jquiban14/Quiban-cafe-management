<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with(['order.customer'])
            ->latest('created_at')
            ->get();

        return view('payments.index', compact('payments'));
    }

    public function create(): View
    {
        $orders = Order::with('customer')
            ->whereIn('status', ['pending', 'preparing', 'ready', 'completed'])
            ->orderByDesc('created_at')
            ->get();

        return view('payments.create', compact('orders'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'amount' => ['required', 'numeric', 'gt:0', 'decimal:0,2'],
            'payment_method' => [
                'required',
                'in:cash,card,gcash,bank_transfer',
            ],
            'payment_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($validated) {
            $order = Order::whereKey($validated['order_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $alreadyPaid = (float) Payment::where('order_id', $order->id)
                ->where('status', 'completed')
                ->sum('amount');

            $remaining = round((float) $order->total - $alreadyPaid, 2);
            $amount = round((float) $validated['amount'], 2);

            if ($remaining <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'This order has already been fully paid.',
                ]);
            }

            if ($amount > $remaining) {
                throw ValidationException::withMessages([
                    'amount' => 'Payment exceeds the remaining balance of ₱'
                        . number_format($remaining, 2) . '.',
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_reference' => 'PAY-' . strtoupper(Str::random(10)),
                'amount' => $amount,
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
                'payment_date' => $validated['payment_date'] ?? now(),
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }
}
