<?php

namespace App\Console\Commands;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Console\Command;

class CheckCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and remove carts when timeout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCarts = Order::query()->with('orderProducts')
            ->where('status', OrderStatusEnum::DRAFT)
            ->where('updated_at', '<', now()->subMinutes(15))
            ->get();

        foreach ($expiredCarts as $cart) {
            foreach ($cart->orderProducts as $orderProduct) {
                $productVariant = ProductVariant::find($orderProduct->product_variant_id);
                $productVariant->quantity += $orderProduct->quantity;
                $productVariant->save();

                //Xóa sản phẩm ở giỏ hàng
                $orderProduct->delete();
            }
            if ($cart->orderProducts->isEmpty()) {
                $cart->delete();
            }
        }

    }
}
