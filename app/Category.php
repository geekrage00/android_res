<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = "categories";
    protected $primary_key = "categoryId";
    protected $fillable = ["categoryName"];

    public function products()
    {
        return $this->hasMany('App\Product', 'categoryId', 'categoryId');
    }
}
