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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * Buyer
 */
Route::resource('buyer','Buyer\BuyerController',['only' => ['index','show']]);
Route::resource('buyer.transaction','Buyer\BuyerTransactionController',['only' => ['index']]);
Route::resource('buyer.product','Buyer\BuyerProductController',['only' => ['index']]);
Route::resource('buyer.seller','Buyer\BuyerSellerController',['only' => ['index']]);
Route::resource('buyer.category','Buyer\BuyerCategoryController',['only' => ['index']]);

/*
 * User
 */
Route::resource('user','User\UserController',['except' => ['create','edit']]);
Route::name('verify')->get('users/verify/{token}','User/UserController@verify');
Route::name('resend')->get('users/{user}','User/UserController@resend');
/*
 * Category
 */
Route::resource('category','Category\CategoryController',['except' => ['create','edit']]);
Route::resource('category.product','Category\CategoryProductController',['only' => ['index']]);
Route::resource('category.seller','Category\CategorySellerController',['only' => ['index']]);
Route::resource('category.transaction','Category\CategoryTransactionController',['only' => ['index']]);
Route::resource('category.buyer','Category\CategoryBuyerController',['only' => ['index']]);
/*
 * Product
 */
Route::resource('product','Product\ProductController',['only' => ['index','show']]);
Route::resource('product.transactions','Product\ProductTransactionController',['only' => ['index','show']]);
Route::resource('product.buyer','Product\ProductBuyerController',['only' => ['index','show']]);
Route::resource('product.buyer.transactions','Product\ProductBuyerTransactionController',['only' => ['store']]);
/*
 * Transaction
 */
Route::resource('transaction','Transaction\TransactionController',['only' => ['index','show']]);
Route::resource('transaction.category','Transaction\TransactionCategoryController',['only' => ['index']]);
Route::resource('transaction.seller','Transaction\TransactionSellerController',['only' => ['index']]);
Route::resource('transaction.seller','Transaction\TransactionSellerController',['only' => ['index','update','destroy']]);
/*
 * Seller
 */
Route::resource('seller','Seller\SellerController',['only' => ['index','show']]);
Route::resource('seller.transaction','Seller\SellerTransactionController',['only' => ['index']]);
Route::resource('seller.category','Seller\SellerCategoryController',['only' => ['index']]);
Route::resource('seller.buyer','Seller\SellerBuyerController',['only' => ['index']]);
Route::resource('seller.product','Seller\SellerProductController',['except' => ['edit','show','create']]);
