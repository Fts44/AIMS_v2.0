<?php

namespace App\Http\Controllers\Patient\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\RequiredIf;

class FamilyDetailsController extends Controller
{
    public function get_user_details(){
        return DB::table('accounts as acc')
            ->leftjoin('family_details as fd', 'acc.fd_id', 'fd.fd_id')
            ->leftjoin('family_illness_history as fih', 'fd.fih_id', 'fih.fih_id')
            ->select('fd.*', 'fih.*')
            ->where('acc_id', Session::get('user_id'))
            ->first();
    }
    
    public function index(){
        $user_details = $this->get_user_details();
        
        return view('Patient.Profile.FamilyDetails')->with([
            'user_details' => $user_details
        ]);
    }

    public function update(Request $request){

        $rules = [
            'father_firstname' => ['required'],
            'father_middlename' => ['nullable'],
            'father_lastname' => ['required'],
            'father_suffixname' => ['nullable'],
            'father_occupation' => ['required'],
            'mother_firstname' => ['required'],
            'mother_middlename' => ['nullable'],
            'mother_lastname' => ['required'],
            'mother_suffixname' => ['nullable'],
            'mother_occupation' => ['required'],
            'marital_satus' => ['required', 'in:married,separated,divorced'],
            'family_illness_history_diabetes' => ['required'],
            'family_illness_history_heart_disease' => ['required'],
            'family_illness_history_mental' => ['required'],
            'family_illness_history_cancer' => ['required'],
            'family_illness_history_hypertension' => ['required'],
            'family_illness_history_kidney_disease' => ['required'],
            'family_illness_history_epilepsy' => ['required'],
            'family_illness_history_others' => ['nullable'],
        ];

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Family details not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            $user_details = $this->get_user_details();

            if($user_details->fd_id){

                DB::table('family_illness_history')->where('fih_id', $user_details->fih_id)->update([
                    'fih_diabetes' => $request->family_illness_history_diabetes,
                    'fih_heart_disease' => $request->family_illness_history_heart_disease,
                    'fih_mental' => $request->family_illness_history_mental,
                    'fih_cancer' => $request->family_illness_history_cancer,
                    'fih_hypertension' => $request->family_illness_history_hypertension,
                    'fih_kidney_disease' =>	 $request->family_illness_history_kidney_disease,
                    'fih_epilepsy' =>  $request->family_illness_history_epilepsy,
                    'fih_others' => $request->family_illness_history_others,
                ]);

                DB::table('family_details')->where('fd_id',$user_details->fd_id)->update([
                    'fd_father_firstname' => $request->father_firstname,
                    'fd_father_middlename' => $request->father_middlename,
                    'fd_father_lastname' => $request->father_lastname,
                    'fd_father_suffixname' => $request->father_suffixname,
                    'fd_father_occupation' => $request->father_occupation,
                    'fd_mother_firstname' =>  $request->mother_firstname,
                    'fd_mother_middlename' =>  $request->mother_middlename,
                    'fd_mother_lastname' =>  $request->mother_lastname,
                    'fd_mother_suffixname' =>  $request->mother_suffixname,
                    'fd_mother_occupation' =>  $request->mother_occupation,
                    'fd_marital_status' => $request->marital_satus,
                    'fih_id' => $user_details->fih_id
                ]);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Family details updated.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            else{

                try{
                    DB::transaction(function() use ($request, $user_details){

                        $user_details->fih_id = DB::table('family_illness_history')->insertGetId([
                            'fih_diabetes' => $request->family_illness_history_diabetes,
                            'fih_heart_disease' => $request->family_illness_history_kidney_disease,
                            'fih_mental' => $request->family_illness_history_mental,
                            'fih_cancer' => $request->family_illness_history_cancer,
                            'fih_hypertension' => $request->family_illness_history_hypertension,
                            'fih_kidney_disease' =>	 $request->family_illness_history_kidney_disease,
                            'fih_epilepsy' =>  $request->family_illness_history_epilepsy,
                            'fih_others' => $request->family_illness_history_others,
                        ]);

                        $user_details->fd_id = DB::table('family_details')->insertGetId([
                            'fd_father_firstname' => $request->father_firstname,
                            'fd_father_middlename' => $request->father_middlename,
                            'fd_father_lastname' => $request->father_lastname,
                            'fd_father_suffixname' => $request->father_suffixname,
                            'fd_father_occupation' => $request->father_occupation,
                            'fd_mother_firstname' =>  $request->mother_firstname,
                            'fd_mother_middlename' =>  $request->mother_middlename,
                            'fd_mother_lastname' =>  $request->mother_lastname,
                            'fd_mother_suffixname' =>  $request->mother_suffixname,
                            'fd_mother_occupation' =>  $request->mother_occupation,
                            'fd_marital_status' => $request->marital_satus,
                            'fih_id' => $user_details->fih_id
                        ]);

                        DB::table('accounts')->where('acc_id', Session::get('user_id'))->update([
                            'fd_id' => $user_details->fd_id
                        ]);
                    });

                    $response = [
                        'title' => 'Success!',
                        'message' => 'Family details updated.',
                        'icon' => 'success',
                        'status' => 200
                    ];
                }
                catch(Exception $e){
                    $response = [
                        'title' => 'Failed!',
                        'message' => 'Family details not updated.'.$e,
                        'icon' => 'error',
                        'status' => 400
                    ];
                }
                
            }
        }
        echo json_encode($response);
    }
}
