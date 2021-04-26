<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Easyperiodmessage;
use App\Easyperioduserimage;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use File;
use Session, Config;
use PDF;
use Storage;

class EasyPeriodController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('auth')->except('storeMessageAPI', 'storeUserImageAPI');
    }

    public function index() {
    	$messages = Easyperiodmessage::orderBy('id', 'desc')->get();
    	return view('dashboard.easyperiod.index')->withMessages($messages);
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
    	} else {
    		$userimage = new Easyperioduserimage;
    		$userimage->uid = $request->uid;

    		$filename   = $request->uid . time() . '.jpg';
	        $location   = public_path('/images/easyperiod/users/'. $filename);
	        // Image::make($request->image)->save($location);
	        file_put_contents($location, $uploadedimage);
	        $userimage->image = $filename;
	        $userimage->save();
    	}

    	return response()->json([
    	    'success' => true,
    	    'image' => $request->image,
    	]);
    }
}
