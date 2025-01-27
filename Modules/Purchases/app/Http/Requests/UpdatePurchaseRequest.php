<?php

namespace Modules\Purchases\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'purchase_id' => "required|int",
            'purchase_id' => [
                'required',
                'exists:purchases,id'
            ],
            'description' => "nullable|string",
            'supplier_id' => "nullable|int",
            'payment_type_id' => "nullable|int",
            'ship_via' => "nullable|string",
            'target_delivery' => 'nullable|date_format:Y-m-d H:i:s',
            'payment_status' => "nullable|string",
            'status' => "required|string",
            'items' => "nullable|array"
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
