<?php

namespace App\Http\Requests;

use App\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && (Auth::user()->isOwner() || Auth::user()->user_type == User::ADMIN);
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
            'adults'     => 'required|numeric',
            'children'   => 'required|numeric',
            'date_start' => 'required',
            'date_end'   => 'required'
        ];
    }
}
