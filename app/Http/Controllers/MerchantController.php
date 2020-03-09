<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\ResponseController;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MerchantController extends ResponseController
{
    public function getAllProductOwnedByMerchant(Request $r){
        $orderBy = $r->orderBy? $r->orderBy : 'newest'; //default 'updated_at'
        $orderType = $r->orderType ? $r->orderType : 'desc'; //default 'desc'
        $user = Auth::user();
        if($user->is_merchant){
            $products = Product::where('merchantId',$user->merchant->merchantId)->with('merchant')->with('category')->orderedBy($orderBy,$orderType)->get();
            $response =[
                'data'=>$products
            ];
            return $this->sendResponse($response);
        }
        elseif(!$user->is_merchant){
            $error = "You are not a merchant. Become a merchant first !";
            return $this->sendError($user);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }
    }

    public function saveProduct(Request $r){
        $user = Auth::user();
        if($user->is_merchant){
            $validator = Validator::make($r->all(), [
                'productName' => 'required|string',
                'productQty' => 'required|integer|min:1',
                'productPrice' =>'bail|required',
                'categoryId' =>'bail|required'
            ]);
            $response = [
                "code"=>400,
                "message"=>$validator->messages()
            ];

            if ($validator->fails()) {
                return response()->json($response,202);
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
                    "merchantId"=>$user->merchant->merchantId
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
                    "merchantId"=>$user->merchant->merchantId
                ];
                $response = [
                    "data"=>$data
                ];
            }
            //if($r->productImage)


            $product = Product::create($data);
            $response = [
                "code"=>200,
                "message"=>"Success add product",
                "data"=>$product
            ];

            return $this->sendResponse($response);
        }
        elseif(!$user->is_merchant){
            $error = "You are not a merchant. Become a merchant first !";
            return $this->sendError($user);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }

    }
    public function updateProduct(Request $r, $id){
        $user = Auth::user();
        if($user->is_merchant){
            $product = Product::find($id);
            $oldImage = $product->productImage;

            $validator = Validator::make($r->all(), [
                'productName' => 'bail|required|string',
                'productQty' => 'bail|required',
                'productPrice' =>'bail|required',
                'categoryId' =>'bail|required'
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
                    "merchantId"=>$user->merchant->merchantId
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
                    "merchantId"=>$user->merchant->merchantId
                ];
                $response = [
                    "data"=>$data
                ];
            }
            //if($r->productImage)


            $product->update($data);

            return $this->sendResponse($response);
        }
        elseif(!$user->is_merchant){
            $error = "You are not a merchant. Become a merchant first !";
            return $this->sendError($user);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }
    }
    public function deleteProductById($id){
        $user = Auth::user();
        if($user->is_merchant){
            $product = Product::findOrFail($id)->where("merchantId",$user->merchant->merchantId);
            $product->delete();
            $response = [
                "code"=>200,
                "message"=>"Success Delete Product",
                "data"=>$product
            ];
            return $this->sendResponse($response);
        }
        elseif(!$user->is_merchant){
            $error = "You are not a merchant. Become a merchant first !";
            return $this->sendError($user);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }

    }
    public function generateRandomString($length = 5) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
