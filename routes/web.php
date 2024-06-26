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
use App\Http\Controllers\CashRegController;
use App\Http\Controllers\InventoryController;

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
Route::get("/get-sales-count", [HomeController::class, 'getSalesCount']);
Route::get("/recent-products", [HomeController::class, 'recentProducts']);
Route::get("/get-sold-items", [HomeController::class, 'getSoldItems']);
Route::get("/get-returns", [HomeController::class, 'getReturnedItems']);

//User
Route::post("/submit-user", [UserController::class, 'createUser'])->name("createUser");
Route::get("/get-users", [UserController::class, "getUsers"]);
Route::post("/update-user", [UserController::class, "updateUser"]);
Route::post("/delete-user", [UserController::class, "deleteUser"]);


//Product
Route::get("/get-products", [ProductController::class, 'getProducts']);
Route::post("/update-product", [ProductController::class, 'updateProduct']);
Route::post("/approve-product", [ProductController::class, 'approveProduct']);
Route::post("/delete-product", [ProductController::class, 'deleteProduct']);
Route::post("/upload-image", [ProductController::class, 'uploadImage']);

Route::post("/return-product", [ProductController::class, 'returnProduct'])->name("returnProduct");
Route::post("/returnAll-product", [ProductController::class, 'ReturnAll'])->name("ReturnAll");

Route::get("/get-categories", [ProductController::class, 'getCategories']);
Route::get("/get-users", [ProductController::class, 'getUsers']);
Route::get("/get-productlists", [ProductController::class, 'getProductLists']);
Route::get("/get-deliveries", [ProductController::class, 'fetchDeliveries']);
Route::post("/receive", [ProductController::class, 'updateProduct']);


//ProductUser
Route::post("/submit-product", [ProductUserController::class, 'createProduct'])->name("createProduct");
Route::get("/get-productsUser", [ProductUserController::class, 'getProductsUser']);
Route::post("/submit-to-admin", [ProductUserController::class, 'SubmitAdmin']);
Route::get("/get-categories", [ProductUserController::class, 'getCategories']);
Route::post("/deliver", [ProductUserController::class, 'Deliver']);
Route::post('/add-Cart', [ProductUserController::class, 'addToDevCart'])->name("addToDevCart");
Route::get('/showCartItems', [ProductUserController::class, 'showCartItems']);
Route::post('/delete-item', [ProductUserController::class, 'deleteItem']);
Route::post('/delete-product', [ProductUserController::class, 'deleteProduct']);
Route::post('/checkout', [ProductUserController::class, 'checkout']);
Route::get("/getproductlists", [ProductUserController::class, 'getProductLists']);

Route::get("/fetch-inventories", [InventoryController::class, 'fetchInventories']);

//Route::get('/get-transaction-id/{productId}', [ProductUserController::class, 'getTransactionId']);


Route::get("/get-product-lists", [ProductListController::class, 'getProductLists']);
Route::post("/submit-productList", [ProductListController::class, 'createProductList']);
Route::post("/upload-images", [ProductListController::class, 'uploadImages']);
Route::post("/update-productlist", [ProductListController::class, 'updateProductList']);
Route::get('/generateItemCode', [ProductListController::class, 'getItemCode']);


Route::post("/submit-return", [ReturnedProductController::class, 'createReturns'])->name("createReturns");
Route::get("/get-returns", [ReturnedProductController::class, 'getReturnedProducts'])->name("getReturnedProducts");
Route::get("/returned-products", [ReturnedProductController::class, 'fetchReturnedProducts'])->name("fetchReturnedProducts");
Route::post("/update-returnedProduct", [ReturnedProductController::class, 'updateReturnedProduct']);
Route::post("delete-returns",[ReturnedProductController::class,'deleteReturn']);

//Category
Route::post("/submit-category", [CategoryController::class, 'createCategory'])->name("createCategory");
Route::get("/get-categories", [CategoryController::class, 'getCategories']);
Route::post("/update-category", [CategoryController::class, 'updateCategory']);
Route::post("/delete-category", [CategoryController::class, 'deleteCategory']);

//POS
Route::get("/getProducts", [PosController::class, 'fetchProducts'])->name('fetchProducts');
Route::get("/getproductlists", [PosController::class, 'fetchProductLists']);
Route::get('/fetch-categories', [PosController::class, 'fetchCategories']);
Route::post('/addToCart', [PosController::class, 'addToCart'])->name("addToCart");
Route::get('/showCartItem', [PosController::class, 'showCartItem']);
Route::post('/delete-item', [PosController::class, 'deleteItem']);
Route::post('/checkout', [PosController::class, 'checkout']);

Route::get('/fetch-orders', [PosController::class, 'fetchOrders']);
Route::get('/view-order', [PosController::class, 'viewOrder']);

Route::get('/fetch-transactions', [TransactionController::class, 'fetchTransactions']);


//Online Order
Route::get("/getProd", [OrderController::class, 'getProd']);
Route::get("/getOrders", [OrderController::class, 'getOrders']);
Route::get("/getProdlist", [OrderController::class, 'getProdlist']);
Route::post('/add-cart', [OrderController::class, 'addCart'])->name("addCart");
Route::post('/checkOutOrder', [OrderController::class, 'checkOutOrder']);
Route::post("/approve-order", [OrderController::class, 'approveOrder']);
Route::post('/reject-order/{id}', [OrderController::class, 'rejectOrder']);

//CashReg
Route::get("/get-cash", [CashRegController::class, 'getCash']);
Route::post("/add-cash", [CashRegController::class, 'addCash']);
Route::post("/save-to-admin", [CashRegController::class, 'remitToAdmin']);
Route::post("/get-cashlogs", [CashRegController::class, 'getCashLogs']);
Route::post("/get-admins", [CashRegController::class, 'getCashadmins']);

Route::get('/{vue?}', function(){
    return view('app');
})->where('vue', '[\/\w\.-]*');

