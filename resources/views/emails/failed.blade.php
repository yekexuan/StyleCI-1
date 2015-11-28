@extends('layouts.email')

@section('content')
<p>The coding style analysis of <b>{{ $commit }}</b> on the <b>{{ $branch }}</b> branch of <b>{{ $repo }}</b> revealed problems.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
