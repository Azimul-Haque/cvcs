<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;
use App\About;
use App\Album;
use App\Albumphoto;
use App\Event;
use App\Notice;
use App\Basicinfo;
use App\Formmessage;
use App\Payment;
use App\Paymentreceipt;
use App\Adhocmember;

use DB;
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
        $this->middleware('admin')->except('getBlogs', 'getProfile', 'getPaymentPage', 'getSelfPaymentPage', 'storeSelfPaymentPage');
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

        return view('dashboard.index');
                    // ->withAbout($about)
                    // ->withWhoweare($whoweare)
                    // ->withWhatwedo($whatwedo)
                    // ->withAtaglance($ataglance)
                    // ->withMembership($membership)
                    // ->withBasicinfo($basicinfo);
    }

    public function getAbouts()
    {
        $about = About::where('type', 'about')->get()->first();
        $whoweare = About::where('type', 'whoweare')->get()->first();
        $whatwedo = About::where('type', 'whatwedo')->get()->first();
        $ataglance = About::where('type', 'ataglance')->get()->first();
        $membership = About::where('type', 'membership')->get()->first();
        $basicinfo = Basicinfo::where('id', 1)->first();

        return view('dashboard.abouts')
                    ->withAbout($about)
                    ->withWhoweare($whoweare)
                    ->withWhatwedo($whatwedo)
                    ->withAtaglance($ataglance)
                    ->withMembership($membership)
                    ->withBasicinfo($basicinfo);
    }

    public function updateAbouts(Request $request, $id) {
        $this->validate($request,array(
            'text' => 'required',
        ));

        $about = About::find($id);
        $about->text = $request->text;
     
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
        $adhocmembers = Adhocmember::orderBy('id', 'desc')->get();
        return view('dashboard.committee')->withAdhocmembers($adhocmembers);
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
            'image'                     => 'sometimes|image|max:250'
        ));

        $adhocmember = new Adhocmember();
        $adhocmember->name = htmlspecialchars(preg_replace("/\s+/", " ", ucwords($request->name)));
        $adhocmember->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
        $adhocmember->phone = htmlspecialchars(preg_replace("/\s+/", " ", $request->phone));
        $adhocmember->designation = htmlspecialchars(preg_replace("/\s+/", " ", $request->designation));
        $adhocmember->fb = htmlspecialchars(preg_replace("/\s+/", " ", $request->fb));
        $adhocmember->twitter = htmlspecialchars(preg_replace("/\s+/", " ", $request->twitter));
        $adhocmember->gplus = htmlspecialchars(preg_replace("/\s+/", " ", $request->gplus));
        $adhocmember->linkedin = htmlspecialchars(preg_replace("/\s+/", " ", $request->linkedin));

        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = str_replace(' ','',$request->name).time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/committee/adhoc/'. $filename);
            Image::make($image)->resize(250, 250)->save($location);
            $adhocmember->image = $filename;
        }

        $adhocmember->save();
        
        Session::flash('success', 'Saved Successfully!');
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
            'image'                     => 'sometimes|image|max:250'
        ));

        $adhocmember = Adhocmember::find($id);
        $adhocmember->name = htmlspecialchars(preg_replace("/\s+/", " ", ucwords($request->name)));
        $adhocmember->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
        $adhocmember->phone = htmlspecialchars(preg_replace("/\s+/", " ", $request->phone));
        $adhocmember->designation = htmlspecialchars(preg_replace("/\s+/", " ", $request->designation));
        $adhocmember->fb = htmlspecialchars(preg_replace("/\s+/", " ", $request->fb));
        $adhocmember->twitter = htmlspecialchars(preg_replace("/\s+/", " ", $request->twitter));
        $adhocmember->gplus = htmlspecialchars(preg_replace("/\s+/", " ", $request->gplus));
        $adhocmember->linkedin = htmlspecialchars(preg_replace("/\s+/", " ", $request->linkedin));

        // image upload
        if($adhocmember->image == null) {
            if($request->hasFile('image')) {
                $image      = $request->file('image');
                $filename   = str_replace(' ','',$request->name).time() .'.' . $image->getClientOriginalExtension();
                $location   = public_path('/images/committee/adhoc/'. $filename);
                Image::make($image)->resize(250, 250)->save($location);
                $adhocmember->image = $filename;
            }
        } else {
            if($request->hasFile('image')) {
                $image      = $request->file('image');
                $filename   = $adhocmember->image;
                $location   = public_path('/images/committee/adhoc/'. $filename);
                Image::make($image)->resize(250, 250)->save($location);
                $adhocmember->image = $filename;
            }
        }
            
        $adhocmember->save();
        
        Session::flash('success', 'Updated Successfully!');
        return redirect()->route('dashboard.committee');
    }

    public function deleteCommittee($id)
    {
        $adhocmember = Adhocmember::find($id);
        $image_path = public_path('images/committee/adhoc/'. $adhocmember->image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $adhocmember->delete();

        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.committee');
    }

    public function getNews()
    {
        return view('dashboard.index');
    }

    public function getNotice()
    {
        $notices = Notice::orderBy('id', 'desc')->get();
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

    public function getEvents()
    {
        $events = Event::orderBy('id', 'desc')->get();
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

    public function getGallery()
    {
        $albums = Album::orderBy('id', 'desc')->get();

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
            'description'   =>   'required',
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
            Image::make($image)->resize(600, 375)->save($location);
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

        $lastmember = User::orderBy('id', 'desc')
                          ->where('activation_status', 1)
                          ->first();
        $lastfivedigits = substr($lastmember->member_id, -5);

        $application->member_id = date('Y', strtotime($application->dob)).str_pad(($lastfivedigits+1), 5, '0', STR_PAD_LEFT);;
        $application->save();

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
        $text = 'Dear ' . $application->name . ', your membership application has been approved! You can login and do stuffs. Thanks. http://cvcsbd.com';
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
                       ->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.membership.members')->withMembers($members);
    }

    public function getSignleMember($unique_key)
    {
        $member = User::where('unique_key', $unique_key)->first();

        return view('dashboard.membership.singlemember')
                            ->withMember($member);
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
                           ->orderBy('id', 'desc')
                           ->paginate(10);
        return view('dashboard.profile.payment')
                    ->withPayments($payments);
    }

    public function getSelfPaymentPage() 
    {
        return view('dashboard.profile.selfpayment');
    }

    public function storeSelfPaymentPage(Request $request) 
    {
        $this->validate($request,array(
            'member_id'   =>   'required',
            'amount'      =>   'required|integer',
            'bank'        =>   'required',
            'branch'      =>   'required',
            'image'       =>   'sometimes|image|max:500'

        ));

        $payment = new Payment;
        $payment->member_id = $request->member_id;
        $payment->amount = $request->amount;
        $payment->bank = $request->bank;
        $payment->branch = $request->branch;
        $payment->payment_status = 0;
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
            Image::make($receipt)->resize(400, 250)->save($location);
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
        $text = 'Dear ' . Auth::user()->name . ', payment of tk. '. $request->amount .' is submitted successfully. We will notify you once we approve it. Thanks. http://cvcsbd.com';
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

    public function getMembersPendingPayments() 
    {
        $payments = Payment::where('payment_status', 0)
                           ->orderBy('id', 'desc')
                           ->paginate(10);
        return view('dashboard.payments.pending')
                    ->withPayments($payments);
    }

    public function getMembersApprovedPayments() 
    {
        $payments = Payment::where('payment_status', 1)
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
        $text = 'Dear ' . $payment->user->name . ', payment of tk. '. $payment->amount .' is APPROVED successfully! Thanks. http://cvcsbd.com';
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
}
