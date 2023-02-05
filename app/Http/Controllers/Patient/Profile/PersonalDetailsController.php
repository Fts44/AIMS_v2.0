<?php

namespace App\Http\Controllers\Patient\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\PopulateSelectController as PopulateSelect;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Rules\GsuiteRule;
use App\Rules\PasswordRule;
use App\Rules\NotGsuiteRule;

class PersonalDetailsController extends Controller
{
    public function get_user_details(){
        $user_details = DB::table('accounts as acc')
                ->select(
                    'acc.*',
                    'home.prov_code as home_prov', 'home.mun_code as home_mun', 'home.brgy_code as home_brgy',
                    'birth.prov_code as birth_prov', 'birth.mun_code as birth_mun', 'birth.brgy_code as birth_brgy',
                    'dorm.prov_code as dorm_prov', 'dorm.mun_code as dorm_mun', 'dorm.brgy_code as dorm_brgy'
                )
                ->where('acc_id',Session::get('user_id'))
                ->leftjoin('address as home','acc.home_add_id', 'home.add_id')
                ->leftjoin('address as birth','acc.birth_add_id', 'birth.add_id')
                ->leftjoin('address as dorm','acc.dorm_add_id', 'dorm.add_id')
                ->first();

        return $user_details;
    }

    public function index(){
        $populate = new PopulateSelect;

        $user_details = $this->get_user_details(); //get user previous information

        $provinces = $populate->province(); //same to three select province
        $home_municipalities = $populate->municipality($user_details->home_prov); //get the selected home municipality
        $home_barangays = $populate->barangay($user_details->home_mun); //get the selected home barangay

        $birthplace_municipalities = $populate->municipality($user_details->birth_prov); //get the selected birth municipality
        $birthplace_barangays = $populate->barangay($user_details->birth_mun); //get the selected birth barangay

        $dormitory_municipalities = $populate->municipality($user_details->dorm_prov); //get the selected dorm municipality
        $dormitory_barangays = $populate->barangay($user_details->dorm_mun); //get the selected dorm barangay
        
        $grade_levels = $populate->grade_level();//get grade levels
        $departments = $populate->department($user_details->gl_id);//get department based on selected grade_levels
        $programs = $populate->program($user_details->dept_id); //get programs based on selected department
        $year_levels = $populate->year_level($user_details->gl_id);//get year levels

        $religions = $populate->religion(); //get religions

        return view('Patient.Profile.PersonalDetails')
            ->with([
                'user_details' => $user_details,

                'provinces' => $provinces,
                'home_municipalities' => $home_municipalities,
                'home_barangays' => $home_barangays,
                'birthplace_municipalities' => $birthplace_municipalities,
                'birthplace_barangays' => $birthplace_barangays,
                'dormitory_municipalities' => $dormitory_municipalities,
                'dormitory_barangays' => $dormitory_barangays,

                'grade_levels' => $grade_levels,
                'departments' => $departments,
                'programs' => $programs,
                'year_levels' => $year_levels,

                'religions' => $religions
            ]);
    }

    public function update(Request $request){

        $rules = [
            'sr_code' => ['required','unique:accounts,sr_code,'.Session::get('user_id').',acc_id'],
            'personal_email' => ['required', 'email', new NotGsuiteRule, 'unique:accounts,prsn_email,'.Session::get('user_id').',acc_id'],
            'gsuite_email' => ['nullable', 'email', new GsuiteRule, 'unique:accounts,gsuite_email,'.Session::get('user_id').',acc_id'],
            'otp' => ['nullable','required_with:gsuite_email', 'min:4'],
            'firstname' => ['required'],
            'middlename' => ['nullable'],
            'lastname' => ['required'],
            'suffixname' => ['nullable'],
            'sex' => ['required', 'in:male,female'],
            'civil_status' => ['required', 'in:single,married,widowed,separated,divorced'],
            'contact' => ['required','unique:accounts,contact,'.Session::get('user_id').',acc_id'],
            'home_province' => ['required'],
            'home_municipality' => ['required'],
            'home_barangay' => ['required'],
            'religion' => ['required'],
            'birthdate' => ['required'],
            'classification' => ['required','in:st,tr,sp'],
            'birthplace_province' => ['required'],
            'birthplace_municipality' => ['required'],
            'birthplace_barangay' => ['required'],
            'grade_level' => ['nullable','required_unless:classification,sp'],
            'year_level' => ['nullable','required_unless:classification,sp,tr'],
            'department' => ['nullable','required_unless:grade_level,null,1,2'],
            'program' => ['nullable', 
                Rule::requiredIf( function () use ($request){
                    return $request->input('classification') == 'st' && $request->input('grade_level') == '4';
                })
            ],
            'weight' => ['nullable', 'numeric'],
            'height' => ['nullable', 'numeric'],
            'blood_type' => ['nullable'],
            'dormitory_province' => ['nullable'],
            'dormitory_municipality' => ['required_with:dormitory_province'],
            'dormitory_barangay' => ['required_with:dormitory_municipality'],
            'profile_picture' => ['required_if:old_profile_picture,==,null']
        ];

        $messages = [
            'grade_level.required_unless' => 'The grade level field is required for teacher and student.',
            'department.required_unless' => 'The department field is required for teacher and student (senior high and college).',
            'program.required_if' => 'The program field is required for college student.',
            'year_level.required_unless' => 'The department field is required for student.',
            'profile_picture.required_if' => 'The profile picture field is required.'
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        $otp_valid = 2;

        if($request->gsuite_email && $request->otp && !$user_details->gsuite_email){              
            $this->OTPController = new OTPController;
            $otp_request = new Request([
                'email'   => $request->gsuite,
                'otp' => $request->otp,
            ]);
            $otp_status = $this->OTPController->verify_otp($otp_request);

            if($otp_status){
                $otp_valid = 1;
            }
            else{
                $otp_valid = 0;
            }
        }

        if($validator->fails() || !$otp_valid){
            if($otp_valid == 0){
                $validator->getMessageBag()->add('otp', 'The otp is invalid!');
            }
            $response = [
                'title' => 'Failed!',
                'message' => 'Some fields contains invalid input.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{

            try{
                $user_details = $this->get_user_details();

                DB::transaction(function() use ($request, $user_details, $otp_valid){

                    // get previouse picture 
                    $file_name = $user_details->pfp;
                    $user_id = $user_details->acc_id;
                    // profile picture
                    if($request->profile_picture){
                        $path = '/public/profile_picture/';
                        $file = $request->file('profile_picture');
                        $file_name = $user_id.'_'.time().'.'.$file->extension();
                        $upload = $file->storeAs($path, $file_name);

                        if($user_details->pfp){
                            Storage::delete($path.$user_details->pfp); 
                        }
                    }

                    // home address
                    if($user_details->home_add_id){
                        DB::table('address')->where('add_id', $user_details->home_add_id)->update([
                            'prov_code' => $request->home_province,
                            'mun_code' => $request->home_municipality,
                            'brgy_code' => $request->home_barangay
                        ]);
                    }
                    else{
                        $user_details->home_add_id = DB::table('address')->InsertGetId([
                            'prov_code' => $request->home_province,
                            'mun_code' => $request->home_municipality,
                            'brgy_code' => $request->home_barangay
                        ]);
                    }

                    // birthplace address
                    if($user_details->birth_add_id ){
                        DB::table('address')->where('add_id', $user_details->birth_add_id)->update([
                            'prov_code' => $request->birthplace_province,
                            'mun_code' => $request->birthplace_municipality,
                            'brgy_code' => $request->birthplace_barangay
                        ]);
                    }
                    else{
                        $user_details->birth_add_id = DB::table('address')->InsertGetId([
                            'prov_code' => $request->birthplace_province,
                            'mun_code' => $request->birthplace_municipality,
                            'brgy_code' => $request->birthplace_barangay
                        ]);
                    }

                    // dorm address
                    if($request->dormitory_province){
                        if($user_details->dorm_add_id){
                            DB::table('address')->where('add_id', $user_details->dorm_add_id)->update([
                                'prov_code' => $request->dormitory_province,
                                'mun_code' => $request->dormitory_municipality,
                                'brgy_code' => $request->dormitory_barangay
                            ]);
                        }
                        else{
                            $user_details->dorm_add_id = DB::table('address')->InsertGetId([
                                'prov_code' => $request->dormitory_province,
                                'mun_code' => $request->dormitory_municipality,
                                'brgy_code' => $request->dormitory_barangay
                            ]);
                        }
                    }
                    else{
                        if($user_details->dorm_add_id){
                            DB::table('address')->where('add_id', $user_details->dorm_add_id)->delete();
                        }
                    }
                    
                    if($otp_valid==1){
                        DB::table('accounts')->where('acc_id', $user_id)->update([
                            'gsuite_email' => $request->gsuite_email,
                            'is_verified' => 1
                        ]);
                    }

                    DB::table('accounts')->where('acc_id', Session('user_id'))->update([
                        'pfp' => $file_name,
                        'sr_code' => $request->sr_code,
                        'prsn_email' => $request->personal_email,
                        'gsuite_email' => $user_details->gsuite_email,
                        'firstname' => $request->firstname,
                        'middlename' => $request->middlename,
                        'lastname' => $request->lastname,
                        'suffixname' => $request->suffixname,
                        'sex' => $request->sex,
                        'civil_status' => $request->civil_status,
                        'contact' => $request->contact,
                        'home_add_id' => $user_details->home_add_id,
                        'religion' => $request->religion,
                        'birthdate' => $request->birthdate,
                        'classification' => $request->classification,
                        'birth_add_id' => $user_details->birth_add_id,
                        'gl_id' => $request->grade_level,
                        'dept_id' => $request->department,
                        'prog_id' => $request->program,
                        'yl_id' => $request->year_level,
                        'weight' => $request->weight,
                        'height' => $request->height,
                        'blood_type' => $request->blood_type,
                        'dorm_add_id' => $user_details->dorm_add_id
                    ]);
                });

                $response = [
                    'title' => 'Success!',
                    'message' => 'Personal Information updated.',
                    'icon' => 'success',
                    'status' => 200
                ]; 
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Personal Information not updated.'.$e,
                    'icon' => 'error',
                    'status' => 200
                ]; 
            }
        }
        echo json_encode($response);
    }
}
