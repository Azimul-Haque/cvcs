<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/clear', ['as'=>'clear','uses'=>'IndexController@clear']);

// index routes
// index routes
Route::get('/', ['as'=>'index.index','uses'=>'IndexController@index']);
Route::get('/about', ['as'=>'index.about','uses'=>'IndexController@getAbout']);
Route::get('/mission', ['as'=>'index.mission','uses'=>'IndexController@getMission']);
Route::get('/business_entitny', ['as'=>'index.business_entitny','uses'=>'IndexController@getBusinessEntity']);
Route::get('/product_services', ['as'=>'index.product_services','uses'=>'IndexController@getProductServices']);
Route::get('/welfare', ['as'=>'index.welfare','uses'=>'IndexController@getWelfare']);
Route::get('/faq', ['as'=>'index.faq','uses'=>'IndexController@getFAQ']);
Route::get('/journey', ['as'=>'index.journey','uses'=>'IndexController@getJourney']);
Route::get('/constitution', ['as'=>'index.constitution','uses'=>'IndexController@getConstitution']);
Route::get('/adhoc', ['as'=>'index.adhoc','uses'=>'IndexController@getAdhoc']);
Route::get('/news', ['as'=>'index.news','uses'=>'IndexController@getNews']);
Route::get('/notice', ['as'=>'index.notice','uses'=>'IndexController@getNotice']);
Route::get('/events', ['as'=>'index.events','uses'=>'IndexController@getEvents']);
Route::get('/event/{id}/single', ['as'=>'index.singleevent','uses'=>'IndexController@singleEvent']);
Route::get('/gallery', ['as'=>'index.gallery','uses'=>'IndexController@getGallery']);
Route::get('/gallery/{id}/single', ['as'=>'index.gallery.single','uses'=>'IndexController@getSingleGalleryAlbum']);
Route::get('/members', ['as'=>'index.members','uses'=>'IndexController@getMembers']);
Route::get('/contact', ['as'=>'index.contact','uses'=>'IndexController@getContact']);
Route::get('/application', ['as'=>'index.application','uses'=>'IndexController@getApplication']);
Route::get('/member/login', ['as'=>'index.login','uses'=>'IndexController@getLogin']);
Route::get('/member/profile/{unique_key}', ['as'=>'index.profile','uses'=>'IndexController@getProfile']);
Route::post('/member/application/store', ['as'=>'index.storeapplication','uses'=>'IndexController@storeApplication']);
Route::post('/contact/form/message/store', ['as'=>'index.storeformmessage','uses'=>'IndexController@storeFormMessage']);
// index routes
// index routes

// blog routes
// blog routes
Route::resource('blogs','BlogController');
Route::get('blog/{slug}',['as' => 'blog.single', 'uses' => 'BlogController@getBlogPost']);
Route::get('blogger/profile/{unique_key}',['as' => 'blogger.profile', 'uses' => 'BlogController@getBloggerProfile']);
Route::get('/like/{user_id}/{blog_id}',['as' => 'blog.like', 'uses' => 'BlogController@likeBlogAPI']);
Route::get('/check/like/{user_id}/{blog_id}',['as' => 'blog.checklike', 'uses' => 'BlogController@checkLikeAPI']);
Route::get('/category/{name}',['as' => 'blog.categorywise', 'uses' => 'BlogController@getCategoryWise']);
Route::get('/archive/{date}',['as' => 'blog.monthwise', 'uses' => 'BlogController@getMonthWise']);
// blog routes
// blog routes

Route::auth();

// dashboard routes
// dashboard routes
Route::resource('users','UserController');

// DASHBOARD
Route::get('/dashboard', ['as'=>'dashboard.index','uses'=>'DashboardController@index']);

// ADMIN AND BULK PAYER
Route::get('/dashboard/admins', ['as'=>'dashboard.admins','uses'=>'DashboardController@getAdmins']);
Route::get('/dashboard/admins/create', ['as'=>'dashboard.createadmin','uses'=>'DashboardController@getCreateAdmin']);
Route::get('/dashboard/admins/search', ['as'=>'dashboard.searchmemberforadmin','uses'=>'DashboardController@searchMemberForAdminAPI']);
Route::post('/dashboard/admins/addadmin', ['as'=>'dashboard.addadmin','uses'=>'DashboardController@addAdmin']);
Route::patch('/dashboard/admins/removeadmin/{id}', ['as'=>'dashboard.removeadmin','uses'=>'DashboardController@removeAdmin']);

Route::get('/dashboard/bulk/payers', ['as'=>'dashboard.bulkpayers','uses'=>'DashboardController@getBulkPayers']);
Route::get('/dashboard/bulk/payers/create', ['as'=>'dashboard.createbulkpayer','uses'=>'DashboardController@getCreateBulkPayer']);
Route::get('/dashboard/bulk/payers/search', ['as'=>'dashboard.searchmemberforbulkpayer','uses'=>'DashboardController@searchMemberForBulkPayerAPI']);
Route::post('/dashboard/bulk/payers/addbulkpayer', ['as'=>'dashboard.addbulkpayer','uses'=>'DashboardController@addBulkPayer']);
Route::patch('/dashboard/bulk/payers/removebulkpayer/{id}', ['as'=>'dashboard.removebulkpayer','uses'=>'DashboardController@removeBulkPayer']);

// COMMITTEE
Route::get('/dashboard/committee', ['as'=>'dashboard.committee','uses'=>'DashboardController@getCommittee']);
Route::post('/dashboard/committee', ['as'=>'dashboard.storecommittee','uses'=>'DashboardController@storeCommittee']);
Route::put('/dashboard/committee/{id}', ['as'=>'dashboard.updatecommittee','uses'=>'DashboardController@updateCommittee']);
Route::delete('/dashboard/committee/{id}', ['as'=>'dashboard.deletecommittee','uses'=>'DashboardController@deleteCommittee']);

Route::get('/dashboard/news', ['as'=>'dashboard.news','uses'=>'DashboardController@getNews']);

// ABOUTS AND BASIC INFO
Route::get('/dashboard/abouts', ['as'=>'dashboard.abouts','uses'=>'DashboardController@getAbouts']);
Route::put('/dashboard/abouts/{id}', ['as'=>'dashboard.updateabouts','uses'=>'DashboardController@updateAbouts']);
Route::put('/dashboard/basic/information/{id}', ['as'=>'dashboard.updatebasicinfo','uses'=>'DashboardController@updateBasicInfo']);

// SLIDER
Route::get('/dashboard/slider', ['as'=>'dashboard.slider','uses'=>'DashboardController@getSlider']);
Route::post('/dashboard/slider/store', ['as'=>'dashboard.storeslider','uses'=>'DashboardController@storeSlider']);
Route::delete('/dashboard/slider/{id}/delete', ['as'=>'dashboard.deleteslider','uses'=>'DashboardController@deleteSlider']);

// GALLERY
Route::get('/dashboard/gallery', ['as'=>'dashboard.gallery','uses'=>'DashboardController@getGallery']);
Route::get('/dashboard/gallery/create', ['as'=>'dashboard.creategallery','uses'=>'DashboardController@getCreateGallery']);
Route::post('/dashboard/gallery/store', ['as'=>'dashboard.storegallery','uses'=>'DashboardController@storeGalleryAlbum']);
Route::get('/dashboard/gallery/{id}/edit', ['as'=>'dashboard.editgallery','uses'=>'DashboardController@getEditGalleryAlbum']);
Route::put('/dashboard/{id}/gallery/update', ['as'=>'dashboard.updategallery','uses'=>'DashboardController@updateGalleryAlbum']);
Route::delete('/dashboard/gallery/{id}', ['as'=>'dashboard.deletealbum','uses'=>'DashboardController@deleteAlbum']);
Route::delete('/dashboard/gallery/album/single/{id}/delete', ['as'=>'dashboard.deletesinglephoto','uses'=>'DashboardController@deleteSinglePhoto']);

// EVENT
Route::get('/dashboard/events', ['as'=>'dashboard.events','uses'=>'DashboardController@getEvents']);
Route::post('/dashboard/events/store', ['as'=>'dashboard.storeevent','uses'=>'DashboardController@storeEvent']);
Route::put('/dashboard/events/{id}/update', ['as'=>'dashboard.updateevent','uses'=>'DashboardController@updateEvent']);
Route::delete('/dashboard/event/{id}/delete', ['as'=>'dashboard.deleteevent','uses'=>'DashboardController@deleteEvent']);

// NOTICE
Route::get('/dashboard/notice', ['as'=>'dashboard.notice','uses'=>'DashboardController@getNotice']);
Route::post('/dashboard/notice/store', ['as'=>'dashboard.storenotice','uses'=>'DashboardController@storeNotice']);
Route::put('/dashboard/notice/{id}/update', ['as'=>'dashboard.updatenotice','uses'=>'DashboardController@updateNotice']);
Route::delete('/dashboard/notice/{id}/delete', ['as'=>'dashboard.deletenotice','uses'=>'DashboardController@deleteNotice']);

// FAQ
Route::get('/dashboard/faq', ['as'=>'dashboard.faq','uses'=>'DashboardController@getFAQ']);
Route::post('/dashboard/faq/store', ['as'=>'dashboard.storefaq','uses'=>'DashboardController@storeFAQ']);
Route::put('/dashboard/faq/{id}/update', ['as'=>'dashboard.updatefaq','uses'=>'DashboardController@updateFAQ']);
Route::delete('/dashboard/faq/{id}/delete', ['as'=>'dashboard.deletefaq','uses'=>'DashboardController@deleteFAQ']);

// FORM MESSAGE
Route::get('/dashboard/form/messages', ['as'=>'dashboard.formmessage','uses'=>'DashboardController@getFormMessages']);
Route::delete('/dashboard/form/message/{id}/delete', ['as'=>'dashboard.deleteformmessage','uses'=>'DashboardController@deleteFormMessage']);

// BLOG
Route::get('/dashboard/blogs', ['as'=>'dashboard.blogs','uses'=>'DashboardController@getBlogs']);

// APPLICATIONS
Route::get('/dashboard/applications', ['as'=>'dashboard.applications','uses'=>'DashboardController@getApplications']);
Route::get('/dashboard/application/single/{unique_key}', ['as'=>'dashboard.singleapplication','uses'=>'DashboardController@getSignleApplication']);
Route::patch('/dashboard/application/{id}/activate', ['as'=>'dashboard.activatemember','uses'=>'DashboardController@activateMember']);
Route::post('/dashboard/application/send/sms/', ['as'=>'dashboard.sendsmsapplicant','uses'=>'DashboardController@sendSMSApplicant']);
Route::delete('/dashboard/application/{id}/delete/', ['as'=>'dashboard.deleteapplication','uses'=>'DashboardController@deleteApplication']);

// MEMBERS
Route::get('/dashboard/members', ['as'=>'dashboard.members','uses'=>'DashboardController@getMembers']);
Route::get('/dashboard/member/single/{unique_key}', ['as'=>'dashboard.singlemember','uses'=>'DashboardController@getSignleMember']);

// ACCOUNT MANAGEMENT AND PAYMENT
Route::get('/dashboard/profile', ['as'=>'dashboard.profile','uses'=>'DashboardController@getProfile']);
Route::get('/dashboard/member/payment', ['as'=>'dashboard.memberpayment','uses'=>'DashboardController@getPaymentPage']);
Route::get('/dashboard/member/payment/self', ['as'=>'dashboard.memberpaymentself','uses'=>'DashboardController@getSelfPaymentPage']); 
Route::post('/dashboard/member/payment/self', ['as'=>'dashboard.storememberpaymentself','uses'=>'DashboardController@storeSelfPayment']);

// BULK PAYMENT
Route::get('/dashboard/member/payment/bulk', ['as'=>'dashboard.memberpaymentbulk','uses'=>'DashboardController@getBulkPaymentPage']);
Route::get('/dashboard/member/payment/bulk/search/api', ['as'=>'dashboard.searchmemberforbulkpayment','uses'=>'DashboardController@searchMemberForBulkPaymentAPI']);
Route::post('/dashboard/member/payment/bulk', ['as'=>'dashboard.storememberpaymentbulk','uses'=>'DashboardController@storeBulkPayment']);

// PAYMENTS BY ADMIN
Route::get('/dashboard/members/payments/pending', ['as'=>'dashboard.memberspendingpayments','uses'=>'DashboardController@getMembersPendingPayments']);
Route::get('/dashboard/members/payments/approved', ['as'=>'dashboard.membersapprovedpayments','uses'=>'DashboardController@getMembersApprovedPayments']);
Route::patch('/dashboard/members/payments/single/{id}/approve', ['as'=>'dashboard.approvesinglepayment','uses'=>'DashboardController@approveSinglePayment']);


// dashboard routes
// dashboard routes
