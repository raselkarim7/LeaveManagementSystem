<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use \App\User;

class EditUserRequest extends FormRequest
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
        $user = User::find($this->id);
        if (empty($user)) {
            return [];
        }
        $consumedPaidLeave = empty($user->paid_leave_taken) ? 0 : $user->paid_leave_taken;
        $consumedSickLeave = empty($user->sick_leave_taken) ? 0 : $user->sick_leave_taken;

        return [
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)],

            'role_ids' => 'required',
            'total_paid_leave' => "required|numeric|min:$consumedPaidLeave|max:20",
            'total_sick_leave' => "required|numeric|min:$consumedSickLeave|max:20",
            'role_ids.required' => 'You have to select Roles!',
        ];
    }
}
