<?php

namespace Modules\Stocks\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Stocks\Services\StockReceivingService;
use Modules\Stocks\Http\Requests\CreateStockReceivingRequest;
use Modules\Stocks\Http\Requests\UpdateStockReceivingRequest;

class StockReceivingController extends Controller
{
    protected $service;
    public function __construct(
        StockReceivingService $service
    ){
        $this->service = $service;
    }

    public function list()
    {
        return response()->json([
            "data" => $this->service->list()
        ]);
    }

    public function create(CreateStockReceivingRequest $request)
    {
        return response()->json([
            "data" => $this->service->create($request->validated())
        ]);
    }

    public function update(UpdateStockReceivingRequest $request)
    {
        $this->service->update($request->validated());
        return response()->json([
            "is_success" => true,
        ]);
    }
}
