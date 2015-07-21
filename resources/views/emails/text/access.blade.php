@extends('layouts.text')

@section('content')
The coding style analysis of "{{ $commit }}" on the "{{ $branch }}" branch of "{{ $repo }}" couldn't be completed due to an error accessing the repo.
You can see the details at {{ $link }}.
@stop
