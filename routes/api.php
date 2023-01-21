<?php

use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\VerificationController;

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
Route::get('email/verify', 'App\Http\Controllers\VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name
Route::get('email/resend', 'App\Http\Controllers\VerificationControllerr@resend')->name('verification.resend');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('change-password', 'changePassword');
    Route::get('user/data', 'getCurrentUserData');
    Route::get('user/referral/data', 'getCurrentUserReferralData');
    Route::post('user/profile/image', 'storeProfilePicture');
    Route::post('user/profile/name', 'storeProfileName');

});

Route::controller(PricingController::class)->group(function () {
    Route::get('pricing/data', 'getPricingData');
});

Route::controller(MessageController::class)->group(function () {
    Route::get('apps/email/emails', 'getAllUserMessages');
    Route::get('apps/email/userOptions', 'getUserEmailOptions');
    Route::post('apps/email/send', 'sendEmail');
});

Route::controller(JobController::class)->group(function () {
    Route::get('/job/list/data', 'getAllAvailableJobs');
    Route::get('/user/job/list/data', 'getAllUserJobs');
    Route::post('/job/list/data', 'getAvailableJobsForQuery');
    Route::get('/job/list/data/sidebar', 'getTopJobs');
    Route::get('/job/list/data/detail/{jobId}', 'getJobDetails');
    Route::post('/job/new', 'saveNewJobPost');
    Route::delete('/job/toggle/{jobId}', 'toggleJob');
});
