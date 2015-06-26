@extends('layouts.email')

@section('content')
<p>The repo "{{ $repo }}" has been enabled on our platform.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
