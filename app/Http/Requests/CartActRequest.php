<?php

namespace App\Http\Requests;

use App\Traits\FormRequestError;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartActRequest extends FormRequest
{
    use FormRequestError;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'act' => (string) $this->act,
            'index' => (int) $this->index,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'act' => ['required', 'string', Rule::in(['add', 'clear', 'recalc', 'remove'])],
            'uuid' => ['nullable', 'required_if:act,add', 'uuid', 'exists:products,uuid'],
            'index' => ['nullable', $this->requiredIfIndex(), 'integer'],
        ];
    }

    private function requiredIfIndex()
    {
        return Rule::requiredIf(function () {
            return in_array($this->act, ['recalc', 'remove']);
        });
    }

    public function messages()
    {
        return [
            'required' => 'Произошла ошибка, обновите страницу и попробуйте снова',
            'exists' => 'Товар не найден',
        ];
    }
}
