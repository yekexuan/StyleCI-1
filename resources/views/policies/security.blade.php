@extends(Config::get('core.default'))

@section('title', 'Security Policy')

@section('content')
<h1>Security Policy</h1>

<hr>

<h2>Reporting A security Vulnerability</h2>

<p>If you have spotted a security vulnerability in StyleCI, please contact us directly at <a href="mailto:team@styleci.io">team@styleci.io</a>. We request that you do not publicly disclose a bug before it has been fixed for obvious reasons.</p>

<h2>Data Storage</h2>

<p>Our <a href="{{ route('privacy_policy') }}">Privacy Policy</a> details our storage of user information and user provided code.</p>

<h2>Questions</h2>

<p>Any questions about the Security Policy should be addressed to <a href="mailto:team@styleci.io">team@styleci.io</a>.</p>
@stop
