$(function() {
    // App setup
    window.StyleCI = {};

    var fuse;

    // Global Ajax Setup
    $.ajaxPrefilter(function(options, originalOptions, jqXHR) {

        if (! options.beforeSend) {
            options.beforeSend = function (xhr) {
                jqXHR.setRequestHeader('Accept', 'application/json; charset=utf-8');
                jqXHR.setRequestHeader('Content-Type', 'application/json');
            };
        }

        var token;
        if (! options.crossDomain) {
            token = $('meta[name="styleci:token"]').attr('content');
            if (token) {
                jqXHR.setRequestHeader('X-CSRF-Token', token);
            }
        }

        return jqXHR;
    });

    $.ajaxSetup({
        statusCode: {
            401: function () {
                (new StyleCI.Notifier()).notify('Your session has expired, please login.');
            },
            403: function () {
                (new StyleCI.Notifier()).notify('Your session has expired, please login.');
            }
        }
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('.js-time-ago').timeago();

    function makeRequest (method, target) {
        if (method === 'GET') {
            window.location.href = target;
            return;
        }

        var token = $('meta[name="styleci:token"]').attr('content');

        var  methodForm = '\n';
        methodForm += '<form action="' + target + '" method="POST" style="display:none">\n';
        methodForm += '<input type="hidden" name="_method" value="' + method + '">\n';
        methodForm += '<input type="hidden" name="_token" value="' + token + '">\n';
        methodForm += '</form>\n';

        $(methodForm).appendTo('body').submit();
    }

    $('[data-method]')
        .not('.disabled')
        .click(function(e) {
            e.preventDefault();

            var $a = $(this);

            if ($a.data('method') === undefined) return;

            if ($a.hasClass('js-confirm-action')) {
                if (confirm('Are you sure you want to do this?')) {
                    makeRequest($a.data('method'), $a.attr('href'));
                }
            } else {
                makeRequest($a.data('method'), $a.attr('href'));
            }

        });

    StyleCI.globals = {
        host: window.location.host,
        base_url: window.location.protocol + '//' + window.location.host,
        url: document.URL,
        user: $('meta[name="styleci:user"]').attr('content'),
        repos: []
    };

    StyleCI.Events = {};
    StyleCI.Listeners = {};

    StyleCI.Notifier = function () {
        this.notify = function (message, type, options) {
            type = (typeof type === 'undefined' || type === 'error') ? 'danger' : type;
            var $alertsHolder = $('.alerts');

            var defaultOptions = {
                dismiss: false,
            };

            options = _.extend(defaultOptions, options);

            var alertTpl = _.template('<div class="alert alert-<%= type %> styleci-alert"><div class="container"><a class="close" data-dismiss="alert">×</a><%= message %></div></div>');
            $alertsHolder.html(alertTpl({message: message, type: type}));

            $('html, body').animate({
                scrollTop: $('body').offset().top
            }, 500);
        };
    };

    StyleCI.Events.RealTime = (function () {
        var instance;

        function createInstance() {
            return new Pusher($('meta[name="styleci:pusher"]').attr('content'));
        }

        return {
            getInstance: function () {
                if (! instance) {
                    instance = createInstance();
                }
                return instance;
            },
            getChannel: function(ch) {
                return this.getInstance().subscribe(ch);
            }
        };
    })();

    StyleCI.Listeners.Repos = {
        RepoStatusChangeEventHandler: function(data) {
            var $repo = $('#js-repo-' + data.event.repo_id);

            // The commit is displayed on this page.
            if ($repo.length) {
                var $status = $repo.find('p.js-status');

                $status.html('<strong>' + data.event.summary + '</strong>');

                if (data.event.status === 1) {
                    $status.css('color', 'green');
                } else if (data.event.status === 2 || data.event.status === 3) {
                    $status.css('color', 'red');
                } else {
                    $status.css('color', 'grey');
                }
            }
        },
        RepoWasDisabledEventHandler: function(data) {
            $('#js-repo-' + data.event.id).remove();
        },
        RepoWasEnabledEventHandler: function(data) {
            var $repo = $('#js-repo-' + data.event.id);

            // The repo is not displayed on this page so we refresh.
            if (! $repo.length) {
                var $tpl = $('#repos-template'),
                    $reposHolder = $('.repos');

                $.get(StyleCI.globals.url)
                    .done(function(response) {
                        var reposTpl = _.template($tpl.html());
                        $reposHolder.empty();
                        _.forEach(response.data, function(item) {
                            $reposHolder.append(reposTpl({repo: item}));
                        });
                    })
                    .fail(function(response) {
                        (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                    });
            }
        }
    };

    StyleCI.Listeners.Repo = {
        CommitsStatusChangeEventHandler: function(data) {
            var $commit = $('#js-commit-' + data.event.shorthandId);

            // The commit is displayed on this page.
            if ($commit.length) {
                var $status = $commit.find('p.js-status');

                $status.html('<strong>' + data.event.summary + '</strong>');

                $commit.removeClass('bg-success')
                    .removeClass('bg-danger')
                    .removeClass('bg-active');

                if (data.event.status === 1) {
                    $status.css('color', 'green');
                    $commit.addClass('bg-success');
                } else if (data.event.status > 1) {
                    $status.css('color', 'red');
                    $commit.addClass('bg-danger');
                } else {
                    $status.css('color', 'grey');
                    $commit.addClass('bg-active');
                }
            } else {
                // We should reload all data again if not found
                var $tpl = $('#commit-template'),
                    $tableHeaders = $('.repo-table-headers'),
                    $commitsHolder = $('.commits');

                $tableHeaders.removeClass('hidden');

                $.get(StyleCI.globals.url)
                    .done(function(response) {
                        var commitsTpl = _.template($tpl.html());
                        $commitsHolder.empty();
                        _.forEach(response.data, function(item) {
                            $commitsHolder.append(commitsTpl({commit: item}));
                        });
                        $commitsHolder.find('.js-time-ago').timeago();
                    })
                    .fail(function(response) {
                        (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                    });
            }
        },
    };

    StyleCI.Listeners.Commit = {
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
        }
    };

    StyleCI.Repos = {
        RealTimeStatus: function() {
            if (typeof StyleCI.globals.user === 'undefined') {
                return;
            }

            StyleCI.Events.RealTime.getChannel('repos-' + StyleCI.globals.user)
                .bind('CommitStatusUpdatedEvent',
                    StyleCI.Listeners.Repos.RepoStatusChangeEventHandler
                )
                .bind('RepoWasDisabledEvent',
                    StyleCI.Listeners.Repos.RepoWasDisabledEventHandler
                )
                .bind('RepoWasEnabledEvent',
                    StyleCI.Listeners.Repos.RepoWasEnabledEventHandler
                );
        },
    };

    StyleCI.Repo = {
        RealTimeStatus: function() {
            StyleCI.Events.RealTime.getChannel('ch-' + $('.js-channel').data('channel')).bind(
                'CommitStatusUpdatedEvent',
                StyleCI.Listeners.Repo.CommitsStatusChangeEventHandler
            );
        },
        AnalyseCommit: function(btn) {
            btn.button('loading');

            return $.post(btn.attr('href'))
                .done(function(response) {
                    if (response.queued) {
                        (new StyleCI.Notifier()).notify('The repository has been queued for analysis.', 'success');
                        var $tpl = $('#commit-template'),
                            $tableHeaders = $('.repo-table-headers'),
                            $commitsHolder = $('.commits');

                        $tableHeaders.removeClass('hidden');

                        $.get(StyleCI.globals.url)
                            .done(function(response) {
                                var commitsTpl = _.template($tpl.html());
                                $commitsHolder.empty();
                                _.forEach(response.data, function(item) {
                                    $commitsHolder.append(commitsTpl({commit: item}));
                                });
                                $commitsHolder.find('.js-time-ago').timeago();
                            })
                            .fail(function(response) {
                                (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                            });
                    }
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    btn.button('reset').blur();
                });
        }
    };

    StyleCI.Commit = {
        RealTimeStatus: function() {
            StyleCI.Events.RealTime.getChannel('ch-' + $('.js-channel').data('channel')).bind(
                'CommitStatusUpdatedEvent',
                StyleCI.Listeners.Commit.CommitStatusChangeEventHandler
            );
        }
    };

    StyleCI.Account = {
        getRepos: function(url) {
            var $tpl = $('#repos-template'),
                $reposHolder = $('.repos'),
                $loading = $('.loading');

            $loading.show();
            $reposHolder.hide();

            var requestUrl = (typeof url !== 'undefined') ? url : StyleCI.globals.base_url + '/account/repos';

            return $.get(requestUrl)
                .done(function(response) {
                    var sortedData = _.sortBy(response.data, function(repo, key) {
                        repo.id = key;
                        return repo.name.toLowerCase();
                    });
                    handleReposList(sortedData);
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    $loading.hide();
                });
        },
        syncRepos: function(btn) {
            var self = this,
                $reposHolder = $('.repos'),
                $loading = $('.loading');

            btn.button('loading');

            $loading.show();
            $reposHolder.hide();

            return $.post(btn.attr('href'))
                .done(function(response) {
                    $.when(self.getRepos()).then(function() {
                        btn.button('reset').blur();
                    });
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                });
        },
        enableOrDisableRepo: function(btn) {
            var repoId = btn.data('id'),
                $enabledTpl = $('#enabled-repo-template'),
                $disabledTpl = $('#disabled-repo-template'),
                $controlsHolder = btn.closest('.repo-controls');

            btn.button('loading');

            $.post(btn.attr('href'))
                .done(function(response) {
                    if (response.enabled) {
                        var enabledTpl = _.template($enabledTpl.html());
                        $controlsHolder.html(enabledTpl({repo: {id: repoId}}));
                    } else {
                        var disabledTpl = _.template($disabledTpl.html());
                        $controlsHolder.html(disabledTpl({repo: {id: repoId}}));
                    }
                })
                .fail(function(response) {
                    (new StyleCI.Notifier()).notify(response.responseJSON.errors[0].title);
                })
                .always(function() {
                    btn.button('reset');
                });
        }
    };

    $(document.body).on('click', '.js-enable-repo, .js-disable-repo', function(e) {
        e.preventDefault();
        var $a = $(this);

        if ($a.hasClass('js-confirm-action')) {
            if (confirm('Are you sure you want to disable this repository, all analysed data will be lost?')) {
                StyleCI.Account.enableOrDisableRepo($a);
            }
        } else {
            StyleCI.Account.enableOrDisableRepo($a);
        }
        return false;
    });

    $('.js-sync-repos').on('click', function(e) {
        e.preventDefault();
        StyleCI.Account.syncRepos($(this));
        return false;
    });

    $('.js-analyse-repo').on('click', function(e) {
        e.preventDefault();
        StyleCI.Repo.AnalyseCommit($(this));
        return false;
    });

    $('input[name=query]').on('keyup', function () {
        var $this = $(this);

        var r = fuse.search($this.val());

        if ($.trim(r) === '') {
            StyleCI.Account.getRepos();
        } else {
            handleReposList(r);
        }
    });

    function handleReposList(data) {
        var $tpl = $('#repos-template'),
            $reposHolder = $('.repos');

        var reposTpl = _.template($tpl.html());

        $reposHolder.html(reposTpl({repos: data}));
        $reposHolder.show();

        fuse = new Fuse(data, { keys: ["name", "id"] });
    }
});
