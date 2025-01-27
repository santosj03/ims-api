<?php

namespace Modules\Orders\Http\Requests;

use Closure;
use Modules\Orders\Models\OrderDetail;
use Illuminate\Foundation\Http\FormRequest;

use function Laravel\Prompts\error;

class CreateRTSRequest extends FormRequest
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
            'encoded_by' => "required|int",
            'validated_by' => "sometimes|int",
            'is_per_item' => "sometimes|bool",
            'description' => "sometimes|string",
            'status' => "required|string",
            'items' => [
                "required",
                "array",
                function ($attribute, $value, Closure $fail) {
                    $arrayLength = count($value);
                    for ($i = 0; $i < $arrayLength; $i++){
                        if (!OrderDetail::whereId($value[$i]['order_detail_id'])->first()){
                            $fail ("This order item ".$value[$i]['order_detail_id']." does not exist!");
                        }
                    }                   
                },
            ]
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
