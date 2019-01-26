@extends('bootstrap')

@section('content')
<style>
    .court_date {
        //margin-top: 5rem;
    }
    .court {
        margin-bottom: 3rem;
    }
    body{
        background-color: #ABADBB;
    }
</style>
<div class='container'>
    <div class='row'>
        <div class='col'>
            <h1>Motions to Suppress</h1>
            @if( $results->hasFile )
            <p>The following data was scraped from the Kern County Criminal Court website on {{$results->getDate()->format('l, F n, Y')}}.</p>
            @foreach( $results->getCollectedData()->getDataAsArray() as $date => $collection )
                @include( 'sections.court_date', compact('date','collection'))
                <br/>
            @endforeach
            @else
            <p>The data file is either missing or corrupt. Please check back tomorrow and notify Jared Clemence.</p>
            @endif
        </div>
    </div>
</div>
@endsection