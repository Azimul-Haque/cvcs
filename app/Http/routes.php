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
Route::get('/journey', ['as'=>'index.journey','uses'=>'IndexController@getJourney']);
Route::get('/constitution', ['as'=>'index.constitution','uses'=>'IndexController@getConstitution']);
Route::get('/faq', ['as'=>'index.faq','uses'=>'IndexController@getFaq']);
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
Route::get('/dashboard', ['as'=>'dashboard.index','uses'=>'DashboardController@index']);
Route::get('/dashboard/committee', ['as'=>'dashboard.committee','uses'=>'DashboardController@getCommittee']);
Route::post('/dashboard/committee', ['as'=>'dashboard.storecommittee','uses'=>'DashboardController@storeCommittee']);
Route::put('/dashboard/committee/{id}', ['as'=>'dashboard.updatecommittee','uses'=>'DashboardController@updateCommittee']);
Route::delete('/dashboard/committee/{id}', ['as'=>'dashboard.deletecommittee','uses'=>'DashboardController@deleteCommittee']);

Route::get('/dashboard/news', ['as'=>'dashboard.news','uses'=>'DashboardController@getNews']);

// ABOUTS AND BASIC INFO
Route::get('/dashboard/abouts', ['as'=>'dashboard.abouts','uses'=>'DashboardController@getAbouts']);
Route::put('/dashboard/abouts/{id}', ['as'=>'dashboard.updateabouts','uses'=>'DashboardController@updateAbouts']);
Route::put('/dashboard/basic/information/{id}', ['as'=>'dashboard.updatebasicinfo','uses'=>'DashboardController@updateBasicInfo']);

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

// ACCOUNT MANAGEMENT
Route::get('/dashboard/profile', ['as'=>'dashboard.profile','uses'=>'DashboardController@getProfile']);

// dashboard routes
// dashboard routes
