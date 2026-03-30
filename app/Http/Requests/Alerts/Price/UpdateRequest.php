<?php

namespace App\Http\Requests\Alerts\Price;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
      'condition' => 'required|in:>,<',
      'target_price' => 'required|numeric'
    ];
  }

  public function messages()
  {
    return [
      // Mensajes para 'symbol'
      'symbol.required' => 'El símbolo del activo es obligatorio (ej. BTCUSDT).',
      'symbol.string'   => 'El símbolo debe ser una cadena de texto válida.',
      // Mensajes para 'condition'
      'condition.required' => 'Debes seleccionar una condición de precio (mayor o menor al precio actual).',
      'condition.in'       => 'La condición debe ser "mayor que" (>) o "menor que" (<).',
      // Mensajes para 'target_price'
      'target_price.required' => 'El precio objetivo es obligatorio.',
      'target_price.numeric'  => 'El precio objetivo debe ser un valor numérico.',
    ];
  }

  public function attributes(): array
  {
    return [
      'symbol' => 'símbolo',
      'condition' => 'condición',
      'target_price' => 'precio objetivo',
    ];
  }
}
