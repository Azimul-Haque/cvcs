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
    }

    public function getReportsPage()
    {
    	$branches = Branch::all();
        return view('dashboard.reports.index')->withBranches($branches);
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

    	if($request->report_type == 1) {
    		$totalapproved = DB::table('payments')
    		                   ->select(DB::raw('SUM(amount) as totalamount'))
    		                   ->where('payment_status', '=', 1)
    		                   ->where('is_archieved', '=', 0)
                               ->where('payment_category', 1)  // 1 means monthly, 0 for membership
    		                   ->first();
    		$totalmontlydues = 0;
    		foreach ($registeredmembers as $member) {
    			$approvedtotal = DB::table('payments')
		                           ->select(DB::raw('SUM(amount) as totalamount'))
		                           ->where('payment_status', 1)
		                           ->where('is_archieved', 0)
		                           ->where('member_id', $member->member_id)
		                           ->where('payment_category', 1)  // 1 means monthly, 0 for membership
		                           ->first();
    			$approvedcashformontly = $approvedtotal->totalamount;

    			if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
    			{
    			    $thismonth = Carbon::now()->format('Y-m-');
    			    $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
    			    $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
    			    $totalmonthsformember = $to->diffInMonths($from) + 1;
    			    if(($totalmonthsformember * 500) > $approvedcashformontly) {
    			    	$totalpendingmonthly = ($totalmonthsformember * 500) - $approvedcashformontly;
    			    	$totalmontlydues = $totalmontlydues + $totalpendingmonthly;
    			    }
    			} else {
					$startmonth = date('Y-m-', strtotime($member->joining_date));
					$thismonth = Carbon::now()->format('Y-m-');
    			    $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
    			    $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
    			    $totalmonthsformember = $to->diffInMonths($from) + 1;
    			    if(($totalmonthsformember * 500) > $approvedcashformontly) {
    			    	$totalpendingmonthly = ($totalmonthsformember * 500) - $approvedcashformontly;
    			    	$totalmontlydues = $totalmontlydues + $totalpendingmonthly;
    			    }
    			}
    		}
    		// dd($totalmontlydues); 
    		$pdf = PDF::loadView('dashboard.reports.pdf.allpaymentsandpendings', ['registeredmembers' => $registeredmembers, 'totalapproved' => $totalapproved, 'totalmontlydues' => $totalmontlydues]);
    		$fileName = 'CVCS_General_Report.pdf';
    		return $pdf->download($fileName); // stream
    	} elseif($request->report_type == 2) {
    		$totalapproved = DB::table('payments')
    		                   ->select(DB::raw('SUM(amount) as totalamount'))
    		                   ->where('payment_status', '=', 1)
    		                   ->where('is_archieved', '=', 0)
                               ->where('payment_category', 1)  // 1 means monthly, 0 for membership
    		                   ->first();

    		$branches = Branch::all();
    		$branch_array = [];
    		foreach ($branches as $branch) {
    			$branchmembers = User::where('activation_status', 1)
			                         ->where('role_type', '!=', 'admin')                
			                         ->where('branch_id', $branch->id)                
			                         ->get();
			    $branch_array[$branch->id]['name'] = $branch->name;
			    $branch_array[$branch->id]['totalmembers'] = $branchmembers->count();
			    $branch_array[$branch->id]['totalmontlypaid'] = 0; // problem ache ektu, kom count kore
			    $branch_array[$branch->id]['totalmontlydues'] = 0;
	    		foreach ($branchmembers as $member) {
	    			$approvedtotal = DB::table('payments')
			                           ->select(DB::raw('SUM(amount) as totalamount'))
			                           ->where('payment_status', 1)
			                           ->where('is_archieved', 0)
			                           ->where('member_id', $member->member_id)
			                           ->where('payment_category', 1)  // 1 means monthly, 0 for membership
			                           ->first();

	    			$approvedcashformontly = $approvedtotal->totalamount;
	    			$branch_array[$branch->id]['totalmontlypaid'] = $branch_array[$branch->id]['totalmontlypaid'] + $approvedcashformontly;

	    			if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
	    			{
	    			    $thismonth = Carbon::now()->format('Y-m-');
	    			    $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
	    			    $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
	    			    $totalmonthsformember = $to->diffInMonths($from) + 1;
	    			    if(($totalmonthsformember * 500) > $approvedcashformontly) {
	    			    	$totalpendingmonthly = ($totalmonthsformember * 500) - $approvedcashformontly;
	    			    	$branch_array[$branch->id]['totalmontlydues'] = $branch_array[$branch->id]['totalmontlydues'] + $totalpendingmonthly;
	    			    }
	    			} else {
						$startmonth = date('Y-m-', strtotime($member->joining_date));
						$thismonth = Carbon::now()->format('Y-m-');
	    			    $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
	    			    $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
	    			    $totalmonthsformember = $to->diffInMonths($from) + 1;
	    			    if(($totalmonthsformember * 500) > $approvedcashformontly) {
	    			    	$totalpendingmonthly = ($totalmonthsformember * 500) - $approvedcashformontly;
	    			    	$branch_array[$branch->id]['totalmontlydues'] = $branch_array[$branch->id]['totalmontlydues'] + $totalpendingmonthly;
	    			    }
	    			}
	    		}
    		}
    		// dd($branch_array); 
    		$pdf = PDF::loadView('dashboard.reports.pdf.branchdetails', ['branch_array' => $branch_array, 'totalapproved' => $totalapproved]);
    		$fileName = 'CVCS_Branch_Details_Report.pdf';
    		return $pdf->download($fileName); // stream
    	}
    }

    public function getPDFBranchMembersPayments(Request $request)
    {
        //validation
        $this->validate($request, array(
          'branch_id' => 'required'
        ));

        $branch = Branch::find($request->branch_id);

        $members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')                
                       ->where('branch_id', $request->branch_id)           
                       ->with(['payments' => function ($query) {
                            $query->orderBy('created_at', 'desc');
                            $query->where('payment_status', '=', 1);
                            $query->where('is_archieved', '=', 0);
                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                        }])           
                       ->get();

        
        $intotalmontlypaid = 0;
        $intotalmontlydues = 0;

        foreach ($members as $member) {
            $approvedcashformontly = $member->payments->sum('amount');
            $member->totalpendingmonthly = 0;
            $intotalmontlypaid = $intotalmontlypaid + $approvedcashformontly;
            if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
            {
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                $totalmonthsformember = $to->diffInMonths($from) + 1;
                if(($totalmonthsformember * 500) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 500) - $approvedcashformontly;
                  $intotalmontlydues = $intotalmontlydues + $member->totalpendingmonthly;
                }
            } else {
                $startmonth = date('Y-m-', strtotime($member->joining_date));
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                $totalmonthsformember = $to->diffInMonths($from) + 1;
                if(($totalmonthsformember * 500) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 500) - $approvedcashformontly;
                  $intotalmontlydues = $intotalmontlydues + $member->totalpendingmonthly;
                }
            }
        }

        // $members = $members->orderBy('totalpendingmonthly', 'desc');
        // dd($members);

        $pdf = PDF::loadView('dashboard.reports.pdf.branchmembersdetails', ['branch' => $branch, 'members' => $members, 'intotalmontlypaid' => $intotalmontlypaid, 'intotalmontlydues' => $intotalmontlydues]);
        $fileName = 'CVCS_Branch_Members_Details_Report.pdf';
        return $pdf->download($fileName); // download
    }

    public function getPDFBranchMembersList(Request $request)
    {
    	//validation
    	$this->validate($request, array(
    	  'branch_id' => 'required'
    	));

    	$branch = Branch::find($request->branch_id);

    	$members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')                
                       ->where('branch_id', $request->branch_id)           
                       ->orderBy('position_id', 'asc')           
                       ->get();

		$pdf = PDF::loadView('dashboard.reports.pdf.branchmemberslist', ['branch' => $branch, 'members' => $members]);
		$fileName = 'CVCS_Branch_Members_List_Report.pdf';
		return $pdf->stream($fileName); // download
    }
}
