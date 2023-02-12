<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AttendanceCodeController extends Controller
{
    public function __construct(){
        $this->get_todays_code();
    }

    public function get_todays_code(){
        // change the date in xampp php.ini instead of using this line of code
        // date_default_timezone_set('Asia/Manila');
        $todays_code = DB::table('attendance_code')
            ->where('ac_date', date("Y-m-d"))
            ->first();

        if(!$todays_code){
            DB::table('attendance_code')
                ->update([
                    'ac_status' => 0
                ]);
            $new_ac_code = rand ( 1000 , 9999 );
            DB::table('attendance_code')->insert([
                'ac_date' =>  date("Y-m-d"),
                'ac_code' => $new_ac_code
            ]);
            $todays_code = DB::table('attendance_code')
            ->where('ac_date',  date("Y-m-d"))
            ->first();
        }
        return $todays_code;
    }

    public function get_new_code($id){
        $new_ac_code = rand ( 1000 , 9999 );

        DB::table('attendance_code')->where('ac_id', $id)->update([
            'ac_code' => $new_ac_code
        ]);

        return $new_ac_code;
    }

    public function index(){
        $codes = DB::table('attendance_code')
            ->orderBy('ac_date', 'DESC')
            ->get();

        return view('Admin.Transaction.Code')
            ->with([
                'codes' => $codes
            ]);
    }

    public function update_status($id){      
        $ac = DB::table('attendance_code')
            ->where('ac_id', $id)
            ->first();

        DB::table('attendance_code')->where('ac_id', $id)
            ->update([
                'ac_status' => ($ac->ac_status) ? 0 : 1
            ]);
    }
}
