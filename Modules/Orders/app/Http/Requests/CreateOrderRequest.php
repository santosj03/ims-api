<?php

namespace Modules\Orders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'customer_id' => "required|int",
            'encoder_id' => "required|int",
            'branch_id' => "required|int",
            'payment_type_id' => "required|int",
            'payment_status' => "required|string",
            'item_count' => "required|int",
            'downpayment' => 'nullable|decimal:0,2',
            'ship_cost' => 'nullable|decimal:0,2',
            'other_cost' => 'nullable|decimal:0,2',
            'amount' => 'nullable|decimal:0,2',
            'discount' => 'nullable|decimal:0,2',
            'status' => "required|string",
            'is_with_rts' => "nullable|bool",
            'expires_at' => "nullable|date_format:Y-m-d H:i:s",
            'confirmed_at' => "nullable|date_format:Y-m-d H:i:s",
            'paid_at' => "nullable|date_format:Y-m-d H:i:s",
            'delivered_at' => "nullable|date_format:Y-m-d H:i:s",
            'items' => "required|array",
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
