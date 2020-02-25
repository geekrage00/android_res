<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "products";
    protected $primaryKey = "productId";
    protected $fillable=[
    "productName",
    "productSlug",
    "productQty",
    "productImage",
    "categoryId",
    "merchantId",
    "productPrice",
    "productDesc"];

    public function category()
    {
        return $this->belongsTo('App\Category', 'categoryId', 'categoryId');
    }

    public function merchant()
    {
        return $this->belongsTo('App\Merchant', 'merchantId', 'merchantId');
    }

    public function scopeBySlug($query,$slug){
        return $query->where('ProductSlug',$slug);
    }

    public function scopeOrderedBy($query,$column = 'newest',$type='desc'){
        switch($column){
            case 'name':
                $column = 'ProductName';
            break;
            case 'newest':
                $column ='updated_at';
            break;
            case 'id':
            $column = 'productId';
            break;
            default:
            $column='updated_at';
        break;
        }
        return $query->orderBy($column,$type);
    }

}
