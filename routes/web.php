<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReturnedProductController;

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

//login
Route::post("/login", [LoginController::class, "login"]);
Route::post("/signup", [SignupController::class, "signup"]);
Route::get("/checkUser", [LoginController::class, "checkLogin"]);
Route::post("/logout", [LoginController::class, "logout"]);

//Home controller
Route::post("/home", [HomeController::class,'index']);
Route::get("/get-user-count", [HomeController::class, 'getUserCount']);
Route::get("/get-product-count", [HomeController::class, 'getProductCount']);
Route::get("/get-category-count", [HomeController::class, 'getCategoryCount']);

//User
Route::post("/submit-user", [UserController::class, 'createUser'])->name("createUser");
Route::get("/get-users", [UserController::class, "getUsers"]);
Route::post("/update-user", [UserController::class, "updateUser"]);
Route::post("/delete-user", [UserController::class, "deleteUser"]);


//Product
Route::post("/submit-product", [ProductController::class, 'createProduct'])->name("createProduct");
Route::get("/get-products", [ProductController::class, 'getProducts']);
Route::post("/update-product", [ProductController::class, 'updateProduct']);
Route::post("/delete-product", [ProductController::class, 'deleteProduct']);

Route::get("/get-returns", [ReturnedProductController::class, 'getReturnedProducts'])->name("getReturnedProducts");
Route::post("/update-returnedProduct", [ReturnedProductController::class, 'updateReturnedProduct']);
Route::post("/returned-products", [ReturnedProductController::class, 'processReturn']);


// Route::post("/products/{product}/approve", [ProductController::class, 'approveStatus'])->name("approveStatus");
// Route::post("/products/{product}/reject", [ProductController::class, 'rejectStatus'])->name("rejectStatus");
// Route::post('/products/{product}/update-status', [ProductController::class, 'updateProductStatus']);



//Category
Route::post("/submit-category", [CategoryController::class, 'createCategory'])->name("createCategory");
Route::get("/get-categories", [CategoryController::class, 'getCategories']);
Route::post("/update-category", [CategoryController::class, 'updateCategory']);
Route::post("/delete-category", [CategoryController::class, 'deleteCategory']);

//
Route::get('/{vue?}', function(){
    return view('app');
})->where('vue', '[\/\w\.-]*');

