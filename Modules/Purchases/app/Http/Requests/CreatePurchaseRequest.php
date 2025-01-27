<?php

namespace Modules\Purchases\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'po_no' => "required|string",
            'description' => "nullable|string",
            'supplier_id' => "required|int",
            'payment_type_id' => "nullable|int",
            'amount' => "required|decimal:0,2",
            'ship_via' => "required|string",
            'target_delivery' => 'nullable|date_format:Y-m-d H:i:s',
            'payment_status' => "required|string",
            'status' => "required|string",
            'items' => "required|array"
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
