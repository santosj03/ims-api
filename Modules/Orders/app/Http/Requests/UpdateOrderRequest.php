<?php

namespace Modules\Orders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'order_id' => [
                'required',
                'exists:orders,id'
            ],
            'status' => "sometimes|string",
            'payment_type_id' => "sometimes|int",
            'payment_status' => "sometimes|string",
            'item_count' => "sometimes|int",
            'downpayment' => 'sometimes|decimal:0,2',
            'ship_cost' => 'sometimes|decimal:0,2',
            'other_cost' => 'sometimes|decimal:0,2',
            'amount' => 'sometimes|decimal:0,2',
            'discount' => 'sometimes|decimal:0,2',
            'expires_at' => "sometimes|date_format:Y-m-d H:i:s",
            'confirmed_at' => "sometimes|date_format:Y-m-d H:i:s",
            'paid_at' => "sometimes|date_format:Y-m-d H:i:s",
            'delivered_at' => "sometimes|date_format:Y-m-d H:i:s",
            'items' => "sometimes|array"
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
