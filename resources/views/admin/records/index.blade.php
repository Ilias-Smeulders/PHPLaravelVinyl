@extends('layouts.template')
@section('title', 'Records (admin)')
@section('main')
<h1>Records</h1>

<ul>
    @foreach ($records as $record)
        <li>{{ $record }}</li>
        <!--Use !! $record !! if unescaped, raw output is needed-->
    @endforeach
</ul>
@endsection
