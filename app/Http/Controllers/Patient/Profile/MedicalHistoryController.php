<?php

namespace App\Http\Controllers\Patient\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\RequiredIf;

class MedicalHistoryController extends Controller
{
    public function get_user_details(){
        return DB::table('accounts')->where('acc_id', Session::get('user_id'))->first();
    }

    public function index(){
        $user_details = DB::table('accounts as acc')->where('acc.acc_id', Session::get('user_id'))
            ->select('acc.sex', 'mhpi.*', 'mha.*', 'mhmi.*', 'mhp.*')
            ->leftjoin('medical_history_past_illness as mhpi', 'acc.mhpi_id', 'mhpi.mhpi_id')
            ->leftjoin('medical_history_allergy as mha', 'acc.mha_id', 'mha.mha_id')
            ->leftjoin('medical_history_medical_immunization as mhmi', 'acc.mhmi_id', 'mhmi.mhmi_id')
            ->leftjoin('medical_history_pubertal as mhp', 'acc.mhp_id', 'mhp.mhp_id')
            ->first();
       
        $disability = DB::table('disability')->get();

        return view('Patient.Profile.MedicalHistory')->with([
            'user_details' => $user_details,
            'disability' => $disability
        ]);
    }

    public function update(Request $request){
        $rules = [
            'hospitalization' => ['required'],
            'hospitalization_specify' => ['nullable','required_if:hospitalization,==,1'],
            'operation' => ['required'],
            'operation_specify' => ['nullable','required_if:operation,==,1'],
            'accident' => ['required'],
            'accident_specify' => ['nullable','required_if:accident,==,1'],
            'disability' => ['required'],
            'disability_specify' => ['nullable','required_if:disability,==,1'],
            'asthma' => ['required'],
            'asthma_last_attack' => ['nullable','required_if:asthma,==,1'],
            'diabetes' => ['required'],
            'epilepsy' => ['required'],
            'heart_disease' => ['required'],
            'hypertension' => ['required'],
            'measles' => ['required'],
            'mumps' => ['required'],
            'thyroid_problem' => ['required'],
            'varicella' => ['required'],
            'allergy_food' => ['required'],
            'allergy_food_specify' => ['nullable','required_if:allergy_food,==,1'],
            'allergy_medicine' => ['required'],
            'allergy_medicine_specify' => ['nullable','required_if:allergy_medicine,==,1'],
            'allergy_others' => ['required'],
            'allergy_others_specify' => ['nullable','required_if:allergy_others,==,1'],
            'immunization_bcg' => ['required'],
            'immunization_mmr' => ['required'],
            'immunization_hepa_a' => ['required'],
            'immunization_typhoid' => ['required'],
            'immunization_varicella' => ['required'],
            'immunization_hepa_b' => ['required'],
            'immunization_hepa_b_doses' => ['nullable','required_if:immunization_hepa_b,==,1','numeric'],
            'immunization_dpt' => ['required'],
            'immunization_dpt_doses' => ['nullable','required_if:immunization_dpt,==,1','numeric'],
            'immunization_opv' => ['required'],
            'immunization_opv_doses' => ['nullable','required_if:immunization_opv,==,1','numeric'],
            'immunization_hib' => ['required'],
            'immunization_hib_doses' => ['nullable','required_if:immunization_hib,==,1','numeric'],
            'pubertal_male_age_on_set' => [new RequiredIf($this->get_user_details()->sex == 'male'),'numeric'],
            'pubertal_menarche' => [new RequiredIf($this->get_user_details()->sex == 'female'),'numeric'],
            'pubertal_lmp' => [new RequiredIf($this->get_user_details()->sex == 'female')],
            'pubertal_dysmenorhea' => [new RequiredIf($this->get_user_details()->sex == 'female')],
            'pubertal_dysmenorhea_medicine' => [new RequiredIf($this->get_user_details()->sex == 'female' && $request->pubertal_dysmenorhea == '1')],

        ];

        $messages = [
            'hospitalization_specify.required_if' => 'The hospitaliization specification is required.',
            'operation_specify.required_if' => 'The operation specification is required.',
            'accident_specify.required_if' => 'The accident specification is required.',
            'asthma_last_attack.required_if' => 'The asthma last attack is required.',
            'disability_specify.required_if' => 'The disability specify is required.',
            'allergy_food_specify.required_if' => 'The allergy food specify is required.',
            'allergy_medicine_specify.required_if' => 'The allergy mdeicine is required.',
            'allergy_others_specify.required_if' => 'The allergy doses is required.',
            'immunization_hepa_b_doses.required_if' => 'The hepa b doses is required.',
            'immunization_dpt_doses.required_if' => 'The dpt doses is required.',
            'immunization_opv_doses.required_if' => 'The opv doses is required.',
            'immunization_hib_doses.required_if' => 'The hib doses is required.',
            'pubertal_dysmenorhea_medicine' => 'The dysmenorhea medicine is required.'
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical history is not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            $user_details = $this->get_user_details();

            try{
                DB::transaction(function() use ($request, $user_details){

                    //past illness
                        if($user_details->mhpi_id){
                            DB::table('medical_history_past_illness')->where('mhpi_id', $user_details->mhpi_id)->update([
                                'mhpi_hospitalization_specify' => $request->hospitalization_specify,
                                'mhpi_operation_specify' => $request->operation_specify,
                                'mhpi_accident_specify' => $request->accident_specify,
                                'mhpi_disability_specify' => $request->disability_specify,
                                'mhpi_asthma_last_attack' => $request->asthma_last_attack,
                                'mhpi_diabetes' => $request->diabetes,
                                'mhpi_epilepsy' => $request->epilepsy,
                                'mhpi_heart_disease' => $request->heart_disease,
                                'mhpi_hypertension' => $request->hypertension,
                                'mhpi_measles' => $request->measles,
                                'mhpi_mumps' => $request->mumps,
                                'mhpi_thyroid_problem' => $request->thyroid_problem,
                                'mhpi_varicella' => $request->varicella,
                            ]);
                        }
                        else{
                            $user_details->mhpi_id = DB::table('medical_history_past_illness')->insertGetId([
                                'mhpi_hospitalization_specify' => $request->hospitalization_specify,
                                'mhpi_operation_specify' => $request->operation_specify,
                                'mhpi_accident_specify' => $request->accident_specify,
                                'mhpi_disability_specify' => $request->disability_specify,
                                'mhpi_asthma_last_attack' => $request->asthma_last_attack,
                                'mhpi_diabetes' => $request->diabetes,
                                'mhpi_epilepsy' => $request->epilepsy,
                                'mhpi_heart_disease' => $request->heart_disease,
                                'mhpi_hypertension' => $request->hypertension,
                                'mhpi_measles' => $request->measles,
                                'mhpi_mumps' => $request->mumps,
                                'mhpi_thyroid_problem' => $request->thyroid_problem,
                                'mhpi_varicella' => $request->varicella,
                            ]);
                        }
                    //past illness

                    //alergy
                        if($user_details->mha_id){
                            DB::table('medical_history_allergy')->where('mha_id', $user_details->mha_id)->update([
                                'mha_food_specify' => $request->allergy_food_specify,
                                'mha_medicine_specify' => $request->allergy_medicine_specify,
                                'mha_others_specify' => $request->allergy_others_specify,
                            ]);
                        }
                        else{
                            $user_details->mha_id = DB::table('medical_history_allergy')->insertGetId([
                                'mha_food_specify' => $request->allergy_food_specify,
                                'mha_medicine_specify' => $request->allergy_medicine_specify,
                                'mha_others_specify' => $request->allergy_others_specify,
                            ]);
                        }
                    //alergy

                    //medical immunization
                        if($user_details->mhmi_id){
                            
                            DB::table('medical_history_medical_immunization')->update([
                                'mhmi_bcg' => $request->immunization_bcg,
                                'mhmi_mmr' => $request->immunization_mmr,
                                'mhmi_hepa_a' => $request->immunization_hepa_a,
                                'mhmi_typhoid' => $request->immunization_typhoid,
                                'mhmi_varicella' => $request->immunization_varicella,
                                'mhmi_hepa_b_doses' => $request->immunization_hepa_b_doses,
                                'mhmi_dpt_doses' => $request->immunization_dpt_doses,
                                'mhmi_opv_doses' => $request->immunization_opv_doses,
                                'mhmi_hib_doses' => $request->immunization_hib_doses
                            ]);
                        }
                        else{
                            $user_details->mhmi_id = DB::table('medical_history_medical_immunization')->insertGetId([
                                'mhmi_bcg' => $request->immunization_bcg,
                                'mhmi_mmr' => $request->immunization_mmr,
                                'mhmi_hepa_a' => $request->immunization_hepa_a,
                                'mhmi_typhoid' => $request->immunization_typhoid,
                                'mhmi_varicella' => $request->immunization_varicella,
                                'mhmi_hepa_b_doses' => $request->immunization_hepa_b_doses,
                                'mhmi_dpt_doses' => $request->immunization_dpt_doses,
                                'mhmi_opv_doses' => $request->immunization_opv_doses,
                                'mhmi_hib_doses' => $request->immunization_hib_doses
                            ]);
                        }
                    //medical immunization

                    //pubertal 
                        if($user_details->mhp_id){
                            DB::table('medical_history_pubertal')->where('mhp_id',$user_details->mhp_id)->update([
                                'mhp_male_age_on_set' => $request->pubertal_male_age_on_set,
                                'mhp_female_menarche' => $request->pubertal_menarche,
                                'mhp_female_lmp' => $request->pubertal_lmp,
                                'mhp_female_dysmenorhea' => $request->pubertal_dysmenorhea,
                                'mhp_female_dysmenorhea_medicine' => $request->pubertal_dysmenorhea_medicine,
                            ]);
                        }
                        else{
                            $user_details->mhp_id = DB::table('medical_history_pubertal')->insertGetId([
                                'mhp_male_age_on_set' => $request->pubertal_male_age_on_set,
                                'mhp_female_menarche' => $request->pubertal_menarche,
                                'mhp_female_lmp' => $request->pubertal_lmp,
                                'mhp_female_dysmenorhea' => $request->pubertal_dysmenorhea,
                                'mhp_female_dysmenorhea_medicine' => $request->pubertal_dysmenorhea_medicine,
                            ]);
                        }
                    //pubertal

                    //update accounts
                        DB::table('accounts')->where('acc_id', Session::get('user_id'))->update([
                            'mhpi_id' => $user_details->mhpi_id,
                            'mhmi_id' => $user_details->mhmi_id,
                            'mha_id' => $user_details->mha_id,
                            'mhp_id' => $user_details->mhp_id
                        ]);
                    //update accounts
                });

                $response = [
                    'title' => 'Success!',
                    'message' => 'Medical history updated.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Medical history not updated.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }

        echo json_encode($response);
    }
}
