@extends('layouts.default')

@section('title', $repo->name)

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>{{ $repo->name }}</h1>
        <p>Here you can see all the analysed commits</p>
    </div>
</div>
@stop

@section('content')
<sc-repo id="{{ $repo->id }}" inline-template>
    @if($canAnalyse)
    <button type="button" v-on="click: analyseRepo('{{ route('repo_analyse_path', $repo->id) }}', $event)" class="btn btn-lg btn-danger btn-circle btn-float pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" data-toggle="tooltip" data-placement="left" title="Analyse Now">
        <i class="fa fa-undo"></i>
    </button>
    @endif
    <div class="repo-table">
        <div v-if="commits.length" class="repo-table-headers row hidden-xs">
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
        <p v-show="!commits.length" class="lead">We haven't analysed anything yet.</p>
        <div class="commits">
            <div v-repeat="commit : commits"
                 class="row"
                 v-class="
                   bg-success: commit.status === 1,
                   bg-danger: commit.status === 2
                 ">
                <div class="col-sm-7">
                    <strong>@{{ commit.message }}</strong>
                    <br>
                    <small class="js-time-ago" title="@{{ commit.createdAtToISO }}">@{{ commit.timeAgo }}</small>
                </div>
                <div class="col-sm-1">
                    <p style="color: @{{ commit.color }}">
                        <strong>@{{ commit.summary }}</strong>
                    </p>
                </div>
                <div class="col-sm-4 repo-buttons">
                    <a class="badge-id" href="https://github.com/@{{ commit.repo_name }}/commit/@{{ commit.id }}">
                        @{{ commit.shorthandId }}
                    </a>
                    <a class="btn btn-sm btn-default" href="@{{ commit.link }}">Show Details</a>
                </div>
            </div>
        </div>
    </div>
</sc-repo>
@stop
