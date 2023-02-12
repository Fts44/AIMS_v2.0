<?php

namespace App\Http\Controllers\Admin\Configuration\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NameController extends Controller
{
    public function index(){
        $ie_names = DB::table('inventory_equipment_name as ien')
            ->select('ien.*', 'ieid.ieid_id')
            ->leftjoin('inventory_equipment_item_details as ieid', 'ien.ien_id', 'ieid.ien_id')
            ->groupBy('ien.ien_id')
            ->get();

        return view('Admin.Configuration.Equipment.Name')->with([
            'ie_names' => $ie_names
        ]);
    }

    public function insert(Request $request){
        $rules = [
            'name' => ['required', 'unique:inventory_equipment_name,ien_name'],
            'status' => ['required', 'in:0,1']
        ];
        
        $validator = validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment name not added.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];    
        }
        else{
            try{
                DB::table('inventory_equipment_name')->insert([
                    'ien_name' => $request->name,
                    'ien_status' => $request->status 
                ]);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment name added',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment name not added.'.$e,
                    'icon' => 'error',
                    'status' => 400,
                    'action' => 'Add'
                ];   
            }
        }
        echo json_encode($response);
    }

    public function update(Request $request, $id){
        $rules = [
            'name' => ['required', 'unique:inventory_equipment_name,ien_name,'.$id.',ien_id'],
            'status' => ['required', 'in:0,1']
        ];
        
        $validator = validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment name not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];    
        }
        else{
            try{
                DB::table('inventory_equipment_name')->where('ien_id', $id)->update([
                    'ien_name' => $request->name,
                    'ien_status' => $request->status 
                ]);
    
                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment name updated',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment name not updated.'.$e,
                    'icon' => 'error',
                    'status' => 400,
                    'action' => 'Add'
                ];
            }
        }
        echo json_encode($response);
    }

    public function delete($id){
        try{
            DB::table('inventory_equipment_name')->where('ien_id', $id)->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Equipment name deleted',
                'icon' => 'success',
                'status' => 200
            ];
        }
        catch(Exception $e){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment name not deleted'.$e,
                'icon' => 'error',
                'status' => 400
            ];
        }
        echo json_encode($response);
    }
}
