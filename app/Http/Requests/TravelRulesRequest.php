<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelRulesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validation = [
            'from' => 'required',
            'to' => 'required',
            'travelDate' => 'required'
        ];
    
        return $validation;
    }
}