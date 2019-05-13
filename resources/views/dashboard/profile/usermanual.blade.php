@extends('adminlte::page')

@section('title', 'CVCS | User Manual (ব্যবহার বিধি)')

@section('css')
  <style type="text/css">
    h4 {
        line-height: 1.5;
    }
  </style>
@stop

@section('content_header')
    <h1><i class="fa fa-umbrella"></i> User Manual (ব্যবহার বিধি)</h1>
@stop

@section('content')
    <div class="row">
    	<div class="col-md-10">
    		<div class="panel-group" id="accordion">
    		  <div class="box box-success">
    		    <div class="box-header with-border">
    		      <h4 class="box-title">
    		        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
    		        একাধিক পরিশোধ</a>
    		      </h4>
    		    </div>
    		    <div id="collapse1" class="panel-collapse collapse ">
    		      <div class="box-body">
    		      	<h4>১. বাল্ক পরিশোধ করার জন্য প্রথমে ডান পাশের মেনু থেকে "একাধিক পরিশোধ" মেনুতে ক্লিক করুন। পাতাটি নিচের ছবির মতো একটি পাতা প্রদর্শন করবে।</h4><br/>
    		      	<center><img src="{{ asset('images/usermanual/bulk_payment_1.png') }}" class="img-responsive shadow" style="width: 90%; height: auto;"></center><br/>
    		      	<h4>২. পাতার "পরিশোধ ফরম" অংশে গিয়ে পরিশোধের তথ্য লিখুন (নিচের ছবির মতোঃ মোট টাকা, ব্যাংক তথ্য)।</h4><br/>
    		      	<h4>৩. ফরমের নিচের অংশে সর্বোচ্চ তিনটি রিসিটের ছবি আপলোড করতে পারবেন। অন্তত একটি রিসিটের ছবি বাধ্যতামূলকভাবে আপলোড করতে হবে।</h4><br/>
    		      	<center><img src="{{ asset('images/usermanual/bulk_payment_2.png') }}" class="img-responsive shadow" style="width: 90%; height: auto;"></center><br/>
    		      	<h4>৪. এবার সদস্য যোগ করতে ডান পাশের "সদস্য তালিকা" ঘরে (নিচের ছবির মতো) "সদস্য যোগ করুন" বাটনে ক্লিক করুন।</h4><br/>
    		      	<center><img src="{{ asset('images/usermanual/bulk_payment_3.png') }}" class="img-responsive shadow" style="width: 90%; height: auto;"></center><br/>
    		      	<h4>৫. "সদস্য যোগ করুন" ক্লিক করলে নিচের ছবির মতো একটি পপআপ ইউন্ডো আসবে। এখান থেকে সদস্যের নাম/ মোবাইল নম্বর/ সদস্য আইডি দিয়ে একজন সদস্যকে খুঁজে বের করে নামের উপরে ক্লিক করুন।</h4><br/>
    		      	<center><img src="{{ asset('images/usermanual/bulk_payment_4.png') }}" class="img-responsive shadow" style="width: 90%; height: auto;"></center><br/>
    		      	<h4>৬. সদস্য সিলেক্ট থাকা অবস্থায় "সদস্য যোগ" বাটনে ক্লিক করুন।</h4><br/>
    		      	<center><img src="{{ asset('images/usermanual/bulk_payment_5.png') }}" class="img-responsive shadow" style="width: 90%; height: auto;"></center><br/>
    		      	<h4>৭. দেখা যাবে সদস্য নিচের ঘরে যোগ হয়েছে। এভাবে প্রয়োজনে একাধিক সদ্য যোগ করুন। সদস্য অপসারণ করতে পরিমাণ ঘরের পাশের লাল বাটনটিতে ক্লিক করুন।</h4><br/>
    		      	<center><img src="{{ asset('images/usermanual/bulk_payment_6.png') }}" class="img-responsive shadow" style="width: 90%; height: auto;"></center><br/>
    		      	<h4>৮. এবার সদ্যের নামের পাশের পরিমাণ ঘরে টাকার পরিমাণ লিখুন। মনে রাখতে হবে, মোট টাকার পরিমাণ এবং সদস্যদের টাকার পরিমাণের যোগফল সমান হতে হবে।</h4><br/>
    		      	<center><img src="{{ asset('images/usermanual/bulk_payment_7.png') }}" class="img-responsive shadow" style="width: 90%; height: auto;"></center><br/>
    		      	<h4>৯. সব তথ্য একবার পর্যবেক্ষণ ক্রে দেখে নিয়ে নিচের "পরবর্তী পাতা" বাটনে ক্লিক করুন। আপনার প্রদান করা তথ্যগুলো প্রিভিউ করে দেখাবে। আপনি নিশ্চিত হলে "দাখিক করুন" বাটনে ক্লিক করুন। তথ্য ঠিক করতে "ফিরে যান" বাটনে ক্লিক করে তথ্য ঠিক করুন। "দাখিল করুন" বাটনে ক্লিক করলে এবং সব ঠিকঠাক থাকলে পাতাটি তথ্য দাখিল করে আপনার পরিশোধ পাতায় নিয়ে যাবে এবং সেখানে তালিকায় প্রদর্শন করবে।</h4><br/>
    		      	<center><img src="{{ asset('images/usermanual/bulk_payment_8.png') }}" class="img-responsive shadow" style="width: 90%; height: auto;"></center><br/>
    		      	<h4>১০. আপনার দাখিল করা তথ্য একজন অ্যাডমিন যাচাই করে অনুমোদন করবেন। অনুমোদিত হলে সদস্য অনুযায়ী তাদের একাউন্টে টাকার পরিমাণ চলে যাবে এবং তাদের প্রোফাইলের "পরিশোধ" অংশে প্রদরশিত হবে।</h4>
    		      </div>
    		    </div>
    		  </div>
    		</div>
    	</div>
    </div>
@stop