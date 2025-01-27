<?php

namespace Modules\Stocks\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GenericException;
use App\Exceptions\DatabaseException;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Repositories\ProductItemRepository;
use Modules\Stocks\Repositories\StockTransferRepository;

class StockTransferService
{
    protected $stockTransferRepo, $productItemRepo, $productRepo;
    public function __construct(
        StockTransferRepository $stockTransferRepo,
        ProductItemRepository $productItemRepo,
        ProductRepository $productRepo
    ){
        $this->stockTransferRepo = $stockTransferRepo;
        $this->productItemRepo = $productItemRepo;
        $this->productRepo = $productRepo;
    }

    public function list()
    {
        return $this->stockTransferRepo::with([
            'branch',
            'stock_transfer_details'
        ])->get();
    }

    public function create($payload)
    {
        try{
            $items = $payload['items'];
            unset($payload['items']);
            return DB::transaction(function () use ($items, $payload) {
                $transfer = $this->stockTransferRepo->saveTransfer($payload);
                $transfer->stock_transfer_details()->createMany($items);
                return $transfer;
            });
        }catch(\Throwable $ex){
            throw $ex;
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }

    public function updateTransfer($payload)
    {
        try{
            $transfer = $this->stockTransferRepo::with([
                'branch',
                'stock_transfer_details'
            ])->whereId($payload['stock_transfer_id'])->first();

            return DB::transaction(function () use ($transfer, $payload) {
                $items = [];
                if(isset($payload['items'])){
                    $items = $payload['items'];
                    unset($payload['items']);
                }

                if(!empty($items)){
                    $transfer->stock_transfer_details()->createMany($items);
                    $transfer->load([
                        'branch',
                        'stock_transfer_details'
                    ]);
                }

                // if($payload['status'] == 'Done'){
                //     $this->checkItemUpdate($transfer->stock_transfer_details, $transfer->from_branch_id, $transfer->to_branch_id);
                // }
                $transfer->update($payload);
                return $transfer;
            });
        }catch(\Throwable $ex){
            throw $ex;
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }

    // private function checkItemUpdate(Collection $items, $from_branch, $to_branch)
    // {
    //     foreach($items as $item){
    //         if(is_null($item['product_item_id']) || empty($item['product_item_id'])){
    //             $product = $this->productRepo->findOrFail($item['product_id']);
    //             $product->updateStock($from_branch, 'less');
    //             $product->updateStock($to_branch);
    //         }else{
    //             $productItem = $this->productItemRepo::with('product')->whereId($item['product_item_id'])->firstOrFail();
    //             $productItem ->update(['branch_id' => $to_branch]);
    //         }
    //         $item->update(["is_received" => true]);
    //     }

    //     return;
    // }
}