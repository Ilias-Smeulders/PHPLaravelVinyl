<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orders()
    {
        return $this->hasMany('App\Order');   // a users has many orders
    }
    public function user()
    {
        return $this->belongsTo('App\User')->withDefault();   // an order belongs to a users
    }
}
