<?php

namespace Modules\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Orders\Services\OrderService;
use Modules\Orders\Http\Requests\CreateRTSRequest;
use Modules\Orders\Http\Requests\UpdateRTSRequest;
use Modules\Orders\Http\Requests\CreateOrderRequest;
use Modules\Orders\Http\Requests\UpdateOrderRequest;

class OrdersController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function list()
    {
        return response()->json([
            "data" => $this->orderService->list()
        ]);
    }

    public function create(CreateOrderRequest $request)
    {
        $data = $this->orderService->process($request->validated());
        return response()->json([
            "is_success" => true,
            "data" => $data
        ]);
    }

    public function update(UpdateOrderRequest $request)
    {
        $this->orderService->updateOrder($request->validated());
        return response()->json([
            "is_success" => true,
        ]);
    }

    public function list_rts()
    {
        return response()->json([
            "data" => $this->orderService->rtsList()
        ]);
    }

    public function create_rts(CreateRTSRequest $request)
    {
        $data = $this->orderService->createRTS($request->validated());
        return response()->json([
            "is_success" => true
        ]);
    }

    public function update_rts(UpdateRTSRequest $request)
    {
        $data = $this->orderService->updateRTS($request->validated());
        return response()->json([
            "is_success" => true,
            "data" => $data
        ]);
    }
}
