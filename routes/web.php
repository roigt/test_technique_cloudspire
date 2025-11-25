<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelPicturesController;
use App\Http\Controllers\pages\HotelPage;
use App\Http\Controllers\pages\PicturePage;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/hotels');
//page images front
Route::get('hotels/{id}/pictures',[PicturePage::class,'index']);
Route::get('hotels/{id}/picture',[PicturePage::class,'create']);
Route::get('hotels/{id}/picture/{pictureId}',[PicturePage::class,'update']);


//pages hotels front
Route::get('/hotels',[HotelPage::class,'index'])->name('hotels');
Route::get('/hotels/new',[HotelPage::class,'create']);
Route::get('/hotels/{id}/update',[HotelPage::class,'update']);
Route::get('/hotels/{id}',[HotelPage::class,'show']);






//hotels backend
Route::get('/api/hotels',[HotelController::class,'index']);
Route::get('/api/hotels/{hotel}',[HotelController::class,'show']);
Route::post('/api/hotels',[HotelController::class,'store']);
Route::put('/api/hotels/{hotel}',[HotelController::class,'update']);
Route::delete('/api/hotels/{hotel}',[HotelController::class,'destroy']);


//hotels_pictures backend
Route::patch('/api/hotels/{hotel}/pictures/reorder',[HotelPicturesController::class,'reorder']);
Route::post('/api/hotels/{hotel}/pictures',[HotelPicturesController::class,'store']);
Route::post('/api/hotels/{hotel}/pictures/{picture}',[HotelPicturesController::class,'update']);
Route::delete('/api/hotels/{hotel}/pictures/{picture}',[HotelPicturesController::class,'destroy']);



