var Analysis = Vue.extend({
    created: function() {
        SyntaxHighlighter.defaults.toolbar = false;
        SyntaxHighlighter.defaults.gutter = false;
        SyntaxHighlighter.all();
    },
    ready: function() {
        this.subscribe();
    },
    methods: {
        AnalysisStatusChangeEventHandler: function(data) {
            var $analysis = $('#js-analysis-' + data.event.shorthandId);

            // The analysis is the one we are looking at.
            if ($analysis.length) {
                var $status = $('p.js-status');

                $status.html('<i class="' + data.event.icon + '"></i> ' + data.event.description);

                if (data.event.status === 2) {
                    $status.css('color', 'green');
                } else if (data.event.status > 2) {
                    $status.css('color', 'red');
                } else {
                    $status.css('color', 'grey');
                }
            }
        },
        subscribe: function() {
            var self = this;
            StyleCI.RealTime.getChannel('ch-' + $('.js-channel').data('channel')).bind(
                'AnalysisStatusUpdatedEvent',
                self.AnalysisStatusChangeEventHandler
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

Vue.component('sc-analysis', Analysis);
