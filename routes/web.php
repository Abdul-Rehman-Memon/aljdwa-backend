<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\EntrepreneurController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('testing', function () {
    return view('layouts/testing');
});

// Route::get('payment', function () {
//     return view('layouts/payment');
// });


Route::get('payment', function ($request) {
    // return dd($request);
})->name('hyper.post');


Route::get('clear-cache', function () {

    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    $run = Artisan::call('route:clear');
    $run = Artisan::call('route:cache');
    $run = Artisan::call('view:clear');
    $run = Artisan::call('optimize:clear');
    $run = Artisan::call('storage:link');
    return 'FINISHED';
});

Route::get('reverb-start', function () {

    $run = Artisan::call('reverb:start');

    return $run;
});