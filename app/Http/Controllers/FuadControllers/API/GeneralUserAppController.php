<?php

namespace App\Http\Controllers\FuadControllers\API;

use App\Album;
use App\Albumphoto;
use App\Branch;
use App\Notice;
use App\Payment;
use App\Paymentreceipt;
use App\Position;
use App\Tempmemdata;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


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


    public function authenticateMember(Request $request){

        $this->validate($request,array(
            'email'       =>   'required',
            'password'      =>   'required',
        ));

        $field = (is_numeric($request->email))? 'member_id': 'email';
        $member = User::where($field, $request->email)->first();
        if(!$member){
            return response()->json("authentication failed", 401);
        }

        if(Hash::check($request->password, $member->password)){
            return response()->json($member, 200);
        }
        return response()->json("authentication failed", 401);
    }


    public function updateMemberProfile(Request $request)
    {
        $this->validate($request,array(
            'unique_key'       =>   'required',
            'position_id'      =>   'required',
            'branch_id'        =>   'required',
            'present_address'  =>   'required',
            'mobile'           =>   'required',
            'email'            =>   'required',
            'image'            =>   'sometimes|image|max:250'
        ));

        $member = User::where('unique_key', $request->unique_key)->first();
        if(!$member){
            return response()->json("Invalid Request", 403);
        }

        if($request->mobile != $member->mobile) {
            $findmobileuser = User::where('mobile', $request->mobile)->first();

            if($findmobileuser) {
                return response()->json('mobile number already taken', 400);
            }
        }
        if($request->email != $member->email) {
            $findemailuser = User::where('email', $request->email)->first();

            if($findemailuser) {
                return response()->json('email number already taken', 400);
            }
        }


        // update data accordign to role...
        if($member->role == 'member' && $member->role_type == 'member') {
            $tempmemdata = new Tempmemdata;
            $tempmemdata->user_id = $member->id;
            $tempmemdata->position_id = $request->position_id;
            $tempmemdata->branch_id = $request->branch_id;
            $tempmemdata->present_address = $request->present_address;
            $tempmemdata->mobile = $request->mobile;
            $tempmemdata->email = $request->email;

            // applicant's temp image upload
            if($request->hasFile('image')) {
                // $old_img = public_path('images/users/'. $application->image);
                // if(File::exists($old_img)) {
                //     File::delete($old_img);
                // }
                $image      = $request->file('image');
                $filename   = 'temp_'. str_replace(' ','',$member->name).time() .'.' . $image->getClientOriginalExtension();
                $location   = public_path('/images/users/'. $filename);
                Image::make($image)->resize(200, 200)->save($location);
                $tempmemdata->image = $filename;
            }
            $tempmemdata->save();

            return response()->json("Update request has been submmitted", 201);
        } else {
            return response()->json('Must be non admin to update from app', 403);
        }
    }


    public function storeSelfPayment(Request $request)
    {
        $this->validate($request,array(
            'member_id'   =>   'required',
            'amount'      =>   'required|integer',
            'bank'        =>   'required',
            'branch'      =>   'required',
            'pay_slip'    =>   'required',
            'image'       =>   'sometimes|image|max:500'
        ));

        $member = User::where('member_id', $request->member_id)->first();
        if(!$member){
            return response()->json("Invalid Request", 403);
        }

        $payment = new Payment;
        $payment->member_id = $request->member_id;
        $payment->payer_id = $request->member_id;
        $payment->amount = $request->amount;
        $payment->bank = $request->bank;
        $payment->branch = $request->branch;
        $payment->pay_slip = $request->pay_slip;
        $payment->payment_status = 0;
        $payment->payment_category = 1; // monthly payment, if 0 then membership payment
        $payment->payment_type = 1; // single payment, if 2 then bulk payment
        // generate payment_key
        $payment_key_length = 10;
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $payment_key = substr(str_shuffle(str_repeat($pool, 10)), 0, $payment_key_length);
        // generate payment_key
        $payment->payment_key = $payment_key;
        $payment->save();

        // receipt upload
        if($request->hasFile('image')) {
            $receipt      = $request->file('image');
            $filename   = $payment->member_id.'_receipt_' . time() .'.' . $receipt->getClientOriginalExtension();
            $location   = public_path('/images/receipts/'. $filename);
            Image::make($receipt)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $paymentreceipt = new Paymentreceipt;
            $paymentreceipt->payment_id = $payment->id;
            $paymentreceipt->image = $filename;
            $paymentreceipt->save();
        }

        // send pending SMS ... aro kichu kaaj baki ache...
        // send sms
        $mobile_number = 0;
        if(strlen($member->mobile) == 11) {
            $mobile_number = $member->mobile;
        } elseif(strlen($member->mobile) > 11) {
            if (strpos($member->mobile, '+') !== false) {
                $mobile_number = substr($member->mobile, -11);
            }
        }
        $url = config('sms.url');
        $number = $mobile_number;
        $text = 'Dear ' . $member->name . ', payment of tk. '. $request->amount .' is submitted successfully. We will notify you once we approve it. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
        $data= array(
            'username'=>config('sms.username'),
            'password'=>config('sms.password'),
            'number'=>"$number",
            'message'=>"$text"
        );
        // initialize send status
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        $smsresult = curl_exec($ch);

        // $sendstatus = $result = substr($smsresult, 0, 3);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        // send sms
        if($sendstatus == 1101) {
            // Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } elseif($sendstatus == 1006) {
            // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }

        return response()->json('Payment issued successfully', 201);
    }

}
