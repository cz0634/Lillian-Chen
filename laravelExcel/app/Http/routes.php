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
    return view('Home/home');
});

/*Route::get("Kit/index","KitController@index");*/

Route::group(["prefix"=>"home"],function(){
    Route::get("home","HomeController@home");
    Route::get("test","HomeController@test");
    Route::post("uploadExcel","HomeController@uploadExcel");
    Route::any("import","HomeController@import");
    Route::any("createSession","HomeController@createSession");
    Route::any("downloadSql","HomeController@downloadSql");
    Route::any("export","HomeController@export");
});


Route::group(["prefix"=>"Kit"],function(){
    Route::get("index","KitController@index");
    Route::get("login","KitController@login");
    Route::get("verify/{num}","KitController@verify");
});
