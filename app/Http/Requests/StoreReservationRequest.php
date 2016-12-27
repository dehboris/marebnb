<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

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
            'adults'     => 'required|numeric',
            'children'   => 'required|numeric',
            'date_start' => 'required',
            'date_end'   => 'required'
        ];
    }

    /**
     * Custom response message if user is not authorized to perform this action (already logged in).
     *
     * @return JsonResponse
     */
    public function forbiddenResponse()
    {
        return new JsonResponse(['data' => 'Niste prijavljeni.'], 403);
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return ['data' => $validator->errors()->first()];
    }
}
