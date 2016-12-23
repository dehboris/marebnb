<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends FormRequest
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
            'object_id'   => 'required|exists:objects,id',
            'category_id' => 'required|exists:categories,id',
            'label'       => 'required|max:100',
            'price'       => 'required',
            'max_people'  => 'required',
            'min_people'  => 'required',
            'seaside'     => 'required',
            'photos'      => 'required'
        ];
    }
}
