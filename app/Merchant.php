<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $primaryKey = "merchantId";
    protected $table = "merchants";
    protected $fillable =["merchantName","merchantSlug"];

    public function products(){
        return $this->hasMany('App\Product', 'merchantId', 'merchantId');
    }
}
