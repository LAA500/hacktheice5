<?php

namespace App\Http\Requests;

use App\Traits\FormRequestError;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    use FormRequestError;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => (string) only_integers($this->phone),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'digits:11', 'starts_with:7'],
            'email' => ['required', 'email', 'string'],
            'address' => ['required', 'string', 'min:10', 'max:200'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ваше имя',
            'address' => 'адрес доставки',
        ];
    }
}
