<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'game_id'=>'required|integer|exists:games,id',
            'position_x'=>'required|integer|max:2|min:0',
            'position_Y'=>'required|integer|max:2|min:0',
        ];
    }
}