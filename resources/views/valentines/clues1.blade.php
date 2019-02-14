@extends('valentines.qrcode')
@section('content')
<div class='container'>
    <div class='row text-center'><div class='col'>
        
Song: <em>Magnolia</em> by Eric Clapton<br/>
<audio controls autoplay preload='auto'>
    <source src='{{asset('music/magnolia.mp3')}}' type='audio/mpeg' autoplay="autoplay"></source>
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
                The next clue will appear at <strong>5:30pm</strong>. The last activity occurs at 6:00pm. Make sure you reload this page after 6:00pm, even if you solve your puzzles before then! <em>Heck!</em> you may even want to reload the page at 5:30pm and 6:00pm just to hear the songs I picked for you.
            </p>
            <img src='{{asset('image/teapot.jpg')}}' class='img-fluid' />
        </div>
    </div>
    <footer></footer>
</div>
@endsection