<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/tes", function () {
    return App\Product::all();
});

Route::get('/products','ProductController@getAllProducts')->name('products');
Route::post('/products','ProductController@saveProduct')->name('products.save');


Route::get('/categories','CategoriesController@getAllCategories');
