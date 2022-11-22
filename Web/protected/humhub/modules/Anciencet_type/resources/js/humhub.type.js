/**
 * This module provides an api for handling content objects e.g. Posts, Polls...
 *
 * @type undefined|Function
 */

humhub.module('type', function (module, require, $) {
    var client = require('client');
    var additions = require('ui.additions');
    var event = require('event');

    // Current type options (guid, image)
    var options;

    var isTypePage = function() {
        return $('.type-layout-container').length > 0;
    };

    var setType = function(typeOptions, pjax) {
        if(!module.options || module.options.guid !== typeOptions.guid) {
            module.options = typeOptions;
            if(pjax) {
                event.trigger('humhub:type:changed', $.extend({}, module.options));
            }
        }
    };

    var guid = function() {
        return (options) ? options.guid : null;
    };

    var archive = function(evt) {
        client.post(evt).then(function(response) {
            if(response.success) {
                additions.switchButtons(evt.$trigger, evt.$trigger.siblings('.unarchive'));
                module.log.success('success.archived');
                event.trigger('humhub:type:archived', response.type);
            }
        }).catch(function(err) {
            module.log.error(err, true);
        });
    };

    var unarchive = function(evt) {
        client.post(evt).then(function(response) {
            if(response.success) {
                additions.switchButtons(evt.$trigger, evt.$trigger.siblings('.archive'));
                module.log.success('success.unarchived');

                event.trigger('humhub:type:unarchived', response.type);
            }
        }).catch(function(err) {
            module.log.error(err, true);
        });
    };

    var init = function() {
        if(!module.isTypePage()) {
            module.options = undefined;
        }
    };

    module.export({
        init: init,
        initOnPjaxLoad: true,
        guid: guid,
        archive : archive,
        unarchive : unarchive,
        isTypePage: isTypePage,
        setType: setType
    });
});
