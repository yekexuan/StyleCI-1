@extends('layouts.text')

@section('content')
The coding style analysis of "{{ $commit }}" on "{{ $repo }}" revealed problems.
You can see the details at {{ $link }}.
@stop
