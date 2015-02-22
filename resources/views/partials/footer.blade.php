</div></div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 copyright">
                <ul class="footer-links">
                    <li>&copy; {{ date('Y') }} StyleCI</li>
                    <li><a href="{{ route('donate') }}">Donate</a></li>
                    <li><a href="{{ route('privacy_policy') }}">Terms</a></li>
                    <li><a href="{{ route('privacy_policy') }}">Privacy</a></li>
                    <li><a href="{{ route('privacy_policy') }}">Security</a></li>
                    <li><a href="mailto:team@styleci.io">Contact</a></li>
                </ul>
            </div>
            <div class="col-sm-4 logo">
                <img src="{{ asset('img/logo.png') }}" width="80" />
            </div>
            <div class="col-sm-4 social-links">
                <ul class="footer-links">
                    <li><a href="https://status.styleci.io" target="_blank">Status</a></li>
                    <li><a href="https://blog.styleci.io" target="_blank">Blog</a></li>
                    <li><a href="https://twitter.com/teamstyleci" target="_blank">Twitter</a></li>
                    <li><a href="https://github.com/StyleCI" target="_blank">GitHub</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ elixir('dist/js/app.js') }}"></script>
@section('js')
@show
@if (Config::get('analytics.enabled'))
    @include('partials.analytics')
@endif
