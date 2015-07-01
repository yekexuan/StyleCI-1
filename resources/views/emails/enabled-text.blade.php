@extends('layouts.text')

@section('content')
The repo "{{ $repo }}" has been enabled on our platform.
You can view the analyses at {{ $link }}.
@stop
