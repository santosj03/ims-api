<?php

namespace Modules\Stocks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockTransferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'stock_transfer_id' => [
                'required',
                'exists:stock_transfer,id'
            ],
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
