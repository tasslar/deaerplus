<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class registervalidation extends Request
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
            'dealer_name' => 'required',
            'd_mobile' => 'required|unique:dms_dealers|min:10',
            'd_email' => 'required|regex:/^[a-z0-9._%+-]+@[a-z0-9.-]*()$/i||email|unique:dms_dealers',
            'dealership_name' => 'required',
            'd_city' => 'required',
            'hear_us' => 'required',
            'periodselection'  => 'required',
            'termcheckid'=>'required',
            
        ];
    }   
    public function messages()
    {
        return [
            'dealer_name.required' => 'Dealer name field is required. ',
            /*'dealer_name.unique'=>'The Entered Dealer name is already registered with us.',*/
            'd_mobile.required'=>'Dealer Mobile number is required.',
            'd_mobile.unique'=>'The Entered Mobile number is already registered with us.',
            'dealership_name.required'=>'Dealer ship name is required.',
            'd_email.required' => 'Email id field is required. ',
            'd_email.regex' => 'Please Enter a Valid Falconnect Emailid. ',
            'd_email.unique'=>'The Entered Email-id is already registered with us.', 
            'd_email.email'=>'Invalid Email id. ',
            'hear_us.required' => 'Hear About Us Field is required.',
            'periodselection.required'  => 'Select One Plan',
            'termcheckid.required'=>'Please check Terms and Conditions. '
             
        ];
    }

}
    