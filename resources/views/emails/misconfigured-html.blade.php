@extends(Config::get('core.email'))

@section('content')
<p>The coding style analysis of the commit "{{ $commit }}" on "{{ $repo }}" couldn't be completed because the repo appears to be misconfigured.</p>
<p>Click <a href="{{ $link }}">here</a> to see the details.</p>
@stop
