<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Blog;
use App\Category;
use App\Adhocmember;
use App\About;

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
        $this->middleware('guest')->only('getLogin');
        $this->middleware('auth')->only('getProfile');
    }

    public function index()
    {
        $about = About::where('type', 'about')->get()->first();
        $blogs = Blog::orderBy('id', 'DESC')->get()->take(4);
        return view('index.index')
                    ->withAbout($about)
                    ->withBlogs($blogs);
    }

    public function getAbout()
    {
        $whoweare = About::where('type', 'whoweare')->get()->first();
        $whatwedo = About::where('type', 'whatwedo')->get()->first();
        $ataglance = About::where('type', 'ataglance')->get()->first();
        $membership = About::where('type', 'membership')->get()->first();

        return view('index.about')
                    ->withWhoweare($whoweare)
                    ->withWhatwedo($whatwedo)
                    ->withAtaglance($ataglance)
                    ->withMembership($membership);
    }

    public function getJourney()
    {
        return view('index.journey');
    }

    public function getConstitution()
    {
        return view('index.constitution');
    }

    public function getFaq()
    {
        return view('index.faq');
    }

    public function getAdhoc()
    {
        $adhocmembers = Adhocmember::orderBy('id', 'asc')->get();
        return view('index.adhoc')->withAdhocmembers($adhocmembers);
    }

    public function getNews()
    {
        //
    }

    public function getEvents()
    {
        //
    }

    public function getGallery()
    {
        //
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
        //
    }

    public function getApplication()
    {
        return view('index.application');
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
            'name'                      => 'required|max:255',
            'email'                     => 'required|email|unique:users,email',
            'phone'                     => 'required|numeric',
            'dob'                       => 'required|max:255',
            'degree'                    => 'required|max:255',
            'batch'                     => 'required|max:255',
            'passing_year'              => 'required|numeric',
            'current_job'               => 'sometimes|max:255',
            'designation'               => 'sometimes|max:255',
            'address'                   => 'required|max:255',
            'fb'                        => 'sometimes|max:255',
            'twitter'                   => 'sometimes|max:255',
            'gplus'                     => 'sometimes|max:255',
            'linkedin'                  => 'sometimes|max:255',
            'image'                     => 'required|image|max:200',
            'password'                  => 'required|min:8|same:password_confirmation'
        ));

        $application = new User();
        $application->name = htmlspecialchars(preg_replace("/\s+/", " ", ucwords($request->name)));
        $application->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
        $application->phone = htmlspecialchars(preg_replace("/\s+/", " ", $request->phone));
        $dob = htmlspecialchars(preg_replace("/\s+/", " ", $request->dob));
        $application->dob = new Carbon($dob);
        $application->degree = htmlspecialchars(preg_replace("/\s+/", " ", $request->degree));
        $application->batch = htmlspecialchars(preg_replace("/\s+/", " ", $request->batch));
        $application->passing_year = htmlspecialchars(preg_replace("/\s+/", " ", $request->passing_year));
        $application->current_job = htmlspecialchars(preg_replace("/\s+/", " ", $request->current_job));
        $application->designation = htmlspecialchars(preg_replace("/\s+/", " ", $request->designation));
        $application->address = htmlspecialchars(preg_replace("/\s+/", " ", $request->address));
        $application->fb = htmlspecialchars(preg_replace("/\s+/", " ", $request->fb));
        $application->twitter = htmlspecialchars(preg_replace("/\s+/", " ", $request->twitter));
        $application->gplus = htmlspecialchars(preg_replace("/\s+/", " ", $request->gplus));
        $application->linkedin = htmlspecialchars(preg_replace("/\s+/", " ", $request->linkedin));

        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = str_replace(' ','',$request->name).time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/users/'. $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $application->image = $filename;
        }
        $application->password = Hash::make($request->password);

        $application->role = 'alumni';
        $application->payment_status = 0;

        // amount will be set dynamically
        // $application->amount = null;
        // $application->trxid = null;

        // generate unique_key
        $unique_key_length = 100;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $unique_key = substr(str_shuffle(str_repeat($pool, 100)), 0, $unique_key_length);
        // generate unique_key
        $application->unique_key = $unique_key;
        $application->save();
        
        Session::flash('success', 'You have registered Successfully!');
        Auth::login($application);
        return redirect()->route('index.profile', $unique_key);
    }


    // clear configs, routes and serve
    public function clear()
    {
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        echo 'Config and Route Cached. All Cache Cleared';
    }
}
