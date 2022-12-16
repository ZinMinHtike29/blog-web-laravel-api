<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\profileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\UserManageController;
use App\Http\Controllers\Api\User\SavePostController;
use App\Http\Controllers\Api\User\UserPostController;
use App\Http\Controllers\WebController;

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
Route::post("/register", [AuthController::class, "registerUser"]);
Route::post("/login", [AuthController::class, "loginUser"]);

Route::middleware('auth:sanctum')->group(function () {
    //Update Profile
    Route::post("update/profile", [profileController::class, "updateProfile"]);
    //Change Password
    Route::post("change/password", [AuthController::class, "changePassword"]);

    //Get Amdin List
    Route::get("get/admin/list", [UserManageController::class, "getAdminList"]);
    //Get USer List
    Route::get("get/user/list", [UserManageController::class, "getUserList"]);

    //Remove From Amdin
    Route::post("delete/admin", [UserManageController::class, "deleteFromAdmin"]);

    //Remove from Admin Role
    Route::post("remove/admin", [UserManageController::class, "removeFromAdminRole"]);

    //Create CAtegory
    Route::post("create/category", [CategoryController::class, "createCategory"]);

    //Get  Category with PAgination
    Route::get("get/category", [CategoryController::class, "getAllCategory"]);
    //Delete Category
    Route::post("delete/category", [CategoryController::class, "deleteCategory"]);
    //Update Category
    Route::post("update/category", [CategoryController::class, "updateCategory"]);
    //Create Post
    Route::post("create/post", [PostController::class, "createPost"]);
    //Get All Post
    Route::get("get/all/post", [PostController::class, "getAllPost"]);
    //Get One Post
    Route::get("get/post", [PostController::class, "getPost"]);
    //Delete Post
    Route::post("delete/post", [PostController::class, "deletePost"]);
    //Update Post Image
    Route::post("update/image", [PostController::class, "updateImage"]);
    //Update Post
    Route::post('update/post', [PostController::class, "updatePost"]);
    //USer
    //User Save Post
    Route::post("user/save/post", [SavePostController::class, "savePost"]);
    //USer Check IS Save
    Route::post("user/check/isSave", [SavePostController::class, "checkIsSave"]);
    //Get All Save Post
    Route::get("user/get/savePost", [SavePostController::class, "getSavePost"]);
    //USer Delete Save Post
    Route::post("user/delete/save/post", [SavePostController::class, "deleteSavePost"]);
});

// Get CAtegory without PAgination
Route::get("get/all/category", [CategoryController::class, "getCategoryWithoutPagination"]);

//Add Website View Count
Route::get("add/website/view/count", [WebController::class, "addWebCount"]);
//User

//GetLatest Post
Route::get("get/latest/post", [UserPostController::class, "getLatestPost"]);
//User Get One Post
Route::post("get/onepost", [UserPostController::class, "getOnePost"]);
//USer Get All Post
Route::get("user/get/all/post", [UserPostController::class, "getAllPost"]);
//Search Post
Route::get("user/search/post", [UserPostController::class, "searchPost"]);
//Add Post Count
Route::post("add/postviewcount", [UserPostController::class, "addPost"]);

//Get Trend Post
Route::get('get/trendPost', [PostController::class, "getTrendPost"]);
//Create Contact Data
Route::post("create/contact/data", [ContactController::class, "createContactData"]);
//GEt All Contact Data
Route::get('get/contact', [ContactController::class, "getContact"]);
//Get One Contact Data
Route::get("get/oneContact", [ContactController::class, "getOneContact"]);
