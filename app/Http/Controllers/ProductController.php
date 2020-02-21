<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
class ProductController extends Controller
{
    //

    public function getAllProducts(Request $r){
        $orderBy = $r->orderBy? $r->orderBy : 'newest'; //default 'updated_at'
        $orderType = $r->orderType ? $r->orderType : 'desc'; //default 'desc'
        $prodcuts = Product::with('merchant')->with('category')->orderedBy($orderBy,$orderType)->get();
        $response = [
            "data"=>$prodcuts
        ];
        return response()->json($response,200);
    }

    public function saveProduct(Request $r){
        //return $r->json()->all();
        //return $r->all();
        //Product::create($r->json()->all());

        $data = [
            "productName",
            "productSlug",
            "productQty",
            "productImage",
            "categoryId",
            "merchantId"
        ];

        return $data;
    }
}
