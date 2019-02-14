@extends('valentines.qrcode')
@section('content')
<div class='container'>
    <div class='row text-center'><div class='col'>
        
Song: <em>Be The One</em> by Dua Lipa<br/>
<audio controls autoplay preload='auto'>
    <source src='{{asset('music/be_the_one.mp3')}}' type='audio/mpeg' autoplay="autoplay"></source>
</audio>
        </div></div>
    <div class='row text-center'><div class='col'><h1>Valentine's Day Scavenger Hunt 2019</h1></div></div>
    <div class='row text-center'>
        <div class='col-8 offset-2'>
            <h2>Refresh this page as needed.</h2>
            <p>
            <em>The clues remain visible after each time limit passes, just in case you don't get to them in time to see them. They change color to indicate that they are no longer current.</em>
            </p>
            <p>Each time-point has a different song selection. You can start songs at the top of the page.</p>
        </div>
    </div>
    <div class='row'>
        <div class='col-8 offset-2 completed'>
            <h2>Activity 1</h2>
            <img src='{{asset('image/midnight.jpg')}}' class='float-right midnight1' />
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
        </div>
    </div>
    <div class='row'>
        <div class='col-8 offset-2'>
            <h2>Activity 2</h2>
            <p>
                If you had time to watch the episodes. Then the mood has been set. I chose <em>Threat Level Midnight</em>, because it shows the stupid things a man will do to be near or to impress the woman he loves.
            </p>
            <p>
                The second episode, perhaps you figured out, is your next clue. Find the teapot.
            </p>
            <p>
                The next clue will appear at <strong>5:30pm</strong>. You will only need this clue if you fail to find the teapot before then.
            </p>
            <img src='{{asset('image/teapot.jpg')}}' class='img-fluid' />
        </div>
    </div>
    <footer></footer>
</div>
@endsection