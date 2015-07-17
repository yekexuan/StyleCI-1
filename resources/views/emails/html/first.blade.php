@extends('layouts.email')

@section('content')
<p>The first coding style analysis of the "{{ $branch }}" branch on "{{ $repo }}" has passed.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
