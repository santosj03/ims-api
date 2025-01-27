<?php

namespace Modules\Stocks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStockTransferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'from_branch_id' => "required|int",
            'to_branch_id' => "required|int",
            'total_item' => "required|int",
            'description' => "nullable|string",
            'status' => "required|string",
            'prepared_by' => "required|string",
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
