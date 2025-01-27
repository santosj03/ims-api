<?php

namespace Modules\Stocks\Repositories;

use Modules\Stocks\Models\StockReceiving;

class StockReceivingRepository extends StockReceiving
{
    public function saveReceiving($data)
    {
        $this->received_id = $data['received_id'];
        $this->received_type = $data['received_type'];
        $this->received_by = $data['received_by'];
        $this->remarks = $data['remarks'];
        $this->status = $data['status'];

        $this->save();
        return $this->fresh();
    }
}