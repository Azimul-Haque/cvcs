<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Payment;
use App\Paymentreceipt;
use App\Donor;
use App\Donation;
use App\Branch;
use App\Branchpayment;
use App\Position;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Image;
use File;
use Session, Config;
use Hash;
use PDF;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function getReportsPage()
    {
        return view('dashboard.reports.index');
    }

    public function getPDFAllPnedingAndPayments(Request $request)
    {
    	//validation
    	$this->validate($request, array(
    	  'report_type' => 'required'
    	));

    	$registeredmember = User::where('activation_status', 1)
    	                        ->where('role_type', '!=', 'admin')                
    	                        ->count();
    	$totalapproved = DB::table('payments')
    	                   ->select(DB::raw('SUM(amount) as totalamount'))
    	                   ->where('payment_status', '=', 1)
    	                   ->where('is_archieved', '=', 0)
    	                   ->first();

    	if($request->report_type == 1) {
    		$pdf = PDF::loadView('dashboard.reports.pdf.allpaymentsandpendings', ['registeredmember' => $registeredmember, 'totalapproved' => $totalapproved]);
    		$fileName = 'CVCS_General_Report.pdf';
    		return $pdf->stream($fileName); // download
    	}
    	// $from = date("Y-m-d H:i:s", strtotime($request->from));
    	// $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));
    	// $commodities = Commodity::whereBetween('created_at', [$from, $to])
    	//                 ->orderBy('created_at', 'desc')
    	//                 ->where('isdeleted', '=', 0)
    	//                 ->get();
    	// $commodity_total = DB::table('commodities')
    	//                 ->select(DB::raw('SUM(total) as totaltotal'), DB::raw('SUM(paid) as paidtotal'), DB::raw('SUM(due) as duetotal'))
    	//                 ->whereBetween('created_at', [$from, $to])
    	//                 ->where('isdeleted', '=', 0)
    	//                 ->first();

    	// $pdf = PDF::loadView('dashboard.reports.pdf.allpaymentsandpendings', ['commodities' => $commodities], ['data' => [$request->from, $request->to, $commodity_total->totaltotal, $commodity_total->paidtotal, $commodity_total->duetotal]]);
    	// $fileName = 'Commodity_'. date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
    	// return $pdf->download($fileName);
    }
}
