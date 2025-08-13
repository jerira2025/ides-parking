<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParkingTicketRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'license_plate' => 'required|string|max:20',
            'hourly_rate' => 'nullable|numeric|min:0'
        ];
    }
}