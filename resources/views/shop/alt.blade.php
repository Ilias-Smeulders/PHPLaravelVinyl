@extends('layouts.template')

@section('title', 'Shop')

@section('main')
    <h1>Shop - alternative listing</h1>
    @foreach($genres as $genre)
        <h3>{{ $genre->name }}</h3>
    <ul>
        @foreach($records as $record)
            @if($record->genre_id == $genre->id)
                <li><a href="shop/{{ $record->id }}">{{ $record->artist }} - {{ $record->title }}</a> | Price: {{number_format($record->price,2)}} | Stock: {{$record->stock}}</li>
            @endif
        @endforeach
    </ul>
    @endforeach
@endsection
