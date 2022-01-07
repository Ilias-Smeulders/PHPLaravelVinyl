@extends('layouts.template')

@section('title', 'Itunes')

@section('main')
    <h1>iTunes {{$tracks->title. "-" . strtoupper($tracks->country)}}</h1>
    <p>Last updated: {{substr($tracks->updated, 5, 10)}}</p>
    <div class="row">
        @foreach($tracks->results as $res)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card cardShopMaster" data-id="{{ $res->artistUrl }}">
                    <img class="card-img-top" src="/assets/vinyl.png" data-src="{{ $res->artworkUrl100 }}" alt="Hello">
                    <div class="card-body">
                        <h5 class="card-title">{{ $res->artistName }}</h5>
                        <p class="card-text">{{ $res->name }}</p>
                        <hr>
                        <div>
                            <p>Genre: {{$res->genres[0]->name}}</p>
                            <p>Artist: <a href="{{$res->artistUrl}}">{{$res->artistName}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('script_after')
    <script>
        $(function () {
            const card = $('.card');
            // Get record id and redirect to the detail page
            card.click(function () {
                const url = $(this).data('id');
                $(location).attr('href', url); //OR $(location).attr('href', '/shop/' + record_id);
            });
            // Replace vinyl.png with real cover
            $('.card img').each(function () {
                $(this).attr('src', $(this).data('src'));
            });
            // Add shadow to card on hover
            card.hover(function () {
                $(this).addClass('shadow');
            }, function () {
                $(this).removeClass('shadow');
            });
        })
    </script>
@endsection
