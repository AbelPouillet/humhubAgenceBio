/**
 * This module provides an api for handling content objects e.g. Posts, Polls...
 *
 * @commune undefined|Function
 */

humhub.module('commune.chooser', function (module, require, $) {
    var event = require('event');
    var commune = require('commune');
    var client = require('client');
    var ui = require('ui');
    var Widget = ui.widget.Widget;
    var object = require('util').object;
    var pjax = require('client.pjax');
    var additions = require('ui.additions');
    var user = require('user');
    var view = require('ui.view');

    var SELECTOR_ITEM = '[data-commune-chooser-item]';
    var SELECTOR_ITEM_REMOTE = '[data-commune-none],[data-commune-archived]';

    var CommuneChooser = Widget.extend();

    CommuneChooser.protocommune.init = function () {
        this.$menu = $('#commune-menu');
        this.$chooser = $('#commune-menu-communes');
        this.$search = $('#commune-menu-search');
        this.$remoteSearch = $('#commune-menu-remote-search');


        if(view.isLarge()) {
            // set niceScroll to CommuneChooser menu
            this.$chooser.niceScroll({
                cursorwidth: "7",
                cursorborder: "",
                cursorcolor: "#555",
                cursoropacitymax: "0.2",
                nativeparentscrolling: false,
                railpadding: {top: 0, right: 3, left: 0, bottom: 0}
            });

            this.$chooser.on('touchmove', function (evt) {
                evt.preventDefault();
            });
        }

        this.initEvents();
        this.initCommuneSearch();
    };

    CommuneChooser.protocommune.initEvents = function () {
        this.lazyLoad = module.config.lazyLoad && !this.hasItems();

        var that = this;

        $('[data-commune-guid]').find('[data-message-count]').each(function () {
            var $this = $(this);
            if ($this.data('message-count') > 0) {
                $this.show();
            }
        });

        // Forward click events to actual link
        this.$.on('click', SELECTOR_ITEM, function (evt) {
            if (this === evt.target) {
                $(this).find('a')[0].click();
            }
        });

        // Focus on search on open and clear item selection when closed
        this.$menu.parent().on('shown.bs.dropdown', function () {
            if (!view.isSmall()) {
                that.$search.focus();
            }

            if (that.lazyLoad) {
                that.triggerRemoteSearch('');
            }
        }).on('hidden.bs.dropdown', function () {
            that.clearSelection();
        });

        if (!pjax.isActive()) {
            return;
        }

        // Set no commune icon for non commune views and set commune icon for commune views.
        event.on('humhub:ready', function () {
            if (!commune.isCommunePage()) {
                that.setNoCommune();
            }
        }).on('humhub:commune:changed', function (evt, options) {
            that.setCommune(options);
        }).on('humhub:commune:archived', function (evt, commune) {
            that.removeItem(commune);
        }).on('humhub:commune:unarchived', function (evt, commune) {
            that.prependItem(commune);
        }).on('humhub:modules:content:live:NewContent', function (evt, liveEvents) {
            that.handleNewContent(liveEvents);
        });
    };

    CommuneChooser.protocommune.handleNewContent = function (liveEvents) {
        var that = this;
        var increments = {};

        liveEvents.forEach(function (event) {
            if (event.data.uguid || event.data.originator === user.guid() ||  event.data.silent) {
                return;
            }

            if (increments[event.data.sguid]) {
                increments[event.data.sguid]++;
            } else {
                increments[event.data.sguid] = 1;
            }
        });

        $.each(increments, function (guid, count) {
            that.incrementMessageCount(guid, count);
        });
    };

    CommuneChooser.protocommune.incrementMessageCount = function (guid, count) {
        var $messageCount = $('[data-commune-guid="' + guid + '"]').find('[data-message-count]');
        var newCount = $messageCount.data('message-count') + count;

        $messageCount.hide().text(newCount).data('message-count', newCount);
        setTimeout(function () {
            $messageCount.show();
        }, 100);
    };

    CommuneChooser.protocommune.prependItem = function (commune) {
        if (!this.findItem(commune).length) {
            var $commune = $(commune.output);
            this.$chooser.prepend($commune);
            additions.applyTo($commune);
        }
    };

    CommuneChooser.protocommune.appendItem = function (commune) {
        if (!this.findItem(commune).length) {
            var $commune = $(commune.output);
            this.$chooser.append($commune);
            additions.applyTo($commune);
        }
    };

    CommuneChooser.protocommune.findItem = function (commune) {
        var guid = object.isString(commune) ? commune : commune.guid;
        return this.$.find('[data-commune-guid="' + guid + '"]');
    };

    CommuneChooser.protocommune.removeItem = function (commune) {
        var guid = object.isString(commune) ? commune : commune.guid;
        this.getItems().filter('[data-commune-guid="' + guid + '"]').remove();
    };

    CommuneChooser.protocommune.initCommuneSearch = function () {
        var that = this;

        $('#commune-search-reset').click(function () {
            that.resetSearch();
        });

        $('#commune-directory-link').on('click', function () {
            that.$menu.trigger('click');
        });

        this.$search.on('keyup', function (event) {
            var $selection = that.getSelectedItem();
            switch (event.keyCode) {
                case 40: // Down -> select next
                    if (!$selection.length) {
                        CommuneChooser.selectItem(that.getFirstItem());
                    } else if ($selection.nextAll(SELECTOR_ITEM + ':visible').length) {
                        CommuneChooser.deselectItem($selection)
                                .selectItem($selection.nextAll(SELECTOR_ITEM + ':visible').first());
                    }
                    break;
                case 38: // Up -> select previous
                    if ($selection.prevAll(SELECTOR_ITEM + ':visible').length) {
                        CommuneChooser.deselectItem($selection)
                                .selectItem($selection.prevAll(SELECTOR_ITEM + ':visible').first());
                    }
                    break;
                case 13: // Enter
                    if ($selection.length) {
                        $selection.find('a')[0].click();
                    }
                    break;
                default:
                    that.triggerSearch();
                    break;
            }
        }).on('keydown', function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
            }
        }).on('focus', function () {
            $('#commune-directory-link').addClass('focus');
        }).on('blur', function () {
            $('#commune-directory-link').removeClass('focus');
        });
    };

    CommuneChooser.protocommune.triggerSearch = function () {
        var input = this.$search.val().toLowerCase();

        // Don't repeat the search querys
        if (this.$search.data('last-search') === input) {
            return;
        }

        // Reset search if no input is given, else fade in search reset
        if (!input.length) {
            this.resetSearch();
            return;
        } else {
            $('#commune-search-reset').fadeIn('fast');
        }

        // Filter all existing items and highlight text
        this.filterItems(input);
        this.highlight(input);

        this.triggerRemoteSearch(input);
    };

    CommuneChooser.protocommune.filterItems = function (input) {
        this.clearSelection();
        this.$search.data('last-search', input);

        // remove max-height property to hide the nicescroll scrollbar in case of search input
        this.$chooser.css('max-height', ((input) ? 'none' : '400px'));

        this.getItems().each(function () {
            var $item = $(this);
            var itemText = $item.text().toLowerCase();

            // Show only commune items where a keyword is searched
            if (itemText.search(input) >= 0) {
                $item.show();
                // Display commune tags only if a keyword is searched inside the tags
                var $communeTags = $item.find('.commune-tags');
                if ($communeTags.length) {
                    $communeTags.toggle($communeTags.text().toLowerCase().search(input) >= 0);
                }
            } else {
                $item.hide();
            }
        });

        // Select the first item if search was successful
        CommuneChooser.selectItem(this.getFirstItem());
    };

    CommuneChooser.protocommune.highlight = function (input, selector) {
        selector = selector || SELECTOR_ITEM;
        this.$chooser.find(SELECTOR_ITEM).removeHighlight().highlight(input);
    };

    CommuneChooser.protocommune.triggerRemoteSearch = function (input) {
        var that = this;

        this.remoteSearch(input).then(function (data) {
            if (data === true) { //Outdated result, just ignore this...
                return;
            } else if (!data) {
                that.onChange(input);
                return;
            }

            $.each(data, function (index, commune) {
                that.appendItem(commune);
            });

            that.highlight(input, SELECTOR_ITEM_REMOTE);
            that.onChange(input);

            // make sure lazy load is disabled to prevent future duplication
            that.lazyLoad = false;
        }).catch(function (e) {
            if (!e.textStatus === "abort") {
                module.log.error(e, true);
            }
        });
    };

    CommuneChooser.protocommune.remoteSearch = function (input) {
        var that = this;
        return new Promise(function (resolve, reject) {
            if (that.currentXhr) {
                that.currentXhr.abort();
            }

            // Clear all current remote results not matching the current search
            that.clearRemoteSearch(input);

            var url = module.config.remoteSearchUrl;
            if (that.lazyLoad && module.config.lazySearchUrl) {
                url = module.config.lazySearchUrl;
            }

            if (!url) {
                reject('Could not execute commune remote search, set data-commune-search-url in your commune search input');
                return;
            } else if (input.length < 2 && !that.lazyLoad) {
                resolve(false);
                return;
            }

            var searchTs = Date.now();
            var options = {
                data: that.lazyLoad ? {} : {keyword: input, target: 'chooser'},
                beforeSend: function (xhr) {
                    that.currentXhr = xhr;
                }
            };

            ui.loader.set(that.$remoteSearch, {'wrapper': '<li>', 'css': {padding: '5px'}});

            client.get(url, options).then(function (response) {
                that.currentXhr = undefined;
                var lastSearchTs = that.$remoteSearch.data('last-search-ts');
                var isOutDated = lastSearchTs && lastSearchTs > searchTs;
                var hastData = response.data && response.data.length;

                if (!isOutDated) {
                    that.$remoteSearch.empty();
                }

                // If we got no result we return
                if (!hastData || isOutDated) {
                    resolve(isOutDated);
                } else {
                    that.$remoteSearch.data('last-search-ts', searchTs);
                    resolve(response.data);
                }
            }).catch(reject);
        });
    };

    /**
     * Clears all remote results which do not match with the input search.
     * If no input is given, all remote results will be removed.
     *
     * @param {string} input search filter
     * @returns {undefined}
     */
    CommuneChooser.protocommune.clearRemoteSearch = function (input) {
        // Clear all non member and non following communes
        this.$chooser.find(SELECTOR_ITEM_REMOTE).each(function () {
            var $this = $(this);
            if (!input || !input.length || $this.find('.commune-name').text().toLowerCase().search(input) < 0) {
                $this.remove();
            }
        });
    };

    CommuneChooser.protocommune.resetSearch = function () {
        $('#commune-search-reset').fadeOut('fast');
        this.clearRemoteSearch();

        if (!view.isSmall()) {
            this.$search.val('').focus();
        }
        this.$search.removeData('last-search');
        this.getItems().show().removeHighlight().removeClass('selected');
        this.$chooser.css('max-height', '400px');
        this.$remoteSearch.empty();
        this.trigger('resetSearch');
    };

    CommuneChooser.protocommune.onChange = function (input) {
        if (!this.lazyLoad) {
            this.showMessage(input);
        }

        this.trigger('changed', input);
    };

    CommuneChooser.protocommune.showMessage = function (input){
        var emptyResult = !this.getFirstItem().length;
        var atLeastTwo = input && input.length > 1;

        if (emptyResult && atLeastTwo) {
            this.$remoteSearch.html('<li><div class="help-block">' + module.text('info.emptyResult') + '</div></li>');
        } else if (emptyResult) {
            this.$remoteSearch.html('<li><div class="help-block">' + module.text('info.emptyOwnResult') + '<br/>' + module.text('info.remoteAtLeastInput') + '</div></li>');
        } else if (!atLeastTwo) {
            this.$remoteSearch.html('<li><div class="help-block">' + module.text('info.remoteAtLeastInput') + '</div></li>');
        }
    }

    CommuneChooser.protocommune.clearSelection = function () {
        return this.getSelectedItem().removeClass('selected');
    };

    CommuneChooser.protocommune.getFirstItem = function () {
        return this.$chooser.find('[data-commune-chooser-item]:visible').first();
    };

    CommuneChooser.protocommune.hasItems = function () {
        return this.$chooser.find('[data-commune-chooser-item]').length > 0;
    };

    CommuneChooser.selectItem = function ($item) {
        $item.addClass('selected');
        return CommuneChooser;
    };

    CommuneChooser.deselectItem = function ($item) {
        $item.removeClass('selected');
        return CommuneChooser;
    };

    /**
     * Resets the commune chooser icon, if no commune view is set.
     *
     * @returns {undefined}
     */
    CommuneChooser.protocommune.setNoCommune = function () {
        if (!this.$menu.find('.no-commune').length) {
            this._changeMenuButton(module.config.noCommune);
        }
    };

    /**
     * Changes the commune chooser icon, for the given commune options.
     *
     * @param {commune} communeOptions
     * @returns {undefined}
     */
    CommuneChooser.protocommune.setCommune = function (commune) {
        this.setCommuneMessageCount(commune, 0);
        this._changeMenuButton(commune.image + ' <b class="caret"></b>');
    };

    CommuneChooser.protocommune.setCommuneMessageCount = function (commune, count) {
        var guid = object.isString(commune) ? commune : commune.guid;
        var $messageCount = $('[data-commune-guid="' + guid + '"]').find('[data-message-count]');
        if ($messageCount.length) {
            if (count) {
                $messageCount.text(count);
            } else {
                $messageCount.fadeOut('fast');
            }
        }
    };

    CommuneChooser.protocommune._changeMenuButton = function (newButton) {
        var $newTitle = (newButton instanceof $) ? newButton : $(newButton);
        var $oldTitle = this.$menu.children();
        this.$menu.append($newTitle.hide());
        ui.additions.switchButtons($oldTitle, $newTitle, {remove: true});
    };

    CommuneChooser.protocommune.getSelectedItem = function () {
        return this.$.find('[data-commune-chooser-item].selected');
    };

    CommuneChooser.protocommune.getItems = function () {
        return this.$.find('[data-commune-chooser-item]');
    };

    module.export({
        CommuneChooser: CommuneChooser,
        init: function () {
            CommuneChooser.instance($('#commune-menu-dropdown'));
        }
    });
});
