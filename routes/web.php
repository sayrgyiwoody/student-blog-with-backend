<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SavedController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'user/home');

Route::group(['prefix'=>'user',],function(){
    Route::group(['prefix'=>'home'],function(){
        Route::get('/',[UserController::class,'home'])->name('user#home');
        Route::get('view/{id}',[UserController::class,'view'])->name('user#view');
        Route::get('topicFilter/{id}',[UserController::class,'topicFilter'])->name('user#topicFilter');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('auth#dashboard');
    Route::group(['middleware'=>'verified_middleware'],function(){
        Route::get('/adminApprove',[AuthController::class,'adminApprovePage'])->name('auth#adminApprovePage');
        Route::post('/approveRequest',[AuthController::class,'approveRequest'])->name('auth#approveRequest');
        Route::post('/sendCode',[AuthController::class,'sendCode'])->name('auth#sendCode');
        Route::get('checkCodePage',[AuthController::class,'checkCodePage'])->name('auth#checkCodePage');
        Route::post('/verifyCode',[AuthController::class,'checkCode'])->name('auth#checkCode');
    });

    //Admin
    Route::group(['prefix'=>'admin','middleware'=>'admin_auth'],function() {
        //direct home page
        // Route::get('home',function() {
        //     return view('admin.home');
        // })->name('admin#home');

        Route::get('home',[AdminHomeController::class,'home'])->name('admin#home');

        // Admin account
        Route::group(['prefix'=>'account'],function() {
            Route::get('changPasswordPage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('changePassword',[AdminController::class,'changePassword'])->name('admin#changePassword');
            Route::get('informationPage',[AdminController::class,'informationPage'])->name('admin#informationPage');
            Route::get('updateAccountPage',[AdminController::class,'updateAccountPage'])->name('admin#updateAccountPage');
            Route::post('updateAccount/{id}',[AdminController::class,'updateAccount'])->name('admin#updateAccount');
            Route::get('admin/list',[AdminController::class,'adminList'])->name('admin#adminAccountList');
            Route::get('delete',[AdminController::class,'delete'])->name('admin#delete');
            Route::get('change/userRole/{id}',[AdminController::class,'changeUserRole'])->name('admin#changeUserRole');
            Route::get('user/list',[AdminController::class,'userList'])->name('admin#userAccountList');
            Route::get('change/adminRole/{id}',[AdminController::class,'changeAdminRole'])->name('admin#changeAdminRole');
            Route::get('approve/{id}',[AdminController::class,'approve'])->name('admin#approve');
        });

        //Topic
        Route::group(['prefix'=>'topic'],function() {
            Route::get('/',[TopicController::class,'listPage'])->name('topic#listPage');
            Route::get('createPage',[TopicController::class,'createPage'])->name('topic#createPage');
            Route::post('create',[TopicController::class,'create'])->name('topic#create');
            Route::get('editPage/{id}',[TopicController::class,'editPage'])->name('topic#editPage');
            Route::post('edit,{id}',[TopicController::class,'edit'])->name('topic#edit');
            Route::get('delete',[TopicController::class,'delete'])->name('topic#delete');
            Route::get('asc',[TopicController::class,'filterAsc'])->name('topic#filterAsc');
        });

        //Post
        Route::group(['prefix'=>'post'],function() {
            Route::get('/',[PostController::class,'listPage'])->name('post#listPage');
            Route::get('asc',[PostController::class,'filterAsc'])->name('post#filterAsc');
            Route::get('mostSaved',[PostController::class,'mostSaved'])->name('post#mostSaved');
            Route::get('createPage',[PostController::class,'createPage'])->name('post#createPage');
            Route::post('create',[PostController::class,'create'])->name('post#create');
            Route::get('view/{id}',[PostController::class,'view'])->name('post#view');
            Route::get('delete',[PostController::class,'delete'])->name('post#delete');
            Route::get('editPage/{id}',[PostController::class,'editPage'])->name('post#editPage');
            Route::post('edit/{id}',[PostController::class,'edit'])->name('post#edit');
        });

        //Feedback
        Route::group(['prefix'=>'feedback'],function() {
            Route::get('list',[FeedbackController::class,'adminPage'])->name('admin#feedbackPage');
            Route::get('delete',[FeedbackController::class,'delete'])->name('admin$feedbackDelete');
            Route::get('list/viewPage/{id}',[FeedbackController::class,'view'])->name('admin#feedbackView');
            Route::get('delete/all',[FeedbackController::class,'deleteAll'])->name('admin$feedbackDeleteAll');

        });
    });


    //User
    Route::group(['prefix'=>'user','middleware' => ['user_auth', 'verfiy_auth']],function() {
        //direct home page
        // Route::get('home',function() {
        //     return view('user.home');
        // })->name('user#home');

        Route::group(['prefix'=>'home'],function(){
            // Route::get('/',[UserController::class,'home'])->name('user#home');
            // Route::get('view/{id}',[UserController::class,'view'])->name('user#view');
            // Route::get('topicFilter/{id}',[UserController::class,'topicFilter'])->name('user#topicFilter');
            Route::get('save',[SavedController::class,'save'])->name('user#save');
        });

        Route::group(['prefix'=>'saved'],function(){
            Route::get('list',[SavedController::class,'savedList'])->name('saved#list');
            Route::get('unsave',[SavedController::class,'unsave'])->name('saved#unsave');

        });

        Route::group(['prefix'=>'feedback'],function(){
            Route::get('/',[FeedbackController::class,'form'])->name('feedback#form');
            Route::post('send',[FeedbackController::class,'send'])->name('feedback#send');
        });

        Route::group(['prefix'=>'post'],function(){
            Route::get('/',[UserPostController::class,'home'])->name('user#postHome');
            Route::post('create',[UserPostController::class,'create'])->name('user#postCreate');
            Route::get('editPage/{id}',[UserPostController::class,'editPage'])->name('user#postEditPage');
            Route::post('edit',[UserPostController::class,'edit'])->name('user#postEdit');
            Route::get('delete',[UserPostController::class,'delete'])->name('post#delete');
        });

        Route::group(['prefix'=>'account'],function(){
            Route::get('changPasswordPage',[UserAccountController::class,'changePasswordPage'])->name('user#changePasswordPage');
            Route::post('changePassword',[UserAccountController::class,'changePassword'])->name('user#changePassword');
            Route::get('informationPage',[UserAccountController::class,'informationPage'])->name('user#informationPage');
            Route::get('updateAccountPage',[UserAccountController::class,'updateAccountPage'])->name('user#updateAccountPage');
            Route::post('updateAccount',[UserAccountController::class,'updateAccount'])->name('user#updateAccount');
        });
    });


});


Route::post('password/forgot',[UserController::class,'sendResetLink'])->name('forgot.password.link');
Route::get('password/reset/{token}',[UserController::class,'showResetForm'])->name('reset.password.form');
Route::post('password/reset',[UserController::class,'resetPassword'])->name('reset.password');

Route::post('/send-notification',[NotificationController::class,'send']);
