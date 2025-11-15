<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Middleware\ValidUser;
use App\Http\Middleware\CheckAdmin;

// Home 
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::post('contactUs', [HomeController::class, 'contact'])->name('contact.submit');

// Privacy Policy and Terms of Service
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-and-conditions', [HomeController::class, 'termsConditions'])->name('terms.conditions');

Route::get('auth/google', [GoogleAuthController::class, 'redijob/detailrect'])->name('auth.google');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::get('job', [JobController::class, 'job'])->name('job');
Route::get('job/detail/{id}', [JobController::class, 'jobOverview'])->name('account.jobOverview');
Route::post('job/job-apply', [JobController::class, 'applyJob'])->name('job.applyJob');
Route::get('job/applied-job', [JobController::class, 'appliedJob'])->name('job.appliedJob');
Route::post('job/job-delete', [JobController::class, 'appliedJobDelete'])->name('job.appliedJobDelete');
Route::post('job/saved-job', [JobController::class, 'savedJob'])->name('job.savedJob');
Route::post('job/unsaved-job', [JobController::class, 'unSavedJob'])->name('job.unSavedJob');

Route::get('job/job-save', [JobController::class, 'saveJob'])->name('job.saveJob');
Route::post('job/job-delete-saved-job', [JobController::class, 'deleteSavedJob'])->name('job.deleteSavedJob');
Route::post('job/addToFavourite', [JobController::class, 'favouriteJob'])->name('job.addToFav');

// Registration
Route::get('account/registration', [AccountController::class, 'registratioin'])->name('account.registration');
Route::post('account/register', [AccountController::class, 'register'])->name('account.register');

// Login
Route::get('account/login', [AccountController::class, 'login'])->name('account.login');
Route::post('account/authenticate', [AccountController::class, 'authentication'])->name('account.authenticate');

// User Profile
Route::get('account/profile', [AccountController::class, 'profile'])->name('account.profile')->middleware(ValidUser::class);

// Logout
Route::get('account/logout', [AccountController::class, 'logout'])->name('account.logout');

// Update Profile
Route::post('account/updateProile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
Route::post('account/updateProileImage', [AccountController::class, 'updateProileImage'])->name('account.updateProfileImage');
Route::post('account/analyze-resume', [AccountController::class, 'analyzeResume'])->name('account.analyzeResume');

// Create Job
Route::get('account/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
Route::post('account/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');

// Get My Job
Route::get('account/my-job', [AccountController::class, 'myJob'])->name('account.myJob');

// Update Job
Route::get('account/edit-job/{id}', [AccountController::class, 'editJob'])->name('account.editJob');
Route::post('account/update-job', [AccountController::class, 'updateJob'])->name('account.updateJob');

// Delete Job
Route::post('account/delete-job', [AccountController::class, 'deleteJob'])->name('account.deleteJob');

// Change Password
Route::post('account/change-password', [AccountController::class, 'changePassword'])->name('account.changePassword');

// Forgot Password
Route::get('acount/forgot-password', [AccountController::class, 'forgotPassword'])->name('account.forgotPassword');
Route::post('account/process-forgot-passwoed', [AccountController::class, 'processForgotPassword'])->name('account.processForgotPassword');

// Reset Password
Route::get('account/reset-password/{token}', [AccountController::class, 'resetPassword'])->name('account.resetPassword');
Route::post('account/process-reset-password', [AccountController::class, 'processResetPassword'])->name('account.processResetPassword');

// Candidate List
Route::get('job/candidate', [JobController::class, 'candidate'])->name('job.candidate');
Route::post('job/approve-candidate', [JobController::class, 'approveCandidate'])->name('job.approveCandidate');
Route::post('job/reject-candidate', [JobController::class, 'rejectCandidate'])->name('job.rejectCandidate');



// Admin Add User
Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware(CheckAdmin::class);
Route::get('admin/user-list', [AdminDashboardController::class, 'userList'])->name('admin.userList');
Route::get('admin/add-user', [AdminDashboardController::class, 'addUser'])->name('admin.addUser');
Route::post('admin/user-store', [AdminDashboardController::class, 'userStore'])->name('admin.userStore');
Route::get('admin/user-edit/{id}', [AdminDashboardController::class, 'userEdit'])->name('admin.userEdit');
Route::post('admin/user-update', [AdminDashboardController::class, 'userUpdate'])->name('admin.userUpdate');
Route::post('admin/user-delete', [AdminDashboardController::class, 'userDelete'])->name('admin.userDelete');

// Admin Add Job Categroy
Route::get('admin/job-category-list', [AdminDashboardController::class, 'jobCategoryList'])->name('admin.jobCategoryList');
Route::get('admin/job-category-user', [AdminDashboardController::class, 'addJobCategory'])->name('admin.addJobCategory');
Route::post('admin/job-category-store', [AdminDashboardController::class, 'jobCategoryStore'])->name('admin.jobCategoryStore');
Route::get('admin/job-category-edit/{id}', [AdminDashboardController::class, 'jobCategoryEdit'])->name('admin.jobCategoryEdit');
Route::post('admin/job-category-update', [AdminDashboardController::class, 'jobCategoryUpdate'])->name('admin.jobCategoryUpdate');
Route::post('admin/job-category-delete', [AdminDashboardController::class, 'jobCategoryDelete'])->name('admin.jobCategoryDelete');

// Admin Add Job Type
Route::get('admin/job-type-list', [AdminDashboardController::class, 'jobTypeList'])->name('admin.jobTypeList');
Route::get('admin/job-type-user', [AdminDashboardController::class, 'addJobType'])->name('admin.addJobType');
Route::post('admin/job-type-store', [AdminDashboardController::class, 'jobTypeStore'])->name('admin.jobTypeStore');
Route::get('admin/job-type-edit/{id}', [AdminDashboardController::class, 'jobTypeEdit'])->name('admin.jobTypeEdit');
Route::post('admin/job-type-update', [AdminDashboardController::class, 'jobTypeUpdate'])->name('admin.jobTypeUpdate');
Route::post('admin/job-type-delete', [AdminDashboardController::class, 'jobTypeDelete'])->name('admin.jobTypeDelete');

// Admin Add Job 
Route::get('admin/job-list', [AdminDashboardController::class, 'jobList'])->name('admin.jobList');
Route::get('admin/job-user', [AdminDashboardController::class, 'addJob'])->name('admin.addJob');
Route::post('admin/generate-job-description', [AdminDashboardController::class, 'generateJobDescription'])->name('admin.generateJobDescription');
Route::post('admin/job-store', [AdminDashboardController::class, 'jobStore'])->name('admin.jobStore');
Route::get('admin/job-edit/{id}', [AdminDashboardController::class, 'jobEdit'])->name('admin.jobEdit');
Route::post('admin/job-update', [AdminDashboardController::class, 'jobUpdate'])->name('admin.jobUpdate');
Route::post('admin/job-delete', [AdminDashboardController::class, 'jobDelete'])->name('admin.jobDelete');

// Admin Add Job Application
Route::get('admin/job-application-list', [AdminDashboardController::class, 'jobApplicationList'])->name('admin.jobApplicationList');
Route::get('admin/job-application-user', [AdminDashboardController::class, 'addJobApplication'])->name('admin.addJobApplication');
Route::post('admin/job-application-store', [AdminDashboardController::class, 'jobApplicationStore'])->name('admin.jobApplicationStore');
Route::get('admin/job-application-edit/{id}', [AdminDashboardController::class, 'jobApplicationEdit'])->name('admin.jobApplicationEdit');
Route::post('admin/job-application-update', [AdminDashboardController::class, 'jobApplicationUpdate'])->name('admin.jobApplicationUpdate');
Route::post('admin/job-application-delete', [AdminDashboardController::class, 'jobApplicationDelete'])->name('admin.jobApplicationDelete');
Route::post('admin/job-approve-candidate', [AdminDashboardController::class, 'approveCandidate'])->name('admin.approveCandidate');
Route::post('admin/job-reject-candidate', [AdminDashboardController::class, 'rejectCandidate'])->name('admin.rejectCandidate');

// Admin and Roles Management

Route::get('admin/admin-roles', [AdminDashboardController::class, 'adminRoles'])->name('admin.adminsRoles');
Route::get('admin/add-admin', [AdminDashboardController::class, 'addAdmin'])->name('admin.addAdmin');
Route::post('admin/admin-store', [AdminDashboardController::class, 'adminStore'])->name('admin.adminStore');
Route::get('admin/admins-edit/{id}', [AdminDashboardController::class, 'adminEdit'])->name('admin.adminEdit');
Route::post('admin/admin-update', [AdminDashboardController::class, 'adminUpdate'])->name('admin.adminUpdate');
Route::post('admin/admin-delete', [AdminDashboardController::class, 'adminDelete'])->name('admin.adminDelete');
Route::post('admin/profile/update', [AdminDashboardController::class, 'updateProfile'])->name('admin.profileUpdate');


// Admin Website Setting
Route::get('settings', [SettingController::class, 'index'])->name('admin.settings');
Route::post('settings/{type}', [SettingController::class, 'update'])->name('admin.settings.update');

// Admin Change Password
Route::post('admin/change-password', [AdminDashboardController::class, 'changePassword'])->name('admin.changePassword');











