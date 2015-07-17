@extends('layouts.text')

@section('content')
The coding style analysis of "{{ $commit }}" on the "{{ $branch }}" branch of "{{ $repo }}" couldn't be completed because it timed out.
You can see the details at {{ $link }}.
@stop
