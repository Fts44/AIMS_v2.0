<?php

namespace App\Http\Controllers\Admin\Inventory\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllController extends Controller
{
    public function index(){
        $inventory_items = DB::table('inventory_equipment_item as iei')
            ->select('ien.*', 'ieid.*','ieb.*', 'iet.*', 'iep.*', DB::raw('SUM(iei.iei_qty) AS total_qty'), 'iep.iep_place', 
            DB::raw("SUM(CASE WHEN iei_condition = '1' THEN 1 ELSE 0 END) AS working"),
            DB::raw("SUM(CASE WHEN iei_condition = '0' THEN 1 ELSE 0 END) AS not_working"))
            ->leftjoin('inventory_equipment_item_details as ieid', 'iei.ieid_id', 'ieid.ieid_id')
            ->leftjoin('inventory_equipment_name as ien', 'ieid.ien_id', 'ien.ien_id')
            ->leftjoin('inventory_equipment_type as iet', 'ieid.iet_id', 'iet.iet_id')
            ->leftjoin('inventory_equipment_brand as ieb', 'ieid.ieb_id', 'ieb.ieb_id')
            ->leftjoin('inventory_equipment_place as iep', 'iei.iep_id', 'iep.iep_id')
            ->where('iei.is_deleted', '!=', '1')
            ->groupBy('iei.ieid_id', 'iet.iet_id','ieb.ieb_id','iei.iep_id')
            ->get();

        return view('Admin.Inventory.Equipment.All')->with([ 'inventory' => $inventory_items ]);
    }
}
