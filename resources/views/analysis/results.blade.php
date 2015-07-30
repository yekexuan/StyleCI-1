@if ($analysis->error)
<div class="alert alert-danger analysis-alert" role="alert">
    <h4>Error details:</h4>
    <p>{{ $analysis->error }}</p>
</div>
@endif

@if ($analysis->status === Analysis::CONFIG_ISSUES)
<div class="alert alert-info analysis-alert" role="alert">
    <h4>Want to check out our docs?</h4>
    <p>We have detailed configuration documentation available at <a href="https://styleci.readme.io/docs/configuration" target="_blank">https://styleci.readme.io/docs/configuration</a>.</p>
</div>
<div class="alert alert-info analysis-alert" role="alert">
    <h4>Still not sure?</h4>
    <p>Feel free to contact support at <a href="mailto:support@alt-three.com">support@alt-three.com</a>.</p>
</div>
@elseif ($analysis->status === Analysis::ACCESS_ISSUES)
<div class="alert alert-danger analysis-alert" role="alert">
    <h4>We were unable to access the repo or commit to analyze it.</h4>
    <p>Feel free to contact support at <a href="mailto:support@alt-three.com">support@alt-three.com</a>.</p>
</div>
@elseif ($analysis->status === Analysis::TIMEOUT)
<div class="alert alert-danger analysis-alert" role="alert">
    <h4>Unfortunately, the analysis timed out on our platform.</h4>
    <p>Feel free to contact support at <a href="mailto:support@alt-three.com">support@alt-three.com</a>.</p>
</div>
@elseif ($analysis->status === Analysis::INTERNAL)
<div class="alert alert-danger analysis-alert" role="alert">
    <h4>Unfortunately, something went wrong on our platform.</h4>
    <p>Feel free to contact support at <a href="mailto:support@alt-three.com">support@alt-three.com</a>.</p>
</div>
@endif

@if ($analysis->errors)
@foreach ($analysis->errors as $error)
<div class="alert alert-danger analysis-alert" role="alert">
    <h4>{{ $error['type'] }}{{ isset($error['file']) ? ' - '.$error['file'] : '' }}</h4>
    <p>{{ $error['message'] }}</p>
</div>
@endforeach
@endif

@if ($analysis->has_diff)
<hr>
<p>
    <i class="fa fa-file-code-o"></i>
    <small>Showing <b>{{ $analysis->diff->count() }} changed files</b> with <b>{{ $analysis->diff->additions() }} additions</b> and <b>{{ $analysis->diff->deletions() }} deletions</b>.</small>
</p>
<br>
@foreach ($analysis->diff->files() as $name => $file)
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
