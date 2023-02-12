<?php

namespace App\Http\Controllers\Admin\Configuration\Medicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GenericNameController extends Controller
{
    public function index(){
        $generic_names = DB::table('inventory_medicine_generic_name as imgn')
            ->select('imgn.*', 'imi.imi_id')
            ->leftjoin('inventory_medicine_item as imi', 'imgn.imgn_id', 'imi.imgn_id')
            ->groupBy('imgn.imgn_id')
        ->get();

        return view('Admin.Configuration.Medicine.GenericName')
            ->with([
               'generic_names' => $generic_names
            ]);
    }

    public function insert(Request $request){
        $rules = [
            'generic_name' => ['required', 'unique:inventory_medicine_generic_name,imgn_generic_name'],
            'status' => ['required', 'in:0,1'] 
        ];

        $validator = validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Generic name not added.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];    
        }
        else{

            try{
                DB::table('inventory_medicine_generic_name')->insert([
                    'imgn_generic_name' => $request->generic_name,
                    'imgn_status' => $request->status
                ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Generic name added!',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Error!',
                    'message' => 'Generic name not added.'.$e,
                    'icon' => 'error',
                    'status' => 400,
                ];   
            }

        }
        echo json_encode($response);
    }

    public function update(Request $request, $id){
        $rules = [
            'generic_name' => ['required', 'unique:inventory_medicine_generic_name,imgn_generic_name,'.$id.',imgn_id'],
            'status' => ['required', 'in:0,1'] 
        ];

        $validator = validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Generic name not update.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];    
        }
        else{

            try{
                DB::table('inventory_medicine_generic_name')
                ->where('imgn_id', $id)
                ->update([
                    'imgn_generic_name' => $request->generic_name,
                    'imgn_status' => $request->status
                ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Generic name updated!',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Error!',
                    'message' => 'Generic name not updated.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];   
            }

        }
        echo json_encode($response);
    }
    
    public function delete($id){
        try{
            DB::table('inventory_medicine_generic_name')
            ->where('imgn_id', $id)
            ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Generic name deleted!',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }
        catch(Exception $e){
            $response = [
                'title' => 'Error!',
                'message' => 'Generic name not deleted.'.$e,
                'icon' => 'error',
                'status' => 400
            ];   
        }
        echo json_encode($response);
    }
}
