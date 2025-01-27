<?php

namespace Modules\Stocks\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Stocks\Services\StockTransferService;
use Modules\Stocks\Http\Requests\CreateStockTransferRequest;
use Modules\Stocks\Http\Requests\UpdateStockTransferRequest;

class StockTransferController extends Controller
{
    protected $service;
    public function __construct(
        StockTransferService $service
    ){
        $this->service = $service;
    }

    public function list()
    {
        return response()->json([
            "data" => $this->service->list()
        ]);
    }

    public function create(CreateStockTransferRequest $request)
    {
        return response()->json([
            "data" => $this->service->create($request->validated())
        ]);
    }

    public function update(UpdateStockTransferRequest $request)
    {
        $this->service->updateTransfer($request->validated());
        return response()->json([
            "is_success" => true,
        ]);
    }
}
