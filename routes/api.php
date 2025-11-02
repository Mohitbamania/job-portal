<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserConroller;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::post('user/create-job', [UserConroller::class, 'createJob'])->name('user.createJob');
Route::post('user/update-job', [UserConroller::class, 'updateJob'])->name('user.updateJob');
Route::post('user/updateProfile', [UserConroller::class, 'updateProfile'])->name('user.updateProfile');
Route::post('user/appliyJob', [UserConroller::class, 'appliyJob'])->name('user.appliyJob');
Route::post('user/saveJob', [UserConroller::class, 'saveJob'])->name('user.saveJob');
Route::post('user/unSaveJob', [UserConroller::class, 'unSaveJob'])->name('user.unSaveJob');
Route::post('user/approveCandidate', [UserConroller::class, 'approveCandidate'])->name('user.approveCandidate');
Route::post('user/rejectCandidate', [UserConroller::class, 'rejectCandidate'])->name('user.rejectCandidate');
Route::post('user/searchJob', [UserConroller::class, 'searchJob'])->name('user.searchJob');
Route::post('user/getMyJob', [UserConroller::class, 'getMyJob'])->name('user.getMyJob');
Route::post('user/getMyAppliedJob', [UserConroller::class, 'getMyAppliedJob'])->name('user.getMyAppliedJob');
Route::post('user/getMySavedJob', [UserConroller::class, 'getMySavedJob'])->name('user.getMySavedJob');
Route::post('user/getJobDetailsById', [UserConroller::class, 'getJobDetailsById'])->name('user.getJobDetailsById');







