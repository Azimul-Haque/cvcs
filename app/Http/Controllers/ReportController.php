<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Payment;
use App\Paymentreceipt;
use App\Donor;
use App\Donation;
use App\Branch;
use App\Branchpayment;
use App\Position;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Image;
use File;
use Session, Config;
use Hash;
use PDF;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function getReportsPage()
    {
        return view('dashboard.reports.index');
    }
}
