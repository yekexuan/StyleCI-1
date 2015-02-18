@extends(Config::get('core.email'))

@section('content')
<p>Dear {{ $name }},</p>
<p>Thank you for creating an account on <a href="{{ route('home') }}">StyleCI</a>.</p>
<p>StyleCI is powered by PHP CS Fixer, and is totally configurable via an optional .php_cs file, committed to your repo. It might be very useful for you to check out PHP CS Fixer's documentation before continuing at https://github.com/FriendsOfPHP/PHP-CS-Fixer.</p>
<p>If you have any questions at all, feel free to contact me by emailing graham@mineuk.com, or by creating an <a href="https://github.com/StyleCI/StyleCI/issues/new">issue</a> on GitHub.</p>
@stop
