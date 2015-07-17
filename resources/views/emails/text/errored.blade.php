@extends('layouts.text')

@section('content')
The coding style analysis of "{{ $commit }}" on the "{{ $branch }}" branch of "{{ $repo }}" couldn't be completed because of an internal error on our platform.
You can see the details at {{ $link }}.
@stop
