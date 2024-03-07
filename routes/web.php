<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReturnedProductController;
use App\Http\Controllers\ProductUserController;
use App\Http\Controllers\ProductListController;

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
Route::get("/get-return-count", [HomeController::class, 'getReturnCount']);
Route::get("/recent-products", [HomeController::class, 'recentProducts']);

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
Route::post("/upload-image", [ProductController::class, 'uploadImage']);
Route::post("/return-product", [ProductController::class, 'returnProduct'])->name("returnProduct");
Route::post("/returnAll-product", [ProductController::class, 'ReturnAll'])->name("ReturnAll");
Route::get("/get-categories", [ProductController::class, 'getCategories']);
Route::get("/get-users", [ProductController::class, 'getUsers']);
Route::post("/receive", [ProductController::class, 'updateProduct']);

Route::get("/get-productsUser", [ProductUserController::class, 'getProductsUser']);
Route::post("/submitToAdmin", [ProductUserController::class, 'SubmitAdmin']);
Route::get("/get-categories", [ProductUserController::class, 'getCategories']);
Route::post("/deliver", [ProductUserController::class, 'Deliver']);

//Route::get('/get-transaction-id/{productId}', [ProductUserController::class, 'getTransactionId']);


Route::get("/get-product-lists", [ProductListController::class, 'getProductLists']);
// // Route for fetching pending products
// Route::get('/get-pending-products', [ProductController::class, 'getPendingProducts']);

// // Route for fetching approved products
// Route::get('/get-approved-products', [ProductController::class, 'getApprovedProducts']);

// Route::post("/submit-return", [ReturnedProductController::class, 'createReturns'])->name("createReturns");
// Route::get("/get-returns", [ReturnedProductController::class, 'getReturnedProducts'])->name("getReturnedProducts");
// Route::get("/returned-products", [ReturnedProductController::class, 'fetchReturnedProducts'])->name("fetchReturnedProducts");
// Route::post("/update-returnedProduct", [ReturnedProductController::class, 'updateReturnedProduct']);
// Route::post("delete-returns",[ReturnedProductController::class,'deleteReturn']);

//Category
Route::post("/submit-category", [CategoryController::class, 'createCategory'])->name("createCategory");
Route::get("/get-categories", [CategoryController::class, 'getCategories']);
Route::post("/update-category", [CategoryController::class, 'updateCategory']);
Route::post("/delete-category", [CategoryController::class, 'deleteCategory']);

//POS
Route::get("/get-products", [PosController::class, 'fetchProducts']);
Route::get('/fetch-categories', [PosController::class, 'fetchCategories']);

Route::post('/addToCart', [PosController::class, 'addToCart'])->name("addToCart");
Route::get('/showCartItem', [PosController::class, 'showCartItem']);
Route::post('/delete-item', [PosController::class, 'deleteItem']);
Route::post('/checkout', [PosController::class, 'checkout']);

Route::get('/fetch-orders', [OrderController::class, 'fetchOrders']);
Route::get('/view-order', [OrderController::class, 'viewOrder']);

Route::get('/fetch-transactions', [TransactionController::class, 'fetchTransactions']);

Route::get('/{vue?}', function(){
    return view('app');
})->where('vue', '[\/\w\.-]*');

