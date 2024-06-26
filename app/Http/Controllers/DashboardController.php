<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;
use App\About;
use App\Slider;
use App\Album;
use App\Albumphoto;
use App\Event;
use App\Notice;
use App\Basicinfo;
use App\Formmessage;
use App\Payment;
use App\Paymentreceipt;
use App\Faq;
use App\Committee;
use App\Donor;
use App\Donation;
use App\Branch;
use App\Branchpayment;
use App\Tempmemdata;
use App\Position;
use App\Temppayment;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Image;
use File;
use Session, Config;
use Hash;
use PDF;
use Illuminate\Pagination\LengthAwarePaginator;

use \Shipu\Aamarpay\Aamarpay;
use Illuminate\Support\Facades\Artisan;
// use BanglaDate;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('auth')->except('paymentVerification');
        $this->middleware('admin')->except('getBlogs', 'getProfile', 'getPaymentPage', 'getSingleMember', 'getSelfPaymentPage', 'storeSelfPayment', 'getSelfPaymentOnlinePage', 'nextSelfPaymentOnline', 'paymentSuccessOrFailed', 'paymentCancelledPost', 'paymentCancelled', 'getBulkPaymentPage', 'paymentBulkSuccessOrFailed', 'paymentBulkCancelledPost', 'paymentBulkCancelled', 'searchMemberForBulkPaymentAPI', 'findMemberForBulkPaymentAPI', 'storeBulkPayment', 'getMemberTransactionSummary', 'getMemberUserManual', 'getMemberChangePassword', 'memberChangePassword', 'downloadMemberPaymentPDF', 'downloadMemberCompletePDF', 'updateMemberProfile', 'getApplications', 'searchApplicationAPI', 'getDefectiveApplications', 'searchDefectiveApplicationAPI', 'getMembers', 'searchMemberAPI2', 'getMembersForAll', 'getMembersForAllBranchWise', 'searchMemberAPI3', 'searchMemberForBulkPaymentSingleAPI', 'curlAamarpay', 'paymentVerification', 'transferMember', 'changeDesignation');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $about = About::where('type', 'about')->get()->first();
        // $whoweare = About::where('type', 'whoweare')->get()->first();
        // $whatwedo = About::where('type', 'whatwedo')->get()->first();
        // $ataglance = About::where('type', 'ataglance')->get()->first();
        // $membership = About::where('type', 'membership')->get()->first();
        // $basicinfo = Basicinfo::where('id', 1)->first();
        $totalpending = DB::table('payments')
                           ->select(DB::raw('SUM(amount) as totalamount'))
                           ->where('payment_status', '=', 0)
                           ->where('is_archieved', '=', 0)
                           // ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                           // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                           ->first();
        $totalapproved = DB::table('payments')
                           ->select(DB::raw('SUM(amount) as totalamount'))
                           ->where('payment_status', '=', 1)
                           ->where('is_archieved', '=', 0)
                           // ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                           // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                           ->first();
        $registeredmember = User::where('activation_status', 1)
                                ->where('role_type', '!=', 'admin')                
                                ->count();

        $pendingpayments = Payment::where('payment_status', 0)
                                      ->where('is_archieved', 0)
                                      ->count() 
                                      +
                           User::where('activation_status', 0)
                               ->orWhere('activation_status', 202)
                               ->count();

        $successfullpayments = Payment::where('payment_status', 1)->count();

        $totalapplicationpending = DB::table('users')
                                     ->select(DB::raw('SUM(application_payment_amount) as totalamount'))
                                     ->where('activation_status', '=', 0)
                                     // ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                                     // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                                     ->first();

        $totaldonation = DB::table('donations')
                                ->select(DB::raw('SUM(amount) as totalamount'))
                                ->where('payment_status', 1)
                                ->first();
        $totaldonors = Donor::count();

        $totalbranchpayment = DB::table('branchpayments')
                                ->select(DB::raw('SUM(amount) as totalamount'))
                                ->where('payment_status', 1)
                                ->first();
        $totalbranches = Branch::count();

        $lastsixmembers = User::where('activation_status', 1)
                              ->where('role', 'member')
                              ->orderBy('updated_at', 'desc')
                              ->take(6)->get();

        $lastsixmemberstest = User::where('activation_status', 1)
                              ->where('role', 'member')
                              ->orderBy('updated_at', 'desc')
                              ->take(6)->get()->toJson();

        $lastsevenmonthscollection = DB::table('payments')
                                    ->select('created_at', DB::raw('SUM(amount) as totalamount'))
                                    ->where('is_archieved', '=', 0)
                                    ->where('payment_status', '=', 1)
                                    ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                                    ->orderBy('created_at', 'DESC')
                                    ->take(12)
                                    ->get();
        $monthsforchartc = [];
        foreach ($lastsevenmonthscollection as $key => $months) {
            $monthsforchartc[] = date_format(date_create($months->created_at), "M Y");
        }
        $monthsforchartc = json_encode(array_reverse($monthsforchartc));

        $totalsforchartc = [];
        foreach ($lastsevenmonthscollection as $key => $months) {
            $totalsforchartc[] = $months->totalamount;
        }
        $totalsforchartc = json_encode(array_reverse($totalsforchartc));

        // $bangla_date = new BanglaDate(strtotime(date('d-m-Y')), 0);

        // $bangla_output = $bangla_date->get_date();

        // $datebangla =  $bangla_output[1] . ' ' . $bangla_output[0]  . ', ' . $bangla_output[2];

        return view('dashboard.index')
                    ->withTotalpending($totalpending)
                    ->withTotalapproved($totalapproved)
                    ->withRegisteredmember($registeredmember)
                    ->withPendingpayments($pendingpayments)
                    ->withSuccessfullpayments($successfullpayments)
                    ->withLastsixmembers($lastsixmembers)
                    ->withMonthsforchartc($monthsforchartc)
                    ->withTotalsforchartc($totalsforchartc)
                    ->withTotaldonation($totaldonation)
                    ->withTotaldonors($totaldonors)
                    ->withTotalbranchpayment($totalbranchpayment)
                    ->withTotalbranches($totalbranches)
                    ->withTotalapplicationpending($totalapplicationpending)
                    ->withLastsixmemberstest($lastsixmemberstest);
    }

    public function getAdmins()
    {
        $superadmins = User::where('role', 'admin')
                           ->whereNotIn('email', ['mannan@cvcsbd.com', 'dataentry@cvcsbd.com']) // jei email gula deoa hobe tader k dekhabe na!!!
                           ->where('role_type', 'admin')
                           ->paginate(10);

        $admins = User::where('role', 'admin')
                      ->where('role_type', 'manager')
                      ->paginate(10);
        // $whoweare = About::where('type', 'whoweare')->get()->first();
        // $whatwedo = About::where('type', 'whatwedo')->get()->first();
        // $ataglance = About::where('type', 'ataglance')->get()->first();
        // $membership = About::where('type', 'membership')->get()->first();
        // $basicinfo = Basicinfo::where('id', 1)->first();

        return view('dashboard.adminsandothers.admins')
                    ->withSuperadmins($superadmins)
                    ->withAdmins($admins);
    }

    public function getCreateAdmin()
    {
        return view('dashboard.adminsandothers.createadmin');
    }

    public function searchMemberForAdminAPI(Request $request)
    {
        // $response = User::select('name_bangla','member_id', 'image')
        //                 ->where('member_id', 'like', '%' . $request->searchentry . '%')
        //                 ->orWhere('name_bangla', 'like', '%' . $request->searchentry . '%')
        //                 ->orWhere('name', 'like', '%' . $request->searchentry . '%')
        //                 ->orWhere('mobile', 'like', '%' . $request->searchentry . '%')
        //                 ->get();
        $response = User::select('name_bangla', 'member_id', 'mobile')
                        ->where('role_type', '!=', 'admin')
                        ->where('role_type', '!=', 'manager')
                        ->where('activation_status', 1)
                        ->orderBy('id', 'desc')->get();

        return $response;          
    }

    public function addAdmin(Request $request)
    {
        $this->validate($request,array(
            'member_id' => 'required'
        ));

        $member = User::where('member_id', $request->member_id)->first();
        $member->role      = 'admin';
        $member->role_type = 'manager';
        $member->save();

        Session::flash('success', 'সফলভাবে অ্যাডমিন বানানো হয়েছে!');
        return redirect()->route('dashboard.admins');
    }

    public function removeAdmin(Request $request, $id)
    {
        $member = User::find($id);
        $member->role      = 'member';
        $member->role_type = 'member';
        $member->save();

        Session::flash('success', 'সফলভাবে অ্যাডমিন থেকে অব্যহতি দেওয়া হয়েছে!');
        return redirect()->route('dashboard.admins');          
    }

    public function getBulkPayers()
    {
        $bulkpayers = User::where('role_type', 'bulkpayer')->paginate(10);

        return view('dashboard.adminsandothers.bulkpayers')->withBulkpayers($bulkpayers);
    }

    public function getCreateBulkPayer()
    {
        return view('dashboard.adminsandothers.createbulkpayer');
    }

    public function searchMemberForBulkPayerAPI(Request $request)
    {
        $response = User::select('name_bangla', 'member_id', 'mobile')
                        ->where('role_type', 'member')
                        ->where('activation_status', 1)
                        ->orderBy('id', 'desc')->get();

        return $response;          
    }

    public function addBulkPayer(Request $request)
    {
        $this->validate($request,array(
            'member_id' => 'required'
        ));

        $member = User::where('member_id', $request->member_id)->first();
        $member->role_type = 'bulkpayer';
        $member->save();

        Session::flash('success', 'সফলভাবে একাধিক পরিশোধকারী বানানো হয়েছে!');
        return redirect()->route('dashboard.bulkpayers');
    }

    public function removeBulkPayer(Request $request, $id)
    {
        $member = User::find($id);
        $member->role_type = 'member';
        $member->save();

        Session::flash('success', 'সফলভাবে একাধিক পরিশোধকারী থেকে অব্যহতি দেওয়া হয়েছে!');
        return redirect()->route('dashboard.bulkpayers');          
    }

    public function getDonors()
    {
        $donors = Donor::orderBy('id', 'desc')->paginate(10);
        $donations = Donation::orderBy('id', 'desc')->paginate(10);
        $totaldonation = DB::table('donations')
                                ->select(DB::raw('SUM(amount) as totalamount'))
                                ->where('payment_status', 1)
                                ->first();

        return view('dashboard.adminsandothers.donors')
                    ->withDonors($donors)
                    ->withDonations($donations)
                    ->withTotaldonation($totaldonation);
    }

    public function storeDonor(Request $request)
    {
        $this->validate($request,array(
            'name'    => 'required|max:255',
            'address' => 'required|max:255',
            'email'   => 'required|max:255',
            'phone'   => 'required|max:255'
        ));

        $donor = new Donor;
        $donor->name = $request->name;
        $donor->address = $request->address;
        $donor->email = $request->email;
        $donor->phone = $request->phone;
        $donor->save();

        Session::flash('success', 'সফলভাবে Donor (দাতা) সংরক্ষন হয়েছে!');
        return redirect()->route('dashboard.donors');
    }

    public function storeDonation(Request $request)
    {
        $this->validate($request,array(
            'donor_id'       =>   'required',
            'submitter_id'   =>   'required',
            'amount'         =>   'required|integer',
            'bank'           =>   'required',
            'branch'         =>   'required',
            'pay_slip'       =>   'required',
            'image'          =>   'sometimes|image|max:500'
        ));

        $donation = new Donation;
        $donation->donor_id = $request->donor_id;
        $donation->submitter_id = $request->submitter_id;
        $donation->amount = $request->amount;
        $donation->bank = $request->bank;
        $donation->branch = $request->branch;
        $donation->pay_slip = $request->pay_slip;
        $donation->payment_status = 0;
        // generate payment_key
        $payment_key_length = 10;
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $payment_key = substr(str_shuffle(str_repeat($pool, 10)), 0, $payment_key_length);
        // generate payment_key
        $donation->payment_key = $payment_key;
        // receipt upload
        if($request->hasFile('image')) {
            $receipt      = $request->file('image');
            $filename   = $request->submitter_id.'_donation_receipt_' . time() .'.' . $receipt->getClientOriginalExtension();
            $location   = public_path('/images/receipts/'. $filename);
            Image::make($receipt)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $donation->image = $filename;
        }
        $donation->save();

        Session::flash('success', 'ডোনেশন সফলভাবে দাখিল করা হয়েছে!');
        return redirect()->route('dashboard.donors');
    }

    public function approveDonation(Request $request, $id) 
    {
        $donation = Donation::find($id);
        $donation->payment_status = 1;
        $donation->save();

        Session::flash('success', 'অনুমোদন সফল হয়েছে!');
        return redirect()->route('dashboard.donors');
    }

    public function getDonationofDonor($id)
    {
        $donor = Donor::find($id);
        $donations = Donation::where('donor_id', $id)->paginate(10);
        $totalapproved = DB::table('donations')
                           ->select(DB::raw('SUM(amount) as totalamount'))
                           ->where('payment_status', 1)
                           ->where('donor_id', $id)
                           ->first();

        return view('dashboard.adminsandothers.donationsofdonor')
                    ->withDonor($donor)
                    ->withDonations($donations)
                    ->withTotalapproved($totalapproved);
    }

    public function updateDonor(Request $request, $id)
    {
        $this->validate($request,array(
            'name'    => 'required|max:255',
            'address' => 'required|max:255',
            'email'   => 'required|max:255',
            'phone'   => 'required|max:255'
        ));

        $donor = Donor::find($id);
        $donor->name = $request->name;
        $donor->address = $request->address;
        $donor->email = $request->email;
        $donor->phone = $request->phone;
        $donor->save();

        Session::flash('success', 'সফলভাবে Donor (দাতা) হালনাগাদ হয়েছে!');
        return redirect()->route('dashboard.donors');
    }

    public function getBranchPayments()
    {
        $branches = Branch::orderBy('id', 'desc')->paginate(10);
        $branchpayments = Branchpayment::orderBy('id', 'desc')->paginate(10);
        $totalbranchpayment = DB::table('branchpayments')
                                ->select(DB::raw('SUM(amount) as totalamount'))
                                ->where('payment_status', 1)
                                ->first();

        return view('dashboard.adminsandothers.branchepayments')
                    ->withBranches($branches)
                    ->withBranchpayments($branchpayments)
                    ->withTotalbranchpayment($totalbranchpayment);
    }

    public function getBranches()
    {
        $branches = Branch::orderBy('id', 'asc')->where('id', '>', 0)->paginate(15);

        return view('dashboard.adminsandothers.branches')
                    ->withBranches($branches);
    }

    public function getBranchMembers(Request $request, $branch_id)
    {
        $branch = Branch::find($branch_id);
        $memberscount = User::where('activation_status', 1)
                            ->where('branch_id', $branch_id)
                            ->where('role_type', '!=', 'admin')
                            ->count();
        $members = User::where('activation_status', 1)
                       ->where('branch_id', $branch_id)
                       ->where('role_type', '!=', 'admin')
                       ->orderBy('id', 'desc')->get();

        $ordered_member_array = [];
        foreach ($members as $member) {
            $ordered_member_array[(int) substr($member->member_id, -5)] = $member;
        }
        ksort($ordered_member_array); // ascending order according to key
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $itemCollection = collect($ordered_member_array);
        
        $perPage = 20;
        
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        return view('dashboard.membership.branchmembers')
                            ->withMembers($paginatedItems)
                            ->withMemberscount($memberscount)
                            ->withBranch($branch);
    }

    public function storeBranch(Request $request)
    {
        $this->validate($request,array(
            'name'    => 'required|max:255',
            'address' => 'required|max:255',
            'phone'   => 'required|max:255'
        ));

        $branch = new Branch;
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        $branch->save();

        Session::flash('success', 'সফলভাবে ব্রাঞ্চ সংরক্ষন হয়েছে!');
        return redirect()->route('dashboard.branches');
    }
    
    public function updateBranch(Request $request, $id)
    {
        $this->validate($request,array(
            'name'    => 'required|max:255',
            'address' => 'required|max:255',
            'phone'   => 'required|max:255'
        ));

        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        $branch->save();

        Session::flash('success', 'সফলভাবে ব্রাঞ্চ হালনাগাদ হয়েছে!');
        return redirect()->route('dashboard.branches');
    }

    public function storeBranchPayment(Request $request)
    {
        $this->validate($request,array(
            'branch_id'       =>   'required',
            'submitter_id'    =>   'required',
            'amount'          =>   'required|integer',
            'bank'            =>   'required',
            'branch_name'     =>   'required',
            'pay_slip'        =>   'required',
            'image'           =>   'sometimes|image|max:500'
        ));

        $branchpayment = new Branchpayment;
        $branchpayment->branch_id = $request->branch_id;
        $branchpayment->submitter_id = $request->submitter_id;
        $branchpayment->amount = $request->amount;
        $branchpayment->bank = $request->bank;
        $branchpayment->branch_name = $request->branch_name;
        $branchpayment->pay_slip = $request->pay_slip;
        $branchpayment->payment_status = 0;
        // generate payment_key
        $payment_key_length = 10;
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $payment_key = substr(str_shuffle(str_repeat($pool, 10)), 0, $payment_key_length);
        // generate payment_key
        $branchpayment->payment_key = $payment_key;
        // receipt upload
        if($request->hasFile('image')) {
            $receipt      = $request->file('image');
            $filename   = $request->submitter_id.'_branch_payment_receipt_' . time() .'.' . $receipt->getClientOriginalExtension();
            $location   = public_path('/images/receipts/'. $filename);
            Image::make($receipt)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $branchpayment->image = $filename;
        }
        $branchpayment->save();
        Session::flash('success', 'সফলভাবে ব্রাঞ্চ পরিশোধ সংরক্ষণ');
        return redirect()->route('dashboard.branches.payments');
    }

    public function approveBranchPayment(Request $request, $id) 
    {
        $branchpayment = Branchpayment::find($id);
        $branchpayment->payment_status = 1;
        $branchpayment->save();

        Session::flash('success', 'অনুমোদন সফল হয়েছে!');
        return redirect()->route('dashboard.branches.payments');
    }

    public function getPaymentofBranch($id)
    {
        $branch = branch::find($id);
        $branchpayments = Branchpayment::where('branch_id', $id)->paginate(10);
        $totalapproved = DB::table('branchpayments')
                           ->select(DB::raw('SUM(amount) as totalamount'))
                           ->where('payment_status', 1)
                           ->where('branch_id', $id)
                           ->first();

        return view('dashboard.adminsandothers.paymentofbranch')
                    ->withBranch($branch)
                    ->withBranchpayments($branchpayments)
                    ->withTotalapproved($totalapproved);
    }

    public function getDesignations()
    {
        $positions = Position::orderBy('id', 'asc')
                                    ->where('id', '>', 0)
                                    ->where('id', '!=', 34)
                                    ->paginate(15);
                                    
        $memberpos = Position::where('id', 34)->first(); // for the 34th, সদস্য!

        return view('dashboard.adminsandothers.positions')
                    ->withPositions($positions)
                    ->withMemberpos($memberpos);
    }

    public function getDesignationMembers(Request $request, $position_id)
    {
        $designation = Position::find($position_id);
        $memberscount = User::where('activation_status', 1)
                            ->where('position_id', $position_id)
                            ->where('role_type', '!=', 'admin')
                            ->count();
        $members = User::where('activation_status', 1)
                       ->where('position_id', $position_id)
                       ->where('role_type', '!=', 'admin')
                       ->orderBy('id', 'desc')->get();

        $ordered_member_array = [];
        foreach ($members as $member) {
            $ordered_member_array[(int) substr($member->member_id, -5)] = $member;
        }
        ksort($ordered_member_array); // ascending order according to key
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $itemCollection = collect($ordered_member_array);
        
        $perPage = 20;
        
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        return view('dashboard.membership.designationmembers')
                            ->withMembers($paginatedItems)
                            ->withMemberscount($memberscount)
                            ->withDesignation($designation);
    }

    public function getAbouts()
    {
        $about = About::where('type', 'about')->get()->first();
        $whoweare = About::where('type', 'whoweare')->get()->first();
        $whatwedo = About::where('type', 'whatwedo')->get()->first();
        $ataglance = About::where('type', 'ataglance')->get()->first();
        $membership = About::where('type', 'membership')->get()->first();
        $mission = About::where('type', 'mission')->get()->first();
        $basicinfo = Basicinfo::where('id', 1)->first();

        return view('dashboard.abouts')
                    ->withAbout($about)
                    ->withWhoweare($whoweare)
                    ->withWhatwedo($whatwedo)
                    ->withAtaglance($ataglance)
                    ->withMembership($membership)
                    ->withMission($mission)
                    ->withBasicinfo($basicinfo);
    }

    public function updateAbouts(Request $request, $id) {
        $this->validate($request,array(
            'text' => 'required',
        ));

        $about = About::find($id);
        $about->text = nl2br($request->text);
     
        $about->save();
        
        Session::flash('success', 'Updated Successfully!');
        return redirect()->route('dashboard.abouts');
    }

    public function updateBasicInfo(Request $request, $id) {
        $this->validate($request,array(
            'address'      => 'required',
            'contactno'    => 'required',
            'email'        => 'required',
            'fb'           => 'sometimes',
            'twitter'      => 'sometimes',
            'gplus'        => 'sometimes',
            'ytube'        => 'sometimes',
            'linkedin'     => 'sometimes'
        ));

        $basicinfo = Basicinfo::find($id);
        $basicinfo->address = $request->address;
        $basicinfo->contactno = $request->contactno;
        $basicinfo->email = $request->email;
        $basicinfo->fb = $request->fb;
        $basicinfo->twitter = $request->twitter;
        $basicinfo->gplus = $request->gplus;
        $basicinfo->ytube = $request->ytube;
        $basicinfo->linkedin = $request->linkedin;
     
        $basicinfo->save();
        
        Session::flash('success', 'Updated Successfully!');
        return redirect()->route('dashboard.abouts');
    }

    public function getCommittee()
    {
        $committeemembers = Committee::orderBy('committee_type', 'desc')
                                     ->orderBy('serial', 'asc')->get();
        return view('dashboard.committee')->withCommitteemembers($committeemembers);
    }

    public function storeCommittee(Request $request)
    {
        $this->validate($request,array(
            'name'                      => 'required|max:255',
            'email'                     => 'required|email',
            'phone'                     => 'required|numeric',
            'designation'               => 'required|max:255',
            'fb'                        => 'sometimes|max:255',
            'twitter'                   => 'sometimes|max:255',
            'linkedin'                  => 'sometimes|max:255',
            'image'                     => 'sometimes|image|max:500',
            'committee_type'            => 'required',
            'serial'                    => 'required'
        ));

        $committeemember = new Committee();
        $committeemember->committee_type = $request->committee_type;
        $committeemember->name = $request->name;
        $committeemember->email = $request->email;
        $committeemember->phone = $request->phone;
        $committeemember->designation = $request->designation;
        $committeemember->fb = htmlspecialchars(preg_replace("/\s+/", " ", $request->fb));
        $committeemember->twitter = htmlspecialchars(preg_replace("/\s+/", " ", $request->twitter));
        $committeemember->linkedin = htmlspecialchars(preg_replace("/\s+/", " ", $request->linkedin));
        $committeemember->serial = $request->serial;
        
        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = 'member_' . time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/committee/'. $filename);
            Image::make($image)->resize(250, 250)->save($location);
            $committeemember->image = $filename;
        }

        $committeemember->save();
        
        Session::flash('success', 'সফলভাবে সংরক্ষণ করা হয়েছে!');
        return redirect()->route('dashboard.committee');
    }

    public function updateCommittee(Request $request, $id) {
        $this->validate($request,array(
            'name'                      => 'required|max:255',
            'email'                     => 'required|email',
            'phone'                     => 'required|numeric',
            'designation'               => 'required|max:255',
            'fb'                        => 'sometimes|max:255',
            'twitter'                   => 'sometimes|max:255',
            'linkedin'                  => 'sometimes|max:255',
            'image'                     => 'sometimes|image|max:250',
            'committee_type'            => 'required',
            'serial'                    => 'required'
        ));

        $committeemember = Committee::find($id);
        $committeemember->committee_type = $request->committee_type;
        $committeemember->name = $request->name;
        $committeemember->email = $request->email;
        $committeemember->phone = $request->phone;
        $committeemember->designation = $request->designation;
        $committeemember->fb = htmlspecialchars(preg_replace("/\s+/", " ", $request->fb));
        $committeemember->twitter = htmlspecialchars(preg_replace("/\s+/", " ", $request->twitter));
        $committeemember->linkedin = htmlspecialchars(preg_replace("/\s+/", " ", $request->linkedin));
        $committeemember->serial = $request->serial;

        // image upload
        if($request->hasFile('image')) {
            $image_path = public_path('/images/committee/'. $committeemember->image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $image      = $request->file('image');
            $filename   = 'member_' . time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/committee/'. $filename);
            Image::make($image)->resize(250, 250)->save($location);
            $committeemember->image = $filename;
        }
            
        $committeemember->save();
        
        Session::flash('success', 'সফলভাবে হালনাগাদ করা হয়েছে!');
        return redirect()->route('dashboard.committee');
    }

    public function deleteCommittee($id)
    {
        $committeemember = Committee::find($id);
        $image_path = public_path('images/committee/'. $committeemember->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $committeemember->delete();

        Session::flash('success', 'সফলভাবে মুছে দেওয়া হয়েছে!');
        return redirect()->route('dashboard.committee');
    }

    public function getNews()
    {
        return view('dashboard.index');
    }

    public function getNotice()
    {
        $notices = Notice::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.notice')->withNotices($notices);
    }

    public function storeNotice(Request $request)
    {
        $this->validate($request,array(
            'name'          =>   'required',
            'attachment'    => 'required|mimes:doc,docx,ppt,pptx,png,jpeg,jpg,pdf,gif,txt|max:10000'
        ));

        $notice = new Notice;
        $notice->name = $request->name;

        if($request->hasFile('attachment')) {
            $newfile = $request->file('attachment');
            $filename   = 'file_'.time() .'.' . $newfile->getClientOriginalExtension();
            $location   = public_path('/files/');
            $newfile->move($location, $filename);
            $notice->attachment = $filename;
        }
        
        $notice->save();
        
        Session::flash('success', 'Notice has been created successfully!');
        return redirect()->route('dashboard.notice');
    }

    public function updateNotice(Request $request, $id)
    {
        $this->validate($request,array(
            'name'          =>   'required',
            'attachment'    => 'sometimes|mimes:doc,docx,ppt,pptx,png,jpeg,jpg,pdf,gif,txt|max:10000'
        ));

        $notice = Notice::find($id);
        $notice->name = $request->name;

        if($request->hasFile('attachment')) {
            // delete the previous one
            $file_path = public_path('files/'. $notice->attachment);
            if(File::exists($file_path)) {
                File::delete($file_path);
            }
            $newfile = $request->file('attachment');
            $filename   = 'file_'.time() .'.' . $newfile->getClientOriginalExtension();
            $location   = public_path('/files/');
            $newfile->move($location, $filename);
            $notice->attachment = $filename;
        }
        
        $notice->save();
        
        Session::flash('success', 'Notice has been updated successfully!');
        return redirect()->route('dashboard.notice');
    }

    public function deleteNotice($id)
    {
        $notice = Notice::find($id);
        $file_path = public_path('files/'. $notice->attachment);
        if(File::exists($file_path)) {
            File::delete($file_path);
        }
        $notice->delete();
        
        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.notice');
    }

    public function getFAQ()
    {
        $faqs = Faq::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.faq')->withFaqs($faqs);
    }

    public function storeFAQ(Request $request)
    {
        $this->validate($request,array(
            'question'          =>   'required|max:255',
            'answer'            =>   'required'
        ));

        $faq = new Faq;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        
        Session::flash('success', 'প্রশ্ন-উত্তর সফলভাবে সংরক্ষন করা হয়েছে!');
        return redirect()->route('dashboard.faq');
    }

    public function updateFAQ(Request $request, $id)
    {
        $this->validate($request,array(
            'question'          =>   'required|max:255',
            'answer'            =>   'required'
        ));

        $faq = Faq::find($id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        
        Session::flash('success', 'প্রশ্ন-উত্তর সফলভাবে হালনাগাদ করা হয়েছে!');
        return redirect()->route('dashboard.faq');
    }

    public function deleteFAQ($id)
    {
        $faq = Faq::find($id);
        $faq->delete();
        
        Session::flash('success', 'প্রশ্ন-উত্তর সফলভাবে মুছে দেওয়া হয়েছে!');
        return redirect()->route('dashboard.faq');
    }

    public function getEvents()
    {
        $events = Event::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.event')->withEvents($events);
    }

    public function storeEvent(Request $request)
    {
        $this->validate($request,array(
            'name'          =>   'required',
            'description'   =>   'required',
            'image'         =>   'sometimes|image|max:500'
        ));

        $event = new Event;
        $event->name = $request->name;
        $event->description = $request->description;

        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = 'event_' . time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/events/'. $filename);
            Image::make($image)->resize(400, 250)->save($location);
            $event->image = $filename;
        }
        
        $event->save();
        
        Session::flash('success', 'Event has been created successfully!');
        return redirect()->route('dashboard.events');
    }

    public function updateEvent(Request $request, $id)
    {
        $this->validate($request,array(
            'name'          =>   'required',
            'description'   =>   'required',
            'image'         =>   'sometimes|image|max:500'
        ));

        $event = Event::find($id);
        $event->name = $request->name;
        $event->description = $request->description;

        // image upload
        if($request->hasFile('image')) {
            // delete the previous one
            $image_path = public_path('images/events/'. $event->image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $image      = $request->file('image');
            $filename   = 'event_' . time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/events/'. $filename);
            Image::make($image)->resize(400, 250)->save($location);
            $event->image = $filename;
        }
        
        $event->save();
        
        Session::flash('success', 'Event has been updated successfully!');
        return redirect()->route('dashboard.events');
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);
        $image_path = public_path('images/events/'. $event->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $event->delete();
        
        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.events');
    }

    public function getSlider()
    {
        $sliders = Slider::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.slider')->withSliders($sliders);
    }

    public function storeSlider(Request $request)
    {
        $this->validate($request,array(
            'title'          =>   'required',
            'image'          =>   'sometimes|image|max:1000'
        ));

        $slider = new Slider;
        $slider->title = $request->title;

        // slider upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = 'slider_' . time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/slider/'. $filename);
            Image::make($image)->resize(1500, 500)->save($location);
            $slider->image = $filename;
        }
        
        $slider->save();
        
        Session::flash('success', 'সফলভাবে স্লাইডারের ছবি আপলোড করা হয়েছে!');
        return redirect()->route('dashboard.slider');
    }

    public function deleteSlider($id)
    {
        $slider = Slider::find($id);
        $image_path = public_path('images/slider/'. $slider->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $slider->delete();
        
        Session::flash('success', 'সফলভাবে মুছে ফেলা হয়েছে!');
        return redirect()->route('dashboard.slider');
    }

    public function getGallery()
    {
        $albums = Album::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.gallery.index')->withAlbums($albums);
    }

    public function getCreateGallery()
    {
        return view('dashboard.gallery.create');
    }

    public function storeGalleryAlbum(Request $request)
    {
        $this->validate($request,array(
            'name'          =>   'required',
            'description'   =>   'sometimes',
            'thumbnail'     =>   'required|image|max:500',
            'image1'        =>   'sometimes|image|max:500',
            'image2'        =>   'sometimes|image|max:500',
            'image3'        =>   'sometimes|image|max:500',
            'caption1'      =>   'sometimes',
            'caption2'      =>   'sometimes',
            'caption3'      =>   'sometimes'

        ));

        $album = new Album;
        $album->name = $request->name;
        $album->description = $request->description;

        // thumbnail upload
        if($request->hasFile('thumbnail')) {
            $thumbnail      = $request->file('thumbnail');
            $filename   = 'thumbnail_' . time() .'.' . $thumbnail->getClientOriginalExtension();
            $location   = public_path('/images/gallery/'. $filename);
            Image::make($thumbnail)->resize(1000, 625)->save($location);
            $album->thumbnail = $filename;
        }
        
        $album->save();

        // photo (s) upload
        for($i = 1; $i <= 3; $i++) {
            if($request->hasFile('image'.$i)) {
                $image      = $request->file('image'.$i);
                $filename   = 'photo_'. $i . time() .'.' . $image->getClientOriginalExtension();
                $location   = public_path('/images/gallery/'. $filename);
                Image::make($image)->resize(1000, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    })->save($location);
                $albumphoto = new Albumphoto;
                $albumphoto->album_id = $album->id;
                $albumphoto->image = $filename;
                $albumphoto->caption = $request->input('caption'.$i);
                $albumphoto->save();
            }
        }
        
        Session::flash('success', 'Album has been created successfully!');
        return redirect()->route('dashboard.gallery');
    }

    public function getEditGalleryAlbum($id) {
        $album = Album::find($id);
        return view('dashboard.gallery.edit')->withAlbum($album);
    }

    public function updateGalleryAlbum(Request $request, $id) {
        $this->validate($request,array(
            'name'          =>   'required',
            'description'   =>   'required',
            'image'         =>   'sometimes|image|max:500',
            'caption'       =>   'sometimes'
        ));

        $album = Album::find($id);
        $album->name =$request->name;
        $album->description =$request->description;
        $album->save();

        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = 'photo_'. time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/gallery/'. $filename);
            Image::make($image)->resize(1000, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                })->save($location);
            $albumphoto = new Albumphoto;
            $albumphoto->album_id = $album->id;
            $albumphoto->image = $filename;
            $albumphoto->caption = $request->caption;
            $albumphoto->save();
        }

        Session::flash('success', 'Uploaded successfully!');
        return redirect()->route('dashboard.editgallery', $id);
    }

    public function deleteAlbum($id)
    {
        $album = Album::find($id);
        $thumbnail_path = public_path('images/gallery/'. $album->thumbnail);
        if(File::exists($thumbnail_path)) {
            File::delete($thumbnail_path);
        }
        if($album->albumphotoes->count() > 0) {
            foreach ($album->albumphotoes as $albumphoto) {
                $image_path = public_path('images/gallery/'. $albumphoto->image);
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        $album->delete();

        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.gallery');
    }

    public function deleteSinglePhoto($id)
    {
        $albumphoto = Albumphoto::find($id);
        $image_path = public_path('images/gallery/'. $albumphoto->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $albumphoto->delete();
        
        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.editgallery', $albumphoto->album->id);
    }

    public function getBlogs()
    {
        return view('dashboard.index');
    }

    public function getApplications()
    {
        $applications = User::where('activation_status', 0)
                            ->orderBy('id', 'asc')->paginate(20);
        $applicationscount = User::where('activation_status', 0)
                                 ->where('role_type', '!=', 'admin')->count();

        return view('dashboard.membership.applications')
                            ->withApplications($applications)
                            ->withapplicationscount($applicationscount);
    }

    public function getSignleApplication($unique_key)
    {
        $application = User::where('unique_key', $unique_key)->first();

        return view('dashboard.membership.singleapplication')
                            ->withApplication($application);
    }

    public function getSignleApplicationEdit($unique_key)
    {
        $positions = Position::where('id', '>', 0)->get();
        $branches = Branch::where('id', '>', 0)->get();
        $application = User::where('unique_key', $unique_key)->first(); // this is also used to edit MEMBERS!

        return view('dashboard.membership.singleapplicationedit')
                            ->withApplication($application)
                            ->withBranches($branches)
                            ->withPositions($positions);
    }

    public function updateSignleApplication(Request $request, $id)
    {
        $application = User::find($id);

        if($application->activation_status == 0) {
            $this->validate($request,array(
                'name_bangla'                  => 'required|max:255',
                'name'                         => 'required|max:255',
                'nid'                          => 'required|max:255',
                'dob'                          => 'required|max:255',
                'gender'                       => 'required',
                'spouse'                       => 'sometimes|max:255',
                'spouse_profession'            => 'sometimes|max:255',
                'father'                       => 'required|max:255',
                'mother'                       => 'required|max:255',
                'profession'                   => 'required|max:255',
                'position_id'                  => 'required',
                'branch_id'                    => 'required',
                'joining_date'                 => 'sometimes|max:255',
                'present_address'              => 'required|max:255',
                'permanent_address'            => 'required|max:255',
                'office_telephone'             => 'sometimes|max:255',
                'mobile'                       => 'required|max:11',
                'home_telephone'               => 'sometimes|max:255',
                'email'                        => 'sometimes|email',
                'image'                        => 'sometimes|image|max:250', // jehetu up korse ekbar, ekhane na korleo cholbe

                'nominee_one_name'             => 'required|max:255',
                'nominee_one_identity_type'    => 'required',
                'nominee_one_identity_text'    => 'required|max:255',
                'nominee_one_relation'         => 'required|max:255',
                'nominee_one_percentage'       => 'required|max:255',
                'nominee_one_image'            => 'sometimes|image|max:250', // jehetu up korse ekbar, ekhane na korleo cholbe

                'nominee_two_name'             => 'sometimes|max:255',
                'nominee_two_identity_type'    => 'sometimes',
                'nominee_two_identity_text'    => 'sometimes|max:255',
                'nominee_two_relation'         => 'sometimes|max:255',
                'nominee_two_percentage'       => 'sometimes|max:255',
                'nominee_two_image'            => 'sometimes|image|max:250',

                'application_payment_amount'   => 'required|max:255',
                'application_payment_bank'     => 'required|max:255',
                'application_payment_branch'   => 'required|max:255',
                'application_payment_pay_slip' => 'required|max:255',
                'application_payment_receipt'  => 'sometimes|image|max:2048', // jehetu up korse ekbar, ekhane na korleo cholbe
            ));
        } else {
            $this->validate($request,array(
            'name_bangla'                  => 'required|max:255',
            'name'                         => 'required|max:255',
            'nid'                          => 'required|max:255',
            'dob'                          => 'required|max:255',
            'gender'                       => 'required',
            'spouse'                       => 'sometimes|max:255',
            'spouse_profession'            => 'sometimes|max:255',
            'father'                       => 'required|max:255',
            'mother'                       => 'required|max:255',
            'profession'                   => 'required|max:255',
            'position_id'                  => 'required|max:255',
            'branch_id'                    => 'required',
            'joining_date'                 => 'sometimes|max:255',
            'present_address'              => 'required|max:255',
            'permanent_address'            => 'required|max:255',
            'office_telephone'             => 'sometimes|max:255',
            'mobile'                       => 'required|max:11',
            'home_telephone'               => 'sometimes|max:255',
            'email'                        => 'sometimes|email',
            'image'                        => 'sometimes|image|max:250', // jehetu up korse ekbar, ekhane na korleo cholbe

            'nominee_one_name'             => 'required|max:255',
            'nominee_one_identity_type'    => 'required',
            'nominee_one_identity_text'    => 'required|max:255',
            'nominee_one_relation'         => 'required|max:255',
            'nominee_one_percentage'       => 'required|max:255',
            'nominee_one_image'            => 'sometimes|image|max:250', // jehetu up korse ekbar, ekhane na korleo cholbe

            'nominee_two_name'             => 'sometimes|max:255',
            'nominee_two_identity_type'    => 'sometimes',
            'nominee_two_identity_text'    => 'sometimes|max:255',
            'nominee_two_relation'         => 'sometimes|max:255',
            'nominee_two_percentage'       => 'sometimes|max:255',
            'nominee_two_image'            => 'sometimes|image|max:250'
        ));
        }
        


        if($request->mobile != $application->mobile) {
            $findmobileuser = User::where('mobile', $request->mobile)->first();

            if($findmobileuser) {
                Session::flash('warning', 'দুঃখিত! মোবাইল নম্বরটি ব্যবহৃত হয়ে গেছে; আরেকটি দিন');
                return redirect()->route('dashboard.singleapplicationedit', $application->unique_key);
            }
        }
        if($request->email != $application->email) {
            $findemailuser = User::where('email', $request->email)->first();

            if($findemailuser) {
                Session::flash('warning', 'দুঃখিত! ইমেইলটি ব্যবহৃত হয়ে গেছে; আরেকটি দিন');
                return redirect()->route('dashboard.singleapplicationedit', $application->unique_key);
            }
        }

        $application->name_bangla = htmlspecialchars(preg_replace("/\s+/", " ", $request->name_bangla));
        $application->name = htmlspecialchars(preg_replace("/\s+/", " ", ucwords($request->name)));
        $application->nid = htmlspecialchars(preg_replace("/\s+/", " ", $request->nid));
        $dob = htmlspecialchars(preg_replace("/\s+/", " ", $request->dob));
        $application->dob = new Carbon($dob);
        $application->gender = htmlspecialchars(preg_replace("/\s+/", " ", $request->gender));
        $application->spouse = htmlspecialchars(preg_replace("/\s+/", " ", $request->spouse));
        $application->spouse_profession = htmlspecialchars(preg_replace("/\s+/", " ", $request->spouse_profession));
        $application->father = htmlspecialchars(preg_replace("/\s+/", " ", $request->father));
        $application->mother = htmlspecialchars(preg_replace("/\s+/", " ", $request->mother));
        // $application->office = htmlspecialchars(preg_replace("/\s+/", " ", $request->office));
        $application->branch_id = $request->branch_id;
        if($request->joining_date != '') {
            $joining_date = htmlspecialchars(preg_replace("/\s+/", " ", $request->joining_date));
            $application->joining_date = new Carbon($joining_date);
        }
        $application->profession = htmlspecialchars(preg_replace("/\s+/", " ", $request->profession));
        // $application->designation = htmlspecialchars(preg_replace("/\s+/", " ", $request->designation));
        $application->position_id = $request->position_id;
        $application->membership_designation = htmlspecialchars(preg_replace("/\s+/", " ", $request->designation));
        $application->present_address = htmlspecialchars(preg_replace("/\s+/", " ", $request->present_address));
        $application->permanent_address = htmlspecialchars(preg_replace("/\s+/", " ", $request->permanent_address));
        $application->office_telephone = htmlspecialchars(preg_replace("/\s+/", " ", $request->office_telephone));
        $application->mobile = htmlspecialchars(preg_replace("/\s+/", " ", $request->mobile));
        $application->home_telephone = htmlspecialchars(preg_replace("/\s+/", " ", $request->home_telephone));
        if($request->email != '') {
            $application->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
        } else {
            $application->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->mobile)) . '@cvcsbd.com';
        }

        // applicant's image upload
        if($request->hasFile('image')) {
            $old_img = public_path('images/users/'. $application->image);
            if(File::exists($old_img)) {
                File::delete($old_img);
            }
            $image      = $request->file('image');
            $filename   = str_replace(' ','',$request->name).time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/users/'. $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $application->image = $filename;
        }

        $application->nominee_one_name = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_one_name));
        $application->nominee_one_identity_type = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_one_identity_type));
        $application->nominee_one_identity_text = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_one_identity_text));
        $application->nominee_one_relation = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_one_relation));
        $application->nominee_one_percentage = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_one_percentage));
        // nominee one's image upload
        if($request->hasFile('nominee_one_image')) {
            $old_nominee_one_image = public_path('images/users/'. $application->nominee_one_image);
            if(File::exists($old_nominee_one_image)) {
                File::delete($old_nominee_one_image);
            }
            $nominee_one_image      = $request->file('nominee_one_image');
            $filename   = 'nominee_one_' . str_replace(' ','',$request->name).time() .'.' . $nominee_one_image->getClientOriginalExtension();
            $location   = public_path('/images/users/'. $filename);
            Image::make($nominee_one_image)->resize(200, 200)->save($location);
            $application->nominee_one_image = $filename;
        }

        $application->nominee_two_name = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_two_name));
        $application->nominee_two_identity_type = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_two_identity_type));
        $application->nominee_two_identity_text = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_two_identity_text));
        $application->nominee_two_relation = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_two_relation));
        $application->nominee_two_percentage = htmlspecialchars(preg_replace("/\s+/", " ", $request->nominee_two_percentage));
        // nominee two's image upload
        if($request->hasFile('nominee_two_image')) {
            $old_nominee_two_image = public_path('images/users/'. $application->nominee_two_image);
            if(File::exists($old_nominee_two_image)) {
                File::delete($old_nominee_two_image);
            }
            $nominee_two_image      = $request->file('nominee_two_image');
            $filename   = 'nominee_two_' . str_replace(' ','',$request->name).time() .'.' . $nominee_two_image->getClientOriginalExtension();
            $location   = public_path('/images/users/'. $filename);
            Image::make($nominee_two_image)->resize(200, 200)->save($location);
            $application->nominee_two_image = $filename;
        }
        
        if($application->activation_status == 0) {
           $application->application_payment_amount = htmlspecialchars(preg_replace("/\s+/", " ", $request->application_payment_amount));
           $application->application_payment_bank = htmlspecialchars(preg_replace("/\s+/", " ", $request->application_payment_bank));
           $application->application_payment_branch = htmlspecialchars(preg_replace("/\s+/", " ", $request->application_payment_branch));
           $application->application_payment_pay_slip = htmlspecialchars(preg_replace("/\s+/", " ", $request->application_payment_pay_slip));
           // application payment receipt's image upload
           if($request->hasFile('application_payment_receipt')) {
               $old_application_payment_receipt = public_path('images/receipts/'. $application->application_payment_receipt);
               if(File::exists($old_application_payment_receipt)) {
                   File::delete($old_application_payment_receipt);
               }
               $application_payment_receipt      = $request->file('application_payment_receipt');
               $filename   = 'application_payment_receipt_' . str_replace(' ','',$request->name).time() .'.' . $application_payment_receipt->getClientOriginalExtension();
               $location   = public_path('/images/receipts/'. $filename);
               Image::make($application_payment_receipt)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
               $application->application_payment_receipt = $filename;
           } 
        }
        
        $application->save();

        if($application->activation_status == 0 || $application->activation_status == 202) {
            Session::flash('success', 'আবেদনটি সফলভাবে হালনাগাদ করা হয়েছে!');
            return redirect()->route('dashboard.singleapplication', $application->unique_key);
        } else {
            Session::flash('success', 'সদস্য তথ্য সফলভাবে হালনাগাদ করা হয়েছে!');
            return redirect()->route('dashboard.singlemember', $application->unique_key);
        }
    }

    public function getDefectiveApplications()
    {
        $applications = User::where('activation_status', 202)
                            ->orderBy('id', 'asc')->paginate(20);
        $applicationscount = User::where('activation_status', 202)
                                 ->where('role_type', '!=', 'admin')->count();

        return view('dashboard.membership.defectiveapplications')
                            ->withApplications($applications)
                            ->withapplicationscount($applicationscount);
    }

    public function makeDefectiveApplication(Request $request, $id)
    {
        $application = User::find($id);
        $application->activation_status = 202; // 202 for defective applications
        $application->save();
        Session::flash('success', 'সদস্য সফলভাবে অসম্পূর্ণ তালিকায় প্রেরণ করা হয়েছে!');
        return redirect()->route('dashboard.defectiveapplications');
    }

    public function makeDefectiveToPendingApplication(Request $request, $id)
    {
        $application = User::find($id);
        $application->activation_status = 0; // 0 for pending applications
        $application->save();
        Session::flash('success', 'সদস্য সফলভাবে আবেদনের তালিকায় প্রেরণ করা হয়েছে!');
        return redirect()->route('dashboard.applications');
    }

    public function searchDefectiveApplicationAPI(Request $request)
    {
        if($request->ajax())
        {
          $output = '';
          $query = $request->get('query');
          if($query != '')
          {
           $data = DB::table('users')
                    ->where('activation_status', 202) // 202 for defective applications
                    ->where('role_type', '!=', 'admin') // avoid the super admin type
                    ->where(function($newquery) use ($query) {
                        $newquery->where('name', 'like', '%'.$query.'%')
                                 ->orWhere('name_bangla', 'like', '%'.$query.'%')
                                 ->orWhere('mobile', 'like', '%'.$query.'%')
                                 ->orWhere('email', 'like', '%'.$query.'%');
                    })
                    ->orderBy('id', 'desc')
                    ->get();
          }

          $total_row = count($data);
          if($total_row > 0)
          {
           foreach($data as $row)
           {
            $output .= '
            <tr>
             <td>
                <a href="'. route('dashboard.singleapplication', $row->unique_key) .'" title="সদস্য তথ্য দেখুন">
                  '. $row->name_bangla .'<br/> '. $row->name .'
                </a>
             </td>
             <td>'.$row->mobile.'<br/>'.$row->email.'</td>
             <td>'.$row->office.'<br/>'.$row->profession.' ('. $row->designation .')</td>
             <td>৳ '. $row->application_payment_amount .'<br/>'. $row->application_payment_bank .' ('. $row->application_payment_branch .')</td>
            ';
            if($row->image != null) {
                $output .= '<td><img src="'. asset('images/users/'.$row->image) .'" style="height: 50px; width: auto;" /></td>';
            } else {
                $output .= '<td><img src="'. asset('images/user.png') .'" style="height: 50px; width: auto;" /></td>';
            }
            $output .= '<td><a class="btn btn-sm btn-success" href="'. route('dashboard.singleapplication', $row->unique_key) .'" title="সদস্য তথ্য দেখুন"><i class="fa fa-eye"></i></a> 
                <a class="btn btn-sm btn-primary" href="'. route('dashboard.singleapplicationedit', $row->unique_key) .'" title="সদস্য তথ্য সম্পাদনা করুণ"><i class="fa fa-edit"></i></a>
              </td>
            </tr>';
           }
          }
          else
          {
           $output = '
           <tr>
            <td align="center" colspan="6">পাওয়া যায়নি!</td>
           </tr>
           ';
          }
          $data = array(
           'table_data'  => $output,
           'total_data'  => $total_row . ' টি ফলাফল পাওয়া গেছে'
          );

          echo json_encode($data);
        }        
    }

    public function activateMember(Request $request, $id)
    {
        $application = User::find($id);
        $application->activation_status = 1;

        // $lastmember = User::where('activation_status', 1)
        //                   ->orderBy('updated_at', 'desc')
        //                   ->first();
        // $lastfivedigits = (int) substr($lastmember->member_id, -5);

        $members = User::where('activation_status', 1)->get();
        $ordered_member_ids = [];
        foreach ($members as $member) {
            array_push($ordered_member_ids, (int) substr($member->member_id, -5));
        }
        rsort($ordered_member_ids); // descending order to get the last value
        // dd($ordered_member_ids);
        $application->member_id = date('Y', strtotime($application->dob)).str_pad(($ordered_member_ids[0]+1), 5, '0', STR_PAD_LEFT);
        // check if the id already exists...
        $ifexists = User::where('member_id', $application->member_id)->first();
        if($ifexists) {
            Session::flash('warning', 'দুঃখিত! আবার চেষ্টা করুন!');
            return redirect()->route('dashboard.applications');
        } else {
            $application->save();

            $newmembercheck = User::where('activation_status', 1)
                                  ->where('member_id', $application->member_id)
                                  ->first();
            
            if($newmembercheck) {
                // dd($newmembercheck);
                // save the payment!
                $payment = new Payment;
                $payment->member_id = $newmembercheck->member_id;
                $payment->payer_id = $newmembercheck->member_id;
                $payment->amount = 2000; // hard coded; Membership 2000, monthly 300 >>>>>> August 13, 2020
                $payment->bank = $newmembercheck->application_payment_bank;
                $payment->branch = $newmembercheck->application_payment_branch;
                $payment->pay_slip = $newmembercheck->application_payment_pay_slip;
                $payment->bank = $newmembercheck->application_payment_bank;
                $payment->branch = $newmembercheck->application_payment_branch;
                $payment->pay_slip = $newmembercheck->application_payment_pay_slip;
                $payment->payment_status = 1; // approved
                $payment->payment_category = 0; // membership payment
                $payment->payment_type = 1; // single payment
                if($newmembercheck->payment_method == 1) {
                    $payment->payment_method = 1;
                    $payment->payment_key = $newmembercheck->trxid;
                } else {
                    $payment->payment_key = random_string(10);
                }
                
                $payment->save();

                // receipt upload
                if($newmembercheck->application_payment_receipt != '') {
                    $paymentreceipt = new Paymentreceipt;
                    $paymentreceipt->payment_id = $payment->id;
                    $paymentreceipt->image = $newmembercheck->application_payment_receipt;
                    $paymentreceipt->save();
                }

                // Membership 2000, monthly 300 >>>>>> August 13, 2020
                // Membership 2000, monthly 300 >>>>>> August 13, 2020
                // Membership 2000, monthly 300 >>>>>> August 13, 2020
                // Membership 2000, monthly 300 >>>>>> August 13, 2020
                // Membership 2000, monthly 300 >>>>>> August 13, 2020
                if($newmembercheck->application_payment_amount > 2000) {
                    $payment = new Payment;
                    $payment->member_id = $newmembercheck->member_id;
                    $payment->payer_id = $newmembercheck->member_id;
                    $payment->amount = $newmembercheck->application_payment_amount - 2000; // IMPORTANT
                    $payment->bank = $newmembercheck->application_payment_bank;
                    $payment->branch = $newmembercheck->application_payment_branch;
                    $payment->pay_slip = $newmembercheck->application_payment_pay_slip;
                    $payment->payment_status = 1; // approved (0 means pending)
                    $payment->payment_category = 1; // monthly payment (0 means membership)
                    $payment->payment_type = 1; // single payment (2 means bulk)
                    if($newmembercheck->payment_method == 1) {
                        $payment->payment_method = 1;
                        $payment->payment_key = $newmembercheck->trxid;
                    } else {
                        $payment->payment_key = random_string(10);
                    }
                    $payment->save();

                    // receipt upload
                    if($newmembercheck->application_payment_receipt != '') {
                        $paymentreceipt = new Paymentreceipt;
                        $paymentreceipt->payment_id = $payment->id;
                        $paymentreceipt->image = $newmembercheck->application_payment_receipt;
                        $paymentreceipt->save();
                    }
                }
                // save the payment!
            } else {
                Session::flash('warning', 'দুঃখিত! আবার চেষ্টা করুন!');
                return redirect()->back();
            }

            // send activation SMS ... aro kichu kaaj baki ache...
            // send sms
            $mobile_number = 0;
            if(strlen($application->mobile) == 11) {
                $mobile_number = $application->mobile;
            } elseif(strlen($application->mobile) > 11) {
                if (strpos($application->mobile, '+') !== false) {
                    $mobile_number = substr($application->mobile, -11);
                }
            }
            // $url = config('sms.url');
            // $number = $mobile_number;
            $text = 'Dear ' . $application->name . ', your membership application has been approved! Your ID: '. $application->member_id .', Email: '. $application->email .' and Password: cvcs12345. Customs and VAT Co-operative Society (CVCS). Login & change password: https://cvcsbd.com/login';
            // this sms costs 2 SMS
            // this sms costs 2 SMS

            // NEW PANEL
            $url = config('sms.url2');
            $api_key = config('sms.api_key');
            $senderid = config('sms.senderid');
            $number = $mobile_number;
            $message = $text;

            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "number" => $number,
                "message" => $message,
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            $jsonresponse = json_decode($response);

            if($jsonresponse->response_code == 202) {
                Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
            } elseif($jsonresponse->response_code == 1007) {
                Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
            } else {
                Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
            }
            // NEW PANEL
            
            // $data= array(
            //     'username'=>config('sms.username'),
            //     'password'=>config('sms.password'),
            //     'number'=>"$number",
            //     'message'=>"$text",
            // );
            // // initialize send status
            // $ch = curl_init(); // Initialize cURL
            // curl_setopt($ch, CURLOPT_URL,$url);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
            // $smsresult = curl_exec($ch);
            // $p = explode("|",$smsresult);
            // $sendstatus = $p[0];
            // // dd($smsresult);
            // // send sms
            // if($sendstatus == 1101) {
            //     Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
            // } elseif($sendstatus == 1006) {
            //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
            // } else {
            //     Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
            // }

            Session::flash('success', 'সদস্য সফলভাবে অনুমোদন করা হয়েছে!');
            return redirect()->route('dashboard.applications');
        }
        
    }

    public function deleteApplication(Request $request, $id)
    {
        $application = User::find($id);
        $image_path = public_path('images/users/'. $application->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $nominee_one_path = public_path('images/users/'. $application->nominee_one_image);
        if(File::exists($nominee_one_path)) {
            File::delete($nominee_one_path);
        }
        $nominee_two_path = public_path('images/users/'. $application->nominee_two_image);
        if(File::exists($nominee_two_path)) {
            File::delete($nominee_two_path);
        }
        $application->delete();

        return redirect()->route('dashboard.applications');
    }

    public function sendSMSApplicant(Request $request)
    {
        $this->validate($request,array(
            'unique_key'        =>   'required',
            'message'           =>   'required'
        ));

        $applicant = User::where('unique_key', $request->unique_key)->first();

        // send pending SMS ... aro kichu kaaj baki ache...
        // send sms
        $mobile_number = 0;
        if(strlen($applicant->mobile) == 11) {
            $mobile_number = $applicant->mobile;
        } elseif(strlen($applicant->mobile) > 11) {
            if (strpos($applicant->mobile, '+') !== false) {
                $mobile_number = substr($applicant->mobile, -11);
            }
        }
        // $url = config('sms.url');
        // $number = $mobile_number;
        $text = $request->message . ' Customs and VAT Co-operative Society (CVCS).';
        
        // NEW PANEL
        $url = config('sms.url2');
        $api_key = config('sms.api_key');
        $senderid = config('sms.senderid');
        $number = $mobile_number;
        $message = $text;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonresponse = json_decode($response);

        if($jsonresponse->response_code == 202) {
            Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } elseif($jsonresponse->response_code == 1007) {
            Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }
        // NEW PANEL

        // $data= array(
        //     'username'=>config('sms.username'),
        //     'password'=>config('sms.password'),
        //     'number'=>"$number",
        //     'message'=>"$text",
        //     // 'apicode'=>"1",
        //     // 'msisdn'=>"$number",
        //     // 'countrycode'=>"880",
        //     // 'cli'=>"CVCS",
        //     // 'messagetype'=>"3",
        //     // 'messageid'=>"3"
        // );
        // // initialize send status
        // $ch = curl_init(); // Initialize cURL
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        // $smsresult = curl_exec($ch);
        // $p = explode("|",$smsresult);
        // $sendstatus = $p[0];

        // // $sendstatus = substr($smsresult, 0, 3);
        // // API Response Code
        // // 1000 = Invalid user or Password
        // // 1002 = Empty Number
        // // 1003 = Invalid message or empty message
        // // 1004 = Invalid number
        // // 1005 = All Number is Invalid 
        // // 1006 = insufficient Balance 
        // // 1009 = Inactive Account
        // // 1010 = Max number limit exceeded
        // // 1101 = Success
        // // send sms
        // if($sendstatus == 1101) {
        //     Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        // } elseif($sendstatus == 1006) {
        //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        // } else {
        //     Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        //     // return json_encode($smsresult);
        // }

        return redirect()->back();
    }

    public function searchApplicationAPI(Request $request)
    {
        if($request->ajax())
        {
          $output = '';
          $query = $request->get('query');
          if($query != '')
          {
           $data = DB::table('users')
                    ->where('activation_status', 0)
                    ->where('role_type', '!=', 'admin') // avoid the super admin type
                    ->where(function($newquery) use ($query) {
                        $newquery->where('name', 'like', '%'.$query.'%')
                                 ->orWhere('name_bangla', 'like', '%'.$query.'%')
                                 ->orWhere('mobile', 'like', '%'.$query.'%')
                                 ->orWhere('email', 'like', '%'.$query.'%');
                    })
                    ->orderBy('id', 'desc')
                    ->get();
          }

          $total_row = count($data);
          if($total_row > 0)
          {
           foreach($data as $row)
           {
            $output .= '
            <tr>
             <td>
                <a href="'. route('dashboard.singleapplication', $row->unique_key) .'" title="সদস্য তথ্য দেখুন">
                  '. $row->name_bangla .'<br/> '. $row->name .'
                </a>
             </td>
             <td>'.$row->mobile.'<br/>'.$row->email.'</td>
             <td>'.$row->office.'<br/>'.$row->profession.' ('. $row->designation .')</td>
             <td>৳ '. $row->application_payment_amount .'<br/>'. $row->application_payment_bank .' ('. $row->application_payment_branch .')</td>
            ';
            if($row->image != null) {
                $output .= '<td><img src="'. asset('images/users/'.$row->image) .'" style="height: 50px; width: auto;" /></td>';
            } else {
                $output .= '<td><img src="'. asset('images/user.png') .'" style="height: 50px; width: auto;" /></td>';
            }
            $output .= '<td><a class="btn btn-sm btn-success" href="'. route('dashboard.singleapplication', $row->unique_key) .'" title="সদস্য তথ্য দেখুন"><i class="fa fa-eye"></i></a>
                <a class="btn btn-sm btn-primary" href="'. route('dashboard.singleapplicationedit', $row->unique_key) .'" title="আবেদনটি সম্পাদনা করুণ"><i class="fa fa-edit"></i></a>
              </td>
            </tr>';
           }
          }
          else
          {
           $output = '
           <tr>
            <td align="center" colspan="6">পাওয়া যায়নি!</td>
           </tr>
           ';
          }
          $data = array(
           'table_data'  => $output,
           'total_data'  => $total_row . ' টি ফলাফল পাওয়া গেছে'
          );

          echo json_encode($data);
        }        
    }

    public function getMembers(Request $request)
    {
        $memberscount = User::where('activation_status', 1)->where('role_type', '!=', 'admin')->count();
        $positions = Position::where('id', '>', 0)->get();
        $branches = Branch::where('id', '>', 0)->get();
        $members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')
                       ->orderBy('id', 'desc')->get();

        $ordered_member_array = [];
        foreach ($members as $member) {
            $ordered_member_array[(int) substr($member->member_id, -5)] = $member;
        }
        ksort($ordered_member_array); // ascending order according to key
    
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $itemCollection = collect($ordered_member_array);
 
        $perPage = 20;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        return view('dashboard.membership.members')
                            ->withMembers($paginatedItems)
                            ->withPositions($positions)
                            ->withBranches($branches)
                            ->withMemberscount($memberscount);
    }

    public function transferMember(Request $request, $id)
    {
        $this->validate($request,array(
            'branch_id'        =>   'required',
            'confirmcheckbox'  =>   'required'
        ));

        $member = User::find($id);
        $member->branch_id = $request->branch_id;
        $member->save();

        Session::flash('success','সফলভাবে সদস্যের দপ্তর পরিবর্তন করা হয়েছে!');
        return redirect()->route('dashboard.members');
    }

    public function changeDesignation(Request $request, $id)
    {
        $this->validate($request,array(
            'position_id'        =>   'required',
            'confirmcheckbox'  =>   'required'
        ));

        $member = User::find($id);
        $member->position_id = $request->position_id;
        $member->save();

        Session::flash('success','সফলভাবে সদস্যের পদবি পরিবর্তন করা হয়েছে!');
        return redirect()->route('dashboard.members');
    }

    public function getMembersForAll(Request $request)
    {
        $memberscount = User::where('activation_status', 1)->where('role_type', '!=', 'admin')->count();
        $members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')
                       ->with(['payments' => function ($query) {
                            // $query->orderBy('created_at', 'desc');
                            $query->where('payment_status', '=', 1);
                            $query->where('is_archieved', '=', 0);
                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                        }])  
                       ->orderBy('position_id', 'asc')
                       // ->paginate(20);
                       ->get();

        // GET THE DUES AND PAIDS
        // GET THE DUES AND PAIDS
        foreach ($members as $member) {
            $approvedcashformontly = $member->payments->sum('amount');
            $member->totalpendingmonthly = 0;
            if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
            {
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                $totalmonthsformember = $to->diffInMonths($from) + 1;
                if(($totalmonthsformember * 300) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                }
            } else {
                $startmonth = date('Y-m-', strtotime($member->joining_date));
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                $totalmonthsformember = $to->diffInMonths($from) + 1;
                if(($totalmonthsformember * 300) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                }
            }
        }

        // SORT IT WITH সদস্য DESIGNEATION              
        // SORT IT WITH সদস্য DESIGNEATION              
        $adhocmembers1 = [];
        $adhocmemberscol1 = collect();
        $adhocmembers2 = [];
        $adhocmemberscol2 = collect();
        foreach($members as $member) {
          if($member->position_id == 34) {
            $adhocmembers1[] = $member;
          } else {
            $adhocmembers2[] = $member;
          }
        }
        $adhocmemberscol1 = collect($adhocmembers1);
        $adhocmemberscol2 = collect($adhocmembers2);
        $mergedmembers = collect();
        $mergedmembers = $adhocmemberscol1->merge($adhocmemberscol2);
        
        // $ordered_member_array = [];
        // foreach ($members as $member) {
        //     $ordered_member_array[(int) substr($member->member_id, -5)] = $member;
        // }
        // ksort($ordered_member_array); // ascending order according to key
    
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($mergedmembers); // $ordered_member_array chilo aage
        $perPage = 20;
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        $branches = Branch::all();

        return view('dashboard.profile.membersforall')
                            ->withMembers($paginatedItems)
                            ->withMemberscount($memberscount)
                            ->withBranches($branches);
    }

    public function getMembersForAllBranchWise(Request $request, $branch_id)
    {
        $memberscount = User::where('activation_status', 1)->where('branch_id', $branch_id)->where('role_type', '!=', 'admin')->count();
        $members = User::where('activation_status', 1)
                       ->where('branch_id', $branch_id)
                       ->where('role_type', '!=', 'admin')
                       ->with(['payments' => function ($query) {
                            // $query->orderBy('created_at', 'desc');
                            $query->where('payment_status', '=', 1);
                            $query->where('is_archieved', '=', 0);
                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                        }])  
                       ->orderBy('position_id', 'asc')
                       // ->paginate(20);
                       ->get();

        // GET THE DUES AND PAIDS
        // GET THE DUES AND PAIDS
        foreach ($members as $member) {
            $approvedcashformontly = $member->payments->sum('amount');
            $member->totalpendingmonthly = 0;
            if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
            {
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                $totalmonthsformember = $to->diffInMonths($from) + 1;
                if(($totalmonthsformember * 300) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                }
            } else {
                $startmonth = date('Y-m-', strtotime($member->joining_date));
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                $totalmonthsformember = $to->diffInMonths($from) + 1;
                if(($totalmonthsformember * 300) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                }
            }
        }

        // SORT IT WITH সদস্য DESIGNEATION              
        // SORT IT WITH সদস্য DESIGNEATION              
        $adhocmembers1 = [];
        $adhocmemberscol1 = collect();
        $adhocmembers2 = [];
        $adhocmemberscol2 = collect();
        foreach($members as $member) {
          if($member->position_id == 34) {
            $adhocmembers1[] = $member;
          } else {
            $adhocmembers2[] = $member;
          }
        }
        $adhocmemberscol1 = collect($adhocmembers1);
        $adhocmemberscol2 = collect($adhocmembers2);
        $mergedmembers = collect();
        $mergedmembers = $adhocmemberscol1->merge($adhocmemberscol2);
        
        // $ordered_member_array = [];
        // foreach ($members as $member) {
        //     $ordered_member_array[(int) substr($member->member_id, -5)] = $member;
        // }
        // ksort($ordered_member_array); // ascending order according to key
    
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($mergedmembers); // $ordered_member_array chilo aage
        $perPage = 20;
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        $branches = Branch::all();

        return view('dashboard.profile.membersforall')
                            ->withMembers($paginatedItems)
                            ->withMemberscount($memberscount)
                            ->withBranches($branches);
    }

    public function getSearchMember()
    {
        return view('dashboard.membership.searchmember');
    }

    public function searchMemberAPI(Request $request)
    {
        $response = User::select('name_bangla', 'member_id', 'mobile', 'unique_key')
                        ->where('activation_status', 1)
                        ->where('role_type', '!=', 'admin') // avoid the super admin type
                        ->orderBy('id', 'desc')->get();

        return $response;          
    }

    public function searchMemberAPI2(Request $request)
    {
        if($request->ajax())
        {
          $output = '';
          $officelist = '';
          $designationlist = '';
          $query = $request->get('query');
          if($query != '')
          {
           $data = User::where('activation_status', 1)
                    ->where('role_type', '!=', 'admin') // avoid the super admin type
                    ->where(function($newquery) use ($query) {
                        $newquery->where('name', 'like', '%'.$query.'%')
                                 ->orWhere('name_bangla', 'like', '%'.$query.'%')
                                 ->orWhere('member_id', 'like', '%'.$query.'%')
                                 ->orWhere('mobile', 'like', '%'.$query.'%')
                                 ->orWhere('email', 'like', '%'.$query.'%');
                    })
                    ->with('branch')
                    ->with('position')
                    ->orderBy('id', 'desc')
                    ->get();
          }

          $total_row = count($data);
          if($total_row > 0)
          {
           foreach($data as $row)
           {
            $output .= '
            <tr>
             <td>
                <a href="'. route('dashboard.singlemember', $row->unique_key) .'" title="সদস্য তথ্য দেখুন">
                  '. $row->name_bangla .'<br/> '. $row->name .'
                </a>
             </td>
             <td><big><b>'.$row->member_id.'</big></b></td>
             <td>'.$row->mobile.'<br/>'.$row->email.'</td>
             <td>
                <a href="'. route('dashboard.branch.members', $row->branch->id) .'" title="সদস্য তথ্য দেখুন">
                  '. $row->branch->name .'
                </a><br/>
                '. $row->profession .' (<a href="'. route('dashboard.designation.members', $row->position->id) .'" title="সদস্য তথ্য দেখুন">
                  '. $row->position->name .'
                </a>)
            </td>
            ';
            if($row->image != null) {
                $output .= '<td><img src="'. asset('images/users/'.$row->image) .'" style="height: 50px; width: auto;" /></td>';
            } else {
                $output .= '<td><img src="'. asset('images/user.png') .'" style="height: 50px; width: auto;" /></td>';
            }

            $branches = Branch::where('id', '>', 0)->get();
            $positions = Position::where('id', '>', 0)->get();
            foreach($branches as $branch) {
                $officelist .= '<option value="' . $branch->id . '">' . $branch->name . '</option>';
            }
            foreach($positions as $position) {
                $designationlist .= '<option value="' . $position->id . '">' . $position->name . '</option>';
            }
            
            
            $output .= '<td><a class="btn btn-sm btn-success" href="'. route('dashboard.singlemember', $row->unique_key) .'" title="সদস্য তথ্য দেখুন"><i class="fa fa-eye"></i></a>
                <a class="btn btn-sm btn-primary" href="'. route('dashboard.singleapplicationedit', $row->unique_key) .'" title="আবেদনটি সম্পাদনা করুণ"><i class="fa fa-edit"></i></a>
                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#transferMemberModal'. $row->member_id .'" data-backdrop="static" title="সদস্যের দপ্তর পরিবর্তন করুন"><i class="fa fa-fw fa-exchange" aria-hidden="true"></i></a>
                <div class="modal fade" id="transferMemberModal'. $row->member_id .'" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-warning">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-fw fa-exchange"></i> দপ্তর পরিবর্তন করুন</h4>
                      </div>
                      <form method="POST" class="form-default" action="' . route('dashboard.transfermember', $row->id) . '">
                      <input name="_token" type="hidden" value="' . csrf_token() . '">
                      <div class="modal-body">
                        <select name="branch_id" id="branch_id" class="form-control" required="">
                            <option value="" selected="" disabled="">দপ্তরের নাম নির্ধারণ করুন</option>
                            ' . $officelist . '
                        </select><br/>
                        <div class="checkbox">
                          <label><input type="checkbox" name="confirmcheckbox" value="1" required>আপনি কি নিশ্চিতভাবে দপ্তর পরিবর্তন করতে চান? (চেক বাটনে ক্লিক করুন)</label>
                        </div>
                      </div>
                      <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">দাখিল করুন</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                <a class="btn btn-sm btn-info" data-toggle="modal" data-target="#changeDesigModal'. $row->member_id .'" data-backdrop="static" title="সদস্যের পদবি পরিবর্তন করুন"><i class="fa fa-level-up" aria-hidden="true"></i></a>
                <div class="modal fade" id="changeDesigModal'. $row->member_id .'" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-info">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-level-up"></i> পদবি পরিবর্তন করুন</h4>
                      </div>
                      <form method="POST" class="form-default" action="' . route('dashboard.changedesignation', $row->id) . '">
                      <input name="_token" type="hidden" value="' . csrf_token() . '">
                      <div class="modal-body">
                        <select name="position_id" id="position_id" class="form-control" required="">
                            <option value="" selected="" disabled="">পদবির নাম নির্ধারণ করুন</option>
                            ' . $designationlist . '
                        </select><br/>
                        <div class="checkbox">
                          <label><input type="checkbox" name="confirmcheckbox" value="1" required>আপনি কি নিশ্চিতভাবে পদবি পরিবর্তন করতে চান? (চেক বাটনে ক্লিক করুন)</label>
                        </div>
                      </div>
                      <div class="modal-footer">
                            <button type="submit" class="btn btn-info">দাখিল করুন</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>';
           }
          }
          else
          {
           $output = '
           <tr>
            <td align="center" colspan="6">পাওয়া যায়নি!</td>
           </tr>
           ';
          }
          $data = array(
           'table_data'  => $output,
           'total_data'  => $total_row . ' টি ফলাফল পাওয়া গেছে'
          );

          echo json_encode($data);
        }        
    }

    public function searchMemberAPI3(Request $request)
    {
        if($request->ajax())
        {
          $output = '';
          $query = $request->get('query');
          if($query != '')
          {
           $members = User::where('activation_status', 1)
                    ->where('role_type', '!=', 'admin') // avoid the super admin type
                    ->where(function($newquery) use ($query) {
                        $newquery->where('name', 'like', '%'.$query.'%')
                                 ->orWhere('name_bangla', 'like', '%'.$query.'%')
                                 ->orWhere('member_id', 'like', '%'.$query.'%')
                                 ->orWhere('mobile', 'like', '%'.$query.'%')
                                 ->orWhere('email', 'like', '%'.$query.'%');
                    })
                    ->with('branch')
                    ->with('position')
                    ->with(['payments' => function ($query) {
                         // $query->orderBy('created_at', 'desc');
                         $query->where('payment_status', '=', 1);
                         $query->where('is_archieved', '=', 0);
                         $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                     }])  
                    ->orderBy('position_id', 'asc')
                    ->get();

            // GET THE DUES AND PAIDS
            // GET THE DUES AND PAIDS
            foreach ($members as $member) {
                $approvedcashformontly = $member->payments->sum('amount');
                $member->totalpendingmonthly = 0;
                if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
                {
                    $thismonth = Carbon::now()->format('Y-m-');
                    $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
                    $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                    $totalmonthsformember = $to->diffInMonths($from) + 1;
                    if(($totalmonthsformember * 300) > $approvedcashformontly) {
                      $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                    }
                } else {
                    $startmonth = date('Y-m-', strtotime($member->joining_date));
                    $thismonth = Carbon::now()->format('Y-m-');
                    $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
                    $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                    $totalmonthsformember = $to->diffInMonths($from) + 1;
                    if(($totalmonthsformember * 300) > $approvedcashformontly) {
                      $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                    }
                }
            }

            // SORT IT WITH সদস্য DESIGNEATION              
            // SORT IT WITH সদস্য DESIGNEATION              
            $adhocmembers1 = [];
            $adhocmemberscol1 = collect();
            $adhocmembers2 = [];
            $adhocmemberscol2 = collect();
            foreach($members as $member) {
              if($member->position_id == 34) {
                $adhocmembers1[] = $member;
              } else {
                $adhocmembers2[] = $member;
              }
            }
            $adhocmemberscol1 = collect($adhocmembers1);
            $adhocmemberscol2 = collect($adhocmembers2);
            $mergedmembers = collect();
            $mergedmembers = $adhocmemberscol1->merge($adhocmemberscol2);
          }

          $total_row = count($mergedmembers);
          if($total_row > 0)
          {
           foreach($mergedmembers as $row)
           {
            $output .= '
            <tr>
             <td width="25%">'. $row->name_bangla .'<br/> '. $row->name .'</td>
             <td width="10%"><big><b>'.$row->member_id.'</big></b></td>
             <td width="20%">'.$row->branch->name.'<br/>'.$row->profession.' ('. $row->position->name .')</td>
            ';
            if($row->image != null) {
                $output .= '<td><img src="'. asset('images/users/'.$row->image) .'" style="height: 50px; width: auto;" /></td>';
            } else {
                $output .= '<td><img src="'. asset('images/user.png') .'" style="height: 50px; width: auto;" /></td>';
            }
            $output .= '
             <td>৳ '.$row->payments->sum('amount').'</td>
             <td>৳ '.$row->totalpendingmonthly.'</td>
            ';
            $output .= '</tr>';
           }
          }
          else
          {
           $output = '
           <tr>
            <td align="center" colspan="6">পাওয়া যায়নি!</td>
           </tr>
           ';
          }
          $data = array(
           'table_data'  => $output,
           'total_data'  => $total_row . ' টি ফলাফল পাওয়া গেছে'
          );

          echo json_encode($data);
        }        
    }

    public function getSingleMember($unique_key)
    {
        $member = User::where('unique_key', $unique_key)
                      ->with(['payments' => function ($query) {
                            // $query->orderBy('created_at', 'desc');
                            $query->where('payment_status', '=', 1);
                            $query->where('is_archieved', '=', 0);
                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                      }])
                      ->first();
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
        $totalmontlypaid = DB::table('payments')
                                 ->select(DB::raw('SUM(amount) as totalamount'))
                                 ->where('payment_status', 1)
                                 ->where('is_archieved', 0)
                                 ->where('payment_category', 1) // 1 means monthly, 0 for membership
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
        // TOTAL PENDING
        // TOTAL PENDING
        // TOTAL PENDING
        $intotalmontlypaid = 0;
        $intotalmontlydues = 0;
        $approvedcashformontly = $member->payments->sum('amount');
        $member->totalpendingmonthly = 0;
        $intotalmontlypaid = $intotalmontlypaid + $approvedcashformontly;
        if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
        {
            $thismonth = Carbon::now()->format('Y-m-');
            $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
            $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
            $totalmonthsformember = $to->diffInMonths($from) + 1;
            if(($totalmonthsformember * 300) > $approvedcashformontly) {
              $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
              $intotalmontlydues = $intotalmontlydues + $member->totalpendingmonthly;
            }
        } else {
            $startmonth = date('Y-m-', strtotime($member->joining_date));
            $thismonth = Carbon::now()->format('Y-m-');
            $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
            $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
            $totalmonthsformember = $to->diffInMonths($from) + 1;
            if(($totalmonthsformember * 300) > $approvedcashformontly) {
              $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
              $intotalmontlydues = $intotalmontlydues + $member->totalpendingmonthly;
            }
        }
        $totalpendingthiuser = $intotalmontlydues; // BPATC FTC COMMIT                       
        // TOTAL PENDING
        // TOTAL PENDING
        // TOTAL PENDING

        $members = User::all();

        // for now, user can only see his profile, so if there is a change, then kaaj kora jaabe...
        if((Auth::user()->role == 'member') && ($member->unique_key != Auth::user()->unique_key)) {
            Session::flash('warning', ' দুঃখিত, আপনার এই পাতাটি দেখার অনুমতি নেই!');
            return redirect()->route('dashboard.memberpayment');
        }

        return view('dashboard.membership.singlemember')
                            ->withMember($member)
                            ->withMembers($members)
                            ->withPendingfordashboard($pendingfordashboard)
                            ->withApprovedfordashboard($approvedfordashboard)
                            ->withTotalmontlypaid($totalmontlypaid)
                            ->withPendingcountdashboard($pendingcountdashboard)
                            ->withApprovedcountdashboard($approvedcountdashboard)
                            ->withTotalpendingthiuser($totalpendingthiuser);
    }

    public function getFormMessages() 
    {
        $messages = Formmessage::orderBy('id', 'desc')
                               ->where('message_state', 0)
                               ->paginate(10);

        return view('dashboard.formmessage')
                    ->withMessages($messages);
    }

    public function getArchivedFormMessages() 
    {
        $messages = Formmessage::orderBy('id', 'desc')
                               ->where('message_state', 1)
                               ->paginate(10);

        return view('dashboard.archivedformmessage')
                        ->withMessages($messages);
    }

    public function archiveFormMessage($id) 
    {
        $messages = Formmessage::find($id);
        $messages->message_state = 1;
        $messages->save();

        Session::flash('success', 'সফলভাবে আর্কাইভ ক্রয়া হয়েছে!');
        return redirect()->route('dashboard.formmessage');
    }

    public function deleteFormMessage($id) 
    {
        $messages = Formmessage::find($id);
        $messages->delete();

        Session::flash('success', 'সফলভাবে ডিলেট ক্রয়া হয়েছে!');
        return redirect()->back();
    }

    public function getProfile() 
    {
        $positions = Position::where('id', '>', 0)->get();
        $branches = Branch::where('id', '>', 0)->get();
        // $member = User::find(Auth::user()->id);
        $member = User::where('id', Auth::user()->id)
                      ->with(['payments' => function ($query) {
                            // $query->orderBy('created_at', 'desc');
                            $query->where('payment_status', '=', 1);
                            $query->where('is_archieved', '=', 0);
                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                      }])
                      ->first();

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
        // TOTAL PENDING
        // TOTAL PENDING
        // TOTAL PENDING
        $intotalmontlypaid = 0;
        $intotalmontlydues = 0;
        $approvedcashformontly = $member->payments->sum('amount');
        $member->totalpendingmonthly = 0;
        $intotalmontlypaid = $intotalmontlypaid + $approvedcashformontly;
        // dd($approvedcashformontly);
        if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
        {
            $thismonth = Carbon::now()->format('Y-m-');
            $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
            $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
            $totalmonthsformember = $to->diffInMonths($from) + 1;
            if(($totalmonthsformember * 300) > $approvedcashformontly) {
              $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
              $intotalmontlydues = $intotalmontlydues + $member->totalpendingmonthly;
            }
        } else {
            $startmonth = date('Y-m-', strtotime($member->joining_date));
            $thismonth = Carbon::now()->format('Y-m-');
            $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
            $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
            $totalmonthsformember = $to->diffInMonths($from) + 1;
            if(($totalmonthsformember * 300) > $approvedcashformontly) {
              $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
              $intotalmontlydues = $intotalmontlydues + $member->totalpendingmonthly;
            }
        }
        $totalpendingthiuser = $intotalmontlydues; // BPATC FTC COMMIT     
        // dd($totalpendingthiuser);                
        // TOTAL PENDING
        // TOTAL PENDING
        // TOTAL PENDING

        return view('dashboard.profile.index')
                    ->withPositions($positions)
                    ->withBranches($branches)
                    ->withMember($member)
                    ->withPendingfordashboard($pendingfordashboard)
                    ->withApprovedfordashboard($approvedfordashboard)
                    ->withPendingcountdashboard($pendingcountdashboard)
                    ->withApprovedcountdashboard($approvedcountdashboard)
                    ->withTotalpendingthiuser($totalpendingthiuser);
    }

    public function updateMemberProfile(Request $request, $id) 
    {
        $this->validate($request,array(
            'position_id'      =>   'required',
            'branch_id'        =>   'required',
            'present_address'  =>   'required',
            'mobile'           =>   'required',
            'email'            =>   'required',
            'image'            =>   'sometimes|image|max:250'
        ));

        $member = User::find($id);

        if($request->mobile != $member->mobile) {
            $findmobileuser = User::where('mobile', $request->mobile)->first();

            if($findmobileuser) {
                Session::flash('warning', 'দুঃখিত! মোবাইল নম্বরটি ব্যবহৃত হয়ে গেছে; আরেকটি দিন');
                if($member->id == Auth::user()->id) {
                    return redirect()->route('dashboard.profile');
                } else {
                    return redirect()->back();
                }
            }
        }
        if($request->email != $member->email) {
            $findemailuser = User::where('email', $request->email)->first();

            if($findemailuser) {
                Session::flash('warning', 'দুঃখিত! ইমেইলটি ব্যবহৃত হয়ে গেছে; আরেকটি দিন');
                if($member->id == Auth::user()->id) {
                    return redirect()->route('dashboard.profile');
                } else {
                    return redirect()->back();
                }
            }
        }

        // check if any data is changed...
        if((Auth::user()->position_id == $request->position_id) && (Auth::user()->branch_id == $request->branch_id) && (Auth::user()->present_address == $request->present_address) && (Auth::user()->mobile == $request->mobile) && (Auth::user()->email == $request->email) && !$request->hasFile('image')) {
            Session::flash('info', 'আপনি কোন তথ্য পরিবর্তন করেননি!');
            return redirect()->route('dashboard.profile');
        }

        // update data accordign to role...
        if(Auth::user()->role != 'admin') {
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

            Session::flash('success', 'আপনার তথ্য পরিবর্তন অনুরোধ সফলভাবে করা হয়েছে। আমাদের একজন প্রতিনিধি তা অনুমোদন করবেন। ধন্যবাদ।');
            return redirect()->route('dashboard.profile');
        } else {
            $member->position_id = $request->position_id;
            $member->branch_id = $request->branch_id;
            $member->present_address = $request->present_address;
            $member->mobile = $request->mobile;
            $member->email = $request->email;

            // applicant's temp image upload
            if($request->hasFile('image')) {
                $old_img = public_path('images/users/'. $member->image);
                if(File::exists($old_img)) {
                    File::delete($old_img);
                }
                $image      = $request->file('image');
                $filename   = str_replace(' ','',$member->name).time() .'.' . $image->getClientOriginalExtension();
                $location   = public_path('/images/users/'. $filename);
                Image::make($image)->resize(200, 200)->save($location);
                $member->image = $filename;
            }
            $member->save();

            Session::flash('success', 'সফলভাবে হালনাগাদ করা হয়েছে!');
            return redirect()->back();
        }
    }

    public function getMembersUpdateRequests() 
    {
        $tempmemdatas = Tempmemdata::orderBy('id', 'desc')->paginate(10);

        return view('dashboard.membership.membersupdaterequests')
                    ->withTempmemdatas($tempmemdatas);
    }

    public function approveUpdateRequest(Request $request) 
    {
        $tempmemdata = Tempmemdata::where('id', $request->tempmemdata_id)->first();
        $member = User::where('id', $request->user_id)->first();

        $member->position_id = $tempmemdata->position_id;
        $member->branch_id = $tempmemdata->branch_id;
        $member->present_address = $tempmemdata->present_address;
        $member->mobile = $tempmemdata->mobile;
        $member->email = $tempmemdata->email;

        // applicant's temp image upload
        if($tempmemdata->image != '') {
            $old_img = public_path('images/users/'. $member->image);
            if(File::exists($old_img)) {
                File::delete($old_img);
            }
            $member->image = $tempmemdata->image;
        }
        $member->save();

        $tempmemdata->delete();


        // send sms
        $mobile_number = 0;
        if(strlen($member->mobile) == 11) {
            $mobile_number = $member->mobile;
        } elseif(strlen($member->mobile) > 11) {
            if (strpos($member->mobile, '+') !== false) {
                $mobile_number = substr($member->mobile, -11);
            }
        }
        // $url = config('sms.url');
        // $number = $mobile_number;
        $text = 'Dear ' . $member->name . ', your information changing request has been approved! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
        // this sms costs 2 SMS
        
        // NEW PANEL
        $url = config('sms.url2');
        $api_key = config('sms.api_key');
        $senderid = config('sms.senderid');
        $number = $mobile_number;
        $message = $text;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonresponse = json_decode($response);

        if($jsonresponse->response_code == 202) {
            Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } elseif($jsonresponse->response_code == 1007) {
            Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }
        // NEW PANEL


        // $data= array(
        //     'username'=>config('sms.username'),
        //     'password'=>config('sms.password'),
        //     'number'=>"$number",
        //     'message'=>"$text",
        // );

        // // initialize send status
        // $ch = curl_init(); // Initialize cURL
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        // $smsresult = curl_exec($ch);

        // $p = explode("|",$smsresult);
        // $sendstatus = $p[0];
        // // send sms
        // if($sendstatus == 1101) {
        //     Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
        // } elseif($sendstatus == 1006) {
        //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        // } else {
        //     Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        // }

        Session::flash('success', 'সফলভাবে হালনাগাদ করা হয়েছে!');
        return redirect()->route('dashboard.membersupdaterequests');
    }

    public function deleteUpdateRequest($id) 
    {
        $tempmemdata = Tempmemdata::find($id);
        $image_path = public_path('images/users/'. $tempmemdata->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $tempmemdata->delete();

        Session::flash('success', 'সফলভাবে ডিলেট করে দেওয়া হয়েছে!');
        return redirect()->route('dashboard.membersupdaterequests');
    }

    public function getMemberChangePassword() 
    {
        return view('dashboard.profile.changepassword');
    }

    public function memberChangePassword(Request $request) 
    {
        $this->validate($request,array(
            'oldpassword'        =>   'required',
            'newpassword'        =>   'required|min:8',
            'againnewpassword'   =>   'required|same:newpassword'
        ));

        $member = User::find(Auth::user()->id);

        if (Hash::check($request->oldpassword, $member->password)) {
            $member->password = Hash::make($request->newpassword);
            $member->save();
            Session::flash('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
            return redirect()->route('dashboard.profile');
        } else {
            Session::flash('warning', 'পুরোনো পাসওয়ার্ডটি সঠিক নয়!');
            return redirect()->route('dashboard.member.getchangepassword');
        }
    }

    public function getPaymentPage() 
    {
        $payments = Payment::where('member_id', Auth::user()->member_id)
                           ->where('is_archieved', 0)
                           ->orderBy('id', 'desc')
                           ->paginate(10);
        $members = User::all();

        return view('dashboard.profile.payment')
                    ->withPayments($payments)
                    ->withMembers($members);
    }

    public function getSelfPaymentPage() 
    {
        return view('dashboard.profile.selfpayment');
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
        if(strlen(Auth::user()->mobile) == 11) {
            $mobile_number = Auth::user()->mobile;
        } elseif(strlen(Auth::user()->mobile) > 11) {
            if (strpos(Auth::user()->mobile, '+') !== false) {
                $mobile_number = substr(Auth::user()->mobile, -11);
            }
        }
        // $url = config('sms.url');
        // $number = $mobile_number;
        $text = 'Dear ' . Auth::user()->name . ', payment of tk. '. $request->amount .' is submitted successfully. We will notify you once we approve it. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
        
        // NEW PANEL
        $url = config('sms.url2');
        $api_key = config('sms.api_key');
        $senderid = config('sms.senderid');
        $number = $mobile_number;
        $message = $text;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonresponse = json_decode($response);

        if($jsonresponse->response_code == 202) {
            // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } elseif($jsonresponse->response_code == 1007) {
            // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }
        // NEW PANEL

        // $data= array(
        //     'username'=>config('sms.username'),
        //     'password'=>config('sms.password'),
        //     'number'=>"$number",
        //     'message'=>"$text"
        // );
        // // initialize send status
        // $ch = curl_init(); // Initialize cURL
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        // $smsresult = curl_exec($ch);

        // // $sendstatus = $result = substr($smsresult, 0, 3);
        // $p = explode("|",$smsresult);
        // $sendstatus = $p[0];
        // // send sms
        // if($sendstatus == 1101) {
        //     // Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
        // } elseif($sendstatus == 1006) {
        //     // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        // } else {
        //     // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        // }
        
        Session::flash('success', 'পরিশোধ সফলভাবে দাখিল করা হয়েছে!');
        return redirect()->route('dashboard.memberpayment');
    }

    public function getSelfPaymentOnlinePage() 
    {
        return view('dashboard.profile.onlinepayment');
    }

    public function nextSelfPaymentOnline(Request $request) 
    {
        $this->validate($request,array(
            'member_id'   =>   'required',
            'amount'      =>   'required|integer',
        ));

        $member = User::where('member_id', $request->member_id)->first();
        $trxid = 'CVCS' . strtotime('now') . random_string(5);

        $temppayment = new Temppayment;
        $temppayment->member_id = $member->member_id; // IN CASE OF SINGLE, THIS WILL BE THE MEMBER'S MEMBER_ID
        $temppayment->trxid = $trxid;
        $temppayment->amount = $request->amount + (ceil($request->amount * 0.0170));
        $temppayment->payment_type = 1; // 1 == single, 2 == bulk, 3 == registration
        $temppayment->save();

        return view('dashboard.profile.nextpaymentpage')
                    ->withTrxid($trxid)
                    ->withMember($member)
                    ->withAmount($temppayment->amount);
    }

    public function paymentSuccessOrFailed(Request $request)
    {
        // dd($request->all());
        $member_id = $request->get('opt_a');
        
        if($request->get('pay_status') == 'Failed') {
            Session::flash('info', 'পেমেন্ট সম্পন্ন হয়নি, আবার চেষ্টা করুন!');
            return redirect(Route('dashboard.memberpaymentselfonline'));
        }
        
        $amount_request = $request->get('opt_b');
        $amount_paid = $request->get('amount');
        
        if($amount_paid == $amount_request)
        {
            $member = User::where('member_id', $member_id)->first();

            $checkpayment = Payment::where('payment_key', $request->get('mer_txnid'))
                                   ->where('member_id', $member->member_id)
                                   ->where('payment_type', 1) // single payment, if 2 then bulk payment
                                   ->where('amount', round($amount_paid - ($amount_paid * 0.0167158308751)))
                                   ->first();

            if(!empty($checkpayment) || ($checkpayment != null)) {
                // DELETE TEMPPAYMENT
                $temppayment = Temppayment::where('trxid', $request->get('mer_txnid'))->first();
                $temppayment->delete();
                // DELETE TEMPPAYMENT
            } else {
                // SAVE THE PAYMENT
                $payment = new Payment;
                $payment->member_id = $member->member_id;
                $payment->payer_id = $member->member_id;
                $payment->amount = round($amount_paid - ($amount_paid * 0.0167158308751));
                $payment->bank = 'aamarPay Payment Gateway';
                $payment->branch = 'N/A';
                $payment->pay_slip = '00';
                $payment->payment_status = 1; // IN THIS CASE, PAYMENT IS APPROVED
                $payment->payment_category = 1; // monthly payment, if 0 then membership payment
                $payment->payment_type = 1; // single payment, if 2 then bulk payment
                $payment->payment_method = 1; //IF NULL THEN OFFLINE, IF 1 THEN ONLINE
                $payment->card_type = $request->get('card_type');
                $payment->payment_key = $request->get('mer_txnid'); // SAME TRXID FOR BOTH METHOD
                $payment->save();

                // DELETE TEMPPAYMENT
                $temppayment = Temppayment::where('trxid', $request->get('mer_txnid'))->first();
                $temppayment->delete();
                // DELETE TEMPPAYMENT

                // send sms
                $mobile_number = 0;
                if(strlen($payment->user->mobile) == 11) {
                    $mobile_number = $payment->user->mobile;
                } elseif(strlen($payment->user->mobile) > 11) {
                    if (strpos($payment->user->mobile, '+') !== false) {
                        $mobile_number = substr($payment->user->mobile, -11);
                    }
                }
                // $url = config('sms.url');
                // $number = $mobile_number;
                $text = 'Dear ' . $payment->user->name . ', payment of tk. '. $payment->amount .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                
                // NEW PANEL
                $url = config('sms.url2');
                $api_key = config('sms.api_key');
                $senderid = config('sms.senderid');
                $number = $mobile_number;
                $message = $text;

                $data = [
                    "api_key" => $api_key,
                    "senderid" => $senderid,
                    "number" => $number,
                    "message" => $message,
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                $jsonresponse = json_decode($response);

                if($jsonresponse->response_code == 202) {
                    // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
                } elseif($jsonresponse->response_code == 1007) {
                    // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
                } else {
                    // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
                }
                // NEW PANEL
            }

            

            // $data= array(
            //     'username'=>config('sms.username'),
            //     'password'=>config('sms.password'),
            //     'number'=>"$number",
            //     'message'=>"$text",
            // );
            // // initialize send status
            // $ch = curl_init(); // Initialize cURL
            // curl_setopt($ch, CURLOPT_URL,$url);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
            // $smsresult = curl_exec($ch);

            // // $sendstatus = $result = substr($smsresult, 0, 3);
            // $p = explode("|",$smsresult);
            // $sendstatus = $p[0];
            // // send sms
            // if($sendstatus == 1101) {
            //     // Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
            // } elseif($sendstatus == 1006) {
            //     // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
            // } else {
            //     // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
            // }
            // SAVE THE PAYMENT
            Session::flash('success','আপনার পেমেন্ট সফল হয়েছে!');
        } else {
            // Something went wrong.
            Session::flash('info', 'Something went wrong, please reload this page!');
            return redirect(Route('dashboard.memberpaymentselfonline'));
        }
        
        if(Auth::guest()) {
            return redirect()->route('index.index');
        } else {
            return redirect()->route('dashboard.memberpayment');
        }
    }

    public function curlAamarpay($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function paymentVerification()
    {
        // $temppayments = Temppayment::all();
        $temppayments = Temppayment::inRandomOrder()->limit(3)->get();
        // dd($temppayments);
        foreach ($temppayments as $temppayment)
        {
            $store_id = config('aamarpay.store_id');
            $signature_key = config('aamarpay.signature_key');
            $api = "https://secure.aamarpay.com/api/v1/trxcheck/request.php?request_id=" . $temppayment->trxid . "&store_id=" . $store_id . "&signature_key=" . $signature_key . "&type=json";
            // $api = "https://secure.aamarpay.com/api/v1/trxcheck/request.php?request_id=CVCS1613278705VDXQ6&store_id=cvcsbd&signature_key=4cde6ff3e7816ac461447af66baca194&type=json";
            // http://secure.aamarpay.com/api/v1/trxcheck/request.php?request_id=TGA2020D00465350&store_id=sererl&signature_key=4cde6ff3e7816ac461447af66baca194&type=json

            $reply_json = $this->curlAamarpay($api);
            $decode_reply = json_decode($reply_json, true);
            // dd($reply_json);
            if(!empty($decode_reply['pay_status']) || isset($decode_reply['pay_status'])) {
                $pay_status = $decode_reply['pay_status'];
            } else {
                $pay_status = '';
            }
            if($pay_status == 'Successful')
            {
                if($temppayment->payment_type == 1) {
                    // SINGLE PAYMENT CODE
                    // INSERT NEW DATA
                    $member = User::where('member_id', $temppayment->member_id)->first();

                    // check payment
                    // check payment
                    $checkpayment = Payment::where('payment_key', $decode_reply['mer_txnid'])
                                           ->where('member_id', $member->member_id)
                                           ->where('payment_type', $temppayment->payment_type)
                                           ->where('amount', round($temppayment->amount - ($temppayment->amount * 0.0167158308751)))
                                           ->first();

                    if(!empty($checkpayment) || ($checkpayment != null)) {
                        
                        // dd($checkpayment);
                        // if($decode_reply['store_id'] == 'cvcsbd' && $temppayment->tried > 2) {
                        $temppayment->delete();
                        // if($temppayment->tried > 3) {
                        //     $temppayment->delete();
                        // } else {
                        //     $temppayment->tried++;
                        //     $temppayment->save();
                        // }
                    } else {
                        $payment = new Payment;
                        $payment->member_id = $member->member_id;
                        $payment->payer_id = $member->member_id;
                        $payment->amount = round($temppayment->amount - ($temppayment->amount * 0.0167158308751));
                        // DELETE TEMPPAYMENT
                        $temppayment->delete();
                        $payment->bank = 'aamarPay Payment Gateway';
                        $payment->branch = 'N/A';
                        $payment->pay_slip = '00';
                        $payment->payment_status = 1; // IN THIS CASE, PAYMENT IS APPROVED
                        $payment->payment_category = 1; // monthly payment, if 0 then membership payment
                        $payment->payment_type = 1; // single payment, if 2 then bulk payment
                        $payment->payment_method = 1; //IF NULL THEN OFFLINE, IF 1 THEN ONLINE
                        $payment->card_type = $decode_reply['payment_type']; // card_type
                        $payment->payment_key = $decode_reply['mer_txnid']; // SAME TRXID FOR BOTH METHOD
                        $payment->save();

                        // send sms
                        $mobile_number = 0;
                        if(strlen($payment->user->mobile) == 11) {
                            $mobile_number = $payment->user->mobile;
                        } elseif(strlen($payment->user->mobile) > 11) {
                            if (strpos($payment->user->mobile, '+') !== false) {
                                $mobile_number = substr($payment->user->mobile, -11);
                            }
                        }

                        // $url = config('sms.url');
                        // $number = $mobile_number;
                        $text = 'Dear ' . $payment->user->name . ', payment of tk. '. $payment->amount .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                        
                        // NEW PANEL
                        $url = config('sms.url2');
                        $api_key = config('sms.api_key');
                        $senderid = config('sms.senderid');
                        $number = $mobile_number;
                        $message = $text;

                        $data = [
                            "api_key" => $api_key,
                            "senderid" => $senderid,
                            "number" => $number,
                            "message" => $message,
                        ];
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        $jsonresponse = json_decode($response);

                        if($jsonresponse->response_code == 202) {
                            // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
                        } elseif($jsonresponse->response_code == 1007) {
                            // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
                        } else {
                            // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
                        }
                        // NEW PANEL
                        // dd($payment);
                        // $data= array(
                        //     'username'=>config('sms.username'),
                        //     'password'=>config('sms.password'),
                        //     'number'=>"$number",
                        //     'message'=>"$text",
                        // );
                        // // initialize send status
                        // $ch = curl_init(); // Initialize cURL
                        // curl_setopt($ch, CURLOPT_URL,$url);
                        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
                        // $smsresult = curl_exec($ch);

                        // // $sendstatus = $result = substr($smsresult, 0, 3);
                        // $p = explode("|",$smsresult);
                        // $sendstatus = $p[0];
                        // send sms                        
                    }

                    // SINGLE PAYMENT CODE
                } elseif ($temppayment->payment_type == 2) {
                    // BULK PAYMENT CODE
                    // dd($request->all());
                    $payers = (explode(",",$temppayment->bulkdata));

                    // NEW PANEL
                    $url = "http://bulksmsbd.net/api/smsapimany";
                    $api_key = config('sms.api_key');
                    $senderid = config('sms.senderid');
                    
                    $usersarraystosend = [];
                    foreach($payers as $index => $payer) {
                        $payerdata = (explode(":", $payer));
                        // [0] = memebr_id, [1] = mobile, [2] = amount
                        // [0] = memebr_id, [1] = mobile, [2] = amount

                        // check payment
                        $checkpayment = Payment::where('payment_key', $decode_reply['mer_txnid'])
                                               ->where('member_id', $payerdata[0])
                                               ->where('amount', $payerdata[2])
                                               ->first();
                        $payer_member_id = $temppayment->member_id;                 
                        if(!empty($checkpayment) || ($checkpayment != null)) {
                            // dd($checkpayment);
                            // if($decode_reply['store_id'] == 'cvcsbd' && $temppayment->tried > 2) {
                            if($decode_reply['store_id'] == 'cvcsbd' && $temppayment->tried > 3) {
                                $temppayment->delete();
                            } else {
                                $temppayment->tried++;
                                $temppayment->save();
                            }
                        } else {
                          $payment = new Payment;
                          $payment->member_id = $payerdata[0];
                          $payment->payer_id = $payer_member_id; // payers member_id
                          $payment->amount = $payerdata[2];
                          $payment->bank = 'aamarPay Payment Gateway';
                          $payment->branch = 'N/A';
                          $payment->pay_slip = '00';
                          $payment->payment_status = 1; // approved
                          $payment->payment_category = 1; // monthly payment
                          $payment->payment_type = 2; // bulk payment
                          $payment->payment_method = 1; //IF NULL THEN OFFLINE, IF 1 THEN ONLINE
                          $payment->card_type = $decode_reply['payment_type']; // card_type
                          $payment->payment_key = $decode_reply['mer_txnid']; // SAME TRXID FOR BOTH METHOD
                          $payment->save();


                          // input member SMS into array
                          $member = User::where('member_id', $payerdata[0])->first();
                          $text = 'Dear ' . $member->name . ', payment of tk. '. $payerdata[2] .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';

                          $usersarraystosend[$index]['to'] = $payerdata[1];
                          $usersarraystosend[$index]['message'] = $text;
                           
                        }
                    }

                    // DELETE TEMPPAYMENT
                    $temppayment->delete();

                    $messages = json_encode($usersarraystosend);

                    $data = [
                        "api_key" => $api_key,
                        "senderid" => $senderid,
                        "messages" => $messages
                    ];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    // return $response;
                    // NEW PANEL

                    // INSERT DATA TO DATABASE
                    // INSERT DATA TO DATABASE

                    // partial SMS data
                    // $smssuccesscount = 0;
                    // // $url = config('sms.url');
                    
                    // $multiCurl = array();
                    // // data to be returned
                    // $result = array();
                    // // multi handle
                    // $mh = curl_multi_init();
                    // // sms data
                    // $smsdata = [];
                    // // partial SMS data

                    // foreach ($payers as $payer)
                    // {
                    //     $payerdata = (explode(":",$payer));
                    //     // [0] = memebr_id, [1] = mobile, [2] = amount
                    //     // [0] = memebr_id, [1] = mobile, [2] = amount

                    //     // check payment
                    //     // check payment
                    //     $checkpayment = Payment::where('payment_key', $decode_reply['mer_txnid'])
                    //                            ->where('member_id', $payerdata[0])
                    //                            ->where('amount', $payerdata[2])
                    //                            ->first();
                    //     // dd($checkpayment);
                                            
                    //     if(!empty($checkpayment) || ($checkpayment != null)) {
                    //         // dd($checkpayment);
                    //         // if($decode_reply['store_id'] == 'cvcsbd' && $temppayment->tried > 2) {
                    //         if($decode_reply['store_id'] == 'cvcsbd' && $temppayment->tried > 3) {
                    //             $temppayment->delete();
                    //         } else {
                    //             $temppayment->tried++;
                    //             $temppayment->save();
                    //         }
                    //     } else {
                    //       $payment = new Payment;
                    //       $payment->member_id = $payerdata[0];
                    //       $payment->payer_id = $temppayment->member_id; // payers member_id
                    //       $payment->amount = $payerdata[2];
                    //       $payment->bank = 'aamarPay Payment Gateway';
                    //       $payment->branch = 'N/A';
                    //       $payment->pay_slip = '00';
                    //       $payment->payment_status = 1; // approved
                    //       $payment->payment_category = 1; // monthly payment
                    //       $payment->payment_type = 2; // bulk payment
                    //       $payment->payment_method = 1; //IF NULL THEN OFFLINE, IF 1 THEN ONLINE
                    //       $payment->card_type = $decode_reply['payment_type']; // card_type
                    //       $payment->payment_key = $decode_reply['mer_txnid']; // SAME TRXID FOR BOTH METHOD
                    //       $payment->save();


                    //       // input member SMS into array
                    //       // input member SMS into array
                    //       $member = User::where('member_id', $payerdata[0])->first();
                    //       $mobile_number = $payerdata[1];

                    //       $text = 'Dear ' . $member->name . ', payment of tk. '. $payerdata[2] .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                    //       $smsdata[$payerdata[0]] = array(
                    //           'username'=>config('sms.username'),
                    //           'password'=>config('sms.password'),
                    //           'number'=>"$mobile_number",
                    //           'message'=>"$text",
                    //       );
                    //       $multiCurl[$payerdata[0]] = curl_init(); // Initialize cURL
                    //       curl_setopt($multiCurl[$payerdata[0]], CURLOPT_URL, $url);
                    //       curl_setopt($multiCurl[$payerdata[0]], CURLOPT_HEADER, 0);
                    //       curl_setopt($multiCurl[$payerdata[0]], CURLOPT_POSTFIELDS, http_build_query($smsdata[$payerdata[0]]));
                    //       curl_setopt($multiCurl[$payerdata[0]], CURLOPT_RETURNTRANSFER, 1);
                    //       curl_setopt($multiCurl[$payerdata[0]], CURLOPT_SSL_VERIFYPEER, false); // this is important
                    //       curl_multi_add_handle($mh, $multiCurl[$payerdata[0]]);
                    //       // input member SMS into array
                    //       // input member SMS into array  
                    //     }
                    // }

                    // // partial SMS data
                    // $index=null;
                    // do {
                    //   curl_multi_exec($mh, $index);
                    // } while($index > 0);
                    // // get content and remove handles
                    // foreach($multiCurl as $k => $ch) {
                    //   $result[$k] = curl_multi_getcontent($ch);
                    //   curl_multi_remove_handle($mh, $ch);
                    //   $smsresult = $result[$k];
                    //   $p = explode("|",$smsresult);
                    //   $sendstatus = $p[0];
                    //   if($sendstatus == 1101) {
                    //       $smssuccesscount++;
                    //   }
                    // }
                    // // close
                    // curl_multi_close($mh);
                    // // partial SMS data

                    // INSERT DATA TO DATABASE
                    // INSERT DATA TO DATABASE
                    
                    // BULK PAYMENT CODE
                } elseif ($temppayment->payment_type == 3) {
                    // REGISTRATION PAYMENT CODE
                    // INSERT NEW DATA
                    $member = User::find($temppayment->member_id);
                    $member->payment_status = 'Paid';
                    $member->save();

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
                    $text = 'Dear ' . $member->name . ', payment of tk. '. $temppayment->amount .' is received successfully, TrxID: ' . $member->trxid . '. Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                    
                    // NEW PANEL
                    $url = config('sms.url2');
                    $api_key = config('sms.api_key');
                    $senderid = config('sms.senderid');
                    $number = $mobile_number;
                    $message = $text;

                    $data = [
                        "api_key" => $api_key,
                        "senderid" => $senderid,
                        "number" => $number,
                        "message" => $message,
                    ];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $jsonresponse = json_decode($response);

                    if($jsonresponse->response_code == 202) {
                        // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
                    } elseif($jsonresponse->response_code == 1007) {
                        // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
                    } else {
                        // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
                    }
                    // NEW PANEL

                    // $data= array(
                    //     'username'=>config('sms.username'),
                    //     'password'=>config('sms.password'),
                    //     'number'=>"$number",
                    //     'message'=>"$text",
                    // );
                    // // initialize send status
                    // $ch = curl_init(); // Initialize cURL
                    // curl_setopt($ch, CURLOPT_URL,$url);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
                    // $smsresult = curl_exec($ch);

                    // // $sendstatus = $result = substr($smsresult, 0, 3);
                    // $p = explode("|",$smsresult);
                    // $sendstatus = $p[0];
                    // send sms

                    // DELETE TEMPPAYMENT
                    $temppayment->delete();
                    // REGISTRATION PAYMENT CODE
                }

                // Session::flash('info', 'Deleted!');
                // return redirect(Route('dashboard.memberpaymentselfonline'));
                // echo 'success' . '<br/>';
            } else {
                // DELETE PORE KORANO HOBE, AAGE CHECK KORTE THAKUK...
                // $temppayment->delete();
                // echo $decode_reply['store_id'] . '<br/>';
                // dd($temppayment);
                // CHECK FROM AAMARPAY AND INCREMENT TO TWICE HERE
                // if($decode_reply['store_id'] == 'cvcsbd' && $temppayment->tried > 2) {
                if($temppayment->tried > 3) {
                    $temppayment->delete();
                } else {
                    $temppayment->tried++;
                    $temppayment->save();
                }
            }
        }
        
    }

    public function paymentVerificationCheckTotal()
    {
        $totalamount = DB::table('payments')
                         ->select(DB::raw('SUM(amount) as totalamount'))
                         ->where('bank', 'aamarPay Payment Gateway')
                         ->where('payment_status', 1)
                         ->where('is_archieved', 0)
                         ->first();

        dd($totalamount->totalamount);                
        return $totalamount->totalamount;
    }

    public function paymentCancelledPost(Request $request)
    {
        $member_id = $request->get('opt_a');
        
        if($request->get('pay_status') == 'Failed') {
            Session::flash('info', 'Something went wrong, please try again!');
            return redirect(Route('dashboard.memberpaymentselfonline'));
        }
        
        $amount_request = $request->get('opt_b');
        $amount_paid = $request->get('amount');
        
        if($amount_paid == $amount_request)
        {
          $member = User::where('member_id', $member_id)->first();

          // SAVE THE PAYMENT
          $payment = new Payment;
          $payment->member_id = $member->member_id;
          $payment->payer_id = $member->member_id;
          $payment->amount = round($amount_paid - ($amount_paid * 0.0167158308751));
          $payment->bank = 'aamarPay Payment Gateway';
          $payment->branch = 'N/A';
          $payment->pay_slip = '00';
          $payment->payment_status = 1; // IN THIS CASE, PAYMENT IS APPROVED
          $payment->payment_category = 1; // monthly payment, if 0 then membership payment
          $payment->payment_type = 1; // single payment, if 2 then bulk payment
          $payment->payment_method = 1; //IF NULL THEN OFFLINE, IF 1 THEN ONLINE
          $payment->card_type = $request->get('card_type');
          $payment->payment_key = $request->get('mer_txnid'); // SAME TRXID FOR BOTH METHOD
          $payment->save();

          // send sms
          $mobile_number = 0;
          if(strlen($payment->user->mobile) == 11) {
              $mobile_number = $payment->user->mobile;
          } elseif(strlen($payment->user->mobile) > 11) {
              if (strpos($payment->user->mobile, '+') !== false) {
                  $mobile_number = substr($payment->user->mobile, -11);
              }
          }
          // $url = config('sms.url');
          // $number = $mobile_number;
          $text = 'Dear ' . $payment->user->name . ', payment of tk. '. $payment->amount .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
          
          // NEW PANEL
          $url = config('sms.url2');
          $api_key = config('sms.api_key');
          $senderid = config('sms.senderid');
          $number = $mobile_number;
          $message = $text;

          $data = [
              "api_key" => $api_key,
              "senderid" => $senderid,
              "number" => $number,
              "message" => $message,
          ];
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          $response = curl_exec($ch);
          curl_close($ch);
          $jsonresponse = json_decode($response);

          if($jsonresponse->response_code == 202) {
              // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
          } elseif($jsonresponse->response_code == 1007) {
              // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
          } else {
              // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
          }
          // NEW PANEL

          // $data= array(
          //     'username'=>config('sms.username'),
          //     'password'=>config('sms.password'),
          //     'number'=>"$number",
          //     'message'=>"$text",
          // );
          // // initialize send status
          // $ch = curl_init(); // Initialize cURL
          // curl_setopt($ch, CURLOPT_URL,$url);
          // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
          // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
          // $smsresult = curl_exec($ch);

          // // $sendstatus = $result = substr($smsresult, 0, 3);
          // $p = explode("|",$smsresult);
          // $sendstatus = $p[0];
          // // send sms
          // if($sendstatus == 1101) {
          //     Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
          // } elseif($sendstatus == 1006) {
          //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
          // } else {
          //     Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
          // }
          // SAVE THE PAYMENT
          Session::flash('success','আপনার পেমেন্ট সফল হয়েছে!');
        } else {
           // Something went wrong.
          Session::flash('info', 'Something went wrong, please try again!');
          return redirect(Route('dashboard.memberpaymentselfonline'));
        }
        
        //return $request->all();
        return redirect(Route('dashboard.memberpayment'));
    }

    public function paymentCancelled()
    {
        Session::flash('info','Payment is cancelled!');
        return redirect()->route('dashboard.memberpaymentselfonline');
    }

    public function downloadMemberPaymentPDF(Request $request)
    {
        $this->validate($request,array(
            'id'              =>   'required',
            'payment_key'     =>   'required'
        ));

        $payment = Payment::where('id', $request->id)
                          ->where('payment_key', $request->payment_key)
                          ->first();

        $pdf = PDF::loadView('dashboard.profile.pdf.paymentreportsingle', ['payment' => $payment]);
        $fileName = 'Payment_Report_'. Auth::user()->member_id .'_'. $payment->payment_key .'.pdf';
        return $pdf->download($fileName);
    }

    public function downloadMemberCompletePDF(Request $request)
    {
        $this->validate($request,array(
            'id'            =>   'required',
            'member_id'     =>   'required'
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

        $pdf = PDF::loadView('dashboard.profile.pdf.completereport', ['payments' => $payments, 'member' => $member, 'pendingfordashboard' => $pendingfordashboard, 'approvedfordashboard' => $approvedfordashboard, 'pendingcountdashboard' => $pendingcountdashboard, 'approvedcountdashboard' => $approvedcountdashboard, 'totalmontlypaid' => $totalmontlypaid]);
        $fileName = str_replace(' ', '_', $member->name).'_'. $member->member_id .'.pdf';
        return $pdf->download($fileName);
    }

    public function getMemberTransactionSummary() 
    {
        $membertotalpending = DB::table('payments')
                                ->select(DB::raw('SUM(amount) as totalamount'))
                                ->where('member_id', Auth::user()->member_id)
                                ->where('payment_status', 0)
                                ->where('is_archieved', 0)
                                // ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                                // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                                ->first();

        $membertotalapproved = DB::table('payments')
                                 ->select(DB::raw('SUM(amount) as totalamount'))
                                 ->where('member_id', Auth::user()->member_id)
                                 ->where('payment_status', '=', 1)
                                 ->where('is_archieved', '=', 0)
                                 // ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                                 // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                                 ->first();
        $membertotalmontlypaid = DB::table('payments')
                                 ->select(DB::raw('SUM(amount) as totalamount'))
                                 ->where('payment_status', 1)
                                 ->where('is_archieved', 0)
                                 ->where('payment_category', 1) // 1 means monthly, 0 for membership
                                 ->where('member_id', Auth::user()->member_id)
                                 ->first();

        return view('dashboard.profile.transactionsummary')
                        ->withMembertotalpending($membertotalpending)
                        ->withMembertotalapproved($membertotalapproved)
                        ->withMembertotalmontlypaid($membertotalmontlypaid);
    }

    public function getMemberUserManual() 
    {
        return view('dashboard.profile.usermanual');
    }

    public function getBulkPaymentPage() 
    {
        // dd(Auth::user()->branch->id);
        $branch = Branch::find(Auth::user()->branch->id);
        $members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')
                       ->where('branch_id', Auth::user()->branch->id)
                       ->orderBy('id', 'desc')
                       ->get();
        return view('dashboard.adminsandothers.bulkpayment')
                            ->withBranch($branch)
                            ->withMembers($members);
    }

    public function getBulkPaymentPageFromBranch($branch_id) 
    {
        $branch = Branch::find($branch_id);
        $members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')
                       ->where('branch_id', $branch_id)
                       ->orderBy('id', 'desc')
                       ->get();
        return view('dashboard.adminsandothers.bulkpayment')
                            ->withBranch($branch)
                            ->withMembers($members);
    }

    public function storeBulkPayment(Request $request) 
    {
        if($request->payment_method == 'offline') {
            // OFFLINE TRANSACTION
            // OFFLINE TRANSACTION
            $this->validate($request,array(
                'amountoffline'      =>   'required|integer',
                'bank'        =>   'required',
                'branch'      =>   'required',
                'pay_slip'    =>   'required',
                'image1'      =>   'required|image|max:500',
                'image2'      =>   'sometimes|image|max:500',
                'image3'      =>   'sometimes|image|max:500'
            ));

            // dd($request->all());
            $payment = new Payment;
            $payment->member_id = Auth::user()->member_id;
            $payment->payer_id = Auth::user()->member_id;
            $payment->amount = $request->amountoffline;
            $payment->bank = $request->bank;
            $payment->branch = $request->branch;
            $payment->pay_slip = $request->pay_slip;
            $payment->payment_status = 0;
            $payment->payment_category = 1; // monthly payment
            $payment->payment_type = 2; // bulk payment
            // generate payment_key
            $payment_key_length = 10;
            $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $payment_key = substr(str_shuffle(str_repeat($pool, 10)), 0, $payment_key_length);
            // generate payment_key
            $payment->payment_key = $payment_key;

            // storing bulk ids and amounts
            $amountids = $request->amountids;
            $amount_id = [];
            foreach ($amountids as $amountid) {
                $amount_id[$amountid] = $request['amount'.$amountid];
            }
            $payment->bulk_payment_member_ids = json_encode($amount_id);

            $payment->save();

            // receipt upload
            for($itrt=1; $itrt<4;$itrt++) {
                if($request->hasFile('image'.$itrt)) {
                    $receipt      = $request->file('image'.$itrt);
                    $filename   = $payment->member_id . $itrt . '_receipt_' . time() .'.' . $receipt->getClientOriginalExtension();
                    $location   = public_path('/images/receipts/'. $filename);
                    Image::make($receipt)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
                    $paymentreceipt = new Paymentreceipt;
                    $paymentreceipt->payment_id = $payment->id;
                    $paymentreceipt->image = $filename;
                    $paymentreceipt->save();
                }
            }


            // NEW PANEL
            $url = "http://bulksmsbd.net/api/smsapimany";
            $api_key = config('sms.api_key');
            $senderid = config('sms.senderid');
            
            $members = User::whereIn('member_id', $amountids)->get();
            $usersarraystosend = [];
            foreach ($members as $i => $member) {
                $mobile_number = 0;
                if(strlen($member->mobile) == 11) {
                    $mobile_number = $member->mobile;
                } elseif(strlen($member->mobile) > 11) {
                    if (strpos($member->mobile, '+') !== false) {
                        $mobile_number = substr($member->mobile, -11);
                    }
                }

                $text = 'Dear ' . $member->name . ', a payment is submitted against your account. We will notify you further updates. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                
                $usersarraystosend[$i]['to'] = $mobile_number;
                $usersarraystosend[$i]['message'] = $text;  
            }

            $messages = json_encode($usersarraystosend);

            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "messages" => $messages
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            // return $response;
            // NEW PANEL


            // // send sms
            // // $mobile_numbers = [];
            // $smssuccesscount = 0;
            // // $url = config('sms.url');
            // // 
            // $multiCurl = array();
            // // data to be returned
            // $result = array();
            // // multi handle
            // $mh = curl_multi_init();
            // // sms data
            // $smsdata = [];

            // $members = User::whereIn('member_id', $amountids)->get();
            // foreach ($members as $i => $member) {
            //     $mobile_number = 0;
            //     if(strlen($member->mobile) == 11) {
            //         $mobile_number = $member->mobile;
            //     } elseif(strlen($member->mobile) > 11) {
            //         if (strpos($member->mobile, '+') !== false) {
            //             $mobile_number = substr($member->mobile, -11);
            //         }
            //     }
            //     // if($mobile_number != 0) {
            //     //   array_push($mobile_numbers, $mobile_number);
            //     // }
            //     $text = 'Dear ' . $member->name . ', a payment is submitted against your account. We will notify you further updates. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
            //     $smsdata[$i] = array(
            //         'username'=>config('sms.username'),
            //         'password'=>config('sms.password'),
            //         // 'apicode'=>"1",
            //         'number'=>"$mobile_number",
            //         // 'msisdn'=>"$mobile_number",
            //         // 'countrycode'=>"880",
            //         // 'cli'=>"CVCS",
            //         // 'messagetype'=>"1",
            //         'message'=>"$text",
            //         // 'messageid'=>"1"
            //     );
            //     $multiCurl[$i] = curl_init(); // Initialize cURL
            //     curl_setopt($multiCurl[$i], CURLOPT_URL, $url);
            //     curl_setopt($multiCurl[$i], CURLOPT_HEADER, 0);
            //     curl_setopt($multiCurl[$i], CURLOPT_POSTFIELDS, http_build_query($smsdata[$i]));
            //     curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($multiCurl[$i], CURLOPT_SSL_VERIFYPEER, false); // this is important
            //     curl_multi_add_handle($mh, $multiCurl[$i]);
            // }

            // $index=null;
            // do {
            //   curl_multi_exec($mh, $index);
            // } while($index > 0);
            // // get content and remove handles
            // foreach($multiCurl as $k => $ch) {
            //   $result[$k] = curl_multi_getcontent($ch);
            //   curl_multi_remove_handle($mh, $ch);
            //   // $sendstatus = substr($result[$k], 0, 3);
            //   $p = explode("|",$result[$k]);
            //   $sendstatus = $p[0];
            //   if($sendstatus == 1101) {
            //       $smssuccesscount++;
            //   }
            // }
            // // close
            // curl_multi_close($mh);
            
            Session::flash('success', 'পরিশোধ সফলভাবে দাখিল করা হয়েছে!');
            return redirect()->route('dashboard.memberpayment');
            // OFFLINE TRANSACTION
            // OFFLINE TRANSACTION
        } else {
            // ONLINE TRANSACTION
            // ONLINE TRANSACTION
            $this->validate($request,array(
                'amountonline'      =>   'required|integer'
            ));

            // storing bulk ids and amounts
            $amountidsandphn = $request->amountidsandphn; // amountids chilo aage, pore mobile number add kora hoise
            $amount_id = [];
            foreach ($amountidsandphn as $amountidandphn) {
                $amountid = substr($amountidandphn, 0, 9);
                $amount_id[] = $amountidandphn . ":" . $request['amount'.$amountid];
            }
            $bulk_payment_member_ids = implode(',', $amount_id);
            // dd($bulk_payment_member_ids);

            // TEMPPAYMENT DATA
            $trxid = 'CVCS' . strtotime('now') . random_string(5);

            $temppayment = new Temppayment;
            $temppayment->member_id = Auth::user()->member_id; // IN CASE OF BULK, THIS WILL BE PAYER'S MEMBER_ID
            $temppayment->trxid = $trxid;
            $temppayment->amount = $request->amountonline + (ceil($request->amountonline * 0.0170));
            $temppayment->payment_type = 2; // 1 == single, 2 == bulk, 3 == registration
            $temppayment->bulkdata = $bulk_payment_member_ids;
            $temppayment->save();
            // TEMPPAYMENT DATA

            return view('dashboard.adminsandothers.bulknext')
                        ->withTrxid($trxid)
                        ->withAmount($temppayment->amount)
                        ->withPaymentids($bulk_payment_member_ids);
            // ONLINE TRANSACTION
            // ONLINE TRANSACTION
        }
        
    }

    public function searchMemberForBulkPaymentAPI(Request $request)
    {
        $response = User::select('name_bangla', 'member_id', 'mobile', 'position_id', 'joining_date')
                        ->where('activation_status', 1)
                        ->where('role_type', '!=', 'admin')
                        ->with('position')
                        ->with(['payments' => function ($query) {
                            $query->orderBy('created_at', 'desc');
                            $query->where('payment_status', '=', 1);
                            $query->where('is_archieved', '=', 0);
                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                        }]) 
                        ->orderBy('id', 'desc')->get();

        foreach ($response as $member) {
            $approvedcashformontly = $member->payments->sum('amount');
            $member->totalpendingmonthly = 0;
            if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
            {
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                $totalmonthsformember = $to->diffInMonths($from) + 1;
                if(($totalmonthsformember * 300) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                }
            } else {
                $startmonth = date('Y-m-', strtotime($member->joining_date));
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
                $totalmonthsformember = $to->diffInMonths($from) + 1;
                if(($totalmonthsformember * 300) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                }
            }
        }

        return $response;
    }

    public function searchMemberForBulkPaymentSingleAPI($member_id)
    {
        $response = User::select('name_bangla', 'member_id', 'mobile', 'position_id', 'joining_date')
                        ->where('activation_status', 1)
                        ->where('member_id', $member_id)
                        ->with('position')
                        ->with(['payments' => function ($query) {
                            $query->orderBy('created_at', 'desc');
                            $query->where('payment_status', '=', 1);
                            $query->where('is_archieved', '=', 0);
                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                        }]) 
                        ->first();

        $approvedcashformontly = $response->payments->sum('amount');
        $response->totalpendingmonthly = 0;
        if($response->joining_date == '' || $response->joining_date == null || strtotime('31-01-2019') > strtotime($response->joining_date))
        {
            $thismonth = Carbon::now()->format('Y-m-');
            $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
            $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
            $totalmonthsformember = $to->diffInMonths($from) + 1;
            if(($totalmonthsformember * 300) > $approvedcashformontly) {
              $response->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
            }
        } else {
            $startmonth = date('Y-m-', strtotime($response->joining_date));
            $thismonth = Carbon::now()->format('Y-m-');
            $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
            $to = Carbon::createFromFormat('Y-m-d', $thismonth . '1');
            $totalmonthsformember = $to->diffInMonths($from) + 1;
            if(($totalmonthsformember * 300) > $approvedcashformontly) {
              $response->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
            }
        }

        return $response;          
    }

    public function getMembersPendingPayments() 
    {
        $payments = Payment::where('payment_status', 0)
                           ->where('is_archieved', 0)
                           ->orderBy('id', 'desc')
                           ->paginate(10);
        $members = User::all();
        return view('dashboard.payments.pending')
                    ->withPayments($payments)
                    ->withMembers($members);
    }

    public function getMembersApprovedPayments() 
    {
        $payments = Payment::where('payment_status', 1)
                           ->where('is_archieved', 0)
                           ->orderBy('id', 'desc')
                           ->paginate(10);
        return view('dashboard.payments.approved')
                    ->withPayments($payments);
    }

    public function getMembersApprovedPaymentsAamarpay() 
    {
        $totalpaymentsaamarpay = DB::table('payments')
                                   ->select(DB::raw('SUM(amount) as totalamount'))
                                   ->where('payment_status', '=', 1)
                                   ->where('is_archieved', '=', 0)
                                   ->where('bank', 'aamarPay Payment Gateway')
                                   ->first();
        $totalmembershipaamarpay = DB::table('users')
                                   ->select(DB::raw('SUM(application_payment_amount) as totalamount'))
                                   ->where('payment_status', 'Paid')
                                   ->where('activation_status', 0)
                                   ->where('application_payment_bank', 'aamarPay Payment Gateway')
                                   ->first();

        dd($totalpaymentsaamarpay->totalamount + $totalmembershipaamarpay->totalamount);
    }

    public function getMembersDisputedPayments() 
    {
        $payments = Payment::where('payment_status', 2) // 2 Means Disputed
                           ->where('is_archieved', 0)
                           ->orderBy('id', 'desc')
                           ->paginate(10);
        return view('dashboard.payments.disputed')
                    ->withPayments($payments);
    }

    public function approveSinglePayment(Request $request, $id) 
    {
        $payment = Payment::find($id);

        $payment->payment_status = 1;
        $payment->save();

        // send sms
        $mobile_number = 0;
        if(strlen($payment->user->mobile) == 11) {
            $mobile_number = $payment->user->mobile;
        } elseif(strlen($payment->user->mobile) > 11) {
            if (strpos($payment->user->mobile, '+') !== false) {
                $mobile_number = substr($payment->user->mobile, -11);
            }
        }
        // $url = config('sms.url');
        // $number = $mobile_number;
        $text = 'Dear ' . $payment->user->name . ', payment of tk. '. $payment->amount .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
        
        // NEW PANEL
        $url = config('sms.url2');
        $api_key = config('sms.api_key');
        $senderid = config('sms.senderid');
        $number = $mobile_number;
        $message = $text;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonresponse = json_decode($response);

        if($jsonresponse->response_code == 202) {
            Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } elseif($jsonresponse->response_code == 1007) {
            Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }
        // NEW PANEL

        // $data= array(
        //     'username'=>config('sms.username'),
        //     'password'=>config('sms.password'),
        //     // 'apicode'=>"1",
        //     'number'=>"$number",
        //     // 'msisdn'=>"$number",
        //     // 'countrycode'=>"880",
        //     // 'cli'=>"CVCS",
        //     // 'messagetype'=>"1",
        //     'message'=>"$text",
        //     // 'messageid'=>"1"
        // );
        // // initialize send status
        // $ch = curl_init(); // Initialize cURL
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        // // $smsresult = curl_exec($ch);

        // // $sendstatus = $result = substr($smsresult, 0, 3);
        // $p = explode("|",$smsresult);
        // $sendstatus = $p[0];
        // // send sms
        // if($sendstatus == 1101) {
        //     Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
        // } elseif($sendstatus == 1006) {
        //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        // } else {
        //     Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        // }

        Session::flash('success', 'অনুমোদন সফল হয়েছে!');
        return redirect()->route('dashboard.membersapprovedpayments');
    }

    public function disputePayment(Request $request, $id) 
    {
        $payment = Payment::find($id);
        // PAYMENT STATUS 0 MEANS UNAPPROVED, 1 MEANS APPROVED, 2 MEANS DISPUTED
        // PAYMENT STATUS 0 MEANS UNAPPROVED, 1 MEANS APPROVED, 2 MEANS DISPUTED
        // PAYMENT STATUS 0 MEANS UNAPPROVED, 1 MEANS APPROVED, 2 MEANS DISPUTED
        $payment->payment_status = 2;
        // PAYMENT STATUS 0 MEANS UNAPPROVED, 1 MEANS APPROVED, 2 MEANS DISPUTED
        // PAYMENT STATUS 0 MEANS UNAPPROVED, 1 MEANS APPROVED, 2 MEANS DISPUTED
        // PAYMENT STATUS 0 MEANS UNAPPROVED, 1 MEANS APPROVED, 2 MEANS DISPUTED
        $payment->save();
        Session::flash('success', 'অনিষ্পন্ন সফল হয়েছে!');
        return redirect()->route('dashboard.memberspendingpayments');
    }

    public function approveBulkPayment(Request $request, $id) 
    {
        $bulkpayment = Payment::find($id);

        foreach(json_decode($bulkpayment->bulk_payment_member_ids) as $member_id => $amount) {
            $payment = new Payment;
            $payment->member_id = $member_id;
            $payment->payer_id = $bulkpayment->payer_id;
            $payment->amount = $amount;
            $payment->bank = $bulkpayment->bank;
            $payment->branch = $bulkpayment->branch;
            $payment->pay_slip = $bulkpayment->pay_slip;
            $payment->payment_status = 1; // approved
            $payment->payment_category = 1; // monthly payment
            $payment->payment_type = 2; // bulk payment
            $payment->payment_key = $bulkpayment->payment_key;
            $payment->save();

            // receipt upload
            if(count($bulkpayment->paymentreceipts) > 0) {
                foreach($bulkpayment->paymentreceipts as $paymentreceipt) {
                    $newpaymentreceipt = new Paymentreceipt;
                    $newpaymentreceipt->payment_id = $payment->id;
                    $newpaymentreceipt->image = $paymentreceipt->image;
                    $newpaymentreceipt->save();
                }
            }
        }

        $bulkpayment->is_archieved = 1;
        $bulkpayment->save();

        // NEW PANEL
        $url = "http://bulksmsbd.net/api/smsapimany";
        $api_key = config('sms.api_key');
        $senderid = config('sms.senderid');
        
        $usersarraystosend = [];
        $iterator = 0;
        foreach (json_decode($bulkpayment->bulk_payment_member_ids) as $member_id => $amount) {
            $member = User::where('member_id', $member_id)->first();
            $mobile_number = 0;
            if(strlen($member->mobile) == 11) {
                $mobile_number = $member->mobile;
            } elseif(strlen($member->mobile) > 11) {
                if (strpos($member->mobile, '+') !== false) {
                    $mobile_number = substr($member->mobile, -11);
                }
            }
            $text = 'Dear ' . $member->name . ', payment of tk. '. $amount .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
            $usersarraystosend[$iterator]['to'] = $mobile_number;
            $usersarraystosend[$iterator]['message'] = $text; 
            $iterator++;
        }
        $messages = json_encode($usersarraystosend);

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "messages" => $messages
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        // return $response;

        // NEW PANEL


        // // send sms
        // // $mobile_numbers = [];
        // $smssuccesscount = 0;
        // $url = config('sms.url');
        
        // $multiCurl = array();
        // // data to be returned
        // $result = array();
        // // multi handle
        // $mh = curl_multi_init();
        // // sms data
        // $smsdata = [];

        // foreach (json_decode($bulkpayment->bulk_payment_member_ids) as $member_id => $amount) {
        //     $member = User::where('member_id', $member_id)->first();
        //     $mobile_number = 0;
        //     if(strlen($member->mobile) == 11) {
        //         $mobile_number = $member->mobile;
        //     } elseif(strlen($member->mobile) > 11) {
        //         if (strpos($member->mobile, '+') !== false) {
        //             $mobile_number = substr($member->mobile, -11);
        //         }
        //     }
        //     // if($mobile_number != 0) {
        //     //   array_push($mobile_numbers, $mobile_number);
        //     // }
        //     $text = 'Dear ' . $member->name . ', payment of tk. '. $amount .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
        //     $smsdata[$member_id] = array(
        //         'username'=>config('sms.username'),
        //         'password'=>config('sms.password'),
        //         // 'apicode'=>"1",
        //         'number'=>"$mobile_number",
        //         // 'msisdn'=>"$mobile_number",
        //         // 'countrycode'=>"880",
        //         // 'cli'=>"CVCS",
        //         // 'messagetype'=>"1",
        //         'message'=>"$text",
        //         // 'messageid'=>"2"
        //     );
        //     $multiCurl[$member_id] = curl_init(); // Initialize cURL
        //     curl_setopt($multiCurl[$member_id], CURLOPT_URL, $url);
        //     curl_setopt($multiCurl[$member_id], CURLOPT_HEADER, 0);
        //     curl_setopt($multiCurl[$member_id], CURLOPT_POSTFIELDS, http_build_query($smsdata[$member_id]));
        //     curl_setopt($multiCurl[$member_id], CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($multiCurl[$member_id], CURLOPT_SSL_VERIFYPEER, false); // this is important
        //     curl_multi_add_handle($mh, $multiCurl[$member_id]);
        // }

        // $index=null;
        // do {
        //   curl_multi_exec($mh, $index);
        // } while($index > 0);
        // // get content and remove handles
        // foreach($multiCurl as $k => $ch) {
        //   $result[$k] = curl_multi_getcontent($ch);
        //   curl_multi_remove_handle($mh, $ch);
        //   $smsresult = $result[$k];
        //   $p = explode("|",$smsresult);
        //   $sendstatus = $p[0];
        //   if($sendstatus == 1101) {
        //       $smssuccesscount++;
        //   }
        // }
        // // close
        // curl_multi_close($mh);

        Session::flash('success', 'অনুমোদন সফল হয়েছে!');

        if(Auth::user()->role_type == 'bulkpayer') {
            return redirect()->route('dashboard.memberpaymentbulk');
        } else {
            return redirect()->route('dashboard.membersapprovedpayments');
        }
    }

    public function paymentBulkSuccessOrFailed(Request $request) 
    {
        // dd($request->all());
        if($request->get('pay_status') == 'Failed') {
            Session::flash('info', 'পেমেন্ট সম্পন্ন হয়নি, আবার চেষ্টা করুন!');
            return redirect(Route('dashboard.memberpaymentselfonline'));
        }

        $member_data = $request->get('opt_a');
        $amount_request = $request->get('opt_b');
        $amount_paid = $request->get('amount');

        if($amount_paid == $amount_request)
        {
            // dd($request->all());
            $payers = (explode(",",$member_data));

            // NEW PANEL
            $url = "http://bulksmsbd.net/api/smsapimany";
            $api_key = config('sms.api_key');
            $senderid = config('sms.senderid');
            
            $usersarraystosend = [];
            foreach($payers as $index => $payer) {
                $payerdata = (explode(":", $payer));
                //  [0] = memebr_id, [1] = mobile, [2] = amount
                //  [0] = memebr_id, [1] = mobile, [2] = amount

                $payment = new Payment;
                $payment->member_id = $payerdata[0];
                $payment->payer_id = Auth::user()->member_id; // payers member_id
                $payment->amount = $payerdata[2];
                $payment->bank = 'aamarPay Payment Gateway';
                $payment->branch = 'N/A';
                $payment->pay_slip = '00';
                $payment->payment_status = 1; // approved
                $payment->payment_category = 1; // monthly payment
                $payment->payment_type = 2; // bulk payment
                $payment->payment_method = 1; //IF NULL THEN OFFLINE, IF 1 THEN ONLINE
                $payment->card_type = $request->get('card_type');
                $payment->payment_key = $request->get('mer_txnid'); // SAME TRXID FOR BOTH METHOD
                $payment->save();

                // input member SMS into array
                $member = User::where('member_id', $payerdata[0])->first();
                $text = 'Dear ' . $member->name . ', payment of tk. '. $payerdata[2] .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';

                $usersarraystosend[$index]['to'] = $payerdata[1];
                $usersarraystosend[$index]['message'] = $text;
            }
            $messages = json_encode($usersarraystosend);

            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "messages" => $messages
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            // return $response;
            // NEW PANEL

            // INSERT DATA TO DATABASE
            // INSERT DATA TO DATABASE

            // // partial SMS data
            // $smssuccesscount = 0;
            // $url = config('sms.url');
            
            // $multiCurl = array();
            // // data to be returned
            // $result = array();
            // // multi handle
            // $mh = curl_multi_init();
            // // sms data
            // $smsdata = [];
            // // partial SMS data

            // foreach ($payers as $payer)
            // {
            //     $payerdata = (explode(":", $payer)); 
            //     // [0] = memebr_id, [1] = mobile, [2] = amount
            //     // [0] = memebr_id, [1] = mobile, [2] = amount

            //     $payment = new Payment;
            //     $payment->member_id = $payerdata[0];
            //     $payment->payer_id = Auth::user()->member_id; // payers member_id
            //     $payment->amount = $payerdata[2];
            //     $payment->bank = 'aamarPay Payment Gateway';
            //     $payment->branch = 'N/A';
            //     $payment->pay_slip = '00';
            //     $payment->payment_status = 1; // approved
            //     $payment->payment_category = 1; // monthly payment
            //     $payment->payment_type = 2; // bulk payment
            //     $payment->payment_method = 1; //IF NULL THEN OFFLINE, IF 1 THEN ONLINE
            //     $payment->card_type = $request->get('card_type');
            //     $payment->payment_key = $request->get('mer_txnid'); // SAME TRXID FOR BOTH METHOD
            //     $payment->save();


            //     // input member SMS into array
            //     // input member SMS into array
            //     $member = User::where('member_id', $payerdata[0])->first();
            //     $mobile_number = $payerdata[1];

            //     $text = 'Dear ' . $member->name . ', payment of tk. '. $payerdata[2] .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
            //     $smsdata[$payerdata[0]] = array(
            //         'username'=>config('sms.username'),
            //         'password'=>config('sms.password'),
            //         'number'=>"$mobile_number",
            //         'message'=>"$text",
            //     );
            //     $multiCurl[$payerdata[0]] = curl_init(); // Initialize cURL
            //     curl_setopt($multiCurl[$payerdata[0]], CURLOPT_URL, $url);
            //     curl_setopt($multiCurl[$payerdata[0]], CURLOPT_HEADER, 0);
            //     curl_setopt($multiCurl[$payerdata[0]], CURLOPT_POSTFIELDS, http_build_query($smsdata[$payerdata[0]]));
            //     curl_setopt($multiCurl[$payerdata[0]], CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($multiCurl[$payerdata[0]], CURLOPT_SSL_VERIFYPEER, false); // this is important
            //     curl_multi_add_handle($mh, $multiCurl[$payerdata[0]]);
            //     // input member SMS into array
            //     // input member SMS into array
            // }

            // // partial SMS data
            // $index=null;
            // do {
            //   curl_multi_exec($mh, $index);
            // } while($index > 0);
            // // get content and remove handles
            // foreach($multiCurl as $k => $ch) {
            //   $result[$k] = curl_multi_getcontent($ch);
            //   curl_multi_remove_handle($mh, $ch);
            //   $smsresult = $result[$k];
            //   $p = explode("|",$smsresult);
            //   $sendstatus = $p[0];
            //   if($sendstatus == 1101) {
            //       $smssuccesscount++;
            //   }
            // }
            // // close
            // curl_multi_close($mh);
            // // partial SMS data

            // INSERT DATA TO DATABASE
            // INSERT DATA TO DATABASE

            // DELETE TEMPPAYMENT
            $temppayment = Temppayment::where('trxid', $request->get('mer_txnid'))->first();;
            $temppayment->delete();
            // DELETE TEMPPAYMENT

            Session::flash('success', 'পেমেন্ট সফলভাবে সম্পন্ন হয়েছে!');
            return redirect(Route('dashboard.memberpaymentbulk'));
        } else {
            // Something went wrong.
            Session::flash('info', 'Something went wrong, please reload this page!');
            if(Auth::guest()) {
                return redirect()->route('index.index');
            } else {
                return redirect(Route('dashboard.memberpaymentbulk'));
            }
        }
        
        if(Auth::guest()) {
            return redirect()->route('index.index');
        } else {
            return redirect()->route('dashboard.memberpaymentbulk');
        }
    }

    public function paymentBulkCancelledPost(Request $request)
    {
        // $member_id = $request->get('opt_a');
        
        // if($request->get('pay_status') == 'Failed') {
        //     Session::flash('info', 'Something went wrong, please try again!');
        //     return redirect(Route('dashboard.memberpaymentbulk'));
        // }
        
        // $amount_request = $request->get('opt_b');
        // $amount_paid = $request->get('amount');
        
        // if($amount_paid == $amount_request)
        // {
        //   $member = User::where('member_id', $member_id)->first();

        //   // SAVE THE PAYMENT
        //   $payment = new Payment;
        //   $payment->member_id = $member->member_id;
        //   $payment->payer_id = $member->member_id;
        //   $payment->amount = $amount_paid;
        //   $payment->bank = 'aamarPay Payment Gateway';
        //   $payment->branch = 'N/A';
        //   $payment->pay_slip = '00';
        //   $payment->payment_status = 1; // IN THIS CASE, PAYMENT IS APPROVED
        //   $payment->payment_category = 1; // monthly payment, if 0 then membership payment
        //   $payment->payment_type = 1; // single payment, if 2 then bulk payment
        //   $payment->payment_method = 1; //IF NULL THEN OFFLINE, IF 1 THEN ONLINE
        //   $payment->card_type = $request->get('card_type');
        //   $payment->payment_key = $request->get('mer_txnid'); // SAME TRXID FOR BOTH METHOD
        //   $payment->save();

        //   // send sms
        //   $mobile_number = 0;
        //   if(strlen($payment->user->mobile) == 11) {
        //       $mobile_number = $payment->user->mobile;
        //   } elseif(strlen($payment->user->mobile) > 11) {
        //       if (strpos($payment->user->mobile, '+') !== false) {
        //           $mobile_number = substr($payment->user->mobile, -11);
        //       }
        //   }
        //   $url = config('sms.url');
        //   $number = $mobile_number;
        //   $text = 'Dear ' . $payment->user->name . ', payment of tk. '. $payment->amount .' is APPROVED successfully! Thanks. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
        //   $data= array(
        //       'username'=>config('sms.username'),
        //       'password'=>config('sms.password'),
        //       'number'=>"$number",
        //       'message'=>"$text",
        //   );
        //   // initialize send status
        //   $ch = curl_init(); // Initialize cURL
        //   curl_setopt($ch, CURLOPT_URL,$url);
        //   curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        //   $smsresult = curl_exec($ch);

        //   // $sendstatus = $result = substr($smsresult, 0, 3);
        //   $p = explode("|",$smsresult);
        //   $sendstatus = $p[0];
        //   // send sms
        //   if($sendstatus == 1101) {
        //       Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
        //   } elseif($sendstatus == 1006) {
        //       Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        //   } else {
        //       Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        //   }
        //   // SAVE THE PAYMENT
        //   Session::flash('success','আপনার পেমেন্ট সফল হয়েছে!');
        // } else {
        //    // Something went wrong.
        //   Session::flash('info', 'Something went wrong, please try again!');
        //   return redirect(Route('dashboard.memberpaymentbulk'));
        // }
        
        // //return $request->all();
        // return redirect(Route('dashboard.memberpayment'));
    }

    public function paymentBulkCancelled()
    {
        Session::flash('info','Payment is cancelled!');
        return redirect()->route('dashboard.memberpaymentbulk');
    }

    public function getNotifications() 
    {
        return view('dashboard.notifications');
    }

    // not using this
    // not using this
    public function runDBBackup33() 
    {
        Artisan::call('backup:clean');
        Artisan::call('backup:run');
        $path = storage_path('app/laravel-backup/*');
        $latest_ctime = 0;
        $latest_filename = '';
        $files = glob($path);
        foreach($files as $file)
        {
            if (is_file($file) && filectime($file) > $latest_ctime)
            {
                 $latest_ctime = filectime($file);
                 $latest_filename = $file;
            }
        }
        return response()->download($latest_filename);
    }
    public function getExcelDataAll($start_id, $end_id) 
    {
        $users = User::select('name', 'name_bangla', 'nid', 'dob', 'member_id', 'mobile', 'joining_date', 'email', 'designation', 'position_id')
                     ->whereBetween('id', [$start_id, $end_id])
                     ->where('activation_status', 1)
                     ->orderBy('id', 'asc')
                     ->orderBy('position_id', 'asc')
                     ->get()
                     ->take(0); // here is the catch!

        return view('dashboard.excelexport')->withUsers($users);
    }

    public function runDBBackup()
    {
            
        $get_all_table_query = "SHOW TABLES";
        $result = DB::select(DB::raw($get_all_table_query));

        $tables = [];
        $queryTables = DB::select('SHOW TABLES');
        foreach ( $queryTables as $table )
        {
           foreach ( $table as $tName)
           {
               $tables[]= $tName ;
           }
        }

        $structure = '';
        $data = '';
        foreach ($tables as $table) {
          $show_table_query = "SHOW CREATE TABLE " . $table . "";

          $show_table_result = DB::select(DB::raw($show_table_query));

          foreach ($show_table_result as $show_table_row) {
              $show_table_row = (array)$show_table_row;
              $structure .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
          }
          $select_query = "SELECT * FROM " . $table;
          $records = DB::select(DB::raw($select_query));

          foreach ($records as $record) {
              $record = (array)$record;
              $table_column_array = array_keys($record);
              foreach ($table_column_array as $key => $name) {
                  $table_column_array[$key] = '`' . $table_column_array[$key] . '`';
              }

              $table_value_array = array_values($record);
              $data .= "\nINSERT INTO $table (";

              $data .= "" . implode(", ", $table_column_array) . ") VALUES \n";

              foreach($table_value_array as $key => $record_column)
                  $table_value_array[$key] = addslashes($record_column);

              $data .= "('" . implode("','", $table_value_array) . "');\n";
          }
        }

        // delete other files
        File::cleanDirectory(public_path('files/db'));
        // delete other files
        $file_name = public_path('/') . '/files/db/CVCS_DB_' . date('d_m_Y') . '.sql';
        $file_handle = fopen($file_name, 'w + ');

        $output = $structure . $data;
        fwrite($file_handle, $output);
        fclose($file_handle);
        // header('Content-Description: File Transfer');
        // header('Content-Type: application/octet-stream');
        // header('Content-Disposition: attachment; filename=' . basename($file_name));
        // header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate');
        // header('Pragma: public');
        // header('Content-Length: ' . filesize($file_name));
        // ob_clean();
        // flush();
        // readfile($file_name);
        // unlink($file_name);
        echo "DB backup ready";
        return response()->download($file_name);
    }



    // operation
    // operation
    public function getAll5000() 
    {
        $all5000s = Payment::where('payment_category', 0)
                           ->where('payment_status', 1)
                           ->where('amount', 5000)
                           ->get();

        echo 'Total: ' . count($all5000s) . '<br/><br/>';
        echo 'Total: ' . count($all5000s) * 2000 . '<br/><br/>';
        foreach($all5000s as $payment) {
            $payment->amount = 2000;
            $payment->save();

            $paymentthreeth = new Payment;
            $paymentthreeth->member_id = $payment->member_id;
            $paymentthreeth->payer_id = $payment->member_id;
            $paymentthreeth->payment_status = 1; // approved
            $paymentthreeth->payment_category = 1; // monthly payment, if 0 then membership payment
            $paymentthreeth->payment_type = 1; // single payment, if 2 then bulk payment
            $paymentthreeth->payment_key = random_string(10);
            $paymentthreeth->amount = 3000; // hard coded
            $paymentthreeth->bank = $payment->bank;
            $paymentthreeth->branch = $payment->branch;
            $paymentthreeth->pay_slip = $payment->pay_slip;
            $paymentthreeth->created_at = date('Y-m-d H:i:s', strtotime($payment->created_at . '+ 1 minute'));
            $paymentthreeth->updated_at = date('Y-m-d', strtotime($payment->updated_at . '+ 1 minute'));
            $paymentthreeth->save();

            // receipt upload
            $paymentreceiptthreeth = new Paymentreceipt;
            $paymentreceiptthreeth->payment_id = $paymentthreeth->id;
            $paymentreceiptthreeth->image = $payment->paymentreceipts[0]->image;
            $paymentreceiptthreeth->save();
        }

        echo 'Works fine...';
    }

    public function delExPay() 
    {
        $allpays = Payment::all();

        $cosnsd = 0;
        foreach($allpays as $payment) {
            // search user
            if(empty($payment->payee) || empty($payment->user)) {
                $payment->delete();
                $cosnsd++;
                echo $cosnsd;
                echo '. Done.<br/>';
            }
        }
    }

    public function delDoublePayments() 
    {
        $payments = DB::table('payments')
            ->select('id', 'member_id', 'amount', 'payment_key', 'payment_type', DB::raw('COUNT(*) as `count`'))
            ->groupBy('member_id', 'amount', 'payment_key', 'payment_type')
            ->havingRaw('COUNT(*) > 1')
            ->orderBy('id', 'desc')
            ->get();
        foreach($payments as $payment) {
            // DELETE THE DOUBLE PAYMENT!
            // DELETE THE DOUBLE PAYMENT!
            $delpayment = Payment::find($payment->id);
            $delpayment->delete();
            // DELETE THE DOUBLE PAYMENT!
            // DELETE THE DOUBLE PAYMENT!
        }
        // dd($payments);
    }

    public function testAPI() {
        $messages = json_encode( [
            [
                "to" => "88016xxxxxxxx",
                "message" => "test content"
            ],
            [
                "to" => "88019xxxxxxxx",
                "message" => "test 2nd content"
            ]
        ]);

        $users = User::select('name','mobile')->take(2)->get();

        $usersarrays = [];
        foreach($users as $index => $user) {
            $usersarrays[$index]['to'] = $user->mobile;
            $usersarrays[$index]['message'] = $user->name;
        }
        $newmessage = json_encode($usersarrays);
        dd($newmessage);
    }
    // operation
    // operation
    
}
