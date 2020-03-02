<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
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
        $validator = Validator::make($r->all(), [
            'productName' => 'bail|required|string',
            'productQty' => 'bail|required',
            'productPrice' =>'bail|required',
            'categoryId' =>'bail|required',
            'merchantId' =>'bail|required',
           ]);
        $response = [
            "code"=>400,
            "message"=>$validator->messages()
        ];

        if ($validator->fails()) {
            return response()->json($response,400);
       }
        //return $r->json()->all();
        //return $r->all();
        //Product::create($r->json()->all());
        $image = $r->productImage? $r->productImage : null;
        if($image == null){
            $data = [
                "productName"=>$r->productName,
                "productSlug"=>Str::slug($r->productName)."-".self::generateRandomString(),
                "productQty"=>$r->productQty,
                "productImage"=>null,
                "productPrice"=>$r->productPrice,
                "productDesc"=>$r->productDesc,
                "categoryId"=>$r->categoryId,
                "merchantId"=>$r->merchantId
            ];
            $response = [
                "data"=> $data
            ];

        }
        else{
            $image = $r->productImage;  // your base64 encodedph
            preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
            $image = str_replace(' ', '+', $image);
            $imageName = 'image_' . time() . '.' . 'png'; //generating unique file name;
            Storage::disk('public')->put('images/products/'.$imageName,base64_decode($image));

            $data = [
                "productName"=>$r->productName,
                "productSlug"=>Str::slug($r->productName)."-".self::generateRandomString(),
                "productQty"=>$r->productQty,
                "productImage"=>'/images/products/'.$imageName,
                "productPrice"=>$r->productPrice,
                "productDesc"=>$r->productDesc,
                "categoryId"=>$r->categoryId,
                "merchantId"=>$r->merchantId
            ];
            $response = [
                "data"=>$data
            ];
        }
        //if($r->productImage)


        Product::create($data);
        $response = [
            "code"=>200,
            "message"=>"Success add product",
            "data"=>$r->all()
        ];

        return response()->json($response,200);
    }




    public function updateProduct(Request $r, $id){


        $product = Product::find($id);
        $oldImage = $product->productImage;

        $validator = Validator::make($r->all(), [
            'productName' => 'bail|required|string',
            'productQty' => 'bail|required',
            'productPrice' =>'bail|required',
            'categoryId' =>'bail|required',
            'merchantId' =>'bail|required',
           ]);
        if ($validator->fails()) {
            return response()->json($validator->messages());
       }

        $image = $r->productImage? $r->productImage : null;
        if($image == null){
            $data = [
                "productName"=>$r->productName,
                "productSlug"=>Str::slug($r->productName)."-".self::generateRandomString(),
                "productQty"=>$r->productQty,
                "productImage"=>$oldImage,
                "productPrice"=>$r->productPrice,
                "productDesc"=>$r->productDesc,
                "categoryId"=>$r->categoryId,
                "merchantId"=>$r->merchantId
            ];
            $response = [
                "data"=> $data
            ];

        }
        else{
            $image = $r->productImage;  // your base64 encodedph
            preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
            $image = str_replace(' ', '+', $image);
            $imageName = 'image_' . time() . '.' . 'png'; //generating unique file name;
            Storage::disk('public')->put('images/products/'.$imageName,base64_decode($image));

            $data = [
                "productName"=>$r->productName,
                "productSlug"=>Str::slug($r->productName)."-".self::generateRandomString(),
                "productQty"=>$r->productQty,
                "productImage"=>'/images/products/'.$imageName,
                "productPrice"=>$r->productPrice,
                "productDesc"=>$r->productDesc,
                "categoryId"=>$r->categoryId,
                "merchantId"=>$r->merchantId
            ];
            $response = [
                "data"=>$data
            ];
        }
        //if($r->productImage)


        $product->update($data);

        return response()->json($response,200);
    }

    public function getProductBySlug($slug){
        $product = Product::bySlug($slug)->with('merchant')->with('category')->firstOrFail();
        $response = [
            "data"=>$product
        ];
        return response()->json($response,200);
    }

    public function getProductById($id){
        $product = Product::with('merchant')->with('category')->findOrFail($id);
        $response = [
            "data"=>$product
        ];
        return response()->json($response,200);
    }

    public function deleteProductById($id){
        $product = Product::findOrFail($id);
        $product->delete();
        $response = [
            "data"=>$product
        ];
        return response()->json($response,200);
    }

    public function generateRandomString($length = 5) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
