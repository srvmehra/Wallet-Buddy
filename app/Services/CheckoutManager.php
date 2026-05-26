<?php

namespace App\Services;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
use Exception;

class CheckoutManager
{
    protected $orderRepository;
    protected $balanceManager;

    public function __construct(OrderRepository $orderRepository,   BalanceManager $balanceManager) {
        $this->orderRepository = $orderRepository;
        $this->balanceManager = $balanceManager;
    }

    public function placeOrder($user, $items, $paymentDetails = [], $idempotencyKey = null) {
        
        if ($idempotencyKey) {
            $existingOrder = $this->orderRepository->findByIdempotencyKey($idempotencyKey);
            if ($existingOrder) {
                return $existingOrder;
            }
        }

        DB::beginTransaction();

        try {

            $order = $this->orderRepository->create([
                'user_id' => $user->id,
                'reference' => 'ORD-' . strtoupper(uniqid()),
                'amount' => 0,
                'status' => 'initiated',
                'idempotency_key' => $idempotencyKey
            ]);

            $totalAmount = 0;
            $orderItemsData = [];

            foreach ($items as $item) {

                $product = Product::findOrFail($item['product_id']);
                $itemTotal = $product->price * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItemsData[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $itemTotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            OrderItem::insert($orderItemsData);

            $this->balanceManager->debit($user->id, $totalAmount, 'order_payment', 'order', $order->id, $paymentDetails);

            $order->update([
                'amount' => $totalAmount,
                'status' => 'completed'
            ]);

            DB::commit();

            return $order->fresh()->load('items.product');

        } catch (Exception $exception) {

            DB::rollBack();

            throw $exception;
        }
    }
}