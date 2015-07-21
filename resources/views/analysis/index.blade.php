@extends('layouts.default')

@section('title', $analysis->repo->name)

@section('top')
<div class="page-heading">
    <div class="container">
        <h1><a class="github-link" href="{{ route('repo', $analysis->repo->id) }}"><i class="fa fa-chevron-circle-left"></i></a> {{ $analysis->repo->name }}</h1>
        <p>Here you can see the results of the analysis.</p>
    </div>
</div>
@stop

@section('content')
<sc-analysis>
    <div id="analysis" class="analysis hide" data-id="{{ $analysis->id }}">
        <div class="well">
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#badge-modal">
                    <img src="{{ route('repo_shield', $analysis->repo->id) }}" alt="StyleCI Shield">
                </a>
            </div>
            <p class="js-status @if ($analysis->status === 2) status-green; @elseif ($analysis->status > 2) status-red; @else status-grey; @endif">
                <i class="{{ $analysis->icon }}"></i>
                {{ $analysis->description }}
            </p>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <h3>{{ $analysis->message }}</h3>
                    <p>{{ $analysis->commit }}</p>
                    <br>
                    <ul class="list-inline hide" id="status-buttons">
                        <li id="view-time">
                            <span>
                                <i class="fa fa-calendar"></i>
                                <span class="js-time-ago" title="{{ $analysis->created_at_iso }}">{{ $analysis->time_ago }}</span>
                            </span>
                        </li>
                        <li id="view-github">
                            <a class="btn" href="{{ $analysis->github_link }}">
                                <i class="fa fa-github"></i>
                                {{ $analysis->github_id }}
                            </a>
                        </li>
                        <li id="download-diff">
                            <a class="btn" href="{{ route('analysis_download', $analysis->id) }}">
                                <i class="fa fa-cloud-download"></i>
                                Download patch
                            </a>
                        </li>
                        <li id="view-diff">
                            <a class="btn" href="{{ route('analysis_diff', $analysis->id) }}">
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

<div class="modal fade" id="badge-modal" tabindex="-1" role="dialog" aria-labelledby="badge-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal">Embed StyleCI Shield</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="image-url">Raw Image</label>
                    <textarea class="form-control" rows="3" cols="40" id="image-url" readonly>{{ route('repo_shield', $analysis->repo->id) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="markdown-url">Markdown</label>
                    <textarea class="form-control" rows="3" cols="40" id="markdown-url" readonly>[![StyleCI]({{ route('repo_shield', $analysis->repo->id) }})]({{ route('repo', $analysis->repo->id) }})</textarea>
                </div>
                <div class="form-group">
                    <label for="html-url">HTML</label>
                    <textarea class="form-control" rows="3" cols="40" id="html-url" readonly><a href="{{ route('repo', $analysis->repo->id) }}"><img src="{{ route('repo_shield', $analysis->repo->id) }}" alt="StyleCI"></a></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop
