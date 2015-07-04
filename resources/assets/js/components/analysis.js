var Analysis = Vue.extend({
    created: function() {
        SyntaxHighlighter.defaults.toolbar = false;
        SyntaxHighlighter.defaults.gutter = false;
    },
    ready: function() {
        $('#download-diff').hide();
        $('#view-diff').hide();
        $('#status-buttons').removeClass('hide');
        this.analysisId = $('#analysis').data('id');
        this.getResults();
        this.subscribe();
    },
    methods: {
        getResults: function() {
            var self = this;
            var results = $('#results');
            var url = StyleCI.globals.base_url + '/api/analyses/' + self.analysisId;

            self.isLoading = true;

            self.isLoading = true;

            return $.get(url)
                .done(function(response) {
                    if (response.toString().indexOf('changed files') >= 0) {
                        $('#download-diff').show();
                        $('#view-diff').show();
                        $('#results').html(response);
                        SyntaxHighlighter.all();
                    } else {
                        $('#download-diff').hide();
                        $('#view-diff').hide();
                    }
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    self.isLoading = false;
                });
        },
        AnalysisStatusChangeEventHandler: function(data) {
            if ($('#analysis').length) {
                var status = $('p.js-status');

                status.html('<i class="' + data.event.icon + '"></i> ' + data.event.description);

                if (data.event.status === 2) {
                    status.css('color', 'green');
                } else if (data.event.status > 2) {
                    status.css('color', 'red');
                    this.getResults();
                } else {
                    status.css('color', 'grey');
                }
            }
        },
        subscribe: function() {
            var self = this;
            StyleCI.RealTime.getChannel('analysis-' + self.analysisId).bind(
                'AnalysisStatusUpdatedEvent',
                self.AnalysisStatusChangeEventHandler
            );
        }
    },
    data: function() {
        return {
            analysisId: false,
            isLoading: false,
            search: '',
            repos: []
        };
     }
});

Vue.component('sc-analysis', Analysis);
