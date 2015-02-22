</div></div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h4>StyleCI</h4>
                <p>Copyright <a href="https://github.com/GrahamCampbell">Graham Campbell</a> and <a href="https://github.com/joecohens">Joe Cohen</a> {{ date('Y') }}.</p>
                <ul class="footer-links">
                    <li><a href="{{ route('donate') }}">Donate</a></li>
                    <li><a href="{{ route('privacy_policy') }}">Privacy</a></li>
                </ul>
            </div>
            <div class="col-lg-{{ Config::get('app.debug') ? '4' : '8' }}">
                <h4>Social Links</h4>
                <p>
                    <a href="https://twitter.com/teamstyleci" target="_blank"><i class="fa fa-twitter"></i></a>
                    <a href="https://github.com/StyleCI" target="_blank"><i class="fa fa-github"></i></a>
                </p>
            </div>
            @if(Config::get('app.debug'))
            <div class="col-lg-4">
                <h4>Here be dragons</h4>
                <p>Generated in {{ round((microtime(1) - LARAVEL_START), 4) }} sec.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ elixir('dist/js/app.js') }}"></script>
@section('js')
@show
@if (Config::get('analytics.enabled'))
    @include('partials.analytics')
@endif
