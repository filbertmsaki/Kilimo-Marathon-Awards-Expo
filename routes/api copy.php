<?php

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

Route::group(['prefix'=>'v1'], function(){
    Route::get('/marathon', [App\Http\Controllers\API\MarathonRegistrationController::class, 'index'])->name('marathon.index');
    Route::post('/marathon-registration', [App\Http\Controllers\API\MarathonRegistrationController::class, 'registration'])->name('marathon.registration');
    Route::post('/award-registration', [App\Http\Controllers\API\MarathonRegistrationController::class, 'awards_registration'])->name('awards.registration');
    Route::post('/sponsorship-store', [App\Http\Controllers\API\MarathonRegistrationController::class, 'sponsorship_store'])->name('sponsorship.store');
    Route::post('/expo-store', [App\Http\Controllers\API\MarathonRegistrationController::class, 'expo_store'])->name('expo.store');
    Route::post('/award-vote-store', [App\Http\Controllers\API\MarathonRegistrationController::class, 'award_vote_store'])->name('award.vote.store');
  
    Route::middleware('auth:sanctum')->group(function () {
        

    });


});