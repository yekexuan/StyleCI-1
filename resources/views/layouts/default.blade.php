<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>StyleCI - @yield('title', 'The Coding Style Continuous Integration Service')</title>
@include('partials.header')
</head>
<body>
<div id="wrap">
@include('partials.navbar')
@include('partials.notifications')
@section('top')
@show
<div class="container" id="app">
@section('content')
@show
</div>
</div>
@include('partials.footer')
@section('bottom')
@show
</body>
</html>
