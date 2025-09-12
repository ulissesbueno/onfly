<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterTravelOrderRequest extends FormRequest
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
            'status' => 'in:pending,approved,canceled',
            'destination' => 'string|max:255',
            'periodo_start' => 'date',
            'periodo_end' => 'date',
            'page' => 'numeric',
            'order_direction' => 'in:asc,desc',
        ];
    }
}
