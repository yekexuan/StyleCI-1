@extends('layouts.default')

@section('title', 'Your Account')

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>Your Account</h1>
        <p>Here you can manage your StyleCI account.</p>
    </div>
</div>
@stop

@section('content')
@include('account.delete')
<div role="tabpanel">
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <li role="presentation" class="active">
            <a href="#repos" aria-controls="repos" role="tab" data-toggle="tab">Repos</a>
        </li>
        <li role="presentation">
            <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="repos">
            <sc-account inline-template>
                @include('account.repos')
            </sc-account>
        </div>
        <div role="tabpanel" class="tab-pane" id="profile">
            @include('account.profile')
        </div>
    </div>
</div>
@stop
