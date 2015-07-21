var ReposList = Vue.extend({
    data: function() {
        return {
            isLoading: true,
            search: '',
            repos: []
        };
    },
    ready: function() {
        $('#repos').removeClass('hide');
        this.getRepos();
        this.subscribe();
    },
    methods: {
        getRepos: function() {
            var self = this;
            var url = StyleCI.globals.base_url + '/api/repos';

            return $.get(url)
                .done(function(response) {
                    self.$set('repos', response.data);
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    self.isLoading = false;
                });
        },
        RepoStatusUpdatedEventHandler: function(data) {
            var index = _.findIndex(this.repos, { 'id': data.event.id });

            if (index) {
                this.repos.$set(index, data.event);
            } else {
                this.getRepos();
            }
        },
        RepoWasDisabledEventHandler: function(data) {
            var repo = _.findWhere(this.repos, { 'id': data.event.id });
            this.repos.$remove(repo);
        },
        RepoWasEnabledEventHandler: function(data) {
            this.getRepos();
        },
        subscribe: function() {
            var self = this;
            StyleCI.Pusher.getChannel('user-' + StyleCI.globals.user)
                .bind('RepoStatusUpdatedEvent', self.RepoStatusUpdatedEventHandler)
                .bind('RepoWasDisabledEvent', self.RepoWasDisabledEventHandler)
                .bind('RepoWasEnabledEvent', self.RepoWasEnabledEventHandler);
        }
    }
});

Vue.component('sc-repos', ReposList);
