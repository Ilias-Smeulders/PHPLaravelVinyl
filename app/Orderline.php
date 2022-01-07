<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderline extends Model
{
    public function orderlines()
    {
        return $this->hasMany('App\Orderline');   // an order has many orderlines
    }
    public function order()
    {
        return $this->belongsTo('App\Order')->withDefault();   // an orderline belongs to an order
    }
}
