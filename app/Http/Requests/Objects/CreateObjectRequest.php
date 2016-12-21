<?php

namespace App\Http\Requests\Objects;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateObjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->isOwner();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => 'required|unique:objects'
        ];
    }
}
