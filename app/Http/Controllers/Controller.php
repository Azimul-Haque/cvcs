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

      // sms balance check
      $url = config('sms.gp_url');
      $data_notif= array(
          'username'=>config('sms.gp_username'),
          'password'=>config('sms.gp_password'),
          'apicode'=>"3",
          'msisdn'=>"0",
          'countrycode'=>"0",
          'cli'=>"0",
          'messagetype'=>"0",
          'message'=>"0",
          'messageid'=>"0"
      );
      
      // initialize send status
      $chnotif = curl_init(); // Initialize cURL
      curl_setopt($chnotif, CURLOPT_URL,$url);
      curl_setopt($chnotif, CURLOPT_POSTFIELDS, http_build_query($data_notif));
      curl_setopt($chnotif, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($chnotif, CURLOPT_SSL_VERIFYPEER, false); // this is important
      $smsresultnotif = curl_exec($chnotif);
      
      if(substr($smsresultnotif, 0, 3) == 200) {
        $smsbalance = substr(substr($smsresultnotif, 4), 0, -2);
        dd($smsbalance);
      }
      // sms balance check
      
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
