<?php

namespace Modules\Stocks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockReceivingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'stock_receiving_id' => [
                'required',
                'exists:stock_receiving,id'
            ],
            'remarks' => "sometimes|string",
            'status' => "sometimes|string",
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
