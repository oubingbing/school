<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/hui_yi_happy_birthday', function (){
    return view('birthday.flower');
});

Route::get('/hui_yi_song_ni_de_dang_gao', function (){
    return view('birthday.cake');
});


