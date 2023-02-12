<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Transaction\AttendanceCodeController as AttendanceCodeController;
use DB;

class TransactionController extends Controller
{
    public function index($date){
        $AttendanceCode = new AttendanceCodeController;
        $todays_attendance_code = $AttendanceCode->get_todays_code();
        
        $attendance = DB::table('transaction as t')
            ->select('t.*', 'ttl.ttl_title')
            ->where('trans_date', $date)
            ->leftjoin('accounts as a', 't.acc_id', 'a.acc_id')
            ->leftjoin('title as ttl', 'a.ttl_id', 'ttl.ttl_id')
            ->orderBy('trans_time_in', 'DESC')
            ->get();

        return view('Admin.Transaction.Attendance')
            ->with([
                'todays_code' => $todays_attendance_code,
                'attendance' => $attendance,
                'date' => $date
            ]);
    }
}
