<?php

namespace Modules\Orders\Services;

use Carbon\Carbon;
use App\Domain\OrderDomain;
use App\Exceptions\RTSException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GenericException;
use App\Exceptions\DatabaseException;
use Modules\Orders\Repositories\OrderRepository;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Repositories\RTSRequestRepository;
use Modules\Products\Repositories\ProductItemRepository;

class OrderService
{
    protected $orderRepo, $productItemRepo, $productRepo, $rtsRequestRepo;
    public function __construct(
        OrderRepository $orderRepo,
        ProductItemRepository $productItemRepo,
        ProductRepository $productRepo,
        RTSRequestRepository $rtsRequestRepo
    ){
        $this->orderRepo = $orderRepo;
        $this->productItemRepo = $productItemRepo;
        $this->productRepo = $productRepo;
        $this->rtsRequestRepo = $rtsRequestRepo;
    }

    public function list()
    {
        return $this->orderRepo->with([
            'customer',
            'encoder',
            'branch',
            'payment_type',
            'order_details'
        ])->get();
    }

    public function process($payload)
    {
        try{
            $items = $payload['items'];
            unset($payload['items']);
            return DB::transaction(function () use ($items, $payload) {
                $order = $this->orderRepo->saveOrder($payload);
                $order->order_details()->createMany($items);
                $this->checkItemUpdate($items, $order->created_at, $payload['branch_id']);
                return $order;
            });
        }catch(\Throwable $ex){
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }

    private function checkItemUpdate(Array $items, $orderDate, $branch_id)
    {
        foreach($items as $item){
            if(is_null($item['product_item_id']) || empty($item['product_item_id'])){
                $this->productRepo->findOrFail($item['product_id'])->updateStock($branch_id, 'less');
            }else{
                $data = $this->productItemRepo::with('product')->whereId($item['product_item_id'])->firstOrFail();
                $data->sold($orderDate);
                $data->product()->updateStock($branch_id, 'less');
            }
        }

        return;
    }

    public function updateOrder($payload)
    {
        try{
            $order = $this->orderRepo::with('order_details')->whereId($payload['order_id'])->first();
            return DB::transaction(function () use ($order, $payload) {
                $items = [];
                if(isset($payload['items'])){
                    $items = $payload['items'];
                    unset($payload['items']);
                }

                $order->update($payload);
                if(!empty($items)){
                    $order->order_details()->createMany($items);
                    $this->checkItemUpdate($items, $order->updated_at, $order->branch_id);
                }
                return $order;
            });
        }catch(\Throwable $ex){
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }

    public function rtsList()
    {
        return $this->rtsRequestRepo::with('rts_request_details')->get();
    }

    public function createRTS($payload)
    {
        try{
            $items = $payload['items'];
            unset($payload['items']);
            return DB::transaction(function () use ($items, $payload) {
                $rtsRequest = $this->rtsRequestRepo->create($payload);
                $rtsRequest->rts_request_details()->createMany($items);
                return $rtsRequest;
            });
        }catch(\Throwable $ex){
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }

    public function updateRTS($payload)
    {
        try{
            $rts = $this->rtsRequestRepo::with(OrderDomain::RTS_RELATIONSHIPS)
            ->whereId($payload['rts_id'])
            ->first();

            return DB::transaction(function () use ($rts, $payload) {
                $items = [];
                if(isset($payload['items'])){
                    $items = $payload['items'];
                    unset($payload['items']);
                }

                if(!empty($items)){
                    $rts->rts_request_details()->createMany($items);
                    $rts->load(OrderDomain::RTS_RELATIONSHIPS);
                }
                $rts->update($payload);
                $rtsDate = Carbon::now()->format("Y-m-d H:i:s");
                $rtsExist = "";
                foreach($rts->rts_request_details as $rtsDetail){
                    $orderDetails = $rtsDetail->order_details;
                    if(!is_null($orderDetails->rts_at)){
                        $rtsExist = $rtsExist . $orderDetails->id. ",";
                    }
                    $orderDetails->update(["rts_at" => $rtsDate]);
                    $orderDetails->order->update(["is_with_rts" => true]);
                    $orderDetails->product->updateStock(
                        $orderDetails->order->branch_id
                    );
                    if($productItem = $orderDetails->product_item){
                        $productItem->sold($rtsDate, false);
                    }
                }
                if(!empty($rtsExist)){
                    $rtsExist = substr_replace($rtsExist, '', -1);
                    throw new RTSException($rtsExist);
                }
                return $rts;
            });
        }catch(\Throwable $ex){
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            if($ex instanceof RTSException)
                throw $ex;
            throw new GenericException();
        }
    }
}
