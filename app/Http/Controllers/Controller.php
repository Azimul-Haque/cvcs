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

      $notifpendingapplications = User::where('activation_status', 0)->count();

      $notifdefectiveapplications = User::where('activation_status', 202)->count();

      $notifpendingpayments = Payment::where('payment_status', 0)
                                     ->where('is_archieved', 0)
                                     ->count();

      $notiftempmemdatas = Tempmemdata::count();

      $notifregisteredmember = User::where('activation_status', 1)
                                   ->where('role_type', '!=', 'admin')                
                                   ->count();

      // sms balance check
      // $url = config('sms.gp_url');
      // $data_notif= array(
      //     'username'=>config('sms.gp_username'),
      //     'password'=>config('sms.gp_password'),
      //     'apicode'=>"3",
      //     'msisdn'=>"0",
      //     'countrycode'=>"0",
      //     'cli'=>"0",
      //     'messagetype'=>"0",
      //     'message'=>"0",
      //     'messageid'=>"0"
      // );
      
      // // initialize send status
      // $chnotif = curl_init(); // Initialize cURL
      // curl_setopt($chnotif, CURLOPT_URL,$url);
      // curl_setopt($chnotif, CURLOPT_POSTFIELDS, http_build_query($data_notif));
      // curl_setopt($chnotif, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($chnotif, CURLOPT_SSL_VERIFYPEER, false); // this is important
      // $smsresultnotif = curl_exec($chnotif);
      
      // $notifsmsbalance = -1;
      // if(substr($smsresultnotif, 0, 3) == 200) {
      //   $notifsmsbalance = substr(substr($smsresultnotif, 4), 0, -2);
      // }
      $actualbalance = 0;
      try {
          $url = 'http://66.45.237.70/balancechk.php?username='. config('sms.username') .'&password=' . config('sms.password') . '';

          //  Initiate curl
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_URL,$url);
          $result=curl_exec($ch);
          curl_close($ch);

          $actualbalance = number_format((float) $result, 2, '.', '');
          
      } catch (\Exception $e) {

      }
      $notifsmsbalance = -1;
      if($actualbalance > 0) {
        $notifsmsbalance = $actualbalance;
      }
      // sms balance check

      // GREENWEBsms balance check
      
      $actualgbbalance = 0;
      try {
          $grurl = 'http://api.greenweb.com.bd/g_api.php?token='. config('sms.gw_token') .'&balance';
          
          //  Initiate curl
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_URL,$grurl);
          $result=curl_exec($ch);
          curl_close($ch);

          $actualgbbalance = number_format((float) $result, 2, '.', '');
          
      } catch (\Exception $e) {

      }
      $notifgbsmsbalance = -1;
      if($actualgbbalance > 0) {
        $notifgbsmsbalance = $actualgbbalance;
      }
      // GREENWEBsms balance check
      
      $notifcount = 0;
      if($notifpendingapplications > 0) {
        $notifcount++;
      }
      if($notifdefectiveapplications > 0) {
      	$notifcount++;
      }
      if($notifpendingpayments > 0) {
      	$notifcount++;
      }
      if($notiftempmemdatas > 0) {
        $notifcount++;
      } 
      if($notifsmsbalance > 0 && $notifsmsbalance < 21) { // test
      	$notifcount++;
      }    

      View::share('sharedbasicinfo', $sharedbasicinfo);
      View::share('notifpendingapplications', $notifpendingapplications);
      View::share('notifdefectiveapplications', $notifdefectiveapplications);
      View::share('notifpendingpayments', $notifpendingpayments);
      View::share('notiftempmemdatas', $notiftempmemdatas);
      View::share('notifcount', $notifcount);
      View::share('notifsmsbalance', $notifsmsbalance);
      View::share('notifregisteredmember', $notifregisteredmember);
      View::share('notifgbsmsbalance', $notifgbsmsbalance);
    }

}
