<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdminOrHr();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',

            'role_ids' => 'required',
            'total_paid_leave' => 'required|numeric|min:1|max:20',
            'total_sick_leave' => 'required|numeric|min:1|max:20',
            'role_ids.required' => 'You have to select Roles!',
        ];
    }
}
