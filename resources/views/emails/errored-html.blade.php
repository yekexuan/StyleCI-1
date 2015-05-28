@extends('layouts.email')

@section('content')
<p>The coding style analysis of the commit "{{ $commit }}" on "{{ $repo }}" couldn't be completed because of an internal error on our platform.</p>
<p>It's possible this could have been caused by the commit being deleted from GitHub before we analysed it, such as with pull requests being merged and deleted.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
