<?php

namespace Modules\Products\Repositories;

use Modules\Products\Models\Branch;
use Modules\Products\Models\Product;

class ProductRepository extends Product
{
    public function createProduct($payload, $user)
    {
        $this->itemcode = $payload["itemcode"];
        $this->category_id = $payload["category_id"];
        $this->brand_id = $payload["brand_id"];
        $this->supplier_id = $payload["supplier_id"];
        $this->uom_id = $payload["uom_id"];
        $this->sku = $payload["sku"];
        $this->name = $payload["name"];
        $this->description = $payload["description"];
        $this->price = $payload["price"];
        $this->is_per_single_unit = $payload["is_per_single_unit"];
        $this->psu_inv_deduction = $payload["psu_inv_deduction"];
        $this->avg_cost_per_item = $payload["avg_cost_per_item"];
        $this->maintaining_bal = $payload["maintaining_bal"];
        $this->warranty_terms = $payload["warranty_terms"];
        $this->image_src = $payload["image_src"];
        $this->is_active = $payload["is_active"];
        $this->date_expiry = $payload["date_expiry"];
        return $this->save();
    }

    public function updateStock(int $branch_id, string $type = 'add')
    {
        $branch = Branch::whereId($branch_id)->firstOrFail();
        if($type == 'less'){
            $this->{$branch['code']} -= 1;
        }else{
            $this->{$branch['code']} += 1;
        }
        return $this->save();
    }
}