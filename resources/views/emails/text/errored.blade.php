@extends('layouts.text')

@section('content')
The coding style analysis of "{{ $commit }}" on "{{ $repo }}" couldn't be completed because of an internal error on our platform.
It's possible this could have been caused by the commit being deleted from GitHub before we analysed it, such as with pull requests being merged and deleted.
You can see the details at {{ $link }}.
@stop
