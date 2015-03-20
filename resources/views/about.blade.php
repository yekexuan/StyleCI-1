@extends(Config::get('core.default'))

@section('title', 'About')

@section('top')
<div class="about">
    <header id="top" class="home-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Our Amazing Team</h2>
                    <!--<h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>-->
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <div class="team-member">
                        <img src="https://www.gravatar.com/avatar/838bf3ed69d559cb46956c509c9464af?s=225" class="img-responsive img-circle" alt="">
                        <h4>Graham Campbell</h4>
                        <p>Founder</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com/GrahamJCampbell"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://github.com/GrahamCampbell"><i class="fa fa-github"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="team-member">
                        <img src="https://www.gravatar.com/avatar/b19a7e3567c963fe3116e140ab12b8c0?s=225" class="img-responsive img-circle" alt="">
                        <h4>Joseph Cohen</h4>
                        <p>Code Monkey</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com/joecohens"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://github.com/joecohens"><i class="fa fa-github"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="team-member">
                        <img src="https://www.gravatar.com/avatar/13616b6551a3854378f9e6fea964e519?s=225" class="img-responsive img-circle" alt="">
                        <h4>James Brooks</h4>
                        <p>Startup Guru</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com/jbrooksuk"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://github.com/jbrooksuk"><i class="fa fa-github"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="team-member">
                        <img src="https://www.gravatar.com/avatar/971d6f920bea5f86fa9b7f6d29ca6626?s=225" class="img-responsive img-circle" alt="">
                        <h4>Michael Banks</h4>
                        <p>PR Ninja</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com/ChipIsTheName"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://facebook.com/chip.pub"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://linkedin.com/in/itschip"><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li><a href="https://github.com/MichaelBanks"><i class="fa fa-github"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <p class="large">StyleCI - The PHP Coding Style Continuous Integration Service</p>
                </div>
            </div>
        </div>
    </header>
</div>
@stop

@section('content')
<h1>Placeholder</h1>
<p>Foo bar baz.</p>

@stop
