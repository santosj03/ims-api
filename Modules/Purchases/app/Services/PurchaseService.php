<?php

namespace Modules\Purchases\Services;

use App\Domain\PurchaseDomain;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GenericException;
use App\Exceptions\DatabaseException;
use Modules\Purchases\Repositories\PurchaseRepository;

class PurchaseService
{
    protected $purchaseRepo;
    public function __construct(
        PurchaseRepository $purchaseRepo
    ){
        $this->purchaseRepo = $purchaseRepo;
    }

    public function list()
    {
        return $this->purchaseRepo->with(['purchase_details', 'payment_type', 'supplier'])->get();
    }

    public function create($payload)
    {
        try{
            $items = $payload['items'];
            unset($payload['items']);
            return DB::transaction(function () use ($items, $payload) {
                $purchase = $this->purchaseRepo->create($payload);
                $purchase->purchase_details()->createMany($items);
                return $purchase;
            });
        }catch(\Throwable $ex){
            throw $ex;
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }

    public function updatePurchase($payload)
    {
        try{
            $purchase = $this->purchaseRepo::with(PurchaseDomain::PURCHASE_RELATIONSHIPS)->whereId($payload['purchase_id'])->first();
            return DB::transaction(function () use ($purchase, $payload) {
                $items = [];
                if(isset($payload['items'])){
                    $items = $payload['items'];
                    unset($payload['items']);
                }

                if(!empty($items)){
                    $purchase->purchase_details()->createMany($items);
                    // $purchase->load(PurchaseDomain::PURCHASE_RELATIONSHIPS);
                }
                $purchase->update($payload);
                return $purchase;
            });
        }catch(\Throwable $ex){
            throw $ex;
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }
}