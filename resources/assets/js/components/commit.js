var Commit = Vue.extend({
    created: function() {
        SyntaxHighlighter.defaults.toolbar = false;
        SyntaxHighlighter.defaults.gutter = false;
        SyntaxHighlighter.all();
    },
    ready: function() {
        this.subscribe();
    },
    methods: {
        CommitStatusChangeEventHandler: function(data) {
            var $commit = $('#js-commit-' + data.event.shorthandId);

            // The commit is the one we are looking at.
            if ($commit.length) {
                var $status = $('p.js-status');

                $status.html('<i class="' + data.event.icon + '"></i> ' + data.event.description);

                if (data.event.status === 1) {
                    $status.css('color', 'green');
                } else if (data.event.status > 1) {
                    $status.css('color', 'red');
                } else {
                    $status.css('color', 'grey');
                }
            }
        },
        subscribe: function() {
            var self = this;
            StyleCI.RealTime.getChannel('ch-' + $('.js-channel').data('channel')).bind(
                'CommitStatusUpdatedEvent',
                self.CommitStatusChangeEventHandler
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

Vue.component('sc-commit', Commit);
