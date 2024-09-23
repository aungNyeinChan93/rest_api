<?php

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get("defer",function(){
    defer(function(){
        sleep(5);
        dd("hey");
        Mail::to("anc@gmail.com")->send( new TestMail());
    });
    return "hello";
});
