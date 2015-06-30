var RepoList = Vue.extend({
    ready: function() {
        this.repoId = $('#repo').data('id');
        this.getAnalyses();
        this.subscribe();
    },
    methods: {
        getAnalyses: function() {
            var self = this;
            var url = StyleCI.globals.base_url + '/api/repos/' + self.repoId;

            self.isLoading = true;

            return $.get(url)
                .done(function(response) {
                    self.$set('analyses', response.data);
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    self.isLoading = false;
                });
        },
        analyseRepo: function(repo, e) {
            e.preventDefault();
            var self = this;
            var btn = $(e.target);
            var url = StyleCI.globals.base_url + '/api/repos/' + repo.id + '/analyse?branch=' + repo.default_branch;

            btn.button('loading');

            return $.post(url)
                .done(function(response) {
                    if (response.queued) {
                        (new StyleCI.Notifier()).notify('The repository has been queued for analysis.', 'success');
                        self.getAnalyses();
                    }
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    btn.button('reset').blur();
                });
        },
        AnalysisStatusChangeEventHandler: function() {
            var repo = _.findWhere(this.repos, { 'id': data.event.id });

            if (repo) {
                repo = data.event;
            } else {
                this.getAnalyses();
            }
        },
        subscribe: function() {
            var self = this;
            StyleCI.RealTime.getChannel('ch-' + self.repoId).bind(
                'AnalysisStatusUpdatedEvent',
                self.AnalysisStatusChangeEventHandler
            );
        }
    },
    data: function() {
        return {
            repoId: null,
            isLoading: false,
            search: '',
            analyses: []
        };
     }
});

Vue.component('sc-repo', RepoList);
