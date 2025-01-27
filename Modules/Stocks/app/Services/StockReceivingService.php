<?php

namespace Modules\Stocks\Services;

use App\Domain\PurchaseDomain;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GenericException;
use App\Exceptions\DatabaseException;
use Modules\Stocks\Services\StockMovementService;
use Modules\Products\Repositories\ProductRepository;
use Modules\Purchases\Repositories\PurchaseRepository;
use Modules\Products\Repositories\ProductItemRepository;
use Modules\Stocks\Repositories\StockTransferRepository;
use Modules\Stocks\Repositories\StockReceivingRepository;

class StockReceivingService
{
    protected $stockReceivingRepo, $purchaseRepo, $transferRepo, $productItemRepo, $productRepo;
    protected $totalReceived = 0;
    protected $totalQty = 0;
    protected $totalItems = 0;

    public function __construct(
        StockReceivingRepository $stockReceivingRepo,
        PurchaseRepository $purchaseRepo,
        StockTransferRepository $transferRepo,
        ProductItemRepository $productItemRepo,
        ProductRepository $productRepo
    ){
        $this->stockReceivingRepo = $stockReceivingRepo;
        $this->purchaseRepo = $purchaseRepo;
        $this->transferRepo = $transferRepo;
        $this->productItemRepo = $productItemRepo;
        $this->productRepo = $productRepo;
    }

    public function list()
    {
        return $this->stockReceivingRepo::with(['receiver', 'received'])->get();
    }

    public function create($payload)
    {
        try{
            $items = $payload['items'];
            unset($payload['items']);
            return DB::transaction(function () use ($items, $payload)
            {
                $receiving = $this->stockReceivingRepo->saveReceiving($payload);
                if(
                    $payload['received_type'] == "PURCHASE" && 
                    $purchase = $this->purchaseRepo::with(PurchaseDomain::PURCHASE_RELATIONSHIPS)->findOrFail($payload['received_id'])
                ){
                    $this->receivePurchase($items, $purchase, $receiving);
                }

                if(
                    $payload['received_type'] == "TRANSFER" && 
                    $transfer = $this->transferRepo->findOrFail($payload['received_id'])
                ){
                    $this->receiveTransfer($items, $transfer, $receiving);
                }

                if($this->totalItems > 0) $status = "Partially Completed";
                else $status = "Completed";

                $pendingItem = $this->totalQty - $this->totalReceived;
                return $receiving->update([
                    "total_received_item" => $this->totalReceived,
                    "total_pending_item" => $pendingItem,
                    "status" => $status
                ]);
            });
        }catch(\Throwable $ex){
            throw $ex;
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }

    public function update($payload)
    {
        try{
            $items = $payload['items'];
            unset($payload['items']);
            $receiving = $this->stockReceivingRepo::with(['receiver', 'received'])->findOrFail($payload['stock_receiving_id']);
            return DB::transaction(function () use ($payload, $receiving, $items) {
                if(
                    $receiving['received_type'] == "PURCHASE" && 
                    $purchase = $this->purchaseRepo::with(PurchaseDomain::PURCHASE_RELATIONSHIPS)->findOrFail($receiving->received['id'])
                ){
                    $this->receivePurchase($items, $purchase, $receiving);
                }

                if(
                    $receiving['received_type'] == "TRANSFER" && 
                    $transfer = $this->transferRepo->findOrFail($receiving->received['id'])
                ){
                    $this->receiveTransfer($items, $transfer, $receiving);
                }
                
                if($this->totalItems > 0) $status = "Partially Completed";
                else $status = "Completed";

                $pendingItem = $this->totalQty - $this->totalReceived;
                return $receiving->update([
                    "total_received_item" => $this->totalReceived,
                    "total_pending_item" => $pendingItem,
                    "status" => $status
                ]);
            });
        }catch(\Throwable $ex){
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }

    public function receivePurchase($items, $purchase, $receiving)
    {
        $purchaseDetails = $purchase->purchase_details;
        $this->totalQty = collect($purchaseDetails)->sum('qty');
        $this->totalItems = count($purchaseDetails);
        foreach($items as $item){
            $purchaseDetail = collect($purchaseDetails)->where("product_id", $item['product_id'])->firstOrFail();
            if(!$purchaseDetail->is_received){
                $receiving->receiving_details()->create($item);
                $purchaseDetail->qty_received += 1;
                $this->totalReceived += 1;
                if($purchaseDetail->qty == $purchaseDetail->qty_received){
                    $this->totalItems -= 1;
                    $purchaseDetail->is_received = true;
                }
                $purchaseDetail->save();
                $purchaseDetail->fresh();
            }
        }
    }

    public function receiveTransfer($items, $transfer, $receiving)
    {
        $transferDetails = $transfer->stock_transfer_details;
        $this->totalQty = collect($transferDetails)->sum('qty');
        $this->totalItems = count($transferDetails);
        foreach($items as $item){
            $transferDetail = collect($transferDetails)->where("product_id", $item['product_id'])->firstOrFail();
            if(!$transferDetail->is_received){
                if(is_null($transferDetail['product_item_id']) || empty($transferDetail['product_item_id'])){
                    $product = $this->productRepo->findOrFail($item['product_id']);
                    $product->updateStock($transfer->from_branch_id, 'less');
                    $product->updateStock($transfer->to_branch_id);
                }else{
                    $productItem = $this->productItemRepo::with('product')->whereSerial($item['serial'])->firstOrFail();
                    $productItem->update(['branch_id' => $transfer->to_branch_id]);
                    $receiving->receiving_details()->create(["serial" => $item['serial']]);
                }
                $transferDetail->qty_received += 1;
                $this->totalReceived += 1;
                $this->totalItems -= 1;
                if($transferDetail->qty == $transferDetail->qty_received){
                    $transferDetail->is_received = true;
                }
                $transferDetail->save();
                (new StockMovementService)->create($this->buildMovementPayload($transfer, $receiving));
            }
        }
    }

    private function buildMovementPayload($transfer, $receiving)
    {
        return [
            "type" => $receiving->received_type,
            "reference_no" => $receiving->received_type,
        ];
    }
}