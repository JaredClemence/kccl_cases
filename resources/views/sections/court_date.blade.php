<!-- loads with date and collection -->
<div class='card'>
    <div class='card-header'>
<h2 class='court_date'>Calendar Date: {{$date}}</h2>
    </div>
    <div class='card-body'>
@foreach( $collection->getDataAsArray() as $courtName => $collection )
    @include('sections.court', compact('courtName','collection','date'))
@endforeach
    </div>
</div>