<!-- loads with date, courtName and collection -->

<h3 class='court'>{{$courtName}}</h3>
<p>The court has {{$collection->count()}} suppression motion hearings on {{$date}}.</p>
<table class='table'>
    <tr><th>Case Number</th><th>Time</th><th>Devision</th><th>Defendant</th><th>Type</th></tr>
    @foreach( $collection as $case )
        @include('sections.case', compact('case'))
    @endforeach
</table>