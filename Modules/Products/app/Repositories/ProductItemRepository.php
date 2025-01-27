<?php

namespace Modules\Products\Repositories;

use Modules\Products\Models\ProductItem;

class ProductItemRepository extends ProductItem
{
    public function sold($orderDate, $is_sold = true)
    {
        $this->is_sold = $is_sold;
        $this->date_sold = $is_sold ? $orderDate : null;

        $this->update();
        return $this->fresh();
    }
}