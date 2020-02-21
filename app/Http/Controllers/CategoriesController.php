<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    public function getAllCategories(){
        $categories = Category::all();
        $response = [
            "data"=>$categories
        ];
        return response()->json($response,200);
    }
}
