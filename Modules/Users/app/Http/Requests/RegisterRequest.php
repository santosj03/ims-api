<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'unique:users,username'
            ],
            'password' => 'required|string|min:6|max:50',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'is_admin' => 'required|bool',
            'department_id' => 'required|int',
            'status_id' => 'required|int',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function payload()
    {
        return $this->only([
            'username', 
            'password', 
            'email', 
            'mobile', 
            'first_name',
            'last_name',
            'is_admin',
            'department_id',
            'status_id'
        ]);
    }
}
