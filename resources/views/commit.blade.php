@extends(Config::get('core.default'))

@section('title', 'Commit - '.$commit->message)
@section('description', $commit->message)

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>{{ $commit->repo->name }} &mdash; Commit Analysis</h1>
        <p>Here you can see the results of the analysed commit.</p>
    </div>
</div>
@stop

@section('content')
<div id="js-commit-{{ $commit->shorthandId }}" class="commit js-channel" data-channel="{{ $commit->repo->id }}">
    <div class="well">
        <div class="pull-right">
            <img src="{{ route('repo_shield_path', $commit->repo->id) }}" alt="Shield" />
        </div>
        <p class="js-status" style="@if ($commit->status === 1) color:green; @elseif ($commit->status > 1) color:red; @else color:grey; @endif">
            <i class="{{ $commit->icon }}"></i>
            {{ $commit->description }}
        </p>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <h3>{{ $commit->message }}</h3>
                <p>{{ $commit->id }}</p>
                <br>
                <ul class="list-inline">
                    <li>
                        <span>
                            <i class="fa fa-calendar"></i>
                            <span class="js-time-ago" title="{{ $commit->createdAtToISO }}">{{ $commit->timeAgo }}</span>
                        </span>
                    </li>
                    <li>
                        <a class="btn" href="https://github.com/{{ $commit->repo->name }}/commit/{{ $commit->id }}">
                            <i class="fa fa-github"></i>
                            Commit {{ $commit->shorthandId }}
                        </a>
                    </li>
                    @if ($commit->status === 2)
                    <li>
                        <a class="btn btn-link" href="{{ route('commit_download_path', $commit->id) }}">
                            <i class="fa fa-cloud-download"></i> Download patch
                        </a>
                    </li>
                    <li>
                        <a class="btn btn-link" href="{{ route('commit_diff_path', $commit->id) }}">
                            <i class="fa fa-code"></i> Open diff file
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @if ($commit->status === 2)
    <hr>
    @foreach ($commit->diffFiles() as $name => $file)
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $name }}
        </div>
        <div class="panel-body">
            <pre class="brush: diff">
                {{ $file }}
            </pre>
        </div>
    </div>
    @endforeach
    @endif
</div>
@stop

@section('js')
<script type="text/javascript">
    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.defaults['gutter'] = false;
    SyntaxHighlighter.all();
    $(function() {
        StyleCI.Commit.RealTimeStatus();
    });
</script>
@stop
