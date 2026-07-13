<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! Auth::check()) {
            return false;
        }

        $user = $this->route('user');

        if ($user && $this->isMethod('patch')) {
            return Auth::user()->can('update', $user);
        }

        if ($user && $this->isMethod('put')) {
            return Auth::user()->can('update', $user);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the user ID from the route (assuming your route param is {user})
        $userId = $this->route('user')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],

            // Ignore the current user's ID during unique check on update
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                'unique:users,email,' . $userId
            ],

            // Password is required on store, but optional on update
            'password' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'confirmed',
                Password::defaults()
            ],

            'role' => ['required'],
        ];
    }

}
