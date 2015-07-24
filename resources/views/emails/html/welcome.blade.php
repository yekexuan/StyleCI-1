@extends('layouts.email')

@section('content')
<p>Thank you for creating an account on <a href="{{ route('home') }}">StyleCI</a>; we're excited to have you on board!</p>
<p>StyleCI is powered by <a href="https://github.com/FriendsOfPHP/PHP-CS-Fixer">PHP CS Fixer</a>, and can be configured via an optional <code>.styleci.yml</code> file committed to the root of your repo.</p>
<p>Our full documentation is available at <a href="https://styleci.readme.io/">https://styleci.readme.io/</a>, and if you have any questions at all, feel free to contact us by emailing <a href="mailto:support@alt-three.com?subject=StyleCI Support">support@alt-three.com</a>.</p>
@stop
