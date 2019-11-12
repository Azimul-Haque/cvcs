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

    	$registeredmembers = User::where('activation_status', 1)
    	                        ->where('role_type', '!=', 'admin')                
    	                        ->get();
    	$totalapproved = DB::table('payments')
    	                   ->select(DB::raw('SUM(amount) as totalamount'))
    	                   ->where('payment_status', '=', 1)
    	                   ->where('is_archieved', '=', 0)
    	                   ->first();

    	if($request->report_type == 1) {
    		$totalmontlydues = 0;
    		foreach ($registeredmembers as $member) {
    			$approvedfordashboard = DB::table('payments')
    			                         ->select(DB::raw('SUM(amount) as totalamount'))
    			                         ->where('payment_status', 1)
    			                         ->where('is_archieved', 0)
    			                         ->where('member_id', $member->member_id)
    			                         ->first();

    			if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
    			{
    			  $startyear = 2019;
    			  $today = date("Y-m-d H:i:s");
    			  $thismonth = '2019-1-';
    			  $approvedcash = $approvedfordashboard->totalamount - 5000; // without the membership money;
    			  $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
    			  $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
    			  $diff_in_months = $to->diffInMonths($from);
    			  dd($diff_in_months);
    			} 
    			// $totalyear = $startyear + ceil($approvedcash/(500 * 12)) - 1; // get total year
    			//   if(date('Y') > $totalyear) {
    			//       $totalyear = date('Y');
    			//   }
    			//   for($i=$startyear; $i <= $totalyear; $i++)
    			//     for($j=1; $j <= 12; $j++) {{--  strtotime("11-12-10") --}}
    			//       php
    			//         $thismonth = '01-'.$j.'-'.$i;
    			//       endphp
    			//       <tr>
    			//         <td>{{ date('F Y', strtotime($thismonth)) }}</td>
    			//         <td>
    			//           if($approvedcash/500 > 0)
    			//             <span>পরিশোধিত</span>
    			//           elseif(date('Y-m-d H:i:s', strtotime($thismonth)) < $today)
    			//             <span style="color: red;">পরিশোধনীয়</span>
    			//           endif
    			//         </td>
    			//         <td>
    			//           if($approvedcash/500 > 0)
    			//             ৳ 500
    			//           endif
    			//         </td>
    			//       </tr>
    			//       php
    			//         $approvedcash = $approvedcash - 500;
    			//       endphp
    			//     endfor
    			//   endfor
    			// else
    			//   php
    			//       $startyear = date('Y', strtotime($member->joining_date));
    			//       $startmonth = date('m', strtotime($member->joining_date));
    			//       $today = date("Y-m-d H:i:s");
    			//       $approvedcash = $approvedfordashboard->totalamount - 5000; // without the membership money;
    			//       $endyear = $startyear + ceil($approvedcash/(500 * 12)) - 1; // get total year
    			//       if(date('Y') > $endyear) {
    			//           $endyear = date('Y');
    			//       }
    			//       $totalyears = $endyear - $startyear;
    			//       $totalmonths = ($totalyears * 12) + (12 - $startmonth + 1);
    			//   endphp
    			//   php
    			//     $thisyear = $startyear;
    			//     $fractionyearsmonths = $totalmonths % 12;
    			//     $fractionyearsmonthscount = $fractionyearsmonths;
    			//     $monthsarray = [];
    			//   endphp
    			//   for($i=1; $i <= $fractionyearsmonthscount; $i++)
    			//     php
    			//       $monthsarray[] = '01-'.(12-$fractionyearsmonths + 1).'-'.$thisyear;

    			//       $fractionyearsmonths--; // this ends with 0;
    			//     endphp
    			//   endfor

    			//   php
    			//     $leftmonths = $totalmonths - $fractionyearsmonthscount;
    			//     if($leftmonths > 0) {
    			//       $thisyear = $thisyear + 1;
    			//       for ($j=1; $j <= $leftmonths; $j++) { 
    			//         $thismonth = $j%12;
    			//         if($thismonth == 0) {
    			//           $thismonth = 12;
    			//         }
    			//         $monthsarray[] = '01-'.$thismonth.'-'.$thisyear;
    			//         if($j%12 == 0) {
    			//           $thisyear++;
    			//         }
    			//       }
    			//     }
    			    
    			//   endphp
    			//   foreach($monthsarray as $month)
    			//     <tr>
    			//       <td>{{ date('F Y', strtotime($month)) }}</td>
    			//       <td>
    			//         if($approvedcash/500 > 0)
    			//           <span class="badge badge-success"><i class="fa fa-check"></i>পরিশোধিত</span>
    			//         elseif(date('Y-m-d H:i:s', strtotime($month)) < $today)
    			//           <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> পরিশোধনীয়</span>
    			//         endif
    			//       </td>
    			//       <td>
    			//         if($approvedcash/500 > 0)
    			//           ৳ 500
    			//         endif
    			//       </td>
    			//     </tr>
    			//     php
    			//       $approvedcash = $approvedcash - 500;
    			//     endphp
    			//   endforeach
    			// endif
    			  
    		}
    		$pdf = PDF::loadView('dashboard.reports.pdf.allpaymentsandpendings', ['registeredmembers' => $registeredmembers, 'totalapproved' => $totalapproved, 'totalmontlydues' => $totalmontlydues]);
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
