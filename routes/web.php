<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelPicturesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');


Route::get('/hotels', function () {
    return view('test_api');
});

//hotels
Route::get('/api/hotels',[HotelController::class,'index']);
Route::get('/api/hotels/{hotel}',[HotelController::class,'show']);
Route::post('/api/hotels',[HotelController::class,'store']);
Route::put('/api/hotels/{hotel}',[HotelController::class,'update']);
Route::delete('/api/hotels/{hotel}',[HotelController::class,'destroy']);


//hotels_pictures
Route::get('/api/hotel/pictures',[HotelPicturesController::class,'create']);
Route::post('/api/hotels/{hotel}/pictures',[HotelPicturesController::class,'store']);
Route::post('/api/hotels/{hotel}/pictures/{picture}',[HotelPicturesController::class,'update']);
Route::delete('/api/hotels/{hotel}/pictures/{picture}',[HotelPicturesController::class,'destroy']);


