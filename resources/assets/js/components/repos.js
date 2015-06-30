var ReposList = Vue.extend({
    ready: function() {
        this.getRepos();
        this.subscribe();
    },
    methods: {
        getRepos: function() {
            var self = this;
            var url = StyleCI.globals.base_url + '/api/repos';

            self.isLoading = true;

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
        RepoStatusChangeEventHandler: function(data) {
            var repo = _.findWhere(this.repos, { 'id': data.event.id });

            repo = data.event;
        },
        RepoWasDisabledEventHandler: function(data) {
            var repo = _.findWhere(this.repos, { 'id': data.event.id });

            this.repos.$remove(repo);
        },
        RepoWasEnabledEventHandler: function(data) {
            this.getRepos();
        },
        subscribe: function() {
            if (typeof StyleCI.globals.user === 'undefined') {
                return;
            }
            var self = this;
            StyleCI.RealTime.getChannel('repos-' + StyleCI.globals.user)
                .bind('AnalysisStatusUpdatedEvent',
                    self.RepoStatusChangeEventHandler
                )
                .bind('RepoWasDisabledEvent',
                    self.RepoWasDisabledEventHandler
                )
                .bind('RepoWasEnabledEvent',
                    self.RepoWasEnabledEventHandler
                );
        }
    },
    data: function() {
        return {
            isLoading: false,
            search: '',
            repos: []
        };
     }
});

Vue.component('sc-repos', ReposList);
