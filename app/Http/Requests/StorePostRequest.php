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
            'syspro_customer_id' => ['required', 'string', 'max:255'],
            // 'primary_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            // 'alternate_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            // 'shipping_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            // 'billing_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            // 'shipping_zip' => 'required|regex:/^\d{5}([ \-]\d{4})?$/',
            // 'billing_zip' => 'required|regex:/^\d{5}([ \-]\d{4})?$/'
        ];
    }



     /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'primary_phone' => 'please enter 10 digit primary number',
            'alternate_phone' => 'please enter 10 digit alternate number',
            'shipping_phone' => 'please enter 10 digit shipping number',
            'billing_phone' => 'please enter 10 digit billing number',
        ];
    }
}
