<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'primary_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            'alternate_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            'shipping_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            'billing_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            'shipping_zip' => 'required|regex:/^\d{5}([ \-]\d{4})?$/',
            'billing_zip' => 'required|regex:/^\d{5}([ \-]\d{4})?$/'
        ];
        if(request()->has('password') && !empty(request()->get('password'))){
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        return $rules;
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
