<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\About;
use App\Album;
use App\Albumphoto;
use App\Event;
use App\Notice;
use App\Basicinfo;
use App\Formmessage;
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
        parent::__construct();
        
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
        $basicinfo = Basicinfo::where('id', 1)->first();

        return view('dashboard.index')
                    ->withAbout($about)
                    ->withWhoweare($whoweare)
                    ->withWhatwedo($whatwedo)
                    ->withAtaglance($ataglance)
                    ->withMembership($membership)
                    ->withBasicinfo($basicinfo);
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

    public function getMembers()
    {
        return view('dashboard.index');
    }

    public function getApplications()
    {
        return view('dashboard.membership.applications');
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
        return redirect()->route('dashboard.index');
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
}
