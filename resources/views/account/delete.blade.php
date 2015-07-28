<div class="modal fade" id="delete_account" tabindex="-1" role="dialog" aria-labelledby="delete_account" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete Account</h4>
            </div>
            <div class="modal-body">
                <p>You are about to delete your account and your repos from StyleCI. This process cannot be reverted, however you may still sign up again in the future should you change your mind.</p>
                <p>Are you sure you wish to continue?</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" href="{{ route('account_delete') }}" data-method="DELETE">Yes</a>
                <button class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
