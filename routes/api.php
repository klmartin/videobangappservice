<?php

use App\Http\Controllers\authenticationController;
use App\Http\Controllers\payments\PaymentAnalyticsController;
use App\Http\Controllers\payments\PaymentsController;
use App\Http\Controllers\VideoController;
use GuzzleHttp\Middleware;
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

//video uploadind test serve//->middleware('auth:sanctum');
Route::post('v1/add/content/cover/image', [VideoController::class, 'UploadVideo']);
Route::get('v1/get/stats/video/encoding', [VideoController::class, 'GetVideoEncodingStats']);
Route::post('v1/upload/content/video', [VideoController::class, 'UploadVideo']);
Route::post('v1/upload/stream/video', [VideoController::class, 'UploadStreamVideo']);
Route::post('v1/upload-video', [VideoController::class, 'upload']);
//get processed content video
Route::get('v1/get-content-video', [VideoController::class, 'getContentVideo']);
Route::get('v1/get/videos/processing-status', [VideoController::class, 'getVideosProcessingStatus']);
Route::get('v1/get/video/processing-status', [VideoController::class, 'getVideoProcessingStatus']);

