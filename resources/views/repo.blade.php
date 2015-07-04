@extends('layouts.default')

@section('title', $repo->name)

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>{{ $repo->name }}</h1>
        <p>Here you can see all the analyses</p>
    </div>
</div>
@stop

@section('content')
<sc-repo inline-template>
    @if($can_analyse)
    <button type="button" v-on="click: analyseRepo($event)" class="btn btn-lg btn-danger btn-circle btn-float pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" data-toggle="tooltip" data-placement="left" title="Analyse Now">
        <i class="fa fa-undo"></i>
    </button>
    @endif
    <div class="repo-table" id="repo" data-id="{{ $repo->id }}" data-branch="{{ $repo->default_branch }}">
        <div v-show="isLoading" class="loading text-center">
            <h3><i class="fa fa-circle-o-notch fa-spin"></i> Fetching your analyses...</h3>
        </div>
        <div v-show="!isLoading && analyses.length" class="repo-table-headers row hidden-xs">
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
            <div v-repeat="analyses : analyses"
                 class="row"
                 v-class="bg-success: analyses.status === 2, bg-danger: analyses.status > 2">
                <div class="col-sm-7">
                    <strong>@{{ analyses.message }}</strong>
                    <br>
                    <small class="js-time-ago" title="@{{ analyses.created_at_iso }}">@{{ analyses.time_ago }}</small>
                </div>
                <div class="col-sm-1">
                    <p style="color: @{{ analyses.color }}">
                        <strong>@{{ analyses.summary }}</strong>
                    </p>
                </div>
                <div class="col-sm-4 repo-buttons">
                    <a class="badge-id" href="@{{ analyses.github_link }}">
                        @{{ analyses.github_id }}
                    </a>
                    <a class="btn btn-sm btn-default" href="@{{ analyses.link }}">Show Details</a>
                </div>
            </div>
        </div>
        <p v-show="!isLoading && !analyses.length" class="lead">We haven't analysed anything yet.</p>
    </div>
</sc-repo>
@stop
