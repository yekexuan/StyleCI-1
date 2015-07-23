@extends('layouts.email')

@section('content')
<p>We have received a request to delete your account from <a href="{{ route('home') }}">StyleCI</a>. All existing analysis data has been removed from our systems.</p>
<p>This request has been fulfilled, your account has been removed from our service. If this was not you then please <a href="mailto:support@alt-three.com?subject=StyleCI Support">contact us</a> immediately.</p>
<p>If this was all a mistake, don't fear! You can log back into StyleCI via GitHub and re-enable your repos.</p>
<p>If you have any questions at all, feel free to reach out to us by emailing <a href="mailto:support@alt-three.com?subject=StyleCI Support">support@alt-three.com</a>, or by creating an <a href="https://github.com/StyleCI/StyleCI/issues/new">issue</a> on GitHub.</p>
@stop
