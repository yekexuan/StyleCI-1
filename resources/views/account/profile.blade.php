<h2>Profile</h2>
<div class="row">
    <div class="col-md-3">
        <img src="{{ $current_user->gravatar }}" alt="{{ $current_user->name }}">
    </div>
    <div class="col-md-9">
        <dl class="profile">
            <dt>GitHub</dt>
            <dd><a href="https://github.com/{{ $current_user->username }}" target="_blank">{{ $current_user->username }}</a></dd>
            <dt>Email</dt>
            <dd>{{ $current_user->email }}</dd>
        </dl>
    </div>
</div>
<hr>
<h2>Delete Account</h2>
<p class="lead">You may delete your account here.</p>
<p class="separate">Note that account deletion will remove all your data from our servers, so if you create a new account in the future, all your current analyses will be missing.</p>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_account"><i class="fa fa-times"></i> Delete Account</button>
