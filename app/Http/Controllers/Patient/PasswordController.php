<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Hash;
use App\Rules\PasswordRule;

class PasswordController extends Controller
{
    public function index(){
        return view('Patient.Password');
    }

    public function update(Request $request){
        $rules = [
            'new_password' => ['required', new PasswordRule],
            'retype_new_password' => ['required','same:new_password'],
            'old_password' => ['required'],
        ];

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Password not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }   
        else{
            $old_password = DB::table('accounts')->where('acc_id', Session::get('user_id'))->first()->password;

            try{
                if(Hash::check($request->old_password, $old_password)){
                    DB::table('accounts')->where('acc_id',Session::get('user_id'))->update([
                        'password' => Hash::make($request->new_password)
                    ]);
                    $response = [
                        'title' => 'Success!',
                        'message' => 'Password updated.',
                        'icon' => 'success',
                        'status' => 200
                    ];
                }
                else{
                    $validator->getMessageBag()->add('old_password', 'The old password is incorrect!');
                    $response = [
                        'title' => 'Failed!',
                        'message' => 'Invalid data!',
                        'icon' => 'error',
                        'status' => 400,
                        'errors' => $validator->messages()
                    ];
                }
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Something went wrong, Please try again later!.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];  
            }

        }
        echo json_encode($response);
    }
}
