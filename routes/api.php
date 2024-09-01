<?php

use App\Http\Controllers\Web\Event\AwardController;
use App\Http\Controllers\Web\Event\ExpoController;
use App\Http\Controllers\Web\Event\MarathonController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix'=>'v1','middleware'=>'localization'], function(){
    Route::post('/flw-callback', [WebController::class, 'flw_callback'])->name('flw_callback');

    Route::get('marathon-status',[MarathonController::class,'getStatus']);
    Route::post('marathon-registration',[MarathonController::class,'store']);

    Route::get('award-status',[AwardController::class,'getStatus']);
    Route::post('award-registration',[AwardController::class,'store']);

    Route::get('expo-status',[ExpoController::class,'getStatus']);
    Route::post('expo-registration',[ExpoController::class,'store']);
});
