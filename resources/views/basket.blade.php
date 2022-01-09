@extends('layouts.template')

@section('title', 'Your Basket')

@section('main')
    <h1>Basket</h1>
    @if( Cart::getTotalQty() == 0)
        <div class="alert alert-primary">
            Your basket is empty.
        </div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="width-50">Qty</th>
                    <th class="width-80">Price</th>
                    <th class="width-80"></th>
                    <th>Record</th>
                    <th class="width-120"></th>
                </tr>
                </thead>
                <tbody>
                @foreach(Cart::getRecords() as $record)
                    <tr>
                        <td>{{ $record['qty'] }}</td>
                        <td>€&nbsp;{{ $record['price'] }}</td>
                        <td>
                            <img class="img-thumbnail cover" src="/assets/vinyl.png"
                                 data-src="{{ $record['cover'] }}"
                                 alt="{{ $record['title'] }}">
                        </td>
                        <td>
                            {{ $record['artist'] . ' - ' . $record['title']  }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/basket/delete/{{ $record['id'] }}" class="btn btn-outline-secondary">-1</a>
                                <a href="/basket/add/{{ $record['id'] }}" class="btn btn-outline-secondary">+1</a>
                                <a href="/basket/remove/{{ $record['id'] }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <p><a href="/basket/empty" class="btn btn-sm btn-outline-danger">Empty your basket</a></p>
                    </td>
                    <td>
                        <p><b>Total</b>: €&nbsp;{{ Cart::getTotalPrice() }}</p>
                        @auth()
                            <p><a href="/user/checkout" class="btn btn-sm btn-outline-success">Checkout</a></p>
                        @endauth
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    @endif
    @guest()
        <div class="alert alert-primary">
            You must be <a href="/login"><b>logged in</b></a> to checkout
        </div>
    @endguest
@endsection
@section('script_after')
    <script>
        $(function () {
            $('.cover').each(function () {
                $(this).attr('src', $(this).data('src'));
            });
            $('tbody tr:not(:last-child) td').addClass('align-middle');
        });
    </script>
@endsection
