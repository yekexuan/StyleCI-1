@extends('layouts.default')

@section('title', $analysis->repo->name)

@section('top')
<div class="page-heading">
    <div class="container">
        <h1><a class="header-link" href="{{ route('repo', $analysis->repo->id) }}"><i class="fa fa-chevron-circle-left"></i></a> {{ $analysis->repo->name }}</h1>
        <p>Here you can see the results of the analysis.</p>
    </div>
</div>
@stop

@section('content')
<sc-analysis inline-template>
    <div id="analysis" class="analysis hide" data-id="{{ $analysis->id }}" data-has-result="{{ $analysis->status > Analysis::PASSED }}" data-has-diff="{{ $analysis->has_diff }}">
        <div class="well">
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#badge-modal">
                    <img src="{{ route('repo_shield', $analysis->repo->id) }}" alt="StyleCI Shield">
                </a>
            </div>
            <p class="js-status status-{{ $analysis->color }}">
                <i class="{{ $analysis->icon }}"></i>
                {{ $analysis->description }}
            </p>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <div class="analysis-result-message">
                        <h3>{{ $analysis->message }}</h3>
                        <p>{{ $analysis->commit }}</p>
                    </div>
                    <ul class="list-inline hide" id="status-buttons">
                        <li id="view-time">
                            <span>
                                <i class="fa fa-calendar"></i>
                                <span class="js-time-ago" title="{{ $analysis->created_at_iso }}">{{ $analysis->time_ago }}</span>
                            </span>
                        </li>
                        <li id="view-github">
                            <a class="btn" href="{{ $analysis->github_link }}" target="_blank">
                                <i class="fa fa-github"></i>
                                {{ $analysis->github_id }}
                            </a>
                        </li>
                        <li v-show="hasDiff" id="download-diff">
                            <a class="btn" href="{{ route('analysis_download', $analysis->id) }}">
                                <i class="fa fa-cloud-download"></i>
                                Download patch
                            </a>
                        </li>
                        <li v-show="hasDiff" id="view-diff">
                            <a class="btn" href="{{ route('analysis_diff', $analysis->id) }}" target="_blank">
                                <i class="fa fa-code"></i>
                                Open diff file
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div v-show="isLoading" class="loading text-center">
            <h3><i class="fa fa-circle-o-notch fa-spin"></i> Fetching results...</h3>
        </div>
        <div id="results">
        </div>
    </div>
</sc-analysis>

@include('analysis.badge')
@stop
