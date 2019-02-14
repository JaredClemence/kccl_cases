@extends('valentines.qrcode')
@section('content')
<div class='container'>
    <div class='row text-center'><div class='col'><h1>Valentine's Day Scavenger Hunt 2019</h1></div></div>
    <div class='row text-center'>
        <div class='col-8 offset-2'>
            <h2>Refresh this page as needed.</h2>
        </div>
    </div>
    <div class='row'>
        <div class='col-8 offset-2'>
            <h2>Activity 1</h2>
            <p>
            The clues are set. The pieces are in place. Check your phone periodically for a new clue until you find your gift.
            </p>
            <p>
                The next clue will appear at <strong>5:00pm</strong>. Until then, find and watch the following two episodes of <em>The Office</em>:
            <ol>
                <li>Season 7, Episode 7</li>
                <li>Season 2, Episode 10</li>
            </ol>
            </p>
            <img src='{{asset('image/midnight.jpg')}}' class='img-fluid' />
        </div>
    </div>
    <footer></footer>
</div>
@endsection