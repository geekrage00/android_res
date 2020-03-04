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
Route::group([ 'prefix' => 'auth'], function (){
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'api\AuthController@login');
        Route::post('refresh', 'api\AuthController@refresh');
        Route::post('signup', 'api\AuthController@signup');
    });
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'api\AuthController@logout');
        Route::get('verify', 'api\AuthController@verifyToken');
        Route::get('getuser', 'api\AuthController@getUser')->middleware(['scopes:do-anything']);
    });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
    dd("tes");
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

//put product
Route::put('/product/{id}/update', 'ProductController@updateProduct')->name('products.update');

//get all categories
Route::get('/categories','CategoriesController@getAllCategories');

//hapus product
Route::delete('/product/{id}/delete', 'ProductController@deleteProductById');
