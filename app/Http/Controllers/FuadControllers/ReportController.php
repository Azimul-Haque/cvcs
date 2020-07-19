<?php

namespace App\Http\Controllers\FuadControllers;

use App\Careerlog;
use App\Position;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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

        foreach ($positions as $position){
            $count = 0;
            foreach ($position->users as $user){
                if($user->activation_status == 1){
                    $count++;
                }
            }
            $position->memberCount = $count;
        }

        $memberpos = Position::where('id', 34)->first(); // for the 34th, সদস্য!
        $count = 0;
        foreach ($memberpos->users as $user){
            if($user->activation_status == 1){
                $count ++;
            }
        }
        $memberpos->memberCount = $count;
        $pdf = PDF::loadView('dashboard.reports.pdf.designationmemberscountlist', ['positions' => $positions, 'memberpos' => $memberpos]);
        $fileName = 'CVCS_Designation_Members_Count_List_Report.pdf';
        return $pdf->download($fileName); // download
    }


    public function getMemberCareerlogReport($member_id)
    {
        $member = User::findOrFail($member_id);
        $memberCareerlogs = Careerlog::where('user_id', $member->id)->orderBy("start_date")->get();

        $pdf = PDF::loadView('dashboard.reports.pdf.membercareerlog', ['member' => $member, 'careerlogs' => $memberCareerlogs]);
        $fileName = 'CVCS_Members_Career_Log_Report.pdf';
        return $pdf->download($fileName); // download
    }

}
