<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Easyperiodmessage;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use File;
use Session, Config;
use PDF;

class EasyPeriodController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('auth')->except('storeMessageAPI');
    }

    public function index() {
    	$messages = Easyperiodmessage::orderBy('id', 'desc')->get();
    	return view('dashboard.easyperiod.index')->withMessages($messages);
    }

    public function storeMessageAPI(Request $request) {
    	$this->validate($request,array(
    	    'name'        => 'required|max:255',
    	    'email'       => 'required|max:255',
    	    'message'     => 'required|max:255'
    	));

    	$message = new Easyperiodmessage;
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

}
