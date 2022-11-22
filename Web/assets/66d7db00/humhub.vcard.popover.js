/*
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */


humhub.module('vcard.popover', function (module, require, $) {

    var additions = require('ui.additions');
    var client = require('client');

    var vCardDelayTimer;


    module.initOnPjaxLoad = true;

    function init(pjax) {
        $('.vcardPopover').remove();

        if (pjax) {
            return;
        }

        $(document).on('mouseenter', '[data-contentcontainer-id],[data-contentcontainer-guid]', function () {

            if(ignoreElement(this)) {
                return;
            }

            var trigger = this;
            var selector = '#' + getVCardId(trigger);
            clearTimeout(vCardDelayTimer);
            vCardDelayTimer = setTimeout(function () {
                if (!$(selector).length) {
                    createPopover(trigger)
                } else {
                    showPopOver(trigger, $(selector).html());
                }
            }, module.config.delay);
        });

        $(document).on('mouseleave', '[data-contentcontainer-id],[data-contentcontainer-guid]', function () {
            if(ignoreElement(this)) {
                return;
            }

            clearTimeout(vCardDelayTimer);

            var $this = $(this);
            setTimeout(function () {
                if (!$('.popover:hover').length) {
                    $this.popover('hide');
                }
            }, 300);
        });
    }

    function ignoreElement(elem)
    {
        return $(elem).closest('#user-account-image, #space-menu-dropdown, #space-menu, .profile-user-photo-container').length;
    }

    function getVCardId(trigger) {
        var contentContainerId = $(trigger).data('contentcontainer-id');
        var contentContainerGuid = $(trigger).data('contentcontainer-guid');
        return 'vCard' + (contentContainerId || contentContainerGuid);
    }

    function createPopover(trigger) {
        var $trigger = $(trigger);
        var vCardId = getVCardId(trigger);
        var contentContainerId = $trigger.data('contentcontainer-id');
        var contentContainerGuid = $trigger.data('contentcontainer-guid');


        $("body").append('<div id="' + vCardId + '" class="hidden"></div>');

        var data = {
            guid: contentContainerGuid,
            id: contentContainerId
        };

        client.post(module.config.loadUrl, {data: data}).then(function (response) {
            if (response.html) {
                $("#" + vCardId).html(response.html);
                showPopOver(trigger, response.html);
            }
        }).catch(function (e) {
            module.log.error(e);
        });
    }

    function showPopOver(trigger, content) {
        var $trigger = $(trigger);
        var $content = $(content);

        var $popover = $trigger.popover({
            trigger: 'manual',
            html: true,
            placement: 'auto left',
            container: 'body',
            content: content,
            animation: true
        }).data('bs.popover').tip().addClass('vcardPopover');

        $trigger.popover('show');

        // Popover seems to get rid of inline styles, so we replace the content
        $popover.find('.vcardContent').replaceWith($content.find('.vcardContent'));

        // Make sure the image itself is not a popover target
        $popover.find('[data-contentcontainer-id]').removeAttr('data-contentcontainer-id');

        $('.vcardPopover').one('mouseleave', function () {
            $trigger.popover('hide');
        });
    }

    module.export({
        init: init
    });

});

