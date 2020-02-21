<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
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
        $image = $r->productImage? $r->productImage : null;
        if($image == null){
            $data = [
                "productName"=>$r->productName,
                "productSlug"=>Str::slug($r->productName),
                "productQty"=>$r->productQty,
                "productImage"=>null,
                "categoryId"=>$r->categoryId,
                "merchantId"=>$r->merchantId
            ];
            $response = [
                "image"=> $image
            ];

        }
        else{
            $image = $r->productImage;  // your base64 encodedph
            preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
            $image = str_replace(' ', '+', $image);
            $imageName = 'image_' . time() . '.' . 'png'; //generating unique file name;
            Storage::disk('public')->put('images/products/'.$imageName,base64_decode($image));
            $response = [
                "image"=>$imageName
            ];
            $data = [
                "productName"=>$r->productName,
                "productSlug"=>Str::slug($r->productName),
                "productQty"=>$r->productQty,
                "productImage"=>'/images/products/'.$imageName,
                "categoryId"=>$r->categoryId,
                "merchantId"=>$r->merchantId
            ];
        }
        //if($r->productImage)


        Product::create($data);

        return response()->json($response,200);
    }
}
