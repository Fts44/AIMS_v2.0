<?php

namespace App\Http\Controllers\Admin\Configuration\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    public function index(){
        $ie_places = DB::table('inventory_equipment_place as iep')
            ->select('iep.*', 'iei_id')
            ->leftjoin('inventory_equipment_item as iei', 'iep.iep_id', 'iei.iep_id')
            ->groupBy('iep.iep_id')
            ->get();

        return view('Admin.Configuration.Equipment.Place')->with([
            'ie_places' => $ie_places
        ]);
    }

    public function insert(Request $request){
        $rules = [
            'place' => ['required', 'unique:inventory_equipment_place,iep_place'],
            'status' => ['required', 'in:0,1']
        ];
        
        $validator = validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment place not added.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];    
        }
        else{
            try{
                DB::table('inventory_equipment_place')->insert([
                    'iep_place' => $request->place,
                    'iep_status' => $request->status 
                ]);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment place added',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment place not added.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];    
            }
        }
        echo json_encode($response);
    }

    public function update(Request $request, $id){
        $rules = [
            'place' => ['required', 'unique:inventory_equipment_place,iep_place,'.$id.',iep_id'],
            'status' => ['required', 'in:0,1']
        ];
        
        $validator = validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment place not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                DB::table('inventory_equipment_place')->where('iep_id', $id)->update([
                    'iep_place' => $request->place,
                    'iep_status' => $request->status 
                ]);
    
                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment place updated',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment place not updated.'.$e,
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
            DB::table('inventory_equipment_place')->where('iep_id', $id)->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Equipment place deleted',
                'icon' => 'success',
                'status' => 200
            ];
        }
        catch(Exception $e){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment place not deleted'.$e,
                'icon' => 'error',
                'status' => 400
            ];
        }
        echo json_encode($response);
    }
}
