@extends('layouts.default')

@section('title', 'Analysis - '.$analysis->message)
@section('description', $analysis->message)

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>{{ $analysis->repo->name }} &mdash; Analysis</h1>
        <p>Here you can see the results of the analysis.</p>
    </div>
</div>
@stop

@section('content')
<sc-analysis>
    <div id="analysis" class="analysis" data-id="{{ $analysis->id }}">
        <div class="well">
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#badge-modal">
                    <img src="{{ route('repo_shield_path', $analysis->repo->id) }}" alt="StyleCI Shield">
                </a>
            </div>
            <p class="js-status" style="@if ($analysis->status === 2) color:green; @elseif ($analysis->status > 2) color:red; @else color:grey; @endif">
                <i class="{{ $analysis->icon }}"></i>
                {{ $analysis->description }}
            </p>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <h3>{{ $analysis->message }}</h3>
                    <p>{{ $analysis->commit }}</p>
                    <br>
                    <ul class="list-inline">
                        <li>
                            <span>
                                <i class="fa fa-calendar"></i>
                                <span class="js-time-ago" title="{{ $analysis->created_at_iso }}">{{ $analysis->time_ago }}</span>
                            </span>
                        </li>
                        <li>
                            <a class="btn" href="{{ $analysis->github_link }}">
                                <i class="fa fa-github"></i>
                                {{ $analysis->github_id }}
                            </a>
                        </li>
                        @if ($analysis->has_diff)
                        <li>
                            <a class="btn" href="{{ route('analysis_download_path', $analysis->id) }}">
                                <i class="fa fa-cloud-download"></i> Download patch
                            </a>
                        </li>
                        <li>
                            <a class="btn" href="{{ route('analysis_diff_path', $analysis->id) }}">
                                <i class="fa fa-code"></i> Open diff file
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div id="results">
            @if($analysis->status > 2)
            <p class="lead"><i class='fa fa-circle-o-notch fa-spin'></i> Loading...</p>
            @endif
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
                    <textarea class="form-control" rows="3" cols="40" id="image-url" readonly>{{ route('repo_shield_path', $analysis->repo->id) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="markdown-url">Markdown</label>
                    <textarea class="form-control" rows="3" cols="40" id="markdown-url" readonly>[![StyleCI]({{ route('repo_shield_path', $analysis->repo->id) }})]({{ route('repo_path', $analysis->repo->id) }})</textarea>
                </div>
                <div class="form-group">
                    <label for="html-url">HTML</label>
                    <textarea class="form-control" rows="3" cols="40" id="html-url" readonly><a href="{{ route('repo_path', $analysis->repo->id) }}"><img src="{{ route('repo_shield_path', $analysis->repo->id) }}" alt="StyleCI"></a></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop
