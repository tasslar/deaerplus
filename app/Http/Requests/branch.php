<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class branch extends FormRequest
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
            "dealer_name"=>"required",
            "dealer_contact_no"=>"required",
            "branch_address"=>"required",
            "dealer_state"=>"",
            "dealer_city"=>"",
            "dealer_pincode"=>"required|max:6",
            "dealer_mail"=>"email",
        ];
    }
}
