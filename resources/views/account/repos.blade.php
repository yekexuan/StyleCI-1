<sc-account inline-template>
    <a class="btn btn-default pull-right" v-on="click: syncRepos" href="{{ route('api_account_repos_sync') }}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Loading...">
        <i class="fa fa-github"></i>
        Sync with GitHub
    </a>
    <h2>Repos</h2>
    <p>We're showing all your <i>public</i> repos we have access to.</p><br>
    <div v-show="isLoading" class="loading text-center">
        <h3><i class="fa fa-circle-o-notch fa-spin"></i> Fetching your repos...</h3>
    </div>
    <form v-show="!isLoading && repos.length" name="search">
        <div class="form-group">
            <label for="query">Filter repos</label>
            <input v-model="search" type="text" name="query" class="form-control" id="query">
        </div>
    </form>
    <div class="repos" v-repeat="repo : repos | filterBy search">
        <hr>
        <div class="row">
            <div class="col-sm-8">
                <h4>@{{ repo.name }}</h4>
                <h5>
                    <span v-show="repo.enabled">StyleCI is currently enabled on this repo.</span>
                    <span v-show="!repo.enabled">StyleCI is currently disabled on this repo.</span>
                </h5>
            </div>
            <div class="col-sm-4 list-vcenter">
                <div class="repo-controls">
                    <div v-show="repo.enabled">
                        <a class="btn btn-primary" href="{{ route('repo', '') }}/@{{ repo.id }}">
                            <i class="fa fa-history"></i> Show Analyses
                        </a>
                        <a class="btn btn-danger" v-on="click: toggleEnableDisableRepo(repo, $event)" href="{{ route('api_disable_repo', '') }}/@{{ repo.id }}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Disabling...">
                            <i class="fa fa-times"></i> Disable StyleCI
                        </a>
                    </div>
                    <div v-show="!repo.enabled">
                        <a class="btn btn-success" v-on="click: toggleEnableDisableRepo(repo, $event)" href="{{ route('api_enable_repo', '') }}/@{{ repo.id }}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Enabling...">
                            <i class="fa fa-check"></i> Enable StyleCI
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p v-show="!isLoading && !repos.length" class="lead">You have no repos we can access.</p>
</sc-account>
