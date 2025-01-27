<?php

namespace Modules\Purchases\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Purchases\Services\PurchaseService;
use Modules\Purchases\Http\Requests\CreatePurchaseRequest;
use Modules\Purchases\Http\Requests\UpdatePurchaseRequest;

class PurchasesController extends Controller
{
    protected $purchaseService;
    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function list()
    {
        return response()->json([
            "data" => $this->purchaseService->list()
        ]);
    }

    public function create(CreatePurchaseRequest $request)
    {
        $data = $this->purchaseService->create($request->validated());
        return response()->json([
            "is_success" => true,
            "data" => $data
        ]);
    }

    public function update(UpdatePurchaseRequest $request)
    {
        $this->purchaseService->updatePurchase($request->validated());
        return response()->json([
            "is_success" => true,
        ]);
    }
}
