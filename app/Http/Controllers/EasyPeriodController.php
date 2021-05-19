<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Easyperiodmessage;
use App\Easyperioduserimage;
use App\Easyperiodarticle;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use File;
use Session, Config;
use PDF;
use Storage;
use Purifier;
use Image;

class EasyPeriodController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('auth')->except('storeMessageAPI', 'storeUserImageAPI', 'getUserImageAPI', 'getArticle', 'getArticlesList');
    }

    public function index() {
    	$messages = Easyperiodmessage::orderBy('id', 'desc')->get();
        $articles = Easyperiodarticle::orderBy('id', 'desc')->get();

    	return view('dashboard.easyperiod.index')
                            ->withMessages($messages)
                            ->withArticles($articles);
    }

    public function storeMessageAPI(Request $request) {
    	$this->validate($request,array(
    	    'uid'         => 'required|max:255',
    	    'name'        => 'required|max:255',
    	    'email'       => 'required|max:255',
    	    'message'     => 'required|max:255'
    	));

    	$message = new Easyperiodmessage;
    	$message->uid = $request->uid;
    	$message->name = $request->name;
    	$message->email = $request->email;
    	$message->message = $request->message;
    	$message->location = $request->location;
    	$message->save();

    	return response()->json([
    	    'success' => true
    	]);
    }

    public function delMessage($id)
    {
        $message = Easyperiodmessage::findOrFail($id);
        $message->delete();

        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.easyperiod.index');
    }

    public function storeUserImageAPI(Request $request) {
    	$this->validate($request,array(
    	    'uid'       	  => 'required|max:255',
    	    'image'           => 'sometimes'
    	));

    	$data = $request->all();
    	$uploadedimage = base64_decode($data['image']);

    	$oldimage = Easyperioduserimage::where('uid', $request->uid)->first();
    	if(!empty($oldimage) || $oldimage != null) {
    		$image_path = public_path('/images/easyperiod/users/'. $oldimage->image);
	        if(File::exists($image_path)) {
	            File::delete($image_path);
	        }
	        $filename   = $request->uid . time() . '.jpg';
	        $location   = public_path('/images/easyperiod/users/'. $filename);
	        // Image::make($request->image)->save($location);
	        file_put_contents($location, $uploadedimage);
	        $oldimage->image = $filename;
	        $oldimage->save();

	        return response()->json([
	            'success' => true,
	        ]);
    	} else {
    		$userimage = new Easyperioduserimage;
    		$userimage->uid = $request->uid;

    		$filename   = $request->uid . time() . '.jpg';
	        $location   = public_path('/images/easyperiod/users/'. $filename);
	        // Image::make($request->image)->save($location);
	        file_put_contents($location, $uploadedimage);
	        $userimage->image = $filename;
	        $userimage->save();

	        return response()->json([
	            'success' => true,
	        ]);
    	}
    }
    
    public function getUserImageAPI($uid)
    {
        $userdata = Easyperioduserimage::where('uid', $uid)->first();

        if(!empty($userdata) || $userdata != null) {
            return response()->json([
                'success' => true,
                'image' => $userdata->image
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
    
    public function getArticle($slug)
    {
        $article = Easyperiodarticle::where('slug', $slug)->first();
        
        return view('dashboard.easyperiod.article')
                ->withArticle($article);
    }
    
    public function createArticlePage()
    {        
        return view('dashboard.easyperiod.createarticle');
    }
    
    public function storeArticle(Request $request)
    {        
        $this->validate($request,array(
            'title'          => 'required|max:255',
            'author'         => 'required',
            'category'      => 'required',
            'slug'           => 'required|max:255|unique:easyperiodarticles,slug',
            'body'           => 'required',
            'featured_image' => 'sometimes|image|max:300'
        ));

        //store to DB
        $artilce              = new Easyperiodarticle;
        $artilce->title       = $request->title;
        $artilce->author       = $request->author;
        $artilce->category = $request->category;
        $artilce->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug));
        $artilce->body        = Purifier::clean($request->body, 'youtube');
        
        // image upload
        if($request->hasFile('featured_image')) {
            $image      = $request->file('featured_image');
            $filename   = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug)) . '-' .time() . '.' . $image->getClientOriginalExtension();
            $location   = public_path('images/easyperiod/articles/'. $filename);
            // Image::make($image)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($image)->fit(600, 315)->save($location);
            $artilce->featured_image = $filename;
        }

        $artilce->save();
        //redirect
        return redirect()->route('dashboard.easyperiod.index');
    }

    public function editArticle($id)
    {
        $article = Easyperiodarticle::findOrFail($id);
        return view('dashboard.easyperiod.editarticle')
                        ->withArticle($article);
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Easyperiodarticle::findOrFail($id);

        $this->validate($request,array(
            'title'          => 'required|max:255',
            'author'         => 'required',
            'category'      => 'required',
            'slug'           => 'required|max:255|unique:blogs,slug,'.$article->id,
            'body'           => 'required',
            'featured_image' => 'sometimes|image|max:300'
        ));

        //update to DB
        $article->title       = $request->title;
        $article->author       = $request->author;
        $article->category       = $request->category;
        if($article->slug == $request->slug) {

        } else {
            $article->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug));
        }
        $article->body        = Purifier::clean($request->body, 'youtube');
        
        // image upload
        if($request->hasFile('featured_image')) {
            $image_path = public_path('images/easyperiod/articles/'. $article->featured_image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $image      = $request->file('featured_image');
            $filename   = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug)) . '-' .time() . '.' . $image->getClientOriginalExtension();
            $location   = public_path('images/easyperiod/articles/'. $filename);
            // Image::make($image)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($image)->fit(600, 315)->save($location);
            $article->featured_image = $filename;
        }

        $article->save();

        Session::flash('success', 'Article updated successfully!');
        //redirect
        return redirect()->route('dashboard.easyperiod.index');
    }

    public function delArticle($id)
    {
        $article = Easyperiodarticle::findOrFail($id);

        $image_path = public_path('images/easyperiod/articles/'. $article->featured_image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $article->delete();

        Session::flash('success', 'Deleted Successfully!');
        //redirect
        return redirect()->route('dashboard.easyperiod.index');
    }

    public function getArticlesList()
    {
        $articles = Easyperiodarticle::orderBy('id', 'desc')->get();

        $articlelist = [];

        foreach ($articles as $article) {
            $articlelist[] = $article->slug;
        }
        return $articlelist;
    }
}
