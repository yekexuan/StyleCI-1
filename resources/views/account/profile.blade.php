<h2>Profile</h2>
<div class="row">
    <div class="col-md-3">
        <img src="{{ $currentUser->gravatar }}" alt="{{ $currentUser->name }}">
    </div>
    <div class="col-md-9">
        <dl class="profile">
            <dt>GitHub</dt>
            <dd><a href="https://github.com/{{ $currentUser->username }}" target="_blank">{{ $currentUser->username }}</a></dd>
            <dt>Email</dt>
            <dd>{{ $currentUser->email }}</dd>
        </dl>
    </div>
</div>
<hr>
<h2>Delete Account</h2>
<p class="lead">You may delete your account here.</p>
<p>Note that account deletion will remove all your data from our servers, so if you create a new account in the future, all your current analyses will be missing.</p>
<br>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_account"><i class="fa fa-times"></i> Delete Account</button>
