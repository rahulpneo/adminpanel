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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/admin/notification', 'ArticleController@notification');

Route::group(['middleware'=>['admin_auth','admin']],function(){
	Route::get('/admin', 'AdminController@index');	
	
	//Route::resource('tags','TagController');
	
	//Group to put all the routes that need login first
	Route::group(array('prefix'=> 'admin','middleware'=>['role:admin']), function(){
		//Route::auth();
		Route::resource('tags' , 'TagController' );
		Route::resource('categories' , 'CategoryController' );
		
		Route::put('change_tag_status/{id}' , 'TagController@changeStatus' );
		Route::put('change_category_status/{id}' , 'CategoryController@changeStatus' );
		
		Route::get('/ajax_get_tags', 'TagController@ajax_get_tags');	
		Route::get('/ajax_get_categories', 'CategoryController@ajax_get_categories');	
	});
	
	Route::group(array('prefix'=> 'admin','middleware'=>['role:admin|approver']), function(){
		//Route::auth();
		Route::resource('users' , 'UsersController' );
		
		Route::get('/ajax_get_users', 'UsersController@ajax_get_user');	
	});

	Route::group(array('prefix'=> 'admin','middleware'=>['role:admin|editor']), function(){
		//Route::auth();
		Route::resource("articles","ArticleController");
		Route::get('/ajax_get_templates/{id}', 'ArticleController@ajax_get_templates');
		Route::get('/ajax_get_articles', 'ArticleController@ajax_get_articles');	
	});
	
	
	Route::group(array('prefix'=> 'admin','middleware'=>['role:admin|editor']), function(){
		//Route::auth();
		Route::resource("emails","EmailController");
		Route::get('/ajax_get_templates/{id}', 'EmailController@ajax_get_templates');
		Route::get('/ajax_get_emails', 'EmailController@ajax_get_emails');	
	});
	
	Route::group(array('prefix'=>'admin','middleware'=>['role:admin|editor']), function(){
		Route::resource('changepassword' , 'ChangepasswordController' );
		//Route::get('passwordstore' , 'ChangepasswordController@store' );
	});
	//Entrust::routeNeedsRole('admin/users*', array('admin','approver'));
});	

Route::group(['prefix' => 'admin'], function() {
    Route::auth();
});
