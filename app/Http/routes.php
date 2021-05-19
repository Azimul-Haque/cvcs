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
Route::get('/committee/previous', ['as'=>'index.previouscommittee','uses'=>'IndexController@getPreviousCommittee']);
Route::get('/committee/current', ['as'=>'index.currentcommittee','uses'=>'IndexController@getCurrentCommittee']);
Route::get('/news', ['as'=>'index.news','uses'=>'IndexController@getNews']);
Route::get('/notice', ['as'=>'index.notice','uses'=>'IndexController@getNotice']);
Route::get('/events', ['as'=>'index.events','uses'=>'IndexController@getEvents']);
Route::get('/event/{id}/single', ['as'=>'index.singleevent','uses'=>'IndexController@singleEvent']);
Route::get('/gallery', ['as'=>'index.gallery','uses'=>'IndexController@getGallery']);
Route::get('/gallery/{id}/single', ['as'=>'index.gallery.single','uses'=>'IndexController@getSingleGalleryAlbum']);
Route::get('/members', ['as'=>'index.members','uses'=>'IndexController@getMembers']);
Route::get('/contact', ['as'=>'index.contact','uses'=>'IndexController@getContact']);
Route::get('/application', ['as'=>'index.application','uses'=>'IndexController@getApplication']);

Route::get('/application/payment/{id}', ['as'=>'index.application.payment','uses'=>'IndexController@getApplicationPaymentPage']);
Route::post('/application/payment/success', 'IndexController@paymentRegSuccessOrFailed')->name('payment.regsuccess');
Route::post('/application/payment/cancel/{id}', 'IndexController@paymentRegCancelledPost')->name('payment.regcancel');
Route::get('/application/payment/cancel/{id}', 'IndexController@paymentRegCancelled')->name('payment.regcancel');

Route::get('/member/login', ['as'=>'index.login','uses'=>'IndexController@getLogin']);
Route::get('/member/profile/{unique_key}', ['as'=>'index.profile','uses'=>'IndexController@getProfile']);
Route::post('/member/application/store', ['as'=>'index.storeapplication','uses'=>'IndexController@storeApplication']);
Route::post('/contact/form/message/store', ['as'=>'index.storeformmessage','uses'=>'IndexController@storeFormMessage']);
Route::get('/tutorial/video', ['as'=>'index.videotutorial','uses'=>'IndexController@getVideoTutorials']);

Route::get('/test', ['as'=>'index.test','uses'=>'IndexController@getTest']);
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

// sms password reset
Route::get('/reset/password/mobile', ['as'=>'index.mobilereset','uses'=>'IndexController@getMobileReset']);
Route::post('/reset/password/mobile/send', ['as'=>'index.sendpasswordresetsms','uses'=>'IndexController@sendPasswordResetSMS']);
Route::get('/reset/password/mobile/verify/{mobile}/page', ['as'=>'index.mobileresetverifypage','uses'=>'IndexController@getMobileResetVerifyPage']);
Route::post('/reset/password/mobile/verify/code', ['as'=>'index.mobileresetverifycode','uses'=>'IndexController@mobileResetVerifyCode']);
Route::get('/reset/password/mobile/verified/{mobile}/{security_code}', ['as'=>'index.getpasswordresetpage','uses'=>'IndexController@getPasswordResetPage']);
Route::post('/reset/password/mobile/update', ['as'=>'index.updatepasswordmobileverified','uses'=>'IndexController@updatePasswordMobileVerified']);
// sms password reset

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

Route::get('/dashboard/donors', ['as'=>'dashboard.donors','uses'=>'DashboardController@getDonors']);
Route::post('/dashboard/donors/store', ['as'=>'dashboard.storedonor','uses'=>'DashboardController@storeDonor']);
Route::put('/dashboard/donors/update/{id}', ['as'=>'dashboard.updatedonor','uses'=>'DashboardController@updateDonor']);
Route::post('/dashboard/donation/store', ['as'=>'dashboard.storedonation','uses'=>'DashboardController@storeDonation']);
Route::patch('/dashboard/donation/approve/{id}', ['as'=>'dashboard.approvedonation','uses'=>'DashboardController@approveDonation']);
Route::get('/dashboard/donor/donation/{id}/list', ['as'=>'dashboard.donationofdonor','uses'=>'DashboardController@getDonationofDonor']);

Route::get('/dashboard/branches', ['as'=>'dashboard.branches','uses'=>'DashboardController@getBranches']);
Route::get('/dashboard/branch/{branch_id}/members/', ['as'=>'dashboard.branch.members','uses'=>'DashboardController@getBranchMembers']);
Route::get('/dashboard/branch/{id}/payment/bulk/', ['as'=>'dashboard.bulkpaymentofbranch','uses'=>'DashboardController@getBulkPaymentPageFromBranch']);

Route::get('/dashboard/branches/payments', ['as'=>'dashboard.branches.payments','uses'=>'DashboardController@getBranchPayments']);
Route::post('/dashboard/branches/store', ['as'=>'dashboard.storebranch','uses'=>'DashboardController@storeBranch']);
Route::put('/dashboard/branches/update/{id}', ['as'=>'dashboard.updatebranch','uses'=>'DashboardController@updateBranch']);
Route::post('/dashboard/branch/payment/store', ['as'=>'dashboard.storebranchpayment','uses'=>'DashboardController@storeBranchPayment']);
Route::patch('/dashboard/branch/payment/approve/{id}', ['as'=>'dashboard.approvebranchpayment','uses'=>'DashboardController@approveBranchPayment']);
Route::get('/dashboard/branch/payment/{id}/list', ['as'=>'dashboard.paymentofbranch','uses'=>'DashboardController@getPaymentofBranch']);


Route::get('/dashboard/designations', ['as'=>'dashboard.designations','uses'=>'DashboardController@getDesignations']);
Route::get('/dashboard/designation/{position_id}/members', ['as'=>'dashboard.designation.members','uses'=>'DashboardController@getDesignationMembers']);

##Fuad##
Route::post('/dashboard/designation/store', ['as'=>'dashboard.storedesignation','uses'=>'FuadControllers\PositionController@addPosition']);
Route::put('/dashboard/designation/update', ['as'=>'dashboard.updatedesignation','uses'=>'FuadControllers\PositionController@updatePosition']);
########




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
Route::get('/dashboard/form/messages/archives', ['as'=>'dashboard.formmessage.archive','uses'=>'DashboardController@getArchivedFormMessages']);
Route::delete('/dashboard/form/message/{id}/archive', ['as'=>'dashboard.archiveformmessage','uses'=>'DashboardController@archiveFormMessage']);
Route::delete('/dashboard/form/message/{id}/delete', ['as'=>'dashboard.deleteformmessage','uses'=>'DashboardController@deleteFormMessage']);

// BLOG
Route::get('/dashboard/blogs', ['as'=>'dashboard.blogs','uses'=>'DashboardController@getBlogs']);

// APPLICATIONS
Route::get('/dashboard/applications', ['as'=>'dashboard.applications','uses'=>'DashboardController@getApplications']);
Route::get('/dashboard/application/single/{unique_key}', ['as'=>'dashboard.singleapplication','uses'=>'DashboardController@getSignleApplication']);

Route::get('/dashboard/application/single/{unique_key}/edit', ['as'=>'dashboard.singleapplicationedit','uses'=>'DashboardController@getSignleApplicationEdit']);
Route::put('/dashboard/application/single/{unique_key}/update', ['as'=>'dashboard.singleapplicationupdate','uses'=>'DashboardController@updateSignleApplication']);

Route::patch('/dashboard/application/{id}/activate', ['as'=>'dashboard.activatemember','uses'=>'DashboardController@activateMember']);
Route::post('/dashboard/application/send/sms/', ['as'=>'dashboard.sendsmsapplicant','uses'=>'DashboardController@sendSMSApplicant']);
Route::delete('/dashboard/application/{id}/delete/', ['as'=>'dashboard.deleteapplication','uses'=>'DashboardController@deleteApplication']);
Route::get('/dashboard/application/search/api', ['as'=>'dashboard.applicationsearchapi','uses'=>'DashboardController@searchApplicationAPI']);

// DEFECTIVE APPLICATIONS
Route::get('/dashboard/defective/applications', ['as'=>'dashboard.defectiveapplications','uses'=>'DashboardController@getDefectiveApplications']);
Route::patch('/dashboard/application/{id}/makedefective', ['as'=>'dashboard.makedefective','uses'=>'DashboardController@makeDefectiveApplication']);
Route::get('/dashboard/defective/application/search/api', ['as'=>'dashboard.defectiveapplicationsearchapi','uses'=>'DashboardController@searchDefectiveApplicationAPI']);
Route::patch('/dashboard/application/{id}/makepending', ['as'=>'dashboard.makedefectivetopending','uses'=>'DashboardController@makeDefectiveToPendingApplication']);

// MEMBERS
Route::get('/dashboard/members', ['as'=>'dashboard.members','uses'=>'DashboardController@getMembers']);
Route::get('/dashboard/member/single/{unique_key}', ['as'=>'dashboard.singlemember','uses'=>'DashboardController@getSingleMember']);
Route::get('/dashboard/members/update/requests', ['as'=>'dashboard.membersupdaterequests','uses'=>'DashboardController@getMembersUpdateRequests']);
Route::post('/dashboard/member/update/request/approve', ['as'=>'dashboard.approveupdaterequest','uses'=>'DashboardController@approveUpdateRequest']);
Route::delete('/dashboard/member/update/request/{id}/delete', ['as'=>'dashboard.deleteupdaterequest','uses'=>'DashboardController@deleteUpdateRequest']);

// SEARCH MEMBER
Route::get('/dashboard/members/search', ['as'=>'dashboard.members.search','uses'=>'DashboardController@getSearchMember']);
Route::get('/dashboard/member/search/api', ['as'=>'dashboard.membersearchapi','uses'=>'DashboardController@searchMemberAPI']);
Route::get('/dashboard/member/search/api/2', ['as'=>'dashboard.membersearchapi2','uses'=>'DashboardController@searchMemberAPI2']);
Route::get('/dashboard/member/search/api/3', ['as'=>'dashboard.membersearchapi3','uses'=>'DashboardController@searchMemberAPI3']);

// ACCOUNT MANAGEMENT AND PAYMENT
Route::get('/dashboard/profile', ['as'=>'dashboard.profile','uses'=>'DashboardController@getProfile']);
Route::patch('/dashboard/profile/{id}/update', ['as'=>'dashboard.profileupdate','uses'=>'DashboardController@updateMemberProfile']);
Route::get('/dashboard/member/payment', ['as'=>'dashboard.memberpayment','uses'=>'DashboardController@getPaymentPage']);
Route::get('/dashboard/member/payment/self', ['as'=>'dashboard.memberpaymentself','uses'=>'DashboardController@getSelfPaymentPage']);
Route::post('/dashboard/member/payment/self', ['as'=>'dashboard.storememberpaymentself','uses'=>'DashboardController@storeSelfPayment']);
Route::post('/dashboard/member/payment/report/download/pdf', ['as'=>'dashboard.member.payment.pdf','uses'=>'DashboardController@downloadMemberPaymentPDF']);

// SINGLE ONLINE PAYMENT
// SINGLE ONLINE PAYMENT
// SINGLE ONLINE PAYMENT
Route::get('/dashboard/member/payment/self/online', ['as'=>'dashboard.memberpaymentselfonline','uses'=>'DashboardController@getSelfPaymentOnlinePage']);
Route::get('/dashboard/member/payment/verification', ['as'=>'dashboard.payment.verification','uses'=>'DashboardController@paymentVerification']);
Route::get('/dashboard/member/payment/verification/checktotal', ['as'=>'dashboard.payment.verification','uses'=>'DashboardController@paymentVerificationCheckTotal']);
Route::post('/dashboard/member/payment/self/online', ['as'=>'dashboard.storememberonlinepaymentself','uses'=>'DashboardController@nextSelfPaymentOnline']);

Route::post('/payment/success', 'DashboardController@paymentSuccessOrFailed')->name('payment.success');
Route::get('/payment/failed', 'DashboardController@paymentSuccessOrFailed')->name('payment.failed');
Route::post('/payment/cancel', 'DashboardController@paymentCancelledPost')->name('payment.cancel');
Route::get('/payment/cancel', 'DashboardController@paymentCancelled')->name('payment.cancel');
// SINGLE ONLINE PAYMENT
// SINGLE ONLINE PAYMENT
// SINGLE ONLINE PAYMENT

Route::post('/dashboard/member/complete/report/download/pdf', ['as'=>'dashboard.member.complete.pdf','uses'=>'DashboardController@downloadMemberCompletePDF']);
Route::get('/dashboard/members/for/all', ['as'=>'dashboard.membersforall','uses'=>'DashboardController@getMembersForAll']);

Route::get('/dashboard/member/transaction/summary', ['as'=>'dashboard.membertransactionsummary','uses'=>'DashboardController@getMemberTransactionSummary']);
Route::get('/dashboard/member/user/manual', ['as'=>'dashboard.memberusermanual','uses'=>'DashboardController@getMemberUserManual']);

Route::get('/dashboard/member/change/password', ['as'=>'dashboard.member.getchangepassword','uses'=>'DashboardController@getMemberChangePassword']);
Route::post('/dashboard/member/change/password', ['as'=>'dashboard.member.changepassword','uses'=>'DashboardController@memberChangePassword']);

// BULK PAYMENT
Route::get('/dashboard/member/payment/bulk', ['as'=>'dashboard.memberpaymentbulk','uses'=>'DashboardController@getBulkPaymentPage']);
Route::get('/dashboard/member/payment/bulk/search/api', ['as'=>'dashboard.searchmembersforbulkpayment','uses'=>'DashboardController@searchMemberForBulkPaymentAPI']);
Route::get('/dashboard/member/payment/bulk/search/single/member/api/{member_id}', ['as'=>'dashboard.searchmemberforbulkpaymentsingle','uses'=>'DashboardController@searchMemberForBulkPaymentSingleAPI']);
Route::post('/dashboard/member/payment/bulk', ['as'=>'dashboard.storememberpaymentbulk','uses'=>'DashboardController@storeBulkPayment']);

// BULK ONLINE PAYMENT
// BULK ONLINE PAYMENT
// BULK ONLINE PAYMENT
Route::post('/payment/bulk/success', 'DashboardController@paymentBulkSuccessOrFailed')->name('payment.bulksuccess');
Route::get('/payment/bulk/failed', 'DashboardController@paymentBulkSuccessOrFailed')->name('payment.bulkfailed');
Route::post('/payment/bulk/cancel', 'DashboardController@paymentBulkCancelledPost')->name('payment.bulkcancel');
Route::get('/payment/bulk/cancel', 'DashboardController@paymentBulkCancelled')->name('payment.bulkcancel');
// BULK ONLINE PAYMENT
// BULK ONLINE PAYMENT
// BULK ONLINE PAYMENT

// REPORTS
Route::get('/dashboard/reports', ['as'=>'dashboard.reports','uses'=>'ReportController@getReportsPage']);
Route::get('/dashboard/reports/export/payment/pdf', ['as'=>'reports.getpaymentsallreport','uses'=>'ReportController@getPDFAllPnedingAndPayments']);
Route::get('/dashboard/reports/export/branch/members/pdf', ['as'=>'reports.getbranchmemberspaymentreport','uses'=>'ReportController@getPDFBranchMembersPayments']);
Route::get('/dashboard/reports/export/branch/members/list/pdf', ['as'=>'reports.branchmemberslist','uses'=>'ReportController@getPDFBranchMembersList']);
Route::get('/dashboard/reports/export/designation/members/list/pdf', ['as'=>'reports.designationsmemberslist','uses'=>'ReportController@getPDFDesignationMembersList']);

//Fuads reports----
Route::get('/dashboard/reports/export/designation/members/count/pdf', ['as'=>'reports.designationsmemberscountlist','uses'=>'FuadControllers\ReportController@getDesignationMemberCounts']);

//-----------------

// PAYMENTS BY ADMIN
Route::get('/dashboard/members/payments/pending', ['as'=>'dashboard.memberspendingpayments','uses'=>'DashboardController@getMembersPendingPayments']);
Route::get('/dashboard/members/payments/approved', ['as'=>'dashboard.membersapprovedpayments','uses'=>'DashboardController@getMembersApprovedPayments']);
Route::get('/dashboard/members/payments/approved/total', ['as'=>'dashboard.membersapprovedpaymentstotal','uses'=>'DashboardController@getMembersApprovedPaymentsAamarpay']);
Route::get('/dashboard/members/payments/disputed', ['as'=>'dashboard.membersdisputedpayments','uses'=>'DashboardController@getMembersDisputedPayments']);
Route::patch('/dashboard/members/payments/single/{id}/approve', ['as'=>'dashboard.approvesinglepayment','uses'=>'DashboardController@approveSinglePayment']);
Route::patch('/dashboard/members/payments/bulk/{id}/approve', ['as'=>'dashboard.approvebulkpayment','uses'=>'DashboardController@approveBulkPayment']);
Route::patch('/dashboard/members/payments/{id}/dispute', ['as'=>'dashboard.disputepayment','uses'=>'DashboardController@disputePayment']);

// NOTIFICATION PAGE
Route::get('/dashboard/notifications', ['as'=>'dashboard.notifications','uses'=>'DashboardController@getNotifications']);

// SMS MODULE
Route::get('/dashboard/sms/module', ['as'=>'dashboard.smsmodule','uses'=>'SMSController@getSMSModule']);
Route::post('/dashboard/sms/send/bulk', ['as'=>'dashboard.sms.sendbulk','uses'=>'SMSController@sendBulkSMS']);
Route::post('/dashboard/sms/send/reminder', ['as'=>'dashboard.sms.sendreminder','uses'=>'SMSController@sendReminderSMS']);

Route::get('/dashboard/sms/module/test', ['as'=>'dashboard.testgpsmsapi','uses'=>'SMSController@testGPSMSAPI']);
Route::get('/dashboard/sms/module/multi/test', ['as'=>'dashboard.testgpmultismsapi','uses'=>'SMSController@testMultiGPSMSAPI']);

// dashboard routes
// dashboard routes

// operation
// operation
Route::get('/dashboard/get5000', ['as'=>'dashboard.get5000','uses'=>'DashboardController@getAll5000']);

Route::get('/dashboard/easyperiod', ['as'=>'dashboard.easyperiod','uses'=>'EasyPeriodController@index']);

Route::get('/easyperiod/{slug}', ['as'=>'easyperiod.article','uses'=>'EasyPeriodController@getArticle']);
Route::get('/easyperiod/article/list/api', ['as'=>'easyperiod.article.list','uses'=>'EasyPeriodController@getArticlesList']);
Route::get('/dashboard/easyperiod/create/article', ['as'=>'easyperiod.article.create','uses'=>'EasyPeriodController@createArticlePage']);
Route::post('/dashboard/easyperiod/store/article', ['as'=>'easyperiod.article.store','uses'=>'EasyPeriodController@storeArticle']);
Route::get('/dashboard/easyperiod/{id}/edit/article', ['as'=>'easyperiod.article.edit','uses'=>'EasyPeriodController@editArticle']);
Route::post('/dashboard/easyperiod/{id}/update/article', ['as'=>'easyperiod.article.update','uses'=>'EasyPeriodController@updateArticle']);
Route::delete('/dashboard/easyperiod/article/{id}/delete', ['as'=>'easyperiod.article.delete','uses'=>'EasyPeriodController@delArticle']);
// Route::get('/dashboard/delete/extra/payments', ['as'=>'dashboard.delexpay','uses'=>'DashboardController@delExPay']);

// EasyPeriod Contact  Data
// EasyPeriod Contact  Data
Route::get('/dashboard/easyperiod', ['as'=>'dashboard.easyperiod.index','uses'=>'EasyPeriodController@index']);
Route::post('/dashboard/easyperiod/store/message/api', ['as'=>'dashboard.easyperiod.storemessage','uses'=>'EasyPeriodController@storeMessageAPI']);
Route::delete('/dashboard/easyperiod/message/{id}/delete', ['as'=>'dashboard.easyperiod.delmessage','uses'=>'EasyPeriodController@delMessage']);
Route::post('/dashboard/easyperiod/store/userimage/api', ['as'=>'dashboard.easyperiod.storeusermessage','uses'=>'EasyPeriodController@storeUserImageAPI']);
Route::get('/dashboard/easyperiod/userimage/{uid}/api', ['as'=>'dashboard.easyperiod.getuserimage','uses'=>'EasyPeriodController@getUserImageAPI']);


// operation
// operation
