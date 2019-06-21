@extends('adminlte::page')

@section('title', 'CVCS | সদস্য তথ্য')

@section('css')
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      সদস্য তথ্য
      <div class="pull-right">
        @if(Auth::user()->activation_status == 0)

        @else
          <button class="btn btn-success" data-toggle="modal" data-target="#downloadPDFModal" data-backdrop="static" title="আপনার রিপোর্ট ডাউনলোড করুন" id="downloadPDFButton"><i class="fa fa-download"></i></button>
          <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal" data-backdrop="static" title="প্রোফাইল হালনাগাদ করুন"><i class="fa fa-fw fa-edit" aria-hidden="true"></i></button>
          {{-- <button class="btn btn-danger" data-toggle="modal" data-target="#deleteMemberModal" data-backdrop="static" title="সদস্য মুছে ফেলুন" disabled=""><i class="fa fa-fw fa-trash" aria-hidden="true"></i></button> --}}
        @endif
      </div>
    </h1>

    <!-- Download Report PDF Modal -->
    <!-- Download Report PDF Modal -->
    <div class="modal fade" id="downloadPDFModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header modal-header-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-download"></i> সদস্য বিস্তারিত রিপোর্ট ডাউনলোড</h4>
          </div>
          {!! Form::open(['route' => 'dashboard.member.complete.pdf', 'method' => 'POST', 'class' => 'form-default']) !!}
          <div class="modal-body">
            সদস্য বিস্তারিত রিপোর্টটি ডাউনলোড করুন
            {!! Form::hidden('id', $member->id) !!}                      
            {!! Form::hidden('member_id', $member->member_id) !!}
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> ডাউনলোড করুন</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Download Report PDF Modal -->
    <!-- Download Report PDF Modal -->

    <!-- Edit Info Modal -->
    <!-- Edit Info Modal -->
    <div class="modal fade" id="editProfileModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-pencil"></i> তথ্য হালনাগাদ করুন</h4>
          </div>
          {!! Form::model($member, ['route' => ['dashboard.profileupdate', $member->id], 'method' => 'PATCH', 'class' => 'form-default', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '']) !!}
          <div class="modal-body">
            @if($member->tempmemdatas->count() > 0)
              <big>আপনি একবার (সময়ঃ <b>{{ date('F d, Y h:i A', strtotime($member->tempmemdatas[0]->created_at)) }}</b>) তথ্য পরিবর্তন অনুরোধ করেছেন । আমাদের একজন প্রতিনিধি তা অনুমোদন (Approve) করা পর্যন্ত অনুগ্রহ করে অপেক্ষা করুন!</big>
            @else
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group ">
                      {!! Form::label('designation', 'পদবি *') !!}
                      {!! Form::text('designation', null, array('class' => 'form-control', 'placeholder' => 'পদবি লিখুন', 'required')) !!}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                      {!! Form::label('office', 'দপ্তর *') !!}
                      {!! Form::text('office', null, array('class' => 'form-control', 'placeholder' => 'দপ্তরের নাম লিখুন', 'required')) !!}
                  </div>
                </div>
              </div>
              <div class="form-group ">
                  {!! Form::label('present_address', 'বর্তমান ঠিকানা *') !!}
                  {!! Form::text('present_address', null, array('class' => 'form-control', 'placeholder' => 'বর্তমান ঠিকানা লিখুন', 'required')) !!}
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group ">
                      {!! Form::label('mobile', 'মোবাইল নম্বর (১১ ডিজিট) *') !!}
                      {!! Form::text('mobile', null, array('class' => 'form-control', 'placeholder' => '১১ ডিজিটের মোবাইল নম্বর লিখুন', 'required')) !!}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                      {!! Form::label('email', 'ইমেইল *') !!}
                      {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'ইমেইল লিখুন', 'required')) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                    <div class="form-group ">
                        <label><strong>আবেদনকারীর রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০ কিলোবাইট)</strong></label>
                        <input value="" class="form-control" type="file" id="image" name="image">
                    </div>
                </div>
                <div class="col-md-4">
                  <img src="{{ asset('images/users/'. $member->image)}}" id='img-upload' style="height: 120px; width: auto; padding: 5px;" />
                </div>
              </div>
            @endif
            
          </div>
          <div class="modal-footer">
            @if($member->tempmemdatas->count() > 0)

            @else
              {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary')) !!}
            @endif
            <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Edit Info Modal -->
    <!-- Edit Info Modal -->
@stop

@section('content')
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>
            @if(empty($pendingfordashboard->totalamount))
              0.00
            @else
              {{ $pendingfordashboard->totalamount }}
            @endif
            <sup style="font-size: 20px">৳</sup>
          </h3>

          <p>প্রক্রিয়াধীন অর্থ</p>
        </div>
        <div class="icon">
          <i class="ion ion-loop"></i>
        </div>
        <a href="{{ route('dashboard.memberpayment') }}" class="small-box-footer">আরও দেখুন <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>
            @if(empty($approvedfordashboard->totalamount))
              0.00
            @else
              {{ $approvedfordashboard->totalamount }}
            @endif
            <sup style="font-size: 20px">৳</sup>
          </h3>

          <p>অনুমোদিত অর্থ</p>
        </div>
        <div class="icon">
          <i class="ion ion-cash"></i>
        </div>
        <a href="{{ route('dashboard.memberpayment') }}" class="small-box-footer">আরও দেখুন <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>
            @if(empty($pendingcountdashboard))
              0
            @else
              {{ $pendingcountdashboard }}
            @endif
            <sup style="font-size: 20px">টি</sup>
          </h3>

          <p>প্রক্রিয়াধীন পরিশোধ</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('dashboard.memberpayment') }}" class="small-box-footer">আরও দেখুন <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>
            @if(empty($approvedcountdashboard))
              0
            @else
              {{ $approvedcountdashboard }}
            @endif
            <sup style="font-size: 20px">টি</sup>
          </h3>

          <p>অনুমোদিত পরিশোধ</p>
        </div>
        <div class="icon">
          <i class="ion ion-arrow-graph-up-right"></i>
        </div>
        <a href="{{ route('dashboard.memberpayment') }}" class="small-box-footer">আরও দেখুন <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#personal_info_tab" data-toggle="tab" aria-expanded="false">ব্যক্তিগত তথ্য</a></li>
      <li class=""><a href="#mominee_tab" data-toggle="tab" aria-expanded="false">নমিনি সংক্রান্ত</a></li>
     
      <li class="pull-right dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-gear"></i>
        </a>
        <ul class="dropdown-menu">
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
          <li role="presentation" class="divider"></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
        </ul>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="personal_info_tab">
        <div class="row">
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>পরিচিতি</center>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <center>
                      @if($member->image != null)
                          <img src="{{ asset('images/users/'.$member->image)}}" alt="image of {{ $member->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $member->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                @if(Auth::user()->activation_status == 1)
                <tr>
                  <th width="40%">সদস্যপদ নং</th>
                  <td>{{ $member->member_id }}</td>
                </tr>
                @endif
                <tr>
                  <th width="40%">আবেদনকারীর নাম (বাংলায়)</th>
                  <td>{{ $member->name_bangla }}</td>
                </tr>
                <tr>
                  <th>আবেদনকারীর নাম (ইংরেজিতে)</th>
                  <td>{{ $member->name}}</td>
                </tr>
                <tr>
                  <th>জাতীয় পরিচয়পত্র নং</th>
                  <td>{{ $member->nid}}</td>
                </tr>
                <tr>
                  <th>জন্ম তারিখ</th>
                  <td>{{ date('F d, Y', strtotime($member->dob)) }}</td>
                </tr>
                <tr>
                  <th>লিঙ্গ</th>
                  <td>{{ $member->gender }}</td>
                </tr>
                <tr>
                  <th>স্বামী/স্ত্রীর নাম</th>
                  <td>{{ $member->spouse }}</td>
                </tr>
                <tr>
                  <th>স্বামী/স্ত্রীর পেশা</th>
                  <td>{{ $member->spouse_profession }}</td>
                </tr>
                <tr>
                  <th>পিতার নাম</th>
                  <td>{{ $member->father }}</td>
                </tr>
                <tr>
                  <th>মাতার নাম</th>
                  <td>{{ $member->mother }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>কর্ম সংক্রান্ত</center>
                  </th>
                </tr>
                <tr>
                  <th width="40%">আবেদনকারীর পেশা</th>
                  <td>{{ $member->profession }}</td>
                </tr>
                <tr>
                  <th>আবেদনকারীর পদবি</th>
                  <td>{{ $member->designation }}</td>
                </tr>
                <tr>
                  <th>দপ্তরের নাম</th>
                  <td>{{ $member->office }}</td>
                </tr>

                <tr>
                  <th colspan="2">
                    <center>যোগাযোগ</center>
                  </th>
                </tr>
                <tr>
                  <th>বর্তমান ঠিকানা</th>
                  <td>{{ $member->present_address }}</td>
                </tr>
                <tr>
                  <th>স্থায়ী ঠিকানা</th>
                  <td>{{ $member->permanent_address }}</td>
                </tr>
                <tr>
                  <th>অফিসের টেলিফোন</th>
                  <td>{{ $member->office_telephone }}</td>
                </tr>
                <tr>
                  <th>বাসার টেলিফোন</th>
                  <td>{{ $member->home_telephone }}</td>
                </tr>
                <tr>
                  <th>মোবাইল</th>
                  <td>{{ $member->mobile }}</td>
                </tr>
                <tr>
                  <th>ইমেইল এড্রেস</th>
                  <td>{{ $member->email }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="mominee_tab">
        @if(Auth::user()->role_type != 'admin')
        <div class="row">
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>নমিনি ০১</center>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <center>
                      @if($member->nominee_one_image != null)
                          <img src="{{ asset('images/users/'.$member->nominee_one_image)}}" alt="image of {{ $member->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $member->nominee_one_name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                <tr>
                  <th width="40%">নমিনীর নাম (বাংলায়)</th>
                  <td>{{ $member->nominee_one_name }}</td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>
                    {{ $member->nominee_one_identity_text }}
                    @if($member->nominee_one_identity_type == 0)
                      (জাতীয় পরিচয়পত্র)
                    @else
                      (জন্ম নিবন্ধন)
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>সম্পর্ক</th>
                  <td>{{ $member->nominee_one_relation }}</td>
                </tr>
                <tr>
                  <th>শতকরা হার</th>
                  <td>{{ $member->nominee_one_percentage }}%</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>নমিনি ০২</center>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <center>
                      @if($member->nominee_two_image != null)
                          <img src="{{ asset('images/users/'.$member->nominee_two_image)}}" alt="image of {{ $member->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $member->nominee_two_name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                <tr>
                  <th width="40%">নমিনীর নাম (বাংলায়)</th>
                  <td>{{ $member->nominee_two_name }}</td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>
                    {{ $member->nominee_two_identity_text }}
                    @if($member->nominee_two_identity_type == 0)
                      (জাতীয় পরিচয়পত্র)
                    @else
                      (জন্ম নিবন্ধন)
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>{{ $member->nominee_two_relation }}</td>
                </tr>
                <tr>
                  <th>শতকরা হার</th>
                  <td>{{ $member->nominee_two_percentage }}%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        @endif
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
@stop

@section('js')
  {!!Html::script('js/parsley.min.js')!!}
  <script type="text/javascript">
    var _URL = window.URL || window.webkitURL;
    $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
      });

      $('.btn-file :file').on('fileselect', function(event, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = label;
          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
      });
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image").change(function(){
        readURL(this);
        var file, img;

        if ((file = this.files[0])) {
          img = new Image();
          img.onload = function() {
            var imagewidth = this.width;
            var imageheight = this.height;
            filesize = parseInt((file.size / 1024));
            if(filesize > 250) {
              $("#image").val('');
              toastr.warning('ফাইলের আকৃতি '+filesize+' কিলোবাইট. ২৫০ কিলোবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
            console.log(imagewidth/imageheight);
            if(((imagewidth/imageheight) < 0.9375) || ((imagewidth/imageheight) > 1.07142)) {
              $("#image").val('');
              toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:১ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
          };
          img.onerror = function() {
            $("#image").val('');
            toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
            setTimeout(function() {
              $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
            }, 1000);
          };
          img.src = _URL.createObjectURL(file);
        }
      });
    });
  </script>

  <script type="text/javascript">
  @if(session('warning'))
      $('#editProfileModal').modal('show');
  @endif
  </script>

  <script type="text/javascript">
    $('#downloadPDFButton').click(function() {
      setTimeout(function () {
        $('#downloadPDFModal').modal('hide');
      }, 3500);
    })
  </script>
@stop