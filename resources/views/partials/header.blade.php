<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="@yield('description', 'StyleCI is the PHP Coding Style Continuous Integration Service. Sign up with your GitHub account and analyse all your public PHP repos for free!')">
<meta name="author" content="Alt Three Services Limited">

<meta name="styleci:token" content="{{ csrf_token() }}">
<meta name="styleci:pusher" content="{{ $pusher_key }}">
@if ($current_user)
<meta name="styleci:user" content="{{ $current_user->id }}">
@endif

<meta content="summary" name="twitter:card">
<meta content="{{ $__env->yieldContent('title') }}" name="twitter:title">
<meta content="@yield('description', 'StyleCI - The PHP Coding Style Continuous Integration Service')" name="twitter:description">
<meta content="{{ asset('img/styleci-og.png') }}" name="twitter:image:src">
<meta content="StyleCI" property="og:site_name">
<meta content="object" property="og:type">
<meta content="{{ asset('img/styleci-og.png') }}" property="og:image">
<meta content="{{ $__env->yieldContent('title') }}" property="og:title">
<meta content="{{ $current_url }}" property="og:url">
<meta content="@yield('description', 'StyleCI - The PHP Coding Style Continuous Integration Service')" property="og:description">

<link href="//fonts.googleapis.com/css?family=Roboto:400,300,500,700" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ elixir('dist/css/app.css') }}">

@section('css')
@show

<!--[if lt IE 9]>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script type="text/javascript">
    window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website.","dismiss":"Got it!","learnMore":"More info","link":"{{ route('privacy_policy') }}","theme":"light-top"};
</script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>

<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('apple-touch-icon-57x57.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('apple-touch-icon-114x114.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('apple-touch-icon-72x72.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('apple-touch-icon-144x144.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('apple-touch-icon-120x120.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('apple-touch-icon-152x152.png') }}">
<link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32">
<link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16">
<meta name="application-name" content="StyleCI">
<meta name="msapplication-TileColor" content="#FFFFFF">
<meta name="msapplication-TileImage" content="{{ asset('mstile-144x144.png') }}">
