@extends('layouts.text')

@section('content')
The coding style analysis of "{{ $commit }}" on the "{{ $branch }}" branch of "{{ $repo }}" has passed after previous analyses on this branch were failing.
You can see the details at {{ $link }}.
@stop
