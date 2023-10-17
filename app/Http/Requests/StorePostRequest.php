<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'primary_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'alternate_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'shipping_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'billing_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'shipping_zip' => 'required|regex:/\b\d{5}\b/',
            'billing_zip' => 'required|regex:/\b\d{5}\b/'
        ];
    }
}
