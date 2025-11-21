<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelPicturesController;
use App\Http\Controllers\pages\HotelPage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/hotels',[HotelPage::class,'index']);
Route::get('/hotels/new',[HotelPage::class,'create']);
Route::get('/hotels/{id}/update',[HotelPage::class,'update']);
Route::get('/hotels/{id}',[HotelPage::class,'show']);




//Route::get('/hotels', function () {
//    return view('test_api');
//});

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

