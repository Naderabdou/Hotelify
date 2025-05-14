<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\MasterApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class RoomFilterDateRequest extends MasterApiRequest
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
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->filled('start_date') && $this->filled('end_date')) {
                $validator->errors()->add('start_date', 'يجب إدخال تاريخ بداية الحجز إذا تم إدخال تاريخ النهاية.');
            }
        });
    }
}
