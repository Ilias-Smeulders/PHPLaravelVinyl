@extends('layouts.template')

@section('title', 'Contact info')
@section('css_after')
    <style>
        .close{
            display: none;
        }
    </style>
@endsection
@section('main')
    <h1>Contact us</h1>
    @include('shared.alert')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!session()->has('success'))
    <form action="/contact-us" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control {{ $errors->any() ? ($errors->first('name') ? 'is-invalid' : 'is-valid') : '' }}"
                   placeholder="Your name"
                   required
                   value="{{old('name')}}">
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                   class="form-control {{ $errors->any() ? ($errors->first('email') ? 'is-invalid' : 'is-valid') : '' }}"
                   placeholder="Your email"
                   required
                   value="{{old('email')}}">
            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
        </div>
        <div class="form-group">
            <label for="cc">Contact</label>
            <select name="cc" id="cc" class="form-control {{ $errors->any() ? ($errors->first('cc') ? 'is-invalid' : 'is-valid') : '' }}" required>
                <option disabled selected value="">Who do you want to contact?</option>
                <option value="info">Info</option>
                <option value="billing">Billing</option>
                <option value="support">Support</option>
            </select>
            <div class="invalid-feedback">{{ $errors->first('cc') }}</div>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="5"
                      class="form-control {{ $errors->any() ? ($errors->first('message') ? 'is-invalid' : 'is-valid') : '' }}"
                      placeholder="Your message"
                      required
                      minlength="10">{{old('message')}}</textarea>
            <div class="invalid-feedback">{{ $errors->first('message') }}</div>
        </div>
        <button type="submit" class="btn btn-success">Send Message</button>
    </form>
    @endif
@endsection

