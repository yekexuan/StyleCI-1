@extends('layouts.email')

@section('content')
<p>The coding style analysis of "{{ $commit }}" on the "{{ $branch }}" branch of "{{ $repo }}" revealed problems.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
