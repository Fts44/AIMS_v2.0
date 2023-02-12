<?php

namespace App\Http\Controllers\Admin\Inventory\Medicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request){
        $generic = DB::table('inventory_medicine_generic_name')
            ->get();
        
        $brand = DB::table('inventory_medicine_brand')
            ->get();
        
        $gn = ($request->gn) ? ('="'.$request->gn.'"') : 'IS NOT NULL';
        $br = ($request->br) ? ('="'.$request->br.'"') : 'IS NOT NULL';
        $dam = ($request->dam) ? ('="'.$request->dam.'"') : 'IS NOT NULL';
        $day = ($request->day) ? ('="'.$request->day.'"') : 'IS NOT NULL';
        $em = ($request->em) ? ('="'.$request->em.'"') : 'IS NOT NULL';
        $ey = ($request->ey) ? ('="'.$request->ey.'"') : 'IS NOT NULL';
        $status = ($request->status=='' && $request->status!='0') ? 1 : $request->status;
        $qty = $request->quantity;

        if($status==1){
            $items = DB::select("SELECT `imi`.*, `imgn`.`imgn_generic_name`, `imb`.`imb_brand`, 
                SUM(CASE WHEN `imt`.`imt_type`='dispose' THEN `imt`.`imt_quantity` End) AS 'dispose',
                SUM(CASE WHEN `imt`.`imt_type`='dispense' THEN `imt`.`imt_quantity` End) AS 'dispense'
                FROM `inventory_medicine_item` as `imi`
                LEFT JOIN `inventory_medicine_generic_name` as `imgn`
                ON `imi`.`imgn_id`=`imgn`.`imgn_id`
                LEFT JOIN `inventory_medicine_brand` as `imb` 
                ON `imi`.`imb_id`=`imb`.`imb_id`
                LEFT JOIN `inventory_medicine_transaction` as `imt`
                ON `imi`.`imi_id`=`imt`.`imi_id`
                WHERE imi.imgn_id ".$gn."
                AND imi.imb_id ".$br."
                AND DATE_FORMAT(imi.imi_date_added, '%m') ".$dam."
                AND DATE_FORMAT(imi.imi_date_added, '%Y') ".$day."
                AND DATE_FORMAT(imi.imi_expiration, '%m') ".$em."
                AND DATE_FORMAT(imi.imi_expiration, '%Y') ".$ey." 
                AND imi.imi_expiration > '".date('Y-m-d')."'
                GROUP BY `imi`.`imi_id`
                ORDER BY ABS( DATEDIFF( `imi`.`imi_expiration`, NOW() ) ) 
                ");
        }
        else if($status==2){
            $items = DB::select("SELECT `imi`.*, `imgn`.`imgn_generic_name`, `imb`.`imb_brand`, 
                SUM(CASE WHEN `imt`.`imt_type`='dispose' THEN `imt`.`imt_quantity` End) AS 'dispose',
                SUM(CASE WHEN `imt`.`imt_type`='dispense' THEN `imt`.`imt_quantity` End) AS 'dispense'
                FROM `inventory_medicine_item` as `imi`
                LEFT JOIN `inventory_medicine_generic_name` as `imgn`
                ON `imi`.`imgn_id`=`imgn`.`imgn_id`
                LEFT JOIN `inventory_medicine_brand` as `imb` 
                ON `imi`.`imb_id`=`imb`.`imb_id`
                LEFT JOIN `inventory_medicine_transaction` as `imt`
                ON `imi`.`imi_id`=`imt`.`imi_id`
                WHERE imi.imgn_id ".$gn."
                AND imi.imb_id ".$br."
                AND DATE_FORMAT(imi.imi_date_added, '%m') ".$dam."
                AND DATE_FORMAT(imi.imi_date_added, '%Y') ".$day."
                AND DATE_FORMAT(imi.imi_expiration, '%m') ".$em."
                AND DATE_FORMAT(imi.imi_expiration, '%Y') ".$ey." 
                AND datediff(`imi_expiration`,NOW()) BETWEEN 1 AND 14
                GROUP BY `imi`.`imi_id`
                ORDER BY ABS( DATEDIFF( `imi`.`imi_expiration`, NOW() ) ) 
                ");
        }
        else{
            $items = DB::select("SELECT `imi`.*, COUNT(imt.imt_id) AS imt, `imgn`.`imgn_generic_name`, `imb`.`imb_brand`, 
                SUM(CASE WHEN `imt`.`imt_type`='dispose' THEN `imt`.`imt_quantity` End) AS 'dispose',
                SUM(CASE WHEN `imt`.`imt_type`='dispense' THEN `imt`.`imt_quantity` End) AS 'dispense'
                FROM `inventory_medicine_item` as `imi`
                LEFT JOIN `inventory_medicine_generic_name` as `imgn`
                ON `imi`.`imgn_id`=`imgn`.`imgn_id`
                LEFT JOIN `inventory_medicine_brand` as `imb` 
                ON `imi`.`imb_id`=`imb`.`imb_id`
                LEFT JOIN `inventory_medicine_transaction` as `imt`
                ON `imi`.`imi_id`=`imt`.`imi_id`
                WHERE imi.imgn_id ".$gn."
                AND imi.imb_id ".$br."
                AND `imi_expiration` <= '".date('Y-m-d')."'
                GROUP BY `imi`.`imi_id`
                ");
        }

        return view('Admin.Inventory.Medicine.Item')
            ->with([
                'status' => $request->status,
                'generic' => $generic,
                'brand' => $brand,
                'items' => $items,
                'gn' => $gn,
                'br' => $br,
                'dam' => $dam,
                'day' => $day,
                'em' => $em,
                'ey' => $ey,
                'qty' => $qty
            ]);
    }

    public function insert(Request $request){
        $rules = [
            'date_added' => ['required', 'date'],
            'generic_name' => ['required'],
            'brand' => ['required'],
            'quantity' => ['required'],
            'expiration' => ['required', 'date']
        ];

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Medicine item not added.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{

            try{
                DB::table('inventory_medicine_item')->insert([
                    "imi_quantity" => $request->quantity,
                    "imgn_id" => $request->generic_name,
                    "imb_id" => $request->brand,
                    "imi_date_added" => $request->date_added,
                    "imi_expiration" => $request->expiration,
                    "imi_status" => $request->status
                ]);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Medicine item added.',
                    'icon' => 'success',
                    'status' => 200
                ]; 
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Error!',
                    'message' => 'Medicine item not added.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ]; 
            }
        }
        echo json_encode($response);
    }

    public function update(Request $request, $id){
        $rules = [
            'date_added' => ['required', 'date'],
            'generic_name' => ['required'],
            'brand' => ['required'],
            'quantity' => ['required'],
            'expiration' => ['required', 'date']
        ];

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Medicine item not updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];    
        }
        else{

            try{
                DB::table('inventory_medicine_item')
                ->where('imi_id', $id)
                ->update([
                    "imi_quantity" => $request->quantity,
                    "imgn_id" => $request->generic_name,
                    "imb_id" => $request->brand,
                    "imi_date_added" => $request->date_added,
                    "imi_expiration" => $request->expiration,
                    "imi_status" => $request->status
                ]);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Medicine item updated.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Error!',
                    'message' => 'Medicine item not added.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }
        echo json_encode($response);
    }

    public function delete($id){
        try{
            DB::table('inventory_medicine_item')
                ->where('imi_id', $id)
                ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Medicine item deleted.',
                'icon' => 'success',
                'status' => 200
            ];  
        }
        catch(Exception $e){
            $response = [
                'title' => 'Error!',
                'message' => 'Medicine item not deleted.'.$e,
                'icon' => 'error',
                'status' => 400,
            ]; 
        }
        echo json_encode($response);
    }

    public function dispose(Request $request, $id){ 
        $rules = [
            'dispose_available' => ['required', 'numeric'],
            'dispose_quantity' => ['required', 'lte:dispose_available']
        ];

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Error!',
                'message' => 'Dispose failed.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages() 
            ];
        }
        else{
            try{
                DB::table('inventory_medicine_transaction')->insert([
                    'acc_id' => NULL,
                    'imt_type' => 'dispose',
                    'imt_quantity' => $request->dispose_quantity,
                    'imi_id' => $id
                ]);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Disposed successfully.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Dispose failed.'.$e,
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }
        echo json_encode($response);
    }

    public function transaction_index($id){
        $transactions = DB::table('inventory_medicine_transaction as t')
            ->select('t.*', 'a.firstname', 'a.middlename', 'a.lastname', 'ttl.ttl_title')
            ->where('t.imi_id', $id)
            ->leftjoin('accounts as a', 't.acc_id', 'a.acc_id')
            ->leftjoin('title as ttl', 'a.ttl_id', 'ttl.ttl_id')
            ->get();
            
        $item_details = DB::table('inventory_medicine_item as imi')
            ->leftjoin('inventory_medicine_generic_name as imgn', 'imi.imgn_id', 'imgn.imgn_id')
            ->leftjoin('inventory_medicine_brand as imb', 'imi.imb_id', 'imb.imb_id')
            ->where('imi.imi_id', $id)
            ->first();

        return view('Admin.Inventory.Medicine.Transaction')
            ->with([
                'transactions' => $transactions,
                'id' => $item_details
            ]);
    }

    public function transaction_delete($id){
        try{
            DB::table('inventory_medicine_transaction')
                ->where('imt_id', $id)
                ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Transaction deleted.',
                'icon' => 'success',
                'status' => 200
            ];  
        }
        catch(Exception $e){
            $response = [
                'title' => 'Error!',
                'message' => 'Transaction not deleted.'.$e,
                'icon' => 'error',
                'status' => 400,
            ]; 
        }
        echo json_encode($response);
    }
}
