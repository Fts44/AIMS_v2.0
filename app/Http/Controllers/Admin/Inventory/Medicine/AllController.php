<?php

namespace App\Http\Controllers\Admin\Inventory\Medicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllController extends Controller
{
    public function index(){
        $all = DB::select("SELECT `t3`.`imgn_generic_name`,
        SUM(`t1`.`imi_quantity`) AS 'total_quantity',
        
        IF(ISNULL((SELECT SUM(`a4`.`imi_quantity`) FROM `inventory_medicine_item` as `a4` LEFT JOIN `inventory_medicine_generic_name` as `a5`
        ON `a4`.`imgn_id` = `a5`.`imgn_id`  WHERE `a4`.`imi_status`=0 AND `a5`.`imgn_id`=`t3`.`imgn_id`)),0,(SELECT SUM(`a4`.`imi_quantity`) FROM `inventory_medicine_item` as `a4` LEFT JOIN `inventory_medicine_generic_name` as `a5` ON `a4`.`imgn_id` = `a5`.`imgn_id`  WHERE `a4`.`imi_status`=0 AND `a5`.`imgn_id`=`t3`.`imgn_id`)) AS 'total_0',
                
        IF(ISNULL((SELECT SUM(`a4`.`imi_quantity`) FROM `inventory_medicine_item` as `a4` LEFT JOIN `inventory_medicine_generic_name` as `a5`
        ON `a4`.`imgn_id` = `a5`.`imgn_id`  WHERE `a4`.`imi_status`=1 AND `a5`.`imgn_id`=`t3`.`imgn_id`)),0,(SELECT SUM(`a4`.`imi_quantity`) FROM `inventory_medicine_item` as `a4` LEFT JOIN `inventory_medicine_generic_name` as `a5` ON `a4`.`imgn_id` = `a5`.`imgn_id`  WHERE `a4`.`imi_status`=1 AND `a5`.`imgn_id`=`t3`.`imgn_id`)) AS 'total_1',
                
        IF(ISNULL((SELECT SUM(`imt_quantity`) FROM `inventory_medicine_transaction` as `a4` LEFT JOIN `inventory_medicine_item` as `a5`
        ON `a4`.`imi_id` = `a5`.`imi_id` WHERE `imgn_id`=`t1`.`imgn_id` AND `a5`.`imi_status`=0)),0,(SELECT SUM(`imt_quantity`) FROM `inventory_medicine_transaction` as `a4` LEFT JOIN `inventory_medicine_item` as `a5` ON `a4`.`imi_id` = `a5`.`imi_id` WHERE `imgn_id`=`t1`.`imgn_id` AND `a5`.`imi_status`=0)) as 'tq_0',
        IF(ISNULL((SELECT SUM(`imt_quantity`) FROM `inventory_medicine_transaction` as `a4` LEFT JOIN `inventory_medicine_item` as `a5`
        ON `a4`.`imi_id` = `a5`.`imi_id` WHERE `imgn_id`=`t1`.`imgn_id` AND `a5`.`imi_status`=1)),0,(SELECT SUM(`imt_quantity`) FROM `inventory_medicine_transaction` as `a4` LEFT JOIN `inventory_medicine_item` as `a5` ON `a4`.`imi_id` = `a5`.`imi_id` WHERE `imgn_id`=`t1`.`imgn_id` AND `a5`.`imi_status`=1)) as 'tq_1'
                
        FROM `inventory_medicine_item` as `t1`
        LEFT JOIN `inventory_medicine_transaction` as `t2`
        ON `t1`.`imi_id`=`t2`.`imi_id`
        LEFT JOIN `inventory_medicine_generic_name` as `t3`
        ON `t3`.`imgn_id`=`t1`.`imgn_id`
        GROUP BY `t1`.`imgn_id`");

        return view('Admin.Inventory.Medicine.All')
            ->with([
                'all' => $all
            ]);
    }
}
