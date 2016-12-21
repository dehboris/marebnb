<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'first_name' => 'required|alpha|max:60',
            'last_name'  => 'required|alpha|max:60',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|alpha_dash|min:4',
            'street'     => 'required',
            'city'       => 'required',
            'country'    => 'required',
            'zip'        => 'required|numeric|digits:5'
        ];
    }
}
