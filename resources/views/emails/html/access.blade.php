@extends('layouts.email')

@section('content')
<p>The coding style analysis of "{{ $commit }}" on "{{ $repo }}" couldn't be completed because we couldn't access the code.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
