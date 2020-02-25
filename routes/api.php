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

// get all product
Route::get('/products','ProductController@getAllProducts')->name('products');

//get product by slug
Route::get('/product/{slug}','ProductController@getProductBySlug')->name('product.by.slug');

//get product by id
Route::get('/product-by-id/{id}','ProductController@getProductById')->name('product.by.id');

//post product
Route::post('/products','ProductController@saveProduct')->name('products.save');

//get all categories
Route::get('/categories','CategoriesController@getAllCategories');

//hapus product
Route::delete('/product/{id}/delete', 'ProductController@deleteProductById');
