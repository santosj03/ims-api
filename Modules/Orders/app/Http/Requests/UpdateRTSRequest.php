<?php

namespace Modules\Orders\Http\Requests;

use Closure;
use Modules\Orders\Models\OrderDetail;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRTSRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'rts_id' => [
                'required',
                'exists:rts_requests,id'
            ],
            'status' => "sometimes|string",
            'validated_by' => "sometimes|int",
            'items' => [
                "sometimes",
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
