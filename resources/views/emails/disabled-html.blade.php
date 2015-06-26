@extends('layouts.email')

@section('content')
<p>The repo "{{ $repo }}" has been disabled and removed from our platform.</p>
<p>If this was all a mistake, don't fear! You can log back into StyleCI via GitHub and re-enable your repositories.</p>
@stop
