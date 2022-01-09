<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Orderline;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Show the complete order history
    public function index ()
    {
        $orders = Order::with(['orderlines:id,order_id,artist,title,cover,total_price,quantity', 'user:id,name,email'])
            ->select(['id','user_id','total_price','created_at'])
            ->orderByDesc('id')
            ->get();
        $result = compact('orders');
        //Json::dump($result);
        return view('admin.orders.index', $result);
    }
    // Orderlines with order and user
    public function orderlines()
    {
        $orderlines = Orderline::with(['order:id,user_id,total_price', 'order.user:id,name,email'])
            ->get();
        return $orderlines;
    }

// User with orders and orderlines
    public function users()
    {
        $users = User::with(['orders' => function ($query) {
            // select the required fields from the orders table
            $query->select(['id', 'user_id', 'total_price'])
                // go to the next table (orderlines)
                ->with(['orderlines' => function ($query) {
                    // select the required fields from the orderlines table and order by artist
                    $query->select(['id', 'order_id', 'artist', 'title'])
                        ->orderBy('artist');
                }]);
        }])
            ->get();
        return $users;
    }



}
