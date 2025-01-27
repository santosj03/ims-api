<?php

namespace Modules\Orders\Repositories;

use Modules\Orders\Models\Order;

class OrderRepository extends Order
{
    public function saveOrder($payload)
    {
        $this->customer_id = $payload['customer_id'];
        $this->encoder_id = $payload['encoder_id'];
        $this->branch_id = $payload['branch_id'];
        $this->payment_type_id = $payload['payment_type_id'];
        $this->payment_status = $payload['payment_status'];
        $this->item_count = $payload['item_count'];
        $this->downpayment = $payload['downpayment'];
        $this->ship_cost = $payload['ship_cost'];
        $this->other_cost = $payload['other_cost'];
        $this->amount = $payload['amount'];
        $this->discount = $payload['discount'];
        $this->status = $payload['status'];
        $this->expires_at = $payload['expires_at'];
        $this->confirmed_at = $payload['confirmed_at'];
        
        $this->save();
        return $this->fresh();
    }

    public function statusUpdate($status)
    {
        $this->status = $status;
        return $this->save();
    }
}