<?php

namespace Modules\Stocks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStockReceivingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'received_id' => "required|int",
            'received_type' => "required|string",
            'received_by' => "required|int",
            'remarks' => "nullable|string",
            'status' => "required|string",
            'items' => "sometimes|array",
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
