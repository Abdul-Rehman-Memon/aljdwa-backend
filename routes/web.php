<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\EntrepreneurController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('testing', function () {
    return view('layouts/testing');
});

Route::get('payment', function () {
    return view('layouts/payment');
});

Route::get('payment', function ($request) {
    return dd($request);
})->name('stripe.post');


