<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Basicinfo;
use App\Payment;
use App\User;
use App\Tempmemdata;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct() 
    {
      $sharedbasicinfo = Basicinfo::find(1);

      $notifpendingfapplications = User::where('activation_status', 0)
      								  ->orWhere('activation_status', 202)
      								  ->count();

      $notifpendingpayments = Payment::where('payment_status', 0)
                                     ->where('is_archieved', 0)
                                     ->count();

      $notiftempmemdatas = Tempmemdata::count();

      $notifcount = 0;
      if($notifpendingfapplications > 0) {
      	$notifcount++;
      }
      if($notifpendingpayments > 0) {
      	$notifcount++;
      }
      if($notiftempmemdatas > 0) {
      	$notifcount++;
      }    

      View::share('sharedbasicinfo', $sharedbasicinfo);
      View::share('notifpendingfapplications', $notifpendingfapplications);
      View::share('notifpendingpayments', $notifpendingpayments);
      View::share('notiftempmemdatas', $notiftempmemdatas);
      View::share('notifcount', $notifcount);
    }

}
