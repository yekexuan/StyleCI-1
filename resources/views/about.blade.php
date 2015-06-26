@extends('layouts.cutdown')

@section('title', 'About')

@section('content')
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
                <div class="col-md-10 col-md-offset-1">
                    <div class="col-sm-4">
                        <div class="team-member">
                            <img src="https://www.gravatar.com/avatar/838bf3ed69d559cb46956c509c9464af?s=225" class="img-responsive img-circle" alt="">
                            <h4>Graham Campbell</h4>
                            <p>Founder</p>
                            <blockquote>Graham is a prolific PHP developer and the second largest contributor to the Laravel framework.</blockquote>
                            <ul class="list-inline social-buttons">
                                <li><a href="https://twitter.com/GrahamJCampbell"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://github.com/GrahamCampbell"><i class="fa fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="team-member">
                            <img src="https://www.gravatar.com/avatar/b19a7e3567c963fe3116e140ab12b8c0?s=225" class="img-responsive img-circle" alt="">
                            <h4>Joseph Cohen</h4>
                            <p>Code Monkey</p>
                            <blockquote>Joe is a founder of Dinkbit and a big contributor to StyleCI.</blockquote>
                            <ul class="list-inline social-buttons">
                                <li><a href="https://twitter.com/joecohens"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://github.com/joecohens"><i class="fa fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="team-member">
                            <img src="https://www.gravatar.com/avatar/13616b6551a3854378f9e6fea964e519?s=225" class="img-responsive img-circle" alt="">
                            <h4>James Brooks</h4>
                            <p>Startup Guru</p>
                            <blockquote>The founder of Cachet, James supports StyleCI with code and a little startup knowledge.</blockquote>
                            <ul class="list-inline social-buttons">
                                <li><a href="https://twitter.com/jbrooksuk"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://github.com/jbrooksuk"><i class="fa fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <p class="large">StyleCI - The PHP Coding Style Continuous Integration Service</p>
                </div>
            </div>
        </div>
    </header>
</div>
@stop
