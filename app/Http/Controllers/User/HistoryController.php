<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Order;
use App\Orderline;
use App\User;
use Auth;
use Cart;
use Illuminate\Http\Request;
use Mail;

class HistoryController extends Controller
{
    // Show the full order history
    public function index ()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderlines')
            ->orderBy('created_at', 'desc')
            ->get();
        $result = compact('orders');
        //Json::dump($result);
        return view('/user/history', $result);
    }

    // Add data from cart to the database
    public function checkout()
    {
        // Create a new order and save it to the orders table
        $order = new Order();
        $order->user_id = auth()->id();
        $order->total_price = Cart::getTotalPrice();
        $order->save();
        // Retrieve the id of the last inserted order
        $order_id = $order->id;
        // Loop over the records array in the cart and save them to the orderlines table
        foreach (Cart::getRecords() as $record) {
            $orderline = new Orderline();
            $orderline->order_id = $order_id;
            $orderline->artist = $record['artist'];
            $orderline->title = $record['title'];
            $orderline->cover = $record['cover'];
            $orderline->total_price = $record['price'];
            $orderline->quantity = $record['qty'];
            $orderline->save();
        }
        // Empty the cart
        Cart::empty();
        // Redirect to the history page
        $message = 'Thank you for your order.<br>The records will be delivered as soon as possible.';
        // Send email confirmation
        $this->confirmEmail();
        // Send WhatsApp confirmation
        $this->confirmWhatsApp();
        session()->flash('success', $message);
        return redirect('/user/history');
    }
    private function confirmEmail()
    {
        // construct the mail message
        $message = '<p>Thank you for your order.<br>The records will be delivered as soon as possible.</p>';
        $message .= '<ul>';
        foreach (Cart::getRecords() as $record) {
            $message .= "<li>{$record['qty']} x {$record['artist']} - {$record['title']}</li>";
        }
        $message .= '</ul>';

        // Get all admins
        $admins = User::where('admin', true)->select('name', 'email')->get();

        $email = new OrderMail($message);
        Mail::to(Auth::user())
            ->cc($admins)
            ->send($email);
    }

    private function confirmWhatsApp()
    {
        /*// get credentials from the .env file
        $id = env('TWILIO_AUTH_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $to = env('TWILIO_WHATSAPP_TO');
        $from = env('TWILIO_WHATSAPP_FROM');

        // the message for the fourth placeholder of the WhatsApp order template
        $details = "*" . Auth::user()->name . "* has ordered:";
        foreach (Cart::getRecords() as $record) {
            $details .= " {$record['qty']} x {$record['artist']} - {$record['title']},";
        }

        // construct the order template for the sandbox:
        // Your {{1}} order of {{2}} has shipped and should be delivered on {{3}}. Details: {{4}}
        $message = "Your *Vinyl Shop* order of *today* has shipped and should be delivered on *your address*. Details: $details";

        // send WhatsApp message to your phone
        $whatsApp = new Client($sid, $token);
        $whatsApp->messages->create(
            "whatsapp:$to", [
                'from' => "whatsapp:$from",
                'body' => $message
            ]
        );*/
    }
}
