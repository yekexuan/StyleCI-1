@extends(Config::get('core.text'))

@section('content')
The coding style analysis of your commit "{{ $commit }}" on repo "{{ $repo }}" revealed problems.
You can see the details at {{ $link }}.
@stop
