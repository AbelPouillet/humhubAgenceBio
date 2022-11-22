/**
 * This module provides an api for handling content objects e.g. Posts, Polls...
 *
 * @type undefined|Function
 */

humhub.module('type.chooser', function (module, require, $) {
    var event = require('event');
    var type = require('type');
    var client = require('client');
    var ui = require('ui');
    var Widget = ui.widget.Widget;
    var object = require('util').object;
    var pjax = require('client.pjax');
    var additions = require('ui.additions');
    var user = require('user');
    var view = require('ui.view');

    var SELECTOR_ITEM = '[data-type-chooser-item]';
    var SELECTOR_ITEM_REMOTE = '[data-type-none],[data-type-archived]';

    var TypeChooser = Widget.extend();

    TypeChooser.prototype.init = function () {
        this.$menu = $('#type-menu');
        this.$chooser = $('#type-menu-types');
        this.$search = $('#type-menu-search');
        this.$remoteSearch = $('#type-menu-remote-search');


        if(view.isLarge()) {
            // set niceScroll to TypeChooser menu
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
        this.initTypeSearch();
    };

    TypeChooser.prototype.initEvents = function () {
        this.lazyLoad = module.config.lazyLoad && !this.hasItems();

        var that = this;

        $('[data-type-guid]').find('[data-message-count]').each(function () {
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

        // Set no type icon for non type views and set type icon for type views.
        event.on('humhub:ready', function () {
            if (!type.isTypePage()) {
                that.setNoType();
            }
        }).on('humhub:type:changed', function (evt, options) {
            that.setType(options);
        }).on('humhub:type:archived', function (evt, type) {
            that.removeItem(type);
        }).on('humhub:type:unarchived', function (evt, type) {
            that.prependItem(type);
        }).on('humhub:modules:content:live:NewContent', function (evt, liveEvents) {
            that.handleNewContent(liveEvents);
        });
    };

    TypeChooser.prototype.handleNewContent = function (liveEvents) {
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

    TypeChooser.prototype.incrementMessageCount = function (guid, count) {
        var $messageCount = $('[data-type-guid="' + guid + '"]').find('[data-message-count]');
        var newCount = $messageCount.data('message-count') + count;

        $messageCount.hide().text(newCount).data('message-count', newCount);
        setTimeout(function () {
            $messageCount.show();
        }, 100);
    };

    TypeChooser.prototype.prependItem = function (type) {
        if (!this.findItem(type).length) {
            var $type = $(type.output);
            this.$chooser.prepend($type);
            additions.applyTo($type);
        }
    };

    TypeChooser.prototype.appendItem = function (type) {
        if (!this.findItem(type).length) {
            var $type = $(type.output);
            this.$chooser.append($type);
            additions.applyTo($type);
        }
    };

    TypeChooser.prototype.findItem = function (type) {
        var guid = object.isString(type) ? type : type.guid;
        return this.$.find('[data-type-guid="' + guid + '"]');
    };

    TypeChooser.prototype.removeItem = function (type) {
        var guid = object.isString(type) ? type : type.guid;
        this.getItems().filter('[data-type-guid="' + guid + '"]').remove();
    };

    TypeChooser.prototype.initTypeSearch = function () {
        var that = this;

        $('#type-search-reset').click(function () {
            that.resetSearch();
        });

        $('#type-directory-link').on('click', function () {
            that.$menu.trigger('click');
        });

        this.$search.on('keyup', function (event) {
            var $selection = that.getSelectedItem();
            switch (event.keyCode) {
                case 40: // Down -> select next
                    if (!$selection.length) {
                        TypeChooser.selectItem(that.getFirstItem());
                    } else if ($selection.nextAll(SELECTOR_ITEM + ':visible').length) {
                        TypeChooser.deselectItem($selection)
                                .selectItem($selection.nextAll(SELECTOR_ITEM + ':visible').first());
                    }
                    break;
                case 38: // Up -> select previous
                    if ($selection.prevAll(SELECTOR_ITEM + ':visible').length) {
                        TypeChooser.deselectItem($selection)
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
            $('#type-directory-link').addClass('focus');
        }).on('blur', function () {
            $('#type-directory-link').removeClass('focus');
        });
    };

    TypeChooser.prototype.triggerSearch = function () {
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
            $('#type-search-reset').fadeIn('fast');
        }

        // Filter all existing items and highlight text
        this.filterItems(input);
        this.highlight(input);

        this.triggerRemoteSearch(input);
    };

    TypeChooser.prototype.filterItems = function (input) {
        this.clearSelection();
        this.$search.data('last-search', input);

        // remove max-height property to hide the nicescroll scrollbar in case of search input
        this.$chooser.css('max-height', ((input) ? 'none' : '400px'));

        this.getItems().each(function () {
            var $item = $(this);
            var itemText = $item.text().toLowerCase();

            // Show only type items where a keyword is searched
            if (itemText.search(input) >= 0) {
                $item.show();
                // Display type tags only if a keyword is searched inside the tags
                var $typeTags = $item.find('.type-tags');
                if ($typeTags.length) {
                    $typeTags.toggle($typeTags.text().toLowerCase().search(input) >= 0);
                }
            } else {
                $item.hide();
            }
        });

        // Select the first item if search was successful
        TypeChooser.selectItem(this.getFirstItem());
    };

    TypeChooser.prototype.highlight = function (input, selector) {
        selector = selector || SELECTOR_ITEM;
        this.$chooser.find(SELECTOR_ITEM).removeHighlight().highlight(input);
    };

    TypeChooser.prototype.triggerRemoteSearch = function (input) {
        var that = this;

        this.remoteSearch(input).then(function (data) {
            if (data === true) { //Outdated result, just ignore this...
                return;
            } else if (!data) {
                that.onChange(input);
                return;
            }

            $.each(data, function (index, type) {
                that.appendItem(type);
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

    TypeChooser.prototype.remoteSearch = function (input) {
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
                reject('Could not execute type remote search, set data-type-search-url in your type search input');
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
    TypeChooser.prototype.clearRemoteSearch = function (input) {
        // Clear all non member and non following types
        this.$chooser.find(SELECTOR_ITEM_REMOTE).each(function () {
            var $this = $(this);
            if (!input || !input.length || $this.find('.type-name').text().toLowerCase().search(input) < 0) {
                $this.remove();
            }
        });
    };

    TypeChooser.prototype.resetSearch = function () {
        $('#type-search-reset').fadeOut('fast');
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

    TypeChooser.prototype.onChange = function (input) {
        if (!this.lazyLoad) {
            this.showMessage(input);
        }

        this.trigger('changed', input);
    };

    TypeChooser.prototype.showMessage = function (input){
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

    TypeChooser.prototype.clearSelection = function () {
        return this.getSelectedItem().removeClass('selected');
    };

    TypeChooser.prototype.getFirstItem = function () {
        return this.$chooser.find('[data-type-chooser-item]:visible').first();
    };

    TypeChooser.prototype.hasItems = function () {
        return this.$chooser.find('[data-type-chooser-item]').length > 0;
    };

    TypeChooser.selectItem = function ($item) {
        $item.addClass('selected');
        return TypeChooser;
    };

    TypeChooser.deselectItem = function ($item) {
        $item.removeClass('selected');
        return TypeChooser;
    };

    /**
     * Resets the type chooser icon, if no type view is set.
     *
     * @returns {undefined}
     */
    TypeChooser.prototype.setNoType = function () {
        if (!this.$menu.find('.no-type').length) {
            this._changeMenuButton(module.config.noType);
        }
    };

    /**
     * Changes the type chooser icon, for the given type options.
     *
     * @param {type} typeOptions
     * @returns {undefined}
     */
    TypeChooser.prototype.setType = function (type) {
        this.setTypeMessageCount(type, 0);
        this._changeMenuButton(type.image + ' <b class="caret"></b>');
    };

    TypeChooser.prototype.setTypeMessageCount = function (type, count) {
        var guid = object.isString(type) ? type : type.guid;
        var $messageCount = $('[data-type-guid="' + guid + '"]').find('[data-message-count]');
        if ($messageCount.length) {
            if (count) {
                $messageCount.text(count);
            } else {
                $messageCount.fadeOut('fast');
            }
        }
    };

    TypeChooser.prototype._changeMenuButton = function (newButton) {
        var $newTitle = (newButton instanceof $) ? newButton : $(newButton);
        var $oldTitle = this.$menu.children();
        this.$menu.append($newTitle.hide());
        ui.additions.switchButtons($oldTitle, $newTitle, {remove: true});
    };

    TypeChooser.prototype.getSelectedItem = function () {
        return this.$.find('[data-type-chooser-item].selected');
    };

    TypeChooser.prototype.getItems = function () {
        return this.$.find('[data-type-chooser-item]');
    };

    module.export({
        TypeChooser: TypeChooser,
        init: function () {
            TypeChooser.instance($('#type-menu-dropdown'));
        }
    });
});
