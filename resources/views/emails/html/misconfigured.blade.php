@extends('layouts.email')

@section('content')
<p>The coding style analysis of <b>{{ $commit }}</b> on the <b>{{ $branch }}</b> branch on <b>{{ $repo }}</b> couldn't be completed because the repo appears to be misconfigured.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
