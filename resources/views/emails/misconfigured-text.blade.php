@extends('layouts.text')

@section('content')
The coding style analysis of "{{ $commit }}" on "{{ $repo }}" couldn't be completed because the repo appears to be misconfigured.
You can see the details at {{ $link }}.
@stop
