<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\PopulateSelectController as PopulateSelect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CovidVaccinationInsuranceController extends Controller
{
    public function get_user_details(){
        $user_details = DB::table('accounts as acc')
            ->select('vs.*')
            ->leftjoin('vaccination_status as vs', 'acc.vs_id', 'vs.vs_id' )
            ->where('acc_id', Session::get('user_id'))
            ->first();
        return $user_details;
    }

    public function get_user_dose_details(){
        $user_details = $this->get_user_details();
        $user_dose_details = DB::table('vaccination_dose_details as vdd')
            ->select('vdd.*', 'rp.*', 'rm.*', 'cvb.*')
            ->leftjoin('province as rp', 'vdd.vdd_prov_code', 'rp.prov_code')
            ->leftjoin('municipality as rm', 'vdd.vdd_mun_code', 'rm.mun_code')
            ->leftjoin('covid_vaccination_brand as cvb', 'vdd.vdd_brand_id', 'cvb.cvb_id')
            ->where('acc_id', Session::get('user_id'))
            ->get();

        return $user_dose_details;
    }

    public function index(){
        $user_details = $this->get_user_details();
        $user_dose_details = $this->get_user_dose_details();

        $doc_type = DB::table('document_type')
            ->where('dt_id', '<=', '2')
            ->get();

        $user_documents = DB::table('patient_document as pd')
            ->select('pd.*', 'dt.*')
            ->leftjoin('document_type as dt', 'pd.dt_id', 'dt.dt_id')
            ->where('pd.acc_id', Session::get('user_id'))
            ->where('pd.dt_id', '<=', '2')
            ->where('pd.uploaded_by', Session::get('user_id'))
            ->orderBy('pd.pd_date', 'ASC')
            ->get();

        $populate = new PopulateSelect;
        $provinces = $populate->province();
        $covid_vaccination_brands = $populate->covid_vaccination_brand();

        return view('Patient.CovidVaccinationInsurance')->with([
            'user_details' => $user_details,
            'user_dose_details' => $user_dose_details,
            'provinces' => $provinces,
            'doc_type' => $doc_type,
            'user_documents' => $user_documents,
            'covid_vaccination_brands' => $covid_vaccination_brands
        ]);
    }

    public function update_vaxstatus_insurance(Request $request){
        $rules = [
            'vaccination_status' => ['required']
        ];

        $messages = [
            'vaccination_status.required' => 'Choose your vaccination status.'
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Vaccination Status not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            $user_details = $this->get_user_details();

            try{
                if($user_details->vs_id){
                    DB::table('vaccination_status')->where('vs_id', $user_details->vs_id)->update([
                        'vs_status' => $request->vaccination_status,
                        'vs_philhealth_no' => $request->philhealth_no,
                        'vs_others' => $request->others
                    ]);
                }
                else{   
                    DB::transaction(function() use ($request, $user_details){
                        $user_details->vs_id = DB::table('vaccination_status')->insertGetId([
                            'vs_status' => $request->vaccination_status,
                            'vs_philhealth_no' => $request->philhealth_no,
                            'vs_others' => $request->others
                        ]);
                        DB::table('accounts')->where('acc_id', Session::get('user_id'))->update([
                            'vs_id' => $user_details->vs_id
                        ]);
                    });
                } 
                $response = [
                    'title' => 'Success!',
                    'message' => 'Vaccination Status updated.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Vaccination Status not updated.',
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }
        echo json_encode($response);
    }

    public function insert_dossage_details(Request $request){

        $rules = [
            'vdd_dose_number' => ['required',
                Rule::unique('vaccination_dose_details')->where(function ($query) use($request) {
                    return $query->where('acc_id', Session::get('user_id'))
                    ->where('vdd_dose_number', $request->vdd_dose_number);
                })
            ],
            'date' => ['required'],
            'brand' => ['required'],
            'lot_number' => ['required'],
            'province' => ['required'],
            'municipality' => ['required']
        ];

        $messages = [
            'vdd_dose_number.required' => 'The dose number field is required.',
            'vdd_dose_number.unique' => 'The dose number has already been taken.'
        ];
        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Dose details not added.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            $user_dose_details = $this->get_user_dose_details();

            try{
                DB::table('vaccination_dose_details')->insert([
                    'vdd_dose_number' => $request->vdd_dose_number,
                    'vdd_brand_id' => $request->brand,
                    'vdd_date' => $request->date,
                    'vdd_lot_number' => $request->lot_number,
                    'vdd_prov_code' => $request->province,
                    'vdd_mun_code' => $request->municipality,
                    'acc_id' =>  Session::get('user_id')
                ]);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Dose details added.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Dose details not added.',
                    'icon' => 'error',
                    'status' => 400,
                    'form' => 'dosage',
                    'action' => 'insert'
                ];
            }
        }
        echo json_encode($response);
    }

    public function update_dossage_details(Request $request, $id){
        $rules = [
            'vdd_dose_number' => ['required',
                Rule::unique('vaccination_dose_details')->where(function ($query) use($request, $id) {
                    return $query->where('acc_id', Session::get('user_id'))
                        ->where('vdd_dose_number', $request->vdd_dose_number)
                        ->where('vdd_id', '!=', $id);
                }),
            ],
            'date' => ['required'],
            'brand' => ['required'],
            'lot_number' => ['required'],
            'province' => ['required'],
            'municipality' => ['required']
        ];

        $messages = [
            'vdd_dose_number.required' => 'The dose number field is required.',
            'vdd_dose_number.unique' => 'The dose number has already been taken.'
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Dose details not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                DB::table('vaccination_dose_details')->where('vdd_id', $id)
                    ->update([
                        'vdd_dose_number' => $request->vdd_dose_number,
                        'vdd_brand_id' => $request->brand,
                        'vdd_date' => $request->date,
                        'vdd_lot_number' => $request->lot_number,
                        'vdd_prov_code' => $request->province,
                        'vdd_mun_code' => $request->municipality
                    ]);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Dose details updated.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Dose details not updated.'.$e,
                    'icon' => 'error',
                    'status' => 400,
                ];
            }
        }

        echo json_encode($response);
    }

    public function delete_dossage_details($id){
        try{
            DB::table('vaccination_dose_details')->where('vdd_id', $id)->delete();
            $response = [
                'title' => 'Success!',
                'message' => 'Dose details deleted.',
                'icon' => 'success',
                'status' => 200
            ];
        }
        catch(Exception $e){
            $response = [
                'title' => 'Failed!',
                'message' => 'Dose details not deleted.'.$e,
                'icon' => 'error',
                'status' => 400
            ];
        }
        echo json_encode($response);
    }

    public function insert_file(Request $request){
        $rules = [
            'document_type' => ['required'],
            'file' => ['required','max:5000','mimes:jpg,pdf']
        ];

        $message = [
            'document_type.required' => 'Document type is required.',
            'file.required' => 'File is required.'
        ];

        $validator = Validator::make( $request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'File not inserted.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                if($request->file('file')->isValid()){
                    $id = Session::get('user_id');
                    $path = '/public/documents/';
                    $file = $request->file('file');
                    $file_name = time().'_'.$request->document_type.'_'.$id.'.'.$file->extension();
                    $upload = $file->storeAs($path, $file_name);
    
                    DB::table('patient_document')->insert([
                        'dt_id' => $request->document_type,
                        'pd_filename' => $request->file('file')->getClientOriginalName(),
                        'pd_sys_filename' => $file_name,
                        'acc_id' => $id,
                        'uploaded_by' => $id,
                    ]);
                }

                $response = [
                    'title' => 'Success!',
                    'message' => 'Document uploaded.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Document not uploaded.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }
        echo json_encode($response);
    }

    public function delete_file($id){
        $doc_details = DB::table('patient_document')->where('pd_id', $id)->first();
        $path = '/public/documents/';
        try{
            DB::table('patient_document')->where('pd_id', $id)->delete();

            if($doc_details->pd_sys_filename){
                Storage::delete($path.$doc_details->pd_sys_filename); 
            }
            $response = [
                'title' => 'Success!',
                'message' => 'Document deleted.',
                'icon' => 'success',
                'status' => 200
            ];
        }
        catch(Exception $e){
            $response = [
                'title' => 'Failed!',
                'message' => 'Document not deleted.'.$e,
                'icon' => 'error'
            ];
        }
        echo json_encode($response);
    }
}
