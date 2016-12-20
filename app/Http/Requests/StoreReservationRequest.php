<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'room_id'    => 'required|exists:rooms,id',
            'user_id'    => 'required|exists:users,id',
            'adults'     => 'required|numeric',
            'children'   => 'required|numeric',
            'date_start' => 'required',
            'date_end'   => 'required'
        ];
    }
}
