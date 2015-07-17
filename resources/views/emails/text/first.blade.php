@extends('layouts.text')

@section('content')
The first coding style analysis of the "{{ $branch }}" branch on "{{ $repo }}" has passed.
You can see the details at {{ $link }}.
@stop
