@extends('bootstrap')
@section('header')
<link href="https://fonts.googleapis.com/css?family=Meddon" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cinzel|Meddon" rel="stylesheet">
<link href="{{asset('css/valentines.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class='container'>
    <div class='row text-center'><div class='col'><h1>Valentine's Day Scavenger Hunt 2019</h1></div></div>
    <div class='row text-center'>
        <div class='col-12'>
            <br/>
            <img src='{{asset('image/qrcode.png')}}' class='img-fluid' />
        </div>
        <div class='col-4 offset-4'>
            Use a QR scanner to load the next page onto your phone. You may have to take it with you.
        </div>
    </div>
</div>
@endsection