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
