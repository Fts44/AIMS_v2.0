<?php

namespace App\Http\Controllers\Patient\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller
{
    public function index(){
        $doc_type = DB::table('document_type')
            ->where('dt_id', '>', '2')
        ->get();

        $uploads = DB::table('patient_document as pd')
            ->leftjoin('document_type as dt', 'pd.dt_id', 'dt.dt_id')
            ->where('acc_id', Session::get('user_id'))
            ->where('dt.dt_id', '>', '2')
            ->where('uploaded_by', Session::get('user_id'))
        ->get();

        return view('Patient.Documents.Uploads')
            ->with([
                'doc_type' => $doc_type,
                'uploads' => $uploads
            ]);
    }

    public function insert(Request $request){
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
                'message' => 'Invalid data, File not uploaded.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
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
                    'uploaded_by' => $id
                ]);

                $response = [
                    'title' => 'Succes!',
                    'message' => 'Document uploaded.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
        }    
        echo json_encode($response);
    }

    public function delete(Request $request, $id){
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
