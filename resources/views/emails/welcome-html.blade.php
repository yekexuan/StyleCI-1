@extends(Config::get('core.email'))

@section('content')
<p>Thank you for creating an account on <a href="{{ route('home') }}">StyleCI</a>, we're excited to have you on board!</p>
<p>StyleCI is powered by <a href="https://github.com/FriendsOfPHP/PHP-CS-Fixer">PHP CS Fixer</a>, and is totally configurable via an optional <code>.styleci.yml</code> file which can be committed to your repo. It might be useful for you to check out PHP CS Fixer's documentation before continuing at <a href="https://github.com/FriendsOfPHP/PHP-CS-Fixer">https://github.com/FriendsOfPHP/PHP-CS-Fixer</a>.</p>
<p>If you have any questions at all, feel free to contact me by emailing <a href="mailto:graham@mineuk.com?subject=StyleCI Support">graham@mineuk.com</a>, or by creating an <a href="https://github.com/StyleCI/StyleCI/issues/new">issue</a> on GitHub.</p>
@stop
