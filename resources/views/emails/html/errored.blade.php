@extends('layouts.email')

@section('content')
<p>The coding style analysis of "{{ $commit }}" on "{{ $repo }}" couldn't be completed because of an internal error on our platform.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
