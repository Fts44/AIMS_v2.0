<?php

namespace App\Http\Controllers\Admin\Configuration\Medicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index(){
        $brands = DB::table('inventory_medicine_brand as imb')
        ->select('imb.*', 'imi.imi_id')
        ->leftjoin('inventory_medicine_item as imi', 'imb.imb_id', 'imi.imb_id')
        ->groupby('imb.imb_id')
        ->get();

        return view('Admin.Configuration.Medicine.Brand')
            ->with([
                'brands' => $brands
            ]);
    }

    public function insert(Request $request){
        $rules = [
            'brand' => ['required', 'unique:inventory_medicine_brand,imb_brand'],
            'status' => ['required', 'in:0,1'] 
        ];

        $validator = validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Brand name not added.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];    
        }
        else{

            try{
                DB::table('inventory_medicine_brand')->insert([
                    'imb_brand' => $request->brand,
                    'imb_status' => $request->status
                ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Brand name added!',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Error!',
                    'message' => 'Brand name not added.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];   
            }

        }
        echo json_encode($response);
    }

    public function update(Request $request, $id){
        $rules = [
            'brand' => ['required', 'unique:inventory_medicine_brand,imb_brand,'.$id.',imb_id'],
            'status' => ['required', 'in:0,1'] 
        ];

        $validator = validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Brand name not update.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];    
        }
        else{

            try{
                DB::table('inventory_medicine_brand')
                    ->where('imb_id', $id)
                    ->update([
                        'imb_brand' => $request->brand,
                        'imb_status' => $request->status
                ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Brand name updated!',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Error!',
                    'message' => 'Brand name not updated.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];   
            }

        }
        echo json_encode($response);
    }

    public function delete($id){
        try{
            DB::table('inventory_medicine_brand')
            ->where('imb_id', $id)
            ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Brand name deleted!',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }
        catch(Exception $e){
            $response = [
                'title' => 'Error!',
                'message' => 'Brand name not deleted.'.$e,
                'icon' => 'error',
                'status' => 400,
                'action' => 'Delete'
            ];   
        }
        echo json_encode($response);
    }
}
