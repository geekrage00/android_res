<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $primaryKey = "merchantId";
    protected $table = "merchants";
    protected $fillable =["merchantName","merchantSlug","user_id"];

    public function products(){
        return $this->hasMany('App\Product', 'merchantId', 'merchantId');
    }

    public function user(){
        return $this->belongsTo('App\User','id','user_id');
    }
}
