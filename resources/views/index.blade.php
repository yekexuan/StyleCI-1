@extends(Config::get('core.default'))

@section('title', 'The PHP Coding Style Continuous Integration Service')

@section('top')
<header id="top" class="home-header">
    <div class="text-vertical-center">
        <h1>StyleCI</h1>
        <h3>The PHP Coding Style Continuous Integration Service</h3>
        <br>
        @if($currentUser)
        <a href="{{ route('repos_path') }}" class="btn btn-dark btn-lg">Get Started</a>
        @else
        <a href="{{ route('auth_login_path') }}" class="btn btn-dark btn-lg" data-method="POST">Get Started</a>
        @endif
    </div>
</header>
<div class="highlights">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-image">
                        <i class="fa fa-5x fa-code-fork"></i>
                    </div>
                    <div class="panel-body">
                        <h3 class="featurette-heading">Analyse</h3>
                        <p>We watch all your pull requests.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-image">
                        <i class="fa fa-5x fa-code"></i>
                    </div>
                    <div class="panel-body">
                        <h3>Patch</h3>
                        <p>Keep your code aligned with coding standards.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-image">
                        <i class="fa fa-5x fa-gear"></i>
                    </div>
                    <div class="panel-body">
                        <h3>Configure</h3>
                        <p>Fix PSR-1, PSR-2, PSR-5, symfony and more.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="features">
    <div class="row featurette">
        <div class="col-sm-6">
            <img class="featurette-image img-responsive" src="{{ url('img/analyse-repo.jpg') }}" alt="Analyse" />
        </div>
        <div class="col-sm-6">
            <h2 class="featurette-heading">Analyse pull requests</h2>
            <p class="lead">Analyse all your pull requests and see the results alsong side any other continuous integration services such as travis right on GitHub.</p>
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-sm-6">
            <h2 class="featurette-heading">Apply style fixes patch</h2>
            <p class="lead">Download patch files for the coding style fixes ready to use, and apply them automatically using "git apply" or can be inspected via the browser too.</p>
        </div>
        <div class="col-sm-6">
            <img class="featurette-image img-responsive" src="{{ url('img/patch-commit.jpg') }}" alt="Patch">
        </div>
    </div>
    <hr>
    <div class="row featurette">
        <div class="col-sm-12">
            <h2 class="featurette-heading">Configure to your needs</h2>
            <p class="lead">Powered by php-cs-fixer, and is fully configurable to fix PSR-1, PSR-2, PSR-5, symfony, and various other checks via a .php_cs file that can be commited to your repo.</p>
        </div>
    </div>
</div>
@stop
