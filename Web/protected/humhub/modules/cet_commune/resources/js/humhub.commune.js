/**
 * This module provides an api for handling content objects e.g. Posts, Polls...
 *
 * @commune undefined|Function
 */

humhub.module('commune', function (module, require, $) {
    var client = require('client');
    var additions = require('ui.additions');
    var event = require('event');

    // Current commune options (guid, image)
    var options;

    var isCommunePage = function() {
        return $('.commune-layout-container').length > 0;
    };

    var setCommune = function(communeOptions, pjax) {
        if(!module.options || module.options.guid !== communeOptions.guid) {
            module.options = communeOptions;
            if(pjax) {
                event.trigger('humhub:commune:changed', $.extend({}, module.options));
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
                event.trigger('humhub:commune:archived', response.commune);
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

                event.trigger('humhub:commune:unarchived', response.commune);
            }
        }).catch(function(err) {
            module.log.error(err, true);
        });
    };

    var init = function() {
        if(!module.isCommunePage()) {
            module.options = undefined;
        }
    };

    module.export({
        init: init,
        initOnPjaxLoad: true,
        guid: guid,
        archive : archive,
        unarchive : unarchive,
        isCommunePage: isCommunePage,
        setCommune: setCommune
    });
});
