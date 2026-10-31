<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CafeSeeder extends Seeder
{
    public function run(): void
    {
        // Create the staff account
        User::firstOrCreate(
            ['email' => 'staff@cafe.test'],
            [
                'name' => 'Cafe Staff',
                'password' => Hash::make('Staff123!'),
                'role' => 'staff',
            ]
        );

        // Create product categories
        $categories = [
            [
                'name' => 'Coffee',
                'description' => 'Hot and iced coffee drinks',
            ],
            [
                'name' => 'Tea',
                'description' => 'Tea and refreshing beverages',
            ],
            [
                'name' => 'Pastries',
                'description' => 'Baked goods and snacks',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }

        $products = [
            [
                'category' => 'Coffee',
                'name' => 'Americano',
                'description' => 'Classic espresso with water',
                'price' => 90.00,
                'stock' => 50,
            ],
            [
                'category' => 'Coffee',
                'name' => 'Cafe Latte',
                'description' => 'Espresso with steamed milk',
                'price' => 120.00,
                'stock' => 40,
            ],
            [
                'category' => 'Coffee',
                'name' => 'Cappuccino',
                'description' => 'Espresso with milk foam',
                'price' => 125.00,
                'stock' => 35,
            ],
            [
                'category' => 'Tea',
                'name' => 'Iced Tea',
                'description' => 'Chilled refreshing tea',
                'price' => 70.00,
                'stock' => 45,
            ],
            [
                'category' => 'Pastries',
                'name' => 'Croissant',
                'description' => 'Buttery baked pastry',
                'price' => 85.00,
                'stock' => 25,
            ],
            [
                'category' => 'Pastries',
                'name' => 'Chocolate Muffin',
                'description' => 'Chocolate-flavored muffin',
                'price' => 75.00,
                'stock' => 30,
            ],
        ];

        foreach ($products as $item) {
            $category = Category::where(
                'name',
                $item['category']
            )->firstOrFail();

            Product::firstOrCreate(
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                ],
                [
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'is_available' => true,
                ]
            );
        }

        
        // Create sample customers
        $customers = [
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email' => 'juan@example.com',
                'phone' => '09171234567',
                'address' => 'Davao City',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria@example.com',
                'phone' => '09181234567',
                'address' => 'Davao City',
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Reyes',
                'email' => 'pedro@example.com',
                'phone' => '09191234567',
                'address' => 'Davao City',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(
                ['email' => $customer['email']],
                [
                    'first_name' => $customer['first_name'],
                    'last_name' => $customer['last_name'],
                    'phone' => $customer['phone'],
                    'address' => $customer['address'],
                ]
            );
        }

        
        // Create sample orders and their items
        $staff = User::where('email', 'staff@cafe.test')->firstOrFail();

        $orderData = [
            [
                'number' => 'CAFE-1001',
                'customer' => 'juan@example.com',
                'items' => [
                    ['product' => 'Americano', 'quantity' => 2],
                    ['product' => 'Croissant', 'quantity' => 1],
                ],
            ],
            [
                'number' => 'CAFE-1002',
                'customer' => 'maria@example.com',
                'items' => [
                    ['product' => 'Cafe Latte', 'quantity' => 1],
                    ['product' => 'Chocolate Muffin', 'quantity' => 2],
                ],
            ],
            [
                'number' => 'CAFE-1003',
                'customer' => 'pedro@example.com',
                'items' => [
                    ['product' => 'Cappuccino', 'quantity' => 1],
                    ['product' => 'Iced Tea', 'quantity' => 2],
                ],
            ],
        ];

        foreach ($orderData as $data) {
            if (Order::where('order_number', $data['number'])->exists()) {
                continue;
            }

            $customer = Customer::where(
                'email',
                $data['customer']
            )->firstOrFail();

            \Illuminate\Support\Facades\DB::transaction(function () use (
                $data,
                $customer,
                $staff
            ) {
                $order = Order::create([
                    'order_number' => $data['number'],
                    'customer_id' => $customer->id,
                    'user_id' => $staff->id,
                    'order_date' => now(),
                    'subtotal' => 0,
                    'total' => 0,
                    'status' => 'completed',
                ]);

                $total = 0;

                foreach ($data['items'] as $item) {
                    $product = Product::where(
                        'name',
                        $item['product']
                    )->firstOrFail();

                    $quantity = $item['quantity'];
                    $unitPrice = (float) $product->price;
                    $itemSubtotal = round($quantity * $unitPrice, 2);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $itemSubtotal,
                    ]);

                    $total += $itemSubtotal;
                }

                $order->update([
                    'subtotal' => $total,
                    'total' => $total,
                ]);
            });
        }

        
        // Create sample payments for two orders
        $paymentData = [
            [
                'order_number' => 'CAFE-1001',
                'reference' => 'PAY-1001',
            ],
            [
                'order_number' => 'CAFE-1002',
                'reference' => 'PAY-1002',
            ],
        ];

        foreach ($paymentData as $data) {
            $order = Order::where(
                'order_number',
                $data['order_number']
            )->firstOrFail();

            Payment::firstOrCreate(
                ['payment_reference' => $data['reference']],
                [
                    'order_id' => $order->id,
                    'amount' => $order->total,
                    'payment_method' => 'cash',
                    'status' => 'completed',
                    'payment_date' => now(),
                ]
            );
        }


    }
}
