<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'symbol' => 'required|string',
            'amount' => 'required|numeric',
						'avg_price' => 'nullable|numeric',
        ];
    }

		public function messages()
		{
			return [
				'symbol.required' => 'El símbolo es requerido',
				'amount.required' => 'La cantidad es requerida',
				'avg_price.required' => 'El precio promedio es requerido',
			];
		}
}
