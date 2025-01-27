<?php

namespace Modules\Stocks\Repositories;

use Modules\Stocks\Models\StockTransfer;

class StockTransferRepository extends StockTransfer
{
    public function saveTransfer($data)
    {
        $this->from_branch_id = $data['from_branch_id'];
        $this->to_branch_id = $data['to_branch_id'];
        $this->total_item = $data['total_item'];
        $this->description = $data['description'];
        $this->status = $data['status'];
        $this->prepared_by = $data['prepared_by'];

        $this->save();
        return $this->fresh();
    }
}