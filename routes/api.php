<?php

use App\Http\Controllers\AuthController;
use App\project\Category\Controllers\CategController;
use App\project\Factories\Controllers\FactoryController;
use App\project\orders\controllers\OrderController;
use App\project\Product\Controllers\ProductController;
use App\project\SubCateg\Controllers\SubCategController;
use App\project\SubSubCateg\Controllers\SubSubCategController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*----------------------------------------------------------------------------------------------------------------*/
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('logout',[AuthController::class,'logout'])->middleware('VerifyJwt');

/*----------------------------------------------------------------------------------------------------------------*/
Route::middleware(['lang'])->controller(CategController::class)->group(function () {
    Route::get('showall/categ','showall');
    Route::get('show/categ/{id}', 'show');
    Route::delete('destroy/categ/{id}', 'destroy');
    Route::post('store/categ', 'store');
    Route::post('update/categ/{id}', 'update');
    Route::get('getrelated/categ/{id}','getrealted');

});
/*----------------------------------------------------------------------------------------------------------------*/
Route::middleware(['lang'])->controller(SubCategController::class)->group(function () {
    Route::get('showall/subcateg','showall');
    Route::get('show/subcateg/{id}', 'show');
    Route::delete('destroy/subcateg/{id}', 'destroy');
    Route::post('store/subcateg', 'store');
    Route::post('update/subcateg/{id}', 'update');
    Route::get('getrelatedSub/products/{id}','getrelated');

});
/*----------------------------------------------------------------------------------------------------------------*/
Route::middleware(['lang'])->controller(SubSubCategController::class)->group(function () {
    Route::get('showall/subsubcateg','showall');
    Route::get('show/subsubcateg/{id}', 'show');
    Route::delete('destroy/subsubcateg/{id}', 'destroy');
    Route::post('store/subsubcateg', 'store');
    Route::post('update/subsubcateg/{id}', 'update');
    Route::get('getrelatedSubSub/products/{id}','getrelated');

});
/*----------------------------------------------------------------------------------------------------------------*/
Route::middleware(['lang'])->controller(ProductController::class)->group(function () {
    Route::get('showall/products','showall');
    Route::get('show/products/{id}', 'show');
    Route::get('destroy/product/{id}', 'destroy');
    Route::post('store/product', 'store');
    Route::post('update/product/{id}', 'update');
});
/*----------------------------------------------------------------------------------------------------------------*/
Route::middleware(['lang'])->controller(FactoryController::class)->group(function () {
    Route::get('showall/factories','showall');
    Route::get('showallRelated/factories','showallRelated');
    Route::get('show/factories/{id}', 'show');
    Route::get('showRelated/factories/{id}', 'showRelated');
    Route::delete('destroy/factories/{id}', 'destroy');
    Route::post('store/factories', 'store');

});
/*----------------------------------------------------------------------------------------------------------------*/
Route::middleware(['lang'])->controller(OrderController::class)->group(function(){
    Route::get('getOrders','GetOrders');
    Route::post('submitOrder','SubmitOrder');
});
/*----------------------------------------------------------------------------------------------------------------*/
Route::post('submitOrder',[OrderController::class,'SubmitOrder']);
Route::get('getOrders',[OrderController::class,'GetOrders']);
Route::delete('deleteOrder/{id}',[OrderController::class,'DeleteOrder']);


//Route::post('send',[\App\Http\Controllers\SMSauth::class,'index']);

