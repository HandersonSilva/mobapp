<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\PedidoRepositoryInterface;
use \Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Log;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PedidosController extends Controller
{

    public function salvarPedido(Request $request, PedidoRepositoryInterface $pedidoRepositoryInterface)
    {
        Log::debug("Autenticando create do pedido...");
        try {
            Log::debug("error aqui");
            auth()->userOrFail();

        } catch (UserNotDefinedException $e) {
            Log::debug("Erro ao salvar o pedido...Error = ".$e->getMessage());
            return response()->json([],401);
        }

        return $pedidoRepositoryInterface->create($request);

    }

    public function listPedidos($id, PedidoRepositoryInterface $pedidoRepositoryInterface)
    {
        Log::debug("Autenticando a listagem de pedidos...");
        try {

            auth()->userOrFail();

        } catch (UserNotDefinedException $e) {
            Log::debug("Erro ao listar os pedidos...Error = ".$e->getMessage());
            return response()->json([],401);
        }

        return $pedidoRepositoryInterface->listAll($id);
    }

    public function listPedidosDetalhes($id, PedidoRepositoryInterface $pedidoRepositoryInterface)
    {
        Log::debug("Autenticando os detalhes do pedido...");
        try {
            auth()->userOrFail();

        } catch (UserNotDefinedException $e) {
            Log::debug("Erro ao listar detalhes do pedido...Error = ".$e->getMessage());
            return response()->json([],401);
        }
        return $pedidoRepositoryInterface->findByOrderId($id);
    }

    public function cancelarPedido($order_id, $reason_cancellation, PedidoRepositoryInterface $pedidoRepositoryInterface)
    {
        Log::debug("Autenticando o cancelamento do pedido...");
        try {
            auth()->userOrFail();

        } catch (UserNotDefinedException $e) {
            Log::debug("Erro ao cancelar o pedido...Error = ".$e->getMessage());
            return response()->json([],401);
        }
        return $pedidoRepositoryInterface->cancelOrder($order_id, $reason_cancellation);
    }

}
