<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\About;
use App\Album;
use App\Albumphoto;
use App\Event;
use App\Adhocmember;

use DB;
use Auth;
use Image;
use File;
use Session;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = About::where('type', 'about')->get()->first();
        $whoweare = About::where('type', 'whoweare')->get()->first();
        $whatwedo = About::where('type', 'whatwedo')->get()->first();
        $ataglance = About::where('type', 'ataglance')->get()->first();
        $membership = About::where('type', 'membership')->get()->first();

        return view('dashboard.index')
                    ->withAbout($about)
                    ->withWhoweare($whoweare)
                    ->withWhatwedo($whatwedo)
                    ->withAtaglance($ataglance)
                    ->withMembership($membership);
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

    public function getEvents()
    {
        $events = Event::orderBy('id', 'desc')->get();

        return view('dashboard.event')->withEvents($events);
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
            'thumbnail'     =>   'required|image|max:250',
            'image1'        =>   'sometimes|image|max:250',
            'image2'        =>   'sometimes|image|max:250',
            'image3'        =>   'sometimes|image|max:250',
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
            Image::make($thumbnail)->resize(500, 312)->save($location);
            $album->thumbnail = $filename;
        }
        
        $album->save();

        // photo (s) upload
        for($i = 1; $i <= 3; $i++) {
            if($request->hasFile('image'.$i)) {
                $image      = $request->file('image'.$i);
                $filename   = 'photo_'. $i . time() .'.' . $image->getClientOriginalExtension();
                $location   = public_path('/images/gallery/'. $filename);
                Image::make($image)->resize(400, 250)->save($location);
                $albumphoto = new Albumphoto;
                $albumphoto->album_id = $album->id;
                $albumphoto->image = $filename;
                $albumphoto->caption = $request->input('caption'.$i);
                $albumphoto->save();
            }
        }
        
        Session::flash('success', 'Album has been creaed successfully!');
        return redirect()->route('dashboard.gallery');
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

    public function getBlogs()
    {
        return view('dashboard.index');
    }

    public function getMembers()
    {
        return view('dashboard.index');
    }

    public function getApplications()
    {
        return view('dashboard.index');
    }

    public function updateAbouts(Request $request, $id) {
        $this->validate($request,array(
            'text' => 'required',
        ));

        $about = About::find($id);
        $about->text = $request->text;
     
        $about->save();
        
        Session::flash('success', 'Updated Successfully!');
        return redirect()->route('dashboard.index');
    }
}
