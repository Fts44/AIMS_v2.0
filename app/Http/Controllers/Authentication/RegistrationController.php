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


class RegistrationController extends Controller
{
    public function index(){

        return view('Authentication.Registration');
    }

    public function register(Request $request){
        // ip = infirmary personnel
        // dentist = dds, doctor = md, nurse = rn

        // pt = patient
        // student = st, tr = techear, sp = school personnel

        $this->otp_controller = new OTPController;

        $rules = [
            'email' => ['required','unique:accounts,prsn_email'],
            'otp' => ['required','numeric','min:4'],
            'password' => ['required', 'max:20', new PasswordRule],
            'retype_password' => ['required','same:password'],
            'classification' => ['required', 'in:st,tr,sp,ip'],
            'position' => ["required_if:classification,==,ip"]
        ];

        $messages = [
            'retype_password.same' => 'The password does not match.',
            'retype_password.required' => 'The retype password field is required.',
            'classification.in' => 'Student, teacher, school personnel, infirmary personnel only.',
            'position.required_if' => 'The position field is required'
        ];
        
        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Account not created.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $verify_otp_request = new Request([
                'email' => $request->email,
                'otp' => $request->otp,
            ]);
    
            if($this->otp_controller->verify_otp($verify_otp_request)){

                $data = [
                    'password' => Hash::make($request->pass),
                    'classification' => $request->classification
                ];

                if($request->classification != 'ip' ){
                    $data['position'] = 'pt';
                }
                else{
                    $data['position'] = $request->position;
                }

                if(str_contains($request->email, "@g.batstate-u.edu.ph")){
                    $data['gsuite_email'] = $request->email;
                }
                else{
                    $data['prsn_email'] = $request->email;
                }

                if($request->position == null && str_contains($request->email, "@g.batstate-u.edu.ph")){
                    $data['is_verified'] = true;
                }
                else{
                    $data['is_verified'] = false;
                }

                DB::table('accounts')->insert($data);
     
                $response = [
                    'title' => 'Success!',
                    'message' => 'Account created.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            else{
                $validator->errors()->add('otp', 'The otp is invalid!');

                $response = [
                    'title' => 'Invalid OTP!',
                    'message' => 'Please double check the email or get new one.',
                    'icon' => 'error',
                    'status' => 400,
                    'errors' => $validator->messages()
                ];
            }
        }

        $response = json_encode($response, true);
        echo $response;
    }
}
