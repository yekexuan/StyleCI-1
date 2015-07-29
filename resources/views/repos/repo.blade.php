@extends('layouts.default')

@section('title', $repo->name)

@section('top')
<div class="page-heading">
    <div class="container">
        <h1><a class="header-link" href="{{ $repo->github_link }}" target="_blank"><i class="fa fa-github"></i></a> {{ $repo->name }}</h1>
        <p>Here you can see all the analyses for this repo.</p>
    </div>
</div>
@stop

@section('content')
<sc-repo inline-template>
    <div id="repo-list" class="hide">
        @if($can_analyze)
        <button type="button" v-class="disabled: !branches.length" v-on="click: analyzeRepo($event)" class="btn btn-lg btn-danger btn-circle btn-float pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" data-toggle="tooltip" data-placement="left" title="Analyze Now">
            <i class="fa fa-undo"></i>
        </button>
        @endif
        <div class="btn-group">
            <button type="button" v-class="disabled: !branches.length" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @{{ repoBranch }} <span class="caret"></span>
            </button>
            <ul class="dropdown-menu branch-list" v-show="branches.length">
                <li v-repeat="branch : branches"><a v-on="click: filterBranch(branch)">@{{ branch }}</a></li>
            </ul>
        </div>
        <hr>
        <div v-show="isLoading" class="loading text-center">
            <h3><i class="fa fa-circle-o-notch fa-spin"></i> Fetching your analyses...</h3>
        </div>
        <div class="repo-table" id="repo" data-id="{{ $repo->id }}" data-branch="{{ $repo->default_branch }}">
            <div v-show="!isLoading && analyses.length">
                <div class="repo-table-headers row hidden-xs">
                    <div class="col-sm-7">
                        <strong>Commit</strong>
                    </div>
                    <div class="col-sm-1">
                        <strong>Status</strong>
                    </div>
                    <div class="col-sm-4">
                        <!-- Actions -->
                    </div>
                </div>
                <div class="analyses">
                    <div v-repeat="analysis : analyses"
                         class="row"
                         v-class="bg-success: analysis.status === 2, bg-danger: analysis.status > 2">
                        <div class="col-sm-7">
                            <strong>@{{ analysis.message }}</strong>
                            <br>
                            <small class="js-time-ago" title="@{{ analysis.created_at_iso }}">@{{ analysis.time_ago }}</small>
                        </div>
                        <div class="col-sm-1">
                            <p class="status-@{{ analysis.color }}">
                                <strong>@{{ analysis.summary }}</strong>
                            </p>
                        </div>
                        <div class="col-sm-4 repo-buttons">
                            <a class="badge-id" href="@{{ analysis.github_link }}" target="_blank">
                                @{{ analysis.github_id }}
                            </a>
                            <a class="btn btn-sm btn-default" href="@{{ analysis.link }}">Show Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <p v-show="!isLoading && !analyses.length" class="lead">We haven't analysed anything yet.</p>
        </div>
        <nav v-show="totalPages > 1">
            <ul class="pager">
                <li class="previous" v-class="disabled: currentPage == 1"><a v-on="click: pageBackward()"><span aria-hidden="true">&larr;</span> Previous</a></li>
                <li class="next" v-class="disabled: currentPage >= totalPages"><a v-on="click: pageForward()">Next <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    </div>
</sc-repo>
@stop
