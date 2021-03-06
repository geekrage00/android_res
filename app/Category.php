<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = "categories";
    protected $primaryKey = "categoryId";
    protected $fillable = ["categoryName"];

    public function products()
    {
        return $this->hasMany('App\Product', 'categoryId', 'categoryId');
    }
}
