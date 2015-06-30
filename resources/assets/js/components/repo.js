var RepoList = Vue.extend({
    ready: function() {
        this.repoId = $('#repo').data('id');
        this.getCommits();
        this.subscribe();
    },
    methods: {
        getCommits: function() {
            var self = this;
            var url = StyleCI.globals.base_url + '/api/repos/' + self.repoId;

            self.isLoading = true;

            return $.get(url)
                .done(function(response) {
                    self.$set('commits', response.data);
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    self.isLoading = false;
                });
        },
        analyseRepo: function(url, e) {
            var self = this;
            var btn = $(e.target);

            btn.button('loading');

            return $.post(url)
                .done(function(response) {
                    if (response.queued) {
                        (new StyleCI.Notifier()).notify('The repository has been queued for analysis.', 'success');
                        self.getCommits();
                    }
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    btn.button('reset').blur();
                });
        },
        CommitsStatusChangeEventHandler: function() {
            var repo = _.findWhere(this.repos, { 'id': data.event.id });

            if (repo) {
                repo = data.event;
            } else {
                this.getCommits();
            }
        },
        subscribe: function() {
            var self = this;
            StyleCI.RealTime.getChannel('ch-' + self.repoId).bind(
                'CommitStatusUpdatedEvent',
                self.CommitsStatusChangeEventHandler
            );
        }
    },
    data: function() {
        return {
            repoId: null,
            isLoading: false,
            search: '',
            commits: []
        };
     }
});

Vue.component('sc-repo', RepoList);
