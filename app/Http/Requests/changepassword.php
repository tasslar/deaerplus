<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class changepassword extends FormRequest
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
            "oldpassword"=>"required|min:8|max:16",
            "newpassword"=>"required|min:8|max:16",
            "confirmnewpassword"=>"required|same:newpassword|min:8|max:16"
        ];
    }
}
