@extends('layouts.default')

@section('title', 'Analysed Repos')

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>Analysed Repos</h1>
        <p>Here you can see all your analysed repos.</p>
    </div>
</div>
@stop

@section('content')
<sc-repos inline-template>
    <div id="repos" class="repos hide">
        <div v-show="isLoading" class="loading text-center">
            <h3><i class="fa fa-circle-o-notch fa-spin"></i> Fetching your repositories...</h3>
        </div>
        <form v-show="!isLoading && repos.length" name="search">
            <div class="form-group">
                <label for="query">Filter your repositories</label>
                <input v-model="search" type="text" name="query" class="form-control" id="query">
            </div>
        </form>
        <div v-show="repos.length" v-repeat="repo : repos | filterBy search" id="js-repo-@{{ repo.id }}">
            <hr v-show="$index > 0">
            <div class="row">
                <div class="col-sm-8">
                    <h3>@{{ repo.name }}</h3>
                    <p class="js-status">
                        <span v-if="repo.last_analysis">
                            <strong style="color: @{{ repo.last_analysis.color }}">@{{ repo.last_analysis.summary }}</strong>
                        </span>
                        <span v-if="!repo.last_analysis">
                            <strong>Nothing on the @{{ repo.default_branch }} branch has been analysed yet.</strong>
                        </span>
                    </p>
                </div>
                <div class="col-sm-4 list-vcenter">
                    <a class="btn btn-primary" href="{{ route('repo_path', '') }}/@{{ repo.id }}"><i class="fa fa-history"></i> Show Analyses</a>
                </div>
            </div>
        </div>
        <div v-show="!isLoading && !repos.length">
            <p class="lead">We haven't analysed anything yet.</p>
            <p>You can enable repos on your <a href="{{ route('account_path') }}">account page</a>.</p>
        </div>
    </div>
</sc-repos>
@stop
