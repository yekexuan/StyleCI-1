@extends('layouts.email')

@section('content')
<p>The first coding style analysis of the <b>{{ $branch }}</b> branch on <b>{{ $repo }}</b> has passed.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
