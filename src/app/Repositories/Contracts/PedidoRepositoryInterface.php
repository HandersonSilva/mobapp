<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface PedidoRepositoryInterface
{
    public function create(Request $request);

    public function listAll($userId);

    public function findByOrderId($orderId);

    public function cancelOrder($order_id, $reason_cancellation);
}
