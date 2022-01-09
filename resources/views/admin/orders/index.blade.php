@extends('layouts.template')

@section('title', 'Overview orders')

@section('main')
    <h1>Overview orders</h1>
    @foreach($orders as $order)
        <div class="card mb-3 shadow">
            <div class="card-header">
                <p class="float-right"><i class="fas fa-shopping-cart"></i> {{$order->id}}</p>
                <p><i class="fas fa-user"></i> <a href="$order->user->email">{{$order->user->name}}</a>
                    <span class="text-muted ml-5"><i class="fas fa-clock"></i> {{$order->created_at->format('M d Y')}}</span>
                </p>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="width-50">Qty</th>
                        <th class="width-100">Price</th>
                        <th class="width-100"></th>
                        <th>Record</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderlines as $orderline)
                        <tr>
                            <td>{{$orderline->quantity}}</td>
                            <td>€ {{$orderline->total_price}}</td>
                            <td><img class="img img-thumbnail" src="{{$orderline->cover}}" alt="{{$orderline->title}}">
                            </td>
                            <td>{{$orderline->artist}} - {{$orderline->title}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                Total price: <b>€ {{$order->total_price}}</b>
            </div>
        </div>
    @endforeach
@endsection
