<?php

namespace App\Http\Controllers\FuadControllers;

use App\Position;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    public function addPosition(Request $request){
        $this->validate($request,array(
            'name' => 'required| unique:positions| max:255',
        ));

            $newPosition = new Position();
            $newPosition->name = $request->name;
            $newPosition->save();

            Session::flash('success', 'সফলভাবে পদবি যোগ করা হয়েছে!');
            return redirect()->route('dashboard.designations');
    }

    public function updatePosition(Request $request){
        $this->validate($request,array(
            'position_id' => 'required',
            'name' => 'required|  unique:positions,name,'.$request->position_id.'| max:255',
        ));

            $position = Position::findOrFail($request->position_id);

            if($position){
                $position->name = $request->name;
                $position->save();
                Session::flash('success', 'সফলভাবে পদবি যোগ করা হয়েছে!');
            } else{
                Session::flash('warning', 'সঠিক পদবি প্রদান করুন!');
            }


            return redirect()->route('dashboard.designations');
    }

}
