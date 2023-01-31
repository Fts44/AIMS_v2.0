<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;

class LoginController extends Controller
{
    public function index(){

        return view('Authentication.Login');
    }

    public function login(Request $request){

        $rules = [
            'userid' => 'required',
            'password' => 'required',
        ];

        $messages = [
            'userid.required' => 'Email/SR-Code is required.',
            'password.required' => 'Password is required.' 
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{

            $user = DB::table('accounts')
                ->where('gsuite_email','=',$request->userid)
                ->orWhere('prsn_email','=',$request->userid)
                ->orWhere('sr_code','=',$request->userid)
                ->first();
            
            if($user){
                if(Hash::check($request->pass, $user->password)){
                
                    if($user->is_verified){
                        Session(['user_id' => $user->acc_id]);
                        Session(['user_type' => $user->position]);
                        Session(['user_password' => $user->password]);
                        Session(['user_firstname' => $user->firstname]);
                        Session(['user_lastname' => $user->lastname]);
                        Session(['user_profilepic' => $user->pfp]);
                        Session(['last_activity_time' => time()+60*5]);

                        $response = [
                            'status' => 200,
                        ];
    
                        if($user->position != 'pt'){
                            $response['redirect_to'] = route('infirmary_personnel');
                        }
                        else{
                            $response['redirect_to'] = route('patient');
                        }
                    }
                    else{
                        $response = [
                            'status' => 400,
                            'errors' => ['userid' => 'Account is not verified!']
                        ];
                    }
                }
                else{
                    $response = [
                        'status' => 400,
                        'errors' => ['pass' => 'Incorrect password!']
                    ];
                }
            }
            else{
                $response = [
                    'status' => 400,
                    'errors' => ['userid' => 'Email/SR-Code is not connected to any account!']
                ];
            }
        }

        echo json_encode($response);
    }
}
