<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OTPController;
use App\Rules\PasswordRule as PasswordRule;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class RecoverController extends Controller
{
    public function index(){
        return view('Authentication.Recover');
    }

    public function recover(Request $request){
        $this->otp_controller = new OTPController;

        $rules = [
            'email' => ['required','max:255', 'email'],
            'otp' => ['required','numeric','min:4'],
            'password' => ['required', 'max:20', new PasswordRule],
            'retype_password' => ['required','same:password']
        ];

        $messages = [
            'retype_password.same' => 'The password does not match.',
        ];
        
        if(str_contains($request->email, '@g.batstate-u.edu.ph')){         
            array_push($rules['email'], 'exists:accounts,gsuite_email');
            $messages = [
                'email.exists' => 'Gsuite email is not registered.'
            ];
            $email_type = "gsuite_email";
        }
        else{
            array_push($rules['email'], 'exists:accounts,prsn_email');
            $messages = [
                'email.exists' => 'Email is not registered.'
            ];
            $email_type = "email";
        }

        $validator = Validator::make( $request->all(), $rules, $messages);

        $otp_status = 1;

        $verify_otp_request = new Request([
            'email' => $request->email,
            'otp' => $request->otp,
        ]);
        
        if(!$this->otp_controller->verify_otp($verify_otp_request)){
            $otp_status = 0;
        }

        if($validator->fails() || !$otp_status){
            
            if(!$otp_status){
                $validator->getMessageBag()->add('otp', 'The otp is invalid!');
            }

            $response = [
                'title' => 'Failed!',
                'message' => 'Account not recovered.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            DB::table('accounts')->where($email_type, $request->email)->update([
                'password' => Hash::make($request->pass)
            ]);  
 
            $response = [
                'title' => 'Success!',
                'message' => 'Password updated.',
                'icon' => 'success',
                'status' => 200
            ];
        }

        $response = json_encode($response, true);
        echo $response;
    }
}
