<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|int',
            'brand_id' => 'required|int',
            'supplier_id' => 'required|int',
            'uom_id' => 'required|int',
            'sku' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|decimal:2',
            'is_per_single_unit' => 'required|bool',
            'psu_inv_deduction' => 'required|int',
            'avg_cost_per_item' => 'required|decimal:2',
            'maintaining_bal' => 'required|int',
            'warranty_terms' => 'required|string',
            'image_src' => 'nullable|string',
            'is_active' => 'required|bool',
            'date_expiry' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
