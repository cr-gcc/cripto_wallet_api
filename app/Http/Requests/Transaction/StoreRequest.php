<?php

namespace App\Http\Requests\Transaction;

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
			'type' => 'required|in:buy,sell',
			'amount' => 'required|numeric',
			'price' => 'required|numeric'
		];
	}

	public function messages()
	{
		return [
			// Mensajes para 'symbol'
			'symbol.required' => 'El símbolo es requerido.',
			'symbol.string'   => 'El símbolo debe ser una cadena de texto.',
			// Mensajes para 'type'
			'type.required'   => 'El tipo de operación es obligatorio.',
			'type.in'         => 'El tipo debe ser "buy" (compra) o "sell" (venta).',
			// Mensajes para 'amount'
			'amount.required' => 'La cantidad es requerida.',
			'amount.numeric'  => 'La cantidad debe ser un número.',
			'amount.gt'       => 'La cantidad debe ser mayor a cero.',
			// Mensajes para 'price'
			'price.required'  => 'El precio es requerido.',
			'price.numeric'   => 'El precio debe ser un valor numérico.',
			'price.gt'        => 'El precio debe ser un valor positivo.',
		];
	}
}
