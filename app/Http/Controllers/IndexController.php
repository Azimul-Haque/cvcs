<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Blog;
use App\Category;
use App\Adhocmember;
use App\About;
use App\Slider;
use App\Album;
use App\Event;
use App\Notice;
use App\Faq;
use App\Formmessage;

use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use Image;
use File;
use Session;
use Artisan;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('guest')->only('getLogin');
        $this->middleware('auth')->only('getProfile');
    }

    public function index()
    {
        $about = About::where('type', 'about')->get()->first();
        $sliders = Slider::orderBy('id', 'DESC')->get();
        $albums = Album::orderBy('id', 'DESC')->get()->take(4);
        $notices = Notice::orderBy('id', 'DESC')->get()->take(4);
        $events = Event::orderBy('id', 'DESC')->get()->take(4);

        return view('index.index')
                    ->withAbout($about)
                    ->withSliders($sliders)
                    ->withAlbums($albums)
                    ->withNotices($notices)
                    ->withEvents($events);
    }

    public function getAbout()
    {
        $mission = About::where('type', 'mission')->get()->first();
        $whoweare = About::where('type', 'whoweare')->get()->first();
        $whatwedo = About::where('type', 'whatwedo')->get()->first();
        $ataglance = About::where('type', 'ataglance')->get()->first();
        $membership = About::where('type', 'membership')->get()->first();

        return view('index.about')
                    ->withMission($mission)
                    ->withWhoweare($whoweare)
                    ->withWhatwedo($whatwedo)
                    ->withAtaglance($ataglance)
                    ->withMembership($membership);
    }

    public function getMission()
    {
        return view('index.mission');
    }

    public function getBusinessEntity()
    {
        return view('index.otherpages.business_entitny');
    }

    public function getProductServices()
    {
        return view('index.otherpages.product_services');
    }

    public function getWelfare()
    {
        return view('index.otherpages.welfare');
    }

    public function getFaq()
    {
        $faqs = Faq::orderBy('id', 'desc')->get();
        return view('index.otherpages.faq')
                        ->withFaqs($faqs);
    }

    public function getJourney()
    {
        return view('index.journey');
    }

    public function getConstitution()
    {
        return view('index.constitution');
    }

    public function getAdhoc()
    {
        $adhocmembers = Adhocmember::orderBy('id', 'asc')->get();
        return view('index.adhoc')->withAdhocmembers($adhocmembers);
    }

    public function getNews()
    {

    }

    public function getNotice()
    {
        $notices = Notice::orderBy('id', 'desc')->paginate(6);
        return view('index.notice')->withNotices($notices);
    }

    public function getEvents() // paginate korte hobe...
    {
        $events = Event::orderBy('id', 'desc')->get();
        return view('index.event')->withevents($events);
    }

    public function singleEvent($id)
    {
        $event = Event::find($id);
        $events = Event::orderBy('id', 'desc')->get()->take(7);
        return view('index.singleevent')
                                ->withEvent($event)
                                ->withEvents($events);
    }

    public function getGallery()
    {
        $albums = Album::orderBy('id', 'desc')->get();
        return view('index.gallery')->withAlbums($albums);
    }

    public function getSingleGalleryAlbum($id)
    {
        $album = Album::where('id', $id)->get()->first();

        return view('index.singlegallery')->withAlbum($album);
    }

    public function getMembers()
    {
        $members = User::where('role', 'alumni')
                       ->orderBy('passing_year')
                       ->get();
        return view('index.members')->withMembers($members);
    }

    public function getContact()
    {
        return view('index.contact');
    }

    public function getApplication()
    {
        return view('index.membership.application');
    }

    public function getLogin()
    {
        return view('index.login');
    }

    public function getProfile($unique_key)
    {
        $blogs = Blog::where('user_id', Auth::user()->id)->get();
        $categories = Category::all();
        $user = User::where('unique_key', $unique_key)->first();
        if(Auth::user()->unique_key == $unique_key) {
            return view('index.profile')
                    ->withUser($user)
                    ->withCategories($categories)
                    ->withBlogs($blogs);
        } else {
            Session::flash('info', 'Redirected to your profile!');
            return redirect()->route('index.profile', Auth::user()->unique_key); 
        }
        
    }

    public function storeApplication(Request $request)
    {
        $this->validate($request,array(
            'name_bangla'                  => 'required|max:255',
            'name'                         => 'required|max:255',
            'nid'                          => 'required|max:255',
            'dob'                          => 'required|max:255',
            'gender'                       => 'required',
            'spouse'                       => 'required|max:255',
            'spouse_profession'            => 'required|max:255',
            'father'                       => 'required|max:255',
            'mother'                       => 'required|max:255',
            'profession'                   => 'required|max:255',
            'designation'                  => 'required|max:255',
            'office'                       => 'required|max:255',
            'present_address'              => 'required|max:255',
            'permanent_address'            => 'required|max:255',
            'office_telephone'             => 'required|max:255',
            'mobile'                       => 'required|max:255',
            'home_telephone'               => 'required|max:255',
            'email'                        => 'required|email|unique:users,email',
            'image'                        => 'required|image|max:250',

            'nominee_one_name'             => 'required|max:255',
            'nominee_one_identity_type'    => 'required',
            'nominee_one_identity_text'    => 'required|max:255',
            'nominee_one_relation'         => 'required|max:255',
            'nominee_one_percentage'       => 'required|max:255',
            'nominee_one_image'            => 'required|image|max:250',

            'nominee_two_name'             => 'sometimes|max:255',
            'nominee_two_identity_type'    => 'sometimes',
            'nominee_two_identity_text'    => 'sometimes|max:255',
            'nominee_two_relation'         => 'sometimes|max:255',
            'nominee_two_percentage'       => 'sometimes|max:255',
            'nominee_two_image'            => 'sometimes|image|max:250',
            'application_payment_receipt'  => 'sometimes|image|max:500',

            'password'                     => 'required|min:8|same:password_confirmation'
        ));

        $application = new User();
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
        $application->office = htmlspecialchars(preg_replace("/\s+/", " ", $request->office));
        $application->profession = htmlspecialchars(preg_replace("/\s+/", " ", $request->profession));
        $application->designation = htmlspecialchars(preg_replace("/\s+/", " ", $request->designation));
        $application->present_address = htmlspecialchars(preg_replace("/\s+/", " ", $request->present_address));
        $application->permanent_address = htmlspecialchars(preg_replace("/\s+/", " ", $request->permanent_address));
        $application->office_telephone = htmlspecialchars(preg_replace("/\s+/", " ", $request->office_telephone));
        $application->mobile = htmlspecialchars(preg_replace("/\s+/", " ", $request->mobile));
        $application->home_telephone = htmlspecialchars(preg_replace("/\s+/", " ", $request->home_telephone));
        $application->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));

        // applicant's image upload
        if($request->hasFile('image')) {
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
            $nominee_two_image      = $request->file('nominee_two_image');
            $filename   = 'nominee_two_' . str_replace(' ','',$request->name).time() .'.' . $nominee_two_image->getClientOriginalExtension();
            $location   = public_path('/images/users/'. $filename);
            Image::make($nominee_two_image)->resize(200, 200)->save($location);
            $application->nominee_two_image = $filename;
        }
        
        // application payment receipt's image upload
        if($request->hasFile('application_payment_receipt')) {
            $application_payment_receipt      = $request->file('application_payment_receipt');
            $filename   = 'application_payment_receipt_' . str_replace(' ','',$request->name).time() .'.' . $application_payment_receipt->getClientOriginalExtension();
            $location   = public_path('/images/receipts/'. $filename);
            Image::make($application_payment_receipt)->resize(800, 400)->save($location);
            $application->application_payment_receipt = $filename;
        }

        $application->password = Hash::make($request->password);

        $application->role = 'member';
        $application->role_type = 'member';
        $application->activation_status = 0;
        $application->member_id = 0;

        // generate unique_key
        $unique_key_length = 100;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $unique_key = substr(str_shuffle(str_repeat($pool, 100)), 0, $unique_key_length);
        // generate unique_key
        $application->unique_key = $unique_key;
        $application->save();
        
        Session::flash('success', 'আপনার আবেদন সফল হয়েছে! অনুগ্রহ করে আবেদনটি গৃহীত হওয়া পর্যন্ত অপেক্ষা করুন।');

        if(Auth::guest()) {
            Auth::login($application);
            return redirect()->route('index.profile', $unique_key);
        } else {
            if(Auth::user()->role == 'admin') {
                return redirect()->route('dashboard.applications');
            } else {
                return redirect()->route('index.index');
            }
        }
        
    }

    public function storeFormMessage(Request $request)
    {
        $this->validate($request,array(
            'name'                      => 'required|max:255',
            'email'                     => 'required|max:255',
            'message'                   => 'required',
            'contact_sum_result_hidden'   => 'required',
            'contact_sum_result'   => 'required'
        ));

        if($request->contact_sum_result_hidden == $request->contact_sum_result) {
            $message = new Formmessage;
            $message->name = htmlspecialchars(preg_replace("/\s+/", " ", ucwords($request->name)));
            $message->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
            $message->message = htmlspecialchars(preg_replace("/\s+/", " ", $request->message));
            $message->save();
            
            Session::flash('success', 'আপনার বার্তা আমাদের কাছে পৌঁছেছে। ধন্যবাদ!');
            return redirect()->route('index.contact');
        } else {
            return redirect()->route('index.contact')->with('warning', 'যোগফল ভুল হয়েছে! আবার চেষ্টা করুন।')->withInput();
        }
    }


    // clear configs, routes and serve
    public function clear()
    {
        Artisan::call('config:cache');
        // Artisan::call('route:cache');
        Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('key:generate');
        Session::flush();
        echo 'Config and Route Cached. All Cache Cleared';
    }
}
