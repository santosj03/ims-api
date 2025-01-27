<?php

namespace Modules\Stocks\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Stocks\Services\StockAdjustmentService;

class StockAdjustmentController extends Controller
{
    protected $service;
    public function __construct(
        StockAdjustmentService $service
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
