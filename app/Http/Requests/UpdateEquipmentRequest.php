<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends StoreEquipmentRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['serial_number'] = [
            'required',
            'string',
            'max:50',
            Rule::unique('equipments')->ignore($this->equipment->id)
        ];
        return $rules;
    }
}