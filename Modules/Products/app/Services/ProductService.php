<?php

namespace Modules\Products\Services;

use App\Helpers\GenericHelper;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GenericException;
use App\Exceptions\DatabaseException;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Repositories\ProductItemRepository;

class ProductService
{
    protected $productRepo, $productItemRepo;
    public function __construct(
        ProductRepository $productRepo,
        ProductItemRepository $productItemRepo
    ){
        $this->productRepo = $productRepo;
        $this->productItemRepo = $productItemRepo;
    }

    public function createProduct($payload)
    {
        $user = \Auth::user();
        $itemcode = GenericHelper::generateItemCode();
        $payload['itemcode'] = $itemcode;
        return $this->productRepo->createProduct($payload, $user);
    }

    public function insertItems($payloads)
    {
        $exitingID = [];
        try{
            DB::beginTransaction();
            foreach($payloads as $payload){
                if($this->productItemRepo->whereSerial($payload['serial'])->first()){
                    $exitingID[] = $payload['serial'];
                }else{
                    $this->productItemRepo->create($payload);
                    $product = $this->productRepo->whereId($payload['product_id'])->firstOrFail();
                    $product->updateStock($payload['branch_id']);
                }
            }
            if(!empty($exitingID)){
                return response()->json([
                    "is_success" => false,
                    "message" => "Failed! Some data already exists.",
                    "exiting_serials" => $exitingID
                ]);
            }
            DB::commit();
            return response()->json([
                "is_success" => true
            ]);
        }catch(\Throwable $ex){
            DB::rollback();
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }
}
