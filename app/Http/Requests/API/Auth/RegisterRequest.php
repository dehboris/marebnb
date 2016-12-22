<?php

namespace App\Http\Requests\API\Auth;

use Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Log;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::guard('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:60',
            'last_name'  => 'required|max:60',
            'email'      => 'required|email|unique:users',
            'password'   => 'required',
            'street'     => 'required',
            'city'       => 'required',
            'country'    => 'required',
            'zip'        => 'required|digits:5'
        ];
    }

    /**
     * Custom response message if user is not authorized to perform this action (already logged in).
     *
     * @return JsonResponse
     */
    public function forbiddenResponse()
    {
        return new JsonResponse(['data' => 'Već ste prijavljeni.'], 400);
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

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 400);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }
}
