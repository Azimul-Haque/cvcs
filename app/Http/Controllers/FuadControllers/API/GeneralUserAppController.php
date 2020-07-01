<?php

namespace App\Http\Controllers\FuadControllers\API;

use App\Album;
use App\Albumphoto;
use App\Branch;
use App\Notice;
use App\Payment;
use App\Position;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class GeneralUserAppController extends Controller
{
    public function getPaginatedNotices(){
        $notices = Notice::orderBy('id', 'DESC')->paginate(10);
        return response()->json($notices);
    }

    public function getPaginatedGallery(){
        $albums = Album::orderBy('id', 'DESC')->paginate(8);
        return response()->json($albums);
    }

    public function getAlbumPhotos($album_id){
        $album = Album::findOrFail($album_id);
        return response()->json($album->albumphotoes);
    }



    public function getDesignations(){
        $positions = Position::where('id', '>', 0)->get();
        return response()->json($positions);
    }

    public function getBranches(){
        $branches = Branch::where('id', '>', 0)->get();
        return response()->json($branches);
    }

    public function getUserProfile($unique_key){
        $member = User::where('unique_key', $unique_key)->first();

        if(!$member){
            return response()->json("user with unique key does not exist", 404);
        }

        $pendingfordashboard = DB::table('payments')
            ->select(DB::raw('SUM(amount) as totalamount'))
            ->where('payment_status', 0)
            ->where('is_archieved', 0)
            ->where('member_id', $member->member_id)
            ->first()->totalamount;
        $pendingfordashboard = ($pendingfordashboard)? $pendingfordashboard: 0;

        $approvedfordashboard = DB::table('payments')
            ->select(DB::raw('SUM(amount) as totalamount'))
            ->where('payment_status', 1)
            ->where('is_archieved', 0)
            ->where('member_id', $member->member_id)
            ->first()->totalamount;
        $approvedfordashboard = ($approvedfordashboard)? $approvedfordashboard: 0;


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


        return response()->json([
            'user' => $member,
            'pending_amount' => $pendingfordashboard,
            'approved_amount' => $approvedfordashboard,
            'pending_count' => $pendingcountdashboard,
            'approved_count' => $approvedcountdashboard
        ], 200);
    }



    public function getMemberTransactionSummary($unique_key){

        $member = User::where('unique_key', $unique_key)->first();
        if(!$member){
            return response()->json("user with unique key does not exist", 404);
        }

        $membertotalpending = DB::table('payments')
            ->select(DB::raw('SUM(amount) as totalamount'))
            ->where('member_id', $member->member_id)
            ->where('payment_status', 0)
            ->where('is_archieved', 0)
            // ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
            // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->first()->totalamount;
        $membertotalpending = ($membertotalpending)? $membertotalpending: 0;

        $membertotalapproved = DB::table('payments')
            ->select(DB::raw('SUM(amount) as totalamount'))
            ->where('member_id', $member->member_id)
            ->where('payment_status', '=', 1)
            ->where('is_archieved', '=', 0)
            // ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
            // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->first()->totalamount;
        $membertotalapproved = ($membertotalapproved)? $membertotalapproved: 0;


        $membertotalmontlypaid = DB::table('payments')
            ->select(DB::raw('SUM(amount) as totalamount'))
            ->where('payment_status', 1)
            ->where('is_archieved', 0)
            ->where('payment_category', 1) // 1 means monthly, 0 for membership
            ->where('member_id', $member->member_id)
            ->first()->totalamount;

        $membertotalmontlypaid = ($membertotalmontlypaid)? $membertotalmontlypaid: 0;

        return response()->json([
            'membertotalpending' => $membertotalpending,
            'membertotalapproved' => $membertotalapproved,
            'membertotalmontlypaid' => $membertotalmontlypaid,
        ], 200);
    }


    public function getMemberPayments($unique_key){
        $member = User::where('unique_key', $unique_key)->first();
        if(!$member){
            return response()->json("user with unique key does not exist", 404);
        }

        $payments = Payment::where('member_id', $member->member_id)
            ->where('is_archieved', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $payments->getCollection()->transform(function ($payment) {
            $payment->payment_user = User::where('member_id', $payment->payer_id)->first()->name_bangla;
            return $payment;
        });
    
        return response()->json($payments, 200);
    }

}
