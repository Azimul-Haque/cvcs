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

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Image;
use File;
use Session, Config;

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
        
        $this->middleware('auth');
        $this->middleware('admin')->except('getBlogs', 'getProfile', 'getPaymentPage', 'getSingleMember', 'getSelfPaymentPage', 'storeSelfPayment', 'getBulkPaymentPage', 'searchMemberForBulkPaymentAPI', 'findMemberForBulkPaymentAPI', 'storeBulkPayment', 'getMemberTransactionSummary', 'getMemberUserManual');
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
        $successfullpayments = Payment::where('payment_status', 1)->count();

        $lastsixmembers = User::where('activation_status', 1)
                              ->where('role', 'member')
                              ->orderBy('created_at', 'desc')
                              ->take(6)->get();

        return view('dashboard.index')
                    ->withTotalpending($totalpending)
                    ->withTotalapproved($totalapproved)
                    ->withRegisteredmember($registeredmember)
                    ->withSuccessfullpayments($successfullpayments)
                    ->withLastsixmembers($lastsixmembers);
                    // ->withWhatwedo($whatwedo)
                    // ->withAtaglance($ataglance)
                    // ->withMembership($membership)
                    // ->withBasicinfo($basicinfo);
    }

    public function getAdmins()
    {
        $superadmins = User::where('role', 'admin')
                           ->whereNotIn('email', ['mannan@cvcsbd.com', 'dataentry@cvcsbd.com']) // mannan@cvcsbd.com, dataentry@cvcsbd.com er ta dekhabe na!!!
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

        return view('dashboard.adminsandothers.donors')
                    ->withDonors($donors)
                    ->withDonations($donations);
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

        return view('dashboard.adminsandothers.donationsofdonor')
                    ->withDonor($donor)
                    ->withDonations($donations);
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

    public function getBranches()
    {
        $branches = Branch::orderBy('id', 'desc')->paginate(10);

        return view('dashboard.adminsandothers.branches')
                    ->withBranches($branches);
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
        $committeemembers = Committee::orderBy('committee_type', 'desc')->get();
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
            'gplus'                     => 'sometimes|max:255',
            'linkedin'                  => 'sometimes|max:255',
            'image'                     => 'sometimes|image|max:500',
            'committee_type'            => 'required'
        ));

        $committeemember = new Committee();
        $committeemember->committee_type = $request->committee_type;
        $committeemember->name = htmlspecialchars(preg_replace("/\s+/", " ", ucwords($request->name)));
        $committeemember->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
        $committeemember->phone = htmlspecialchars(preg_replace("/\s+/", " ", $request->phone));
        $committeemember->designation = htmlspecialchars(preg_replace("/\s+/", " ", $request->designation));
        $committeemember->fb = htmlspecialchars(preg_replace("/\s+/", " ", $request->fb));
        $committeemember->twitter = htmlspecialchars(preg_replace("/\s+/", " ", $request->twitter));
        $committeemember->gplus = htmlspecialchars(preg_replace("/\s+/", " ", $request->gplus));
        $committeemember->linkedin = htmlspecialchars(preg_replace("/\s+/", " ", $request->linkedin));

        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = str_replace(' ','',$request->name).time() .'.' . $image->getClientOriginalExtension();
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
            'gplus'                     => 'sometimes|max:255',
            'linkedin'                  => 'sometimes|max:255',
            'image'                     => 'sometimes|image|max:250',
            'committee_type'            => 'required'
        ));

        $committeemember = Committee::find($id);
        $committeemember->committee_type = $request->committee_type;
        $committeemember->name = htmlspecialchars(preg_replace("/\s+/", " ", ucwords($request->name)));
        $committeemember->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
        $committeemember->phone = htmlspecialchars(preg_replace("/\s+/", " ", $request->phone));
        $committeemember->designation = htmlspecialchars(preg_replace("/\s+/", " ", $request->designation));
        $committeemember->fb = htmlspecialchars(preg_replace("/\s+/", " ", $request->fb));
        $committeemember->twitter = htmlspecialchars(preg_replace("/\s+/", " ", $request->twitter));
        $committeemember->gplus = htmlspecialchars(preg_replace("/\s+/", " ", $request->gplus));
        $committeemember->linkedin = htmlspecialchars(preg_replace("/\s+/", " ", $request->linkedin));

        // image upload
        if($request->hasFile('image')) {
            $image_path = public_path('/images/committee/'. $committeemember->image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $image      = $request->file('image');
            $filename   = str_replace(' ','',$request->name).time() .'.' . $image->getClientOriginalExtension();
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
            'attachment'    => 'required|mimes:doc,docx,ppt,pptx,png,jpeg,jpg,pdf,gif|max:2000'
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
            'attachment'    => 'sometimes|mimes:doc,docx,ppt,pptx,png,jpeg,jpg,pdf,gif|max:2000'
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
        
        Session::flash('success', 'Notice has been created successfully!');
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
            Image::make($image)->resize(1200, 400)->save($location);
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
            Image::make($thumbnail)->resize(600, 375)->save($location);
            $album->thumbnail = $filename;
        }
        
        $album->save();

        // photo (s) upload
        for($i = 1; $i <= 3; $i++) {
            if($request->hasFile('image'.$i)) {
                $image      = $request->file('image'.$i);
                $filename   = 'photo_'. $i . time() .'.' . $image->getClientOriginalExtension();
                $location   = public_path('/images/gallery/'. $filename);
                Image::make($image)->resize(600, 375)->save($location);
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
            Image::make($image)->resize(700, 438)->save($location);
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
                            ->orderBy('id', 'asc')->paginate(10);

        return view('dashboard.membership.applications')
                            ->withApplications($applications);
    }

    public function getSignleApplication($unique_key)
    {
        $application = User::where('unique_key', $unique_key)->first();

        return view('dashboard.membership.singleapplication')
                            ->withApplication($application);
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

        $application->member_id = date('Y', strtotime($application->dob)).str_pad(($ordered_member_ids[0]+1), 5, '0', STR_PAD_LEFT);
        // check if the id already exists...
        $ifexists = User::where('member_id', $application->member_id)->first();
        if($ifexists) {
            Session::flash('warning', 'দুঃখিত! আবার চেষ্টা করুন!');
            return redirect()->route('dashboard.applications');
        }
        // check if the id already exists...
        $application->save();

        // save the payment!
        $payment = new Payment;
        $payment->member_id = $application->member_id;
        $payment->payer_id = $application->member_id;
        $payment->amount = 5000; // hard coded
        $payment->bank = $application->application_payment_bank;
        $payment->branch = $application->application_payment_branch;
        $payment->pay_slip = $application->application_payment_pay_slip;
        $payment->payment_status = 1; // approved
        $payment->payment_category = 0; // membership payment
        $payment->payment_type = 1; // single payment
        // generate payment_key
        $payment_key_length = 10;
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $payment_key = substr(str_shuffle(str_repeat($pool, 10)), 0, $payment_key_length);
        // generate payment_key
        $payment->payment_key = $payment_key;
        $payment->save();

        // receipt upload
        if($application->application_payment_receipt != '') {
            $paymentreceipt = new Paymentreceipt;
            $paymentreceipt->payment_id = $payment->id;
            $paymentreceipt->image = $application->application_payment_receipt;
            $paymentreceipt->save();
        }
        if($application->application_payment_amount > 5000) {
            $payment = new Payment;
            $payment->member_id = $application->member_id;
            $payment->payer_id = $application->member_id;
            $payment->amount = $application->application_payment_amount - 5000; // IMPORTANT
            $payment->bank = $application->application_payment_bank;
            $payment->branch = $application->application_payment_branch;
            $payment->pay_slip = $application->application_payment_pay_slip;
            $payment->payment_status = 1; // approved (0 means pending)
            $payment->payment_category = 1; // monthly payment (0 means membership)
            $payment->payment_type = 1; // single payment (2 means bulk)
            // generate payment_key
            $payment_key_length = 10;
            $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $payment_key = substr(str_shuffle(str_repeat($pool, 10)), 0, $payment_key_length);
            // generate payment_key
            $payment->payment_key = $payment_key;
            $payment->save();

            // receipt upload
            if($application->application_payment_receipt != '') {
                $paymentreceipt = new Paymentreceipt;
                $paymentreceipt->payment_id = $payment->id;
                $paymentreceipt->image = $application->application_payment_receipt;
                $paymentreceipt->save();
            }
        } else {

        }
        // save the payment!

        // send activation SMS ... aro kichu kaaj baki ache...
        // send sms
        $mobile_number = 0;
        if(strlen($application->mobile) == 11) {
            $mobile_number = '88'.$application->mobile;
        } elseif(strlen($application->mobile) > 11) {
            if (strpos($application->mobile, '+') !== false) {
                $mobile_number = substr($application->mobile,0,1);
            }
        }
        $url = config('sms.url');
        $number = $mobile_number;
        $text = 'Dear ' . $application->name . ', your membership application has been approved! Your ID: '. $application->member_id .' and Email: '. $application->email .'. Login: https://cvcsbd.com/login';
        // this sms costs 2 SMS
        // this sms costs 2 SMS
        
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
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        // send sms
        if($sendstatus == 1101) {
            Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }

        Session::flash('success', 'সদস্য সফলভাবে অনুমোদন করা হয়েছে!');
        return redirect()->route('dashboard.members');
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
            $mobile_number = '88'.$applicant->mobile;
        } elseif(strlen($applicant->mobile) > 11) {
            if (strpos($applicant->mobile, '+') !== false) {
                $mobile_number = substr($applicant->mobile,0,1);
            }
        }
        $url = config('sms.url');
        $number = $mobile_number;
        $text = $request->message;
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
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        // send sms
        if($sendstatus == 1101) {
            Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }

        return redirect()->route('dashboard.singleapplication', $request->unique_key);
    }

    public function getMembers()
    {
        $members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')
                       ->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.membership.members')->withMembers($members);
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

    public function getSingleMember($unique_key)
    {
        $member = User::where('unique_key', $unique_key)->first();

        $members = User::all();

        // for now, user can only see his profile, so if there is a change, then kaaj kora jaabe...
        if((Auth::user()->role == 'member') && ($member->unique_key != Auth::user()->unique_key)) {
            Session::flash('warning', ' দুঃখিত, আপনার এই পাতাটি দেখার অনুমতি নেই!');
            return redirect()->route('dashboard.memberpayment');
        }

        return view('dashboard.membership.singlemember')
                            ->withMember($member)
                            ->withMembers($members);
    }

    public function getFormMessages() 
    {
        $messages = Formmessage::orderBy('id', 'desc')->paginate(10);

        return view('dashboard.formmessage')
                    ->withMessages($messages);
    }


    public function deleteFormMessage($id) 
    {
        $messages = Formmessage::find($id);
        $messages->delete();

        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.formmessage');
    }

    public function getProfile() 
    {
        $member = User::find(Auth::user()->id);
        return view('dashboard.profile.index')
                    ->withMember($member);
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
            $mobile_number = '88'.Auth::user()->mobile;
        } elseif(strlen(Auth::user()->mobile) > 11) {
            if (strpos(Auth::user()->mobile, '+') !== false) {
                $mobile_number = substr(Auth::user()->mobile,0,1);
            }
        }
        $url = config('sms.url');
        $number = $mobile_number;
        $text = 'Dear ' . Auth::user()->name . ', payment of tk. '. $request->amount .' is submitted successfully. We will notify you once we approve it. Login: https://cvcsbd.com/login';
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
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        // send sms
        if($sendstatus == 1101) {
            // Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } else {
            // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }
        
        Session::flash('success', 'পরিশোধ সফলভাবে দাখিল করা হয়েছে!');
        return redirect()->route('dashboard.memberpayment');
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

        return view('dashboard.profile.transactionsummary')
                        ->withMembertotalpending($membertotalpending)
                        ->withMembertotalapproved($membertotalapproved);
    }

    public function getMemberUserManual() 
    {
        return view('dashboard.profile.usermanual');
    }

    public function storeBulkPayment(Request $request) 
    {
        $this->validate($request,array(
            'amount'      =>   'required|integer',
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
        $payment->amount = $request->amount;
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


        // send sms
        $mobile_numbers = [];
        $members = User::whereIn('member_id', $amountids)->get();
        foreach ($members as $i => $member) {
            $mobile_number = 0;
            if(strlen($member->mobile) == 11) {
                $mobile_number = '88'.$member->mobile;
            } elseif(strlen($member->mobile) > 11) {
                if (strpos($member->mobile, '+') !== false) {
                    $mobile_number = substr($member->mobile,0,1);
                }
            }
            if($mobile_number != 0) {
              array_push($mobile_numbers, $mobile_number);
            }
        }
        $numbers = implode(",", $mobile_numbers);
        $url = config('sms.url');
        $data= array(
          'username'=>config('sms.username'),
          'password'=>config('sms.password'),
          'number'=>"$numbers",
          'message'=>"Dear User, a payment is submitted against your account. We will notify you further updates. Login: https://cvcsbd.com/login"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        $smssuccesscount = $p[1];

        if($sendstatus == 1101) {
            //Session::flash('info', 'gese');
        } else {
            //Session::flash('info', 'jayni!');
        }
        
        Session::flash('success', 'পরিশোধ সফলভাবে দাখিল করা হয়েছে!');
        return redirect()->route('dashboard.memberpayment');
    }

    public function getBulkPaymentPage() 
    {
        return view('dashboard.adminsandothers.bulkpayment');
    }

    public function searchMemberForBulkPaymentAPI(Request $request)
    {
        $response = User::select('name_bangla', 'member_id', 'mobile')
                        ->where('activation_status', 1)
                        ->orderBy('id', 'desc')->get();

        return $response;          
    }

    public function searchMemberForBulkPaymentSingleAPI($member_id)
    {
        $response = User::select('name_bangla', 'member_id', 'mobile')
                        ->where('activation_status', 1)
                        ->where('member_id', $member_id)
                        ->first();

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

    public function approveSinglePayment(Request $request, $id) 
    {
        $payment = Payment::find($id);

        $payment->payment_status = 1;
        $payment->save();

        // send pending SMS ... aro kichu kaaj baki ache...
        // send sms
        $mobile_number = 0;
        if(strlen($payment->user->mobile) == 11) {
            $mobile_number = '88'.$payment->user->mobile;
        } elseif(strlen($payment->user->mobile) > 11) {
            if (strpos($payment->user->mobile, '+') !== false) {
                $mobile_number = substr($payment->user->mobile,0,1);
            }
        }
        $url = config('sms.url');
        $number = $mobile_number;
        $text = 'Dear ' . $payment->user->name . ', payment of tk. '. $payment->amount .' is APPROVED successfully! Thanks. Login: Login: h/loginttps://cvcsbd.com/login';
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
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        // send sms
        if($sendstatus == 1101) {
            Session::flash('info', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }

        Session::flash('success', 'অনুমোদন সফল হয়েছে!');
        return redirect()->route('dashboard.membersapprovedpayments');
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

        // send sms
        $mobile_numbers = [];
        foreach(json_decode($bulkpayment->bulk_payment_member_ids) as $member_id => $amount) {
            $member = User::where('member_id', $member_id)->first();
            $mobile_number = 0;
            if(strlen($member->mobile) == 11) {
                $mobile_number = '88'.$member->mobile;
            } elseif(strlen($member->mobile) > 11) {
                if (strpos($member->mobile, '+') !== false) {
                    $mobile_number = substr($member->mobile,0,1);
                }
            }
            if($mobile_number != 0) {
              array_push($mobile_numbers, $mobile_number);
            }
        }
        $numbers = implode(",", $mobile_numbers);
        $url = config('sms.url');
        $data= array(
          'username'=>config('sms.username'),
          'password'=>config('sms.password'),
          'number'=>"$numbers",
          'message'=>"Dear User, your payment is APPROVED successfully. Please signin to see details. Login: https://cvcsbd.com/login"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        $smssuccesscount = $p[1];

        if($sendstatus == 1101) {
            //Session::flash('info', 'gese');
        } else {
            //Session::flash('info', 'jayni!');
        }

        Session::flash('success', 'অনুমোদন সফল হয়েছে!');
        return redirect()->route('dashboard.membersapprovedpayments');
    }

}
