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
}
