<?php

namespace Modules\Stocks\Repositories;

use Modules\Stocks\Models\StockMovement;

class StockMovementRepository extends StockMovement
{
    public function saveData($data)
    {
        $this->type = $data['type'];
        $this->reference_no = $data['reference_no'];
        $this->product_id = $data['product_id'];
        $this->product_item_id = $data['product_item_id'] ?? null;
        $this->serial = $data['serial'] ?? null;
        $this->beg_bal = $data['beg_bal'];
        $this->qty = $data['qty'];
        $this->end_bal = $data['end_bal'];
        $this->status = $data['status'];

        $this->save();
        return $this->fresh();
    }
}