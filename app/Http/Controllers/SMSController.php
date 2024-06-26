<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\About;
use App\Slider;
use App\Album;
use App\Albumphoto;
use App\Event;
use App\Notice;
use App\Basicinfo;
use App\Formmessage;
use App\Payment;
use App\Paymentreceipt;
use App\Faq;
use App\Committee;
use App\Donor;
use App\Donation;
use App\Branch;
use App\Branchpayment;
use App\Tempmemdata;
use App\Position;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Session, Config;
use PDF;

class SMSController extends Controller
{
    public function getSMSModule() 
    {
        return view('dashboard.smsmodule');
    }

    public function sendBulkSMS(Request $request) 
    {
        $this->validate($request,array(
            'smsbalance' => 'required',
            'message'    => 'required',
            'smscount'   => 'required'
        ));
        
        $members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')                
                       ->get();
                       
        // ADHOC
        // ADHOC
        // if(($request->smsbalance) < ($members->count() * $request->smscount)) {
        //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি! রিচার্জ করুন।');
        //     return redirect()->route('dashboard.smsmodule');
        // }
        // ADHOC
        // ADHOC
                      
        // send sms
        $numbersarray = [];
        foreach ($members as $member) {
            $mobile_number = 0;
            if(strlen($member->mobile) == 11) {
                $mobile_number = $member->mobile;
            } elseif(strlen($member->mobile) > 11) {
                if (strpos($member->mobile, '+') !== false) {
                    $mobile_number = substr($member->mobile, -11);
                }
            }
            $numbersarray[] = $mobile_number;
        }
        $numbersstr = implode (",", $numbersarray);
        // dd($numbersstr);
        
        // $url = config('sms.url');
        // $number = $mobile_number;
        $text = $request->message; // . ' Customs and VAT Co-operative Society (CVCS).';
        
        // NEW PANEL
        $url = config('sms.url2');
        $api_key = config('sms.api_key');
        $senderid = config('sms.senderid');
        $number = $numbersstr;
        $message = $text;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonresponse = json_decode($response);

        if($jsonresponse->response_code == 202) {
            Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } elseif($jsonresponse->response_code == 1007) {
            Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }
        // NEW PANEL
        return redirect()->route('dashboard.smsmodule');
    }

    public function sendReminderSMS(Request $request) 
    {
        $this->validate($request,array(
            'hiddengbbalance' => 'required',
            'confirmation' => 'required'
        ));

        if($request->confirmation == 'Confirm') {
	        $members = User::where('activation_status', 1)
	                       ->where('role_type', '!=', 'admin')         
	                       ->with(['payments' => function ($query) {
	                            $query->where('payment_status', '=', 1);
	                            $query->where('is_archieved', '=', 0);
	                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
	                        }])           
	                       ->get();

	        $intotalmontlydues = 0;

	        $smsdata = [];
	        foreach ($members as $i => $member) {
	            $approvedcashformontly = $member->payments->sum('amount');
	            $totalmonthsformember = 0;
	            $member->totalpendingmonthly = 0;
	            if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
	            {
	                $thismonth = Carbon::now()->format('Y-m-');
	                $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
	                $to = Carbon::createFromFormat('Y-m-d', $thismonth . date('t', strtotime($thismonth))); // t returns the number of days of the month
	                $totalmonthsformember = $to->diffInMonths($from);
	                if(($totalmonthsformember * 300) > $approvedcashformontly) {
	                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
	                }
	            } else {
	                $startmonth = date('Y-m-', strtotime($member->joining_date));
	                $thismonth = Carbon::now()->format('Y-m-');
	                $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
	                $to = Carbon::createFromFormat('Y-m-d', $thismonth . date('t', strtotime($thismonth))); // t returns the number of days of the month
	                $totalmonthsformember = $to->diffInMonths($from);
	                if(($totalmonthsformember * 300) > $approvedcashformontly) {
	                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
	                }
	            }

	            if($member->totalpendingmonthly > 0) {
	            	$mobile_number = 0;
	            	if(strlen($member->mobile) == 11) {
	            	    $mobile_number = $member->mobile;
	            	} elseif(strlen($member->mobile) > 11) {
	            	    if (strpos($member->mobile, '+') !== false) {
	            	        $mobile_number = substr($member->mobile, -11);
	            	    }
	            	}
                    $pendingmonths = (int) ceil($member->totalpendingmonthly / 300);
                    if($pendingmonths == 1 || 0) {
                        $text = 'Dear ' . $member->name . ', your monthly payment for the month ' . date('F, Y') . ' is due, you are requested to pay it. Total due: ' . $member->totalpendingmonthly . '/-. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                    } else {
                        $text = 'Dear ' . $member->name . ', your monthly payments from ' . date("F, Y", strtotime("-". ($pendingmonths - 1) ." months"))  . ' to ' . date('F, Y') . ' are due, you are requested to pay it. Total due: ' . $member->totalpendingmonthly . '/-. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                    }
	            	

                    $encodedtext = rawurlencode($text);
	            	// $encodedtext = $text;
	            	$smsdata[$i] = array(
                        // 'name'=>"$member->name",
                        // 'name_bangla'=>"$member->name_bangla",
                        // 'member_id'=>"$member->member_id",
	            	    'to'=>"$mobile_number",
                        'message'=>"$encodedtext", // $encodedtext
                  //       'joining_date'=>"$member->joining_date",
	            	    // 'due'=>"$member->totalpendingmonthly",
	            	);
	            } else {
                    $mobile_number = 0;
                    if(strlen($member->mobile) == 11) {
                        $mobile_number = $member->mobile;
                    } elseif(strlen($member->mobile) > 11) {
                        if (strpos($member->mobile, '+') !== false) {
                            $mobile_number = substr($member->mobile, -11);
                        }
                    }
                    $text = 'Dear ' . $member->name . ', your monthly payment for the month ' . date('F, Y') . ' is already paid. Thank you. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';

                    $encodedtext = rawurlencode($text);
                    $smsdata[$i] = array(
                        // 'name'=>"$member->name",
                        // 'name_bangla'=>"$member->name_bangla",
                        // 'member_id'=>"$member->member_id",
                        'to'=>"$mobile_number",
                        'message'=>"$encodedtext", // $encodedtext
                        // 'joining_date'=>"$member->joining_date",
                        // 'due'=>"$member->totalpendingmonthly",
                    );
                }
	        }

            // TEST CODE
            // TEST CODE
            // ini_set('max_execution_time', '300');
            // ini_set("pcre.backtrack_limit", "5000000");
            // $pdf = PDF::loadView('dashboard.dumpfiles.reminderpdf', ['smsdata' => array_slice($smsdata, 0, 500)]);
            // $fileName = 'Reminder_SMS_List.pdf';
            // return $pdf->stream($fileName);
            // TEST CODE
            // TEST CODE
	        $smsdata = array_values($smsdata);

            // SMS LIST PRINT
            // SMS LIST PRINT
            // SMS LIST PRINT
            // return view('dashboard.smstest')
            //         ->withSmsdata($smsdata);

	        $smsjsondata = json_encode($smsdata);
        	// echo $smsjsondata;
            // dd($smsjsondata);

            // APATOTO TULE DEOA HOILO
            // APATOTO TULE DEOA HOILO
            // APATOTO TULE DEOA HOILO
            // APATOTO TULE DEOA HOILO
            // if((count($smsdata) * 2) > (int) $request->hiddengbbalance) {
            //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি! রিচার্জ করুন।');
            //     return redirect()->route('dashboard.smsmodule');
            // }

	        $url = config('sms.gw_url');

	        $data= array(
	            'smsdata'=>"$smsjsondata",
	            // 'username'=>config('sms.username'),
	            // 'password'=>config('sms.password'),
	            'token'=>config('sms.gw_token'),
	        ); // Add parameters in key value
	        $ch = curl_init(); // Initialize cURL
	        curl_setopt($ch, CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_ENCODING, '');
	        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $smsresult = curl_exec($ch);

	        $resultstr = substr($smsresult, 0, 6);
	        // dd($smsresult);

	        if($resultstr == '') {
	            Session::flash('success', bangla(count($smsdata)) . ' জন সদস্যকে SMS সফলভাবে পাঠানো হয়েছে!');
            } elseif($resultstr == 'Error:' && strpos($smsresult, 'Invalid Number !') !== false) {
                Session::flash('success', bangla(count($smsdata) - substr_count($smsresult, 'Invalid Number !')) . ' জন সদস্যকে SMS সফলভাবে পাঠানো হয়েছে! মোট ' . bangla(substr_count($smsresult, 'Invalid Number !')) . ' টি অকার্যকর নম্বর।');
	        } elseif($resultstr == 'Error:' && strpos($smsresult, 'Invalid Number !') == false) {
	            Session::flash('info', 'দুঃখিত! SMS পাঠানো যায়নি!');
	            // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
	        } else {
                // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
	            Session::flash('warning', 'কিছু কিছু নাম্বারে SMS পাঠানো যায়নি!');
	        }
	        return redirect()->route('dashboard.smsmodule');
        } else {
        	Session::flash('warning', 'Confirm শব্দটি ঠিকমতো লিখুন!');
            return redirect()->route('dashboard.smsmodule');
        }
    }

    public function sendReminderSMSPrev() 
    {
        $members = User::where('activation_status', 1)
                       ->where('role_type', '!=', 'admin')         
                       ->with(['payments' => function ($query) {
                            $query->where('payment_status', '=', 1);
                            $query->where('is_archieved', '=', 0);
                            $query->where('payment_category', 1);  // 1 means monthly, 0 for membership
                        }])           
                       ->get();

        
        $intotalmontlydues = 0;

        $smsdata = [];
        foreach ($members as $i => $member) {
            $approvedcashformontly = $member->payments->sum('amount');
            $totalmonthsformember = 0;
            $member->totalpendingmonthly = 0;
            if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date)) {
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', '2019-1-1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . date('t', strtotime($thismonth))); // t returns the number of days of the month
                $totalmonthsformember = $to->diffInMonths($from);
                if(($totalmonthsformember * 300) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                }
            } else {
                $startmonth = date('Y-m-', strtotime($member->joining_date));
                $thismonth = Carbon::now()->format('Y-m-');
                $from = Carbon::createFromFormat('Y-m-d', $startmonth . '1');
                $to = Carbon::createFromFormat('Y-m-d', $thismonth . date('t', strtotime($thismonth))); // t returns the number of days of the month
                $totalmonthsformember = $to->diffInMonths($from);
                if(($totalmonthsformember * 300) > $approvedcashformontly) {
                  $member->totalpendingmonthly = ($totalmonthsformember * 300) - $approvedcashformontly;
                }
            }

            if($member->totalpendingmonthly > 0) {
                $mobile_number = 0;
                if(strlen($member->mobile) == 11) {
                    $mobile_number = $member->mobile;
                } elseif(strlen($member->mobile) > 11) {
                    if (strpos($member->mobile, '+') !== false) {
                        $mobile_number = substr($member->mobile, -11);
                    }
                }
                $pendingmonths = (int) ceil($member->totalpendingmonthly / 300);
                if($pendingmonths == 1 || 0) {
                    $text = 'Dear ' . $member->name . ', your monthly payment for the month ' . date('F, Y') . ' is due, you are requested to pay it. Total due: ' . $member->totalpendingmonthly . '/-. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                } else {
                    $text = 'Dear ' . $member->name . ', your monthly payments from ' . date("F, Y", strtotime("-". ($pendingmonths - 1) ." months"))  . ' to ' . date('F, Y') . ' are due, you are requested to pay it. Total due: ' . $member->totalpendingmonthly . '/-. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';
                }
                

                $encodedtext = rawurlencode($text);
                $smsdata[$i] = array(
                    'name'=>"$member->name",
                    'name_bangla'=>"$member->name_bangla",
                    'member_id'=>"$member->member_id",
                    'to'=>"$mobile_number",
                    'message'=>"$text", // $encodedtext
                    'joining_date'=>"$member->joining_date",
                    'due'=>"$member->totalpendingmonthly",
                );
            } else {
                $mobile_number = 0;
                if(strlen($member->mobile) == 11) {
                    $mobile_number = $member->mobile;
                } elseif(strlen($member->mobile) > 11) {
                    if (strpos($member->mobile, '+') !== false) {
                        $mobile_number = substr($member->mobile, -11);
                    }
                }
                $text = 'Dear ' . $member->name . ', your monthly payment for the month ' . date('F, Y') . ' is already paid. Thank you. Customs and VAT Co-operative Society (CVCS). Login: https://cvcsbd.com/login';

                $encodedtext = rawurlencode($text);
                $smsdata[$i] = array(
                    'name'=>"$member->name",
                    'name_bangla'=>"$member->name_bangla",
                    'member_id'=>"$member->member_id",
                    'to'=>"$mobile_number",
                    'message'=>"$text", // $encodedtext
                    'joining_date'=>"$member->joining_date",
                    'due'=>"$member->totalpendingmonthly",
                );
            }
        }

        // TEST CODE
        // TEST CODE
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('dashboard.dumpfiles.reminderpdf', ['smsdata' => array_slice($smsdata, 0, 2000)]);
        $fileName = 'Reminder_SMS_List.pdf';
        return $pdf->stream($fileName);
        // TEST CODE
        // TEST CODE
    }

    public function testGPSMSAPI() 
    {
        // KAAJ BAKI ACHE...
        // KAAJ BAKI ACHE...
        // KAAJ BAKI ACHE...
        $url = config('sms.gp_url');
        $number = '01751398392';
        $text = 'This is test';
        
        $data= array(
            'username'=>config('sms.gp_username'),
            'password'=>config('sms.gp_password'),
            'apicode'=>"1",
            'msisdn'=>"01751398392,01837409842",
            'countrycode'=>"880",
            'cli'=>"CVCS",
            'messagetype'=>"1",
            'message'=>"$text",
            'messageid'=>"1"
        );

        // balance check
        // $data= array(
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
        
        // initialize send status
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        $smsresult = curl_exec($ch);
        
        $result = substr($smsresult, 0, 3);
        // $result = file_get_contents('https://gpcmp.grameenphone.com/gpcmpapi/messageplatform/controller.home?username=CAVCSAdmin_3978&password=API_CVCSbd_123&apicode=1&msisdn=01843872972&countrycode=880&cli=CVCS&messagetype=1&message=Test&messageid=1');
        echo $smsresult;

    }

    public function testMultiGPSMSAPI() 
    {
        $users = User::where('mobile', '01837409842')
                     ->orWhere('mobile', '01751398392')
                     ->orWhere('mobile', '03846328463')
                     ->get();

        $smssuccesscount = 0;
        $url = config('sms.gp_url');
        $text = 'This is test';
        
        $multiCurl = array();
        // data to be returned
        $result = array();
        // multi handle
        $mh = curl_multi_init();

        // sms data
        $smsdata = [];
        foreach ($users as $i => $user) {
            $mobile_number = 0;
            if(strlen($user->mobile) == 11) {
                $mobile_number = $user->mobile;
            } elseif(strlen($user->mobile) > 11) {
                if (strpos($user->mobile, '+') !== false) {
                    $mobile_number = substr($user->mobile, -11);
                }
            }
            $text = 'Dear ' . $user->name . ', This is a test!';
            $smsdata[$i] = array(
                'username'=>config('sms.gp_username'),
                'password'=>config('sms.gp_password'),
                'apicode'=>"1",
                'msisdn'=>"$mobile_number",
                'countrycode'=>"880",
                'cli'=>"CVCS",
                'messagetype'=>"3",
                'message'=>"$text",
                'messageid'=>"1"
            );
            $multiCurl[$i] = curl_init(); // Initialize cURL
            curl_setopt($multiCurl[$i], CURLOPT_URL, $url);
            curl_setopt($multiCurl[$i], CURLOPT_HEADER, 0);
            curl_setopt($multiCurl[$i], CURLOPT_POSTFIELDS, http_build_query($smsdata[$i]));
            curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($multiCurl[$i], CURLOPT_SSL_VERIFYPEER, false); // this is important
            curl_multi_add_handle($mh, $multiCurl[$i]);
        }

        $index=null;
        do {
          curl_multi_exec($mh, $index);
        } while($index > 0);
        // get content and remove handles
        foreach($multiCurl as $k => $ch) {
          $result[$k] = curl_multi_getcontent($ch);
          curl_multi_remove_handle($mh, $ch);
          $sendstatus = substr($result[$k], 0, 3);;
          if($sendstatus == 200) {
              $smssuccesscount++;
          }
        }
        // close
        curl_multi_close($mh);


        print_r($result);
    }
}
