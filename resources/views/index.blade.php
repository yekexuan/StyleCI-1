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
        <a href="{{ route('auth_login_path') }}" class="btn btn-dark btn-lg" data-method="POST"><i class='fa fa-github'></i> Login with GitHub</a>
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
                        <p>We watch all of your pull requests and automatically analyse them.</p>
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
                        <p>Keep your code aligned with the best coding standards.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-image">
                        <i class="fa fa-5x fa-gear"></i>
                    </div>
                    <div class="panel-body">
                        <h3>Configurable</h3>
                        <p>Fix PSR-1, PSR-2, PSR-5, Symfony and more.</p>
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
        <div class="col-sm-6 text-left">
            <div class="fake-browser-ui">
                <div class="frame">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img class="featurette-image img-responsive" src="{{ url('img/analyse-repo.jpg') }}" alt="Analyse" />
            </div>
        </div>
        <div class="col-sm-6">
            <h2 class="featurette-heading">Analysis of pull requests</h2>
            <p class="lead">StyleCI automatically analyses all of your pull requests and will display a build status within GitHub before you merge.</p>
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-sm-6">
            <h2 class="featurette-heading">Patches provided</h2>
            <p class="lead">Did the changes not meet the coding standards? Don't worry, StyleCI provides a patch file that you can download and <code>git apply patch.txt</code> , or you can view within your browser.</p>
        </div>
        <div class="col-sm-6 text-right">
            <div class="fake-browser-ui">
                <div class="frame">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img class="featurette-image img-responsive" src="{{ url('img/patch-commit.jpg') }}" alt="Patch">
            </div>
        </div>
    </div>
    <hr>
    <div class="row featurette">
        <div class="col-sm-6 text-left">
            <div class="fake-browser-ui">
                <div class="frame">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img class="featurette-image img-responsive" src="{{ url('img/php-cs.png') }}" alt="PHP CS Fixer">
            </div>
        </div>
        <div class="col-sm-6">
            <h2 class="featurette-heading">Configure to your needs (coming soon)</h2>
            <p class="lead">StyleCI is powered by <a href="https://github.com/FriendsOfPHP/PHP-CS-Fixer" target="_blank">PHP CS Fixer</a>, and is fully configurable to fix PSR-1, PSR-2, PSR-5, Symfony and various other checks via a <code>.styleci.yml</code> file, committed to the root your repository.</p>
        </div>
    </div>
</div>
@stop
