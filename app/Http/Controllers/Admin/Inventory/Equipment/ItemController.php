<?php

namespace App\Http\Controllers\Admin\Inventory\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(){
        $item_details = DB::table('inventory_equipment_item_details as ieid')
            ->select('ieid.*', 'ien.*', 'iet.*', 'ieb.*')
            ->leftjoin('inventory_equipment_name as ien', 'ieid.ien_id', 'ien.ien_id')
            ->leftjoin('inventory_equipment_type as iet', 'ieid.iet_id', 'iet.iet_id')
            ->leftjoin('inventory_equipment_brand as ieb', 'ieid.ieb_id', 'ieb.ieb_id')
            ->orderBy('ien.ien_name', 'ASC')
            ->get();
    
        $places = DB::table('inventory_equipment_place')
            ->orderBy('iep_place', 'ASC')
            ->where('iep_place','!=','none')
            ->get();

        $inventory_items = DB::table('inventory_equipment_item as iei')
            ->select('iei.*', 'ieid.*', 'ien.*', 'iet.*', 'ieb.*', 'iep.*')
            ->leftjoin('inventory_equipment_item_details as ieid', 'iei.ieid_id', 'ieid.ieid_id')
            ->leftjoin('inventory_equipment_name as ien', 'ieid.ien_id', 'ien.ien_id')
            ->leftjoin('inventory_equipment_type as iet', 'ieid.iet_id', 'iet.iet_id')
            ->leftjoin('inventory_equipment_brand as ieb', 'ieid.ieb_id', 'ieb.ieb_id')
            ->leftjoin('inventory_equipment_place as iep', 'iei.iep_id', 'iep.iep_id')
            ->where('is_deleted', '0')
            ->get();
            
        return view('Admin.Inventory.Equipment.Item')
            ->with([
                'inventory_items' => $inventory_items,
                'item_details' => $item_details,
                'places' => $places
            ]);
    }

    public function insert(Request $request){
        $rules = [
            'item' => ['required'],
            'quantity' => ['required', 'numeric', 'min:1', 'max:10'], 
            'date_added' => ['required'],
            'condition' => ['required'],
            'place' => ['required'],
        ];

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment item not added.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];  
        }
        else{
            try{
                $item = [];
                $status = [];
                for($i=0; $i<$request->quantity; $i++){
                    array_push($item, [
                        'iei_qty' => 1,
                        'iei_condition' => $request->condition,
                        'iei_date_added' => $request->date_added,
                        'ieid_id' => $request->item,
                        'iep_id' => $request->place,
                    ]);
                }

                // insert item and get their ids
                foreach($item as $key => $value){
                    $newId = DB::table('inventory_equipment_item')->insertGetId($item[$key]);

                    DB::table('inventory_equipment_update_condition')->insert([
                        'ieuc_date' => date_format(new DateTime($request->date_added),'Y-m-d'),
                        'ieuc_to_condition' => $request->condition,
                        'ieuc_from_condition' => $request->condition,
                        'iep_id' => $request->place,
                        'iei_id' => $newId
                    ]);
                }
               
                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment item added.',
                    'icon' => 'success',
                    'status' => 200
                ]; 
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Error!',
                    'message' => 'Equipment item not added.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];    
            }
        }
        echo json_encode($response);
    }

    public function update(Request $request, $id){

        $rules = [
            'item' => ['required'],
            'quantity' => ['required', 'numeric'], 
            'date_added' => ['required', 'date'],
            'date_condition_update' => ['required', 'date','after_or_equal:date_added'],
            'condition' => ['required'],
            'place' => ['required'],
        ];

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment item not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];  
        }
        else{
            try{
                $item = DB::table('inventory_equipment_item')->where('iei_id', $id)->first();
                $condition = DB::table('inventory_equipment_update_condition')
                    ->whereRaw("iei_id = '".$id."'")
                    ->whereRaw("DATE_FORMAT(ieuc_date, '%Y-%m') = '".date_format(new DateTime($request->date_condition_update),'Y-m')."'")
                    ->first();
                
                DB::table('inventory_equipment_item')->where('iei_id', $id)->update([
                    'iei_qty' => $request->quantity,
                    'iei_condition' => $request->condition,
                    'iei_date_added' => $request->date_added,
                    'ieid_id' => $request->item,
                    'iep_id' => $request->place
                ]);

                if($condition){
                    DB::table('inventory_equipment_update_condition')->where('ieuc_id',$condition->ieuc_id)->update([
                        'ieuc_date' => date_format(new DateTime($request->date_condition_update),'Y-m-d'),
                        'ieuc_to_condition' => $request->condition,
                        'ieuc_from_condition' => $item->iei_condition,
                        'iep_id' => $request->place,
                        'iei_id' => $id
                    ]);
                }
                else{
                    DB::table('inventory_equipment_update_condition')->insert([
                        'ieuc_date' => date_format(new DateTime($request->date_condition_update),'Y-m-d'),
                        'ieuc_to_condition' => $request->condition,
                        'ieuc_from_condition' => $item->iei_condition,
                        'iep_id' => $request->place,
                        'iei_id' => $id
                    ]);
                }
                
                $response = [
                    'title' => 'Success!',
                    'message' => 'Equipment item updated.',
                    'icon' => 'success',
                    'status' => 200
                ];   
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Error!',
                    'message' => 'Equipment item not updated.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }
        echo json_encode($response);
    }

    public function delete($id){
        try{
            DB::table('inventory_equipment_item')->where('iei_id', $id)->delete();
            DB::table('inventory_equipment_update_condition')->where('iei_id', $id)->delete();
           
            $response = [
                'title' => 'Success!',
                'message' => 'Equipment item deleted',
                'icon' => 'success',
                'status' => 200
            ];
        }
        catch(Exception $e){
            $response = [
                'title' => 'Error!',
                'message' => 'Equipment item not deleted'.$e,
                'icon' => 'error',
                'status' => 400
            ];
        }
        echo json_encode($response);
    }
}
