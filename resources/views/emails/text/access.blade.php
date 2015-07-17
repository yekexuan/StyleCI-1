@extends('layouts.text')

@section('content')
The coding style analysis of "{{ $commit }}" on the "{{ $branch }}" branch of "{{ $repo }}" couldn't be completed because we couldn't access the code.
You can see the details at {{ $link }}.
@stop
