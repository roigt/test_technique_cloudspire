<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelPicturesController;
use App\Http\Controllers\pages\HotelPage;
use App\Http\Controllers\pages\PicturePage;
use Illuminate\Support\Facades\Route;


//pages
Route::get('/hotels',[HotelPage::class,'index']);
Route::get('/hotels/new',[HotelPage::class,'create']);
Route::get('/hotels/{id}/update',[HotelPage::class,'update']);
Route::get('/hotels/{id}',[HotelPage::class,'show']);



Route::get('hotel/{id}/pictures',[PicturePage::class,'index']);
Route::get('hotel/{id}/picture',[PicturePage::class,'create']);
Route::get('hotel/{id}/picture/{pictureId}',[PicturePage::class,'update']);



//hotels
Route::get('/api/hotels',[HotelController::class,'index']);
Route::get('/api/hotels/{hotel}',[HotelController::class,'show']);
Route::post('/api/hotels',[HotelController::class,'store']);
Route::put('/api/hotels/{hotel}',[HotelController::class,'update']);
Route::delete('/api/hotels/{hotel}',[HotelController::class,'destroy']);


//hotels_pictures
Route::get('/api/hotel/pictures',[HotelPicturesController::class,'create']);
Route::patch('/api/hotels/{hotel}/pictures/reorder',[HotelPicturesController::class,'reorder']);
Route::post('/api/hotels/{hotel}/pictures',[HotelPicturesController::class,'store']);
Route::post('/api/hotels/{hotel}/pictures/{picture}',[HotelPicturesController::class,'update']);
Route::delete('/api/hotels/{hotel}/pictures/{picture}',[HotelPicturesController::class,'destroy']);



