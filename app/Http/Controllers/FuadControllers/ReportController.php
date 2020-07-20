<?php

namespace App\Http\Controllers\FuadControllers;

use App\Careerlog;
use App\Payment;
use App\Position;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function getDesignationMemberCounts()
    {
        $positions = Position::orderBy('id', 'asc')
            ->where('id', '>', 0)
            ->where('id', '!=', 34)
            ->get();

        foreach ($positions as $position) {
            $count = 0;
            foreach ($position->users as $user) {
                if ($user->activation_status == 1) {
                    $count++;
                }
            }
            $position->memberCount = $count;
        }

        $memberpos = Position::where('id', 34)->first(); // for the 34th, সদস্য!
        $count = 0;
        foreach ($memberpos->users as $user) {
            if ($user->activation_status == 1) {
                $count++;
            }
        }
        $memberpos->memberCount = $count;
        $pdf = PDF::loadView('dashboard.reports.pdf.designationmemberscountlist', ['positions' => $positions, 'memberpos' => $memberpos]);
        $fileName = 'CVCS_Designation_Members_Count_List_Report.pdf';
        return $pdf->download($fileName); // download
    }


    public function getMemberCompleteReport(Request $request)
    {
        $this->validate($request, array(
            'id' => 'required',
            'member_id' => 'required'
        ));

        $member = User::where('id', $request->id)
            ->where('member_id', $request->member_id)
            ->first();

        $payments = Payment::where('member_id', $request->member_id)
            ->where('is_archieved', 0)
            ->get();

        $pendingfordashboard = DB::table('payments')
            ->select(DB::raw('SUM(amount) as totalamount'))
            ->where('payment_status', 0)
            ->where('is_archieved', 0)
            ->where('member_id', $member->member_id)
            ->first();
        $approvedfordashboard = DB::table('payments')
            ->select(DB::raw('SUM(amount) as totalamount'))
            ->where('payment_status', 1)
            ->where('is_archieved', 0)
            ->where('member_id', $member->member_id)
            ->first();
        $pendingcountdashboard = Payment::where('payment_status', 0)
            ->where('is_archieved', 0)
            ->where('member_id', $member->member_id)
            ->get()
            ->count();

        $approvedcountdashboard = Payment::where('payment_status', 1)
            ->where('is_archieved', 0)
            ->where('member_id', $member->member_id)
            ->get()
            ->count();
        $totalmontlypaid = DB::table('payments')
            ->select(DB::raw('SUM(amount) as totalamount'))
            ->where('payment_status', 1)
            ->where('is_archieved', 0)
            ->where('payment_category', 1) // 1 means monthly, 0 for membership
            ->where('member_id', $member->member_id)
            ->first();


        $memberCareerlogs = Careerlog::where('user_id', $member->id)->orderBy("start_date")->get();

        $pdf = PDF::loadView('dashboard.profile.pdf.completereport', ['payments' => $payments, 'member' => $member, 'pendingfordashboard' => $pendingfordashboard, 'approvedfordashboard' => $approvedfordashboard, 'pendingcountdashboard' => $pendingcountdashboard, 'approvedcountdashboard' => $approvedcountdashboard, 'totalmontlypaid' => $totalmontlypaid, 'careerlogs' => $memberCareerlogs]);
//        dd($member->branch->name);
        $fileName = str_replace(' ', '_', $member->name) . '_' . $member->member_id . '.pdf';
        return $pdf->download($fileName);
    }



    public function getPDFMemberApprovalAdminLogReport(Request $request){
        $this->validate($request, array(
            'id' => 'required',
            'member_id' => 'required',
            'log_year' => 'required| numeric'
        ));

        $member = User::where('id', $request->id)
            ->where('member_id', $request->member_id)
            ->first();


        $adminLogsByMember =

        $pdf = PDF::loadView('dashboard.profile.pdf.adminapprovalslog', []);
//        dd($member->branch->name);
        $fileName = str_replace(' ', '_', $member->name) . '_' . $member->member_id . '.pdf';
        return $pdf->download($fileName);
    }
}
