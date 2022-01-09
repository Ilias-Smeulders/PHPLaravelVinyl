<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Record;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function index()
    {
        // Take the first 3 records, ordered by album title
        $records = Record::orderBy('title')->take(3)->get();
        $result = compact('records');
        //Json::dump($result);
        return view('basket', $result);
    }

    public function addToCart($id)
    {
        $record = Record::findOrFail($id);
        $record->cover = $record->cover ?? "https://coverartarchive.org/release/{$record->title_mbid}/front-250.jpg";
        (new \App\Helpers\Cart)->add($record);
        session()->flash('success', "The record <b>$record->title</b> from <b>$record->artist</b> has been added to your basket");
        return back();
    }

    public function deleteFromCart($id)
    {
        $record = Record::findOrFail($id);
        (new \App\Helpers\Cart)->delete($record);
        return back();
    }

    public function emptyCart()
    {
        (new \App\Helpers\Cart)->empty();
        return redirect('basket');
    }
    public function removeRecordFromCart($id){
        $record = Record::findOrFail($id);
        (new \App\Helpers\Cart)->removeRecord($record);
        return redirect('basket');
    }
}
