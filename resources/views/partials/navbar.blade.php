<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if($currentUser)
            <a class="navbar-brand" href="{{ route('repos_path') }}">StyleCI</a>
            @else
            <a class="navbar-brand" href="{{ route('home') }}">StyleCI</a>
            @endif
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            @if($currentUser)
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('account_path') }}">{{ $currentUser->name }}</a></li>
                <li><a href="{{ route('auth_logout_path') }}" data-method="POST">Logout <span class="sr-only">(current)</span></a></li>
            </ul>
            @else
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('auth_login_path') }}" data-method="POST">Login <span class="sr-only">(current)</span></a></li>
            </ul>
            @endif
        </div>
    </div>
</nav>
