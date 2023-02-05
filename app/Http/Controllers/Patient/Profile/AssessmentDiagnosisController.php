<?php

namespace App\Http\Controllers\Patient\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AssessmentDiagnosisController extends Controller
{
    public function get_user_details(){
        $user_details = DB::table('accounts as acc')
            ->select('acc.*', 'ad.*')
            ->where('acc_id',Session::get('user_id'))
            ->leftjoin('assessment_diagnosis as ad','acc.ad_id', 'ad.ad_id')
            ->first();

        return $user_details;
    }

    public function index(){
        $user_details = $this->get_user_details();
        return view('Patient.Profile.AssessmentDiagnosis')->with([
            'user_details' => $user_details
        ]);
    }

    public function update(Request $request){
        $rules = [
            'drinking' => ['required', 'in:0,1'],
            'drinking_how_much' => ['nullable', 'required_if:drinking,==,1', 'numeric'],
            'drinking_how_often' => ['nullable', 'required_if:drinking,==,1'],
            'smoking' => ['required', 'in:0,1'],
            'smoking_sticks_per_day' => ['nullable', 'required_if:smoking,==,1', 'numeric'],
            'smoking_since_when' => ['nullable', 'required_if:smoking,==,1', 'numeric'],
            'drug' => ['required', 'in:0,1'],
            'drug_kind' => ['nullable', 'required_if:drug,==,1'],
            'drug_regular_use' => ['nullable', 'required_if:drug,==,1'],
            'driving' => ['required', 'in:0,1'],
            'driving_specify' => ['nullable', 'required_if:driving,==,1'],
            'driving_with_license' => ['nullable', 'required_if:driving,==,1'],
            'abuse' => ['required', 'in:0,1'],
            'abuse_specify' => ['nullable', 'required_if:abuse,==,1']
        ];

        $messages = [
            'drinking_how_much.required_if' => 'The drinking how much field is required when drinking is yes.',
            'drinking_how_often.required_if' => 'The drinking how often field is required when drinking is yes.',
            'smoking_sticks_per_day.required_if' => 'The smoking sticks per day field is required when smoking is yes.',
            'smoking_since_when.required_if' => 'The smoking since when field is required when smoking is yes.',
            'drug_kind.required_if' => 'The drug kind field is required when drug use is yes.',
            'drug_regular_use.required_if' => 'The drug regular use field is required when drug us is yes.',
            'driving_specify.required_if' => 'The driving specify vehicle field is required when driving is yes.',
            'driving_with_license.required_if' => 'The driving with license field is required when driving is yes.',
            'abuse_specify.required_if' => 'The abuse specify field is required when abuse is yes.',
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Assessment diagnosis is not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                $user_details = $this->get_user_details();

                if($user_details->ad_id){
                    DB::table('assessment_diagnosis')->where('ad_id', $user_details->ad_id)->update([
                        'ad_drinking_how_much' => $request->drinking_how_much ,
                        'ad_drinking_how_often' => $request->drinking_how_often,
                        'ad_smoking_sticks_per_day' => $request->smoking_sticks_per_day,
                        'ad_smoking_since_when' => $request->smoking_since_when,
                        'ad_drug_kind' => $request->drug_kind,
                        'ad_drug_regular_use' => $request->drug_regular_use,
                        'ad_driving_specify' => $request->driving_specify,
                        'ad_driving_with_license' => $request->driving_with_license,
                        'ad_abuse_specify' => $request->abuse_specify
                    ]);
                }
                else{
                    $user_details->ad_id = DB::table('assessment_diagnosis')->insertGetId([
                        'ad_drinking_how_much' => $request->drinking_how_much ,
                        'ad_drinking_how_often' => $request->drinking_how_often,
                        'ad_smoking_sticks_per_day' => $request->smoking_sticks_per_day,
                        'ad_smoking_since_when' => $request->smoking_since_when,
                        'ad_drug_kind' => $request->drug_kind,
                        'ad_drug_regular_use' => $request->drug_regular_use,
                        'ad_driving_specify' => $request->driving_specify,
                        'ad_driving_with_license' => $request->driving_with_license,
                        'ad_abuse_specify' => $request->abuse_specify
                    ]);

                    DB::table('accounts')->where('acc_id', $user_details->acc_id)->update([
                        'ad_id' => $user_details->ad_id
                    ]);
                }

                $response = [
                    'title' => 'Success!',
                    'message' => 'Assessment diagnosis updated.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Assessment diagnosis not updated.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }
        echo json_encode($response);
    }
}
