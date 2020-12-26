import {jQueryScrollSpot} from './jquery.scrollSpot';

jQueryScrollSpot();

/**
 * Global plugin options object
 *
 * @type {*|{ajax_url: string}}
 *
 * @since 1.0.0
 */
window.DaReactions = DaReactions || {
    ajax_url: ''
};

(function ($) {
    'use strict';

    /**
     * Callback for click on reaction image to save reaction
     *
     * @since 1.0.0
     */
    function clickedReaction() {
        // gets all parameters
        let me = $(this).closest('.da-reactions-data'),
            my_type = $(me).data('type'),
            my_id = $(me).data('id'),
            my_reaction = $(me).data('reaction'),
            my_nonce = $(me).data('nonce') || DaReactions.nonce,
            clicked_image = $(me).find('img'),
            before_reveal_container = me.closest('.da-reactions-reveal').find('.before-reveal'),
            target_image = before_reveal_container.find('img'),
            target_total_count = before_reveal_container.find('.count');


        target_image.attr('src', DaReactions.loader_url);

        removeFromCache('clickedCount', my_type, my_id, my_reaction);
        removeFromCache('mouseOverCount', my_type, my_id, my_reaction);

        // calls ajax service
        $.ajax({
            url: DaReactions.ajax_url,
            method: 'post',
            cache: false,
            data: {
                'action': 'add_reaction',
                'id': my_id,
                'nonce': my_nonce,
                'reaction': my_reaction,
                'type': my_type
            },
            success: function (result) {
                if (result.success === 'ok') {
                    // update classes and labels
                    let foundCurrent = false;
                    let totalScore = 0;
                    if (target_image.length) {
                        target_image.attr('src', clicked_image.attr('src'));
                    }
                    for (let a in result['reactions']) {
                        if (result['reactions'].hasOwnProperty(a)) {
                            let $ico = me.parent().find('.reaction.reaction_' + result['reactions'][a]['ID']);
                            if (result['reactions'][a]['current']) {
                                foundCurrent = true;
                                $ico.addClass('active');
                                $ico.removeClass('inactive');
                            } else {
                                $ico.removeClass('active');
                                $ico.addClass('inactive');
                            }
                            const reactionCount = result['reactions'][a]['total'] || 0;
                            const $countBadge = $ico.find('.count');
                            $countBadge.text(numberFormatter(reactionCount));
                            if (DaReactions.show_count === 'always' || (DaReactions.show_count === 'non-zero' && reactionCount > 0)) {
                                $countBadge.show();
                            } else {
                                $countBadge.hide();
                            }
                            totalScore += +result['reactions'][a]['total'];
                        }
                    }
                    target_total_count.text(numberFormatter(totalScore));
                    if (foundCurrent) {
                        me.closest('.da-reactions-container').addClass('has_current');
                    } else {
                        me.closest('.da-reactions-container').removeClass('has_current');
                    }
                }
            }
        });
    }

    /**
     * Toggle visibility of reactions in modal
     *
     * @param event MouseEvent
     *
     * @since 3.0.0
     */
    function clickedModalToggle(event) {
        event.stopPropagation();
        let myId = $(this).data('id');
        $('#da-reactions-users-modal-background').toggleClass(`viewReaction${myId}`);
    }

    /**
     * Toggle visibility of widget on small screen devices
     *
     * @param event
     *
     * @since 2.0.4
     */
    function clickedToggle(event) {
        event.stopPropagation();
        $(this).parent().toggleClass('open');
    }

    /**
     * Callback for click on count badge, opens details modal
     *
     * @since 3.0.0
     */
    function clickedCount(e) {
        e.stopPropagation();
        removeUserTooltip();
        let my_container = $(this).closest('.da-reactions-data, .da-reactions-container-async.gutenberg-block'),
            my_type = $(my_container).data('type'),
            my_id = $(my_container).data('id'),
            my_nonce = $(my_container).data('nonce') || DaReactions.nonce,
            my_reaction = $(this).data('reaction') || $(my_container).data('reaction') || 0,
            pagenum = $(this).data('pagenum') || 0,
            result = loadFromCache('clickedCount', my_type, my_id, my_reaction, pagenum);
        let data = {
            'action': 'get_users_reactions',
            'type': my_type,
            'id': my_id,
            'nonce': my_nonce,
            'reaction': my_reaction,
            'pagenum': pagenum,
            'limit': parseInt(DaReactions.modal_result_limit, 10)
        };
        if (!result || result.success !== 'ok') {
            $.ajax({
                url: DaReactions.ajax_url,
                method: 'post',
                cache: false,
                data,
                success: function (result) {
                    saveToCache('clickedCount', my_type, my_id, my_reaction, result, pagenum);
                    if (result.success && result.success === 'ok') {
                        showUsersModal(result, data);
                    }
                }
            });
        } else {
            showUsersModal(result, data);
        }
    }

    /**
     * Retrieve cached object to avoid redundant server requests
     *
     * @param prefix
     * @param my_type
     * @param my_id
     * @param my_reaction
     * @returns {{success: string}|*}
     *
     * @since 3.0.0
     */
    function loadFromCache(prefix, my_type, my_id, my_reaction, page) {
        DaReactions.cache = DaReactions.cache || {};
        if (DaReactions.cache.hasOwnProperty(prefix)) {
            DaReactions.cache[prefix] = DaReactions.cache[prefix] || {};
            if (DaReactions.cache[prefix].hasOwnProperty(my_type)) {
                DaReactions.cache[prefix][my_type] = DaReactions.cache[prefix][my_type] || {};
                if (DaReactions.cache[prefix][my_type].hasOwnProperty(my_id)) {
                    DaReactions.cache[prefix][my_type][my_id] = DaReactions.cache[prefix][my_type][my_id] || {};
                    if (DaReactions.cache[prefix][my_type][my_id].hasOwnProperty(my_reaction)) {
                        DaReactions.cache[prefix][my_type][my_id][my_reaction] = DaReactions.cache[prefix][my_type][my_id][my_reaction] || {};
                        if (DaReactions.cache[prefix][my_type][my_id][my_reaction].hasOwnProperty(page)) {
                            DaReactions.cache[prefix][my_type][my_id][my_reaction][page] = DaReactions.cache[prefix][my_type][my_id][my_reaction][page] || {};
                            if (DaReactions.cache[prefix][my_type][my_id][my_reaction][page].hasOwnProperty('success') && DaReactions.cache[prefix][my_type][my_id][my_reaction][page].success === 'ok') {
                                return DaReactions.cache[prefix][my_type][my_id][my_reaction][page];
                            }
                        }
                    }
                }
            }
        }
        return {
            success: 'no'
        };
    }

    /**
     * Remove cached value
     *
     * @param prefix
     * @param my_type
     * @param my_id
     * @param my_reaction
     *
     * @since 3.0.0
     */
    function removeFromCache(prefix, my_type, my_id, my_reaction) {
        DaReactions.cache = DaReactions.cache || {};
        DaReactions.cache[prefix] = DaReactions.cache[prefix] || {};
        DaReactions.cache[prefix][my_type] = DaReactions.cache[prefix][my_type] || {};
        DaReactions.cache[prefix][my_type][my_id] = DaReactions.cache[prefix][my_type][my_id] || {};
        DaReactions.cache[prefix][my_type][my_id][my_reaction] = {success: 'no'};
    }

    /**
     * Save value on local cache
     *
     * @param prefix
     * @param my_type
     * @param my_id
     * @param my_reaction
     * @param value
     *
     * @since 3.0.0
     */
    function saveToCache(prefix, my_type, my_id, my_reaction, value, pagenum) {
        DaReactions.cache = DaReactions.cache || {};
        DaReactions.cache[prefix] = DaReactions.cache[prefix] || {};
        DaReactions.cache[prefix][my_type] = DaReactions.cache[prefix][my_type] || {};
        DaReactions.cache[prefix][my_type][my_id] = DaReactions.cache[prefix][my_type][my_id] || {};
        DaReactions.cache[prefix][my_type][my_id][my_reaction] = DaReactions.cache[prefix][my_type][my_id][my_reaction] || {};
        DaReactions.cache[prefix][my_type][my_id][my_reaction][pagenum] = value;
    }

    /**
     * Display a modal popup with users and reactions list
     *
     * @param userReactions
     *
     * @since 3.0.0
     */
    function showUsersModal(userReactions, requestData) {
        removeUsersModal();
        if (!userReactions.reactions.length) {
            return;
        }
        let $modal_background = $('<div id="da-reactions-users-modal-background"></div>');
        let $modal = $('<div class="da-reactions-data">')
            .data('type', requestData.type)
            .data('id', requestData.id)
            .data('limit', requestData.limit)
            .data('nonce', requestData.nonce)
            .data('reaction', requestData.reaction);
        let activeEmotions = {}

        $modal_background.append($modal);

        for (let userReaction of userReactions.reactions) {
            activeEmotions[userReaction.emotion_id] = {
                image: userReaction.image,
                label: userReaction.label
            }
            let $row = $(`<a href="${userReaction.user_link || 'javascript:return false;'}" class="da-reactions-users-modal-row reaction${userReaction.emotion_id}"></a>`);
            $row.append(`<img src="${userReaction.image}" alt="${userReaction.label}">`);
            $row.append(`<span>${userReaction.display_name}</span>`);
            $modal.append($row);
        }

        if (Array.isArray(userReactions.buttons)) {
            let $tools = $('<div class="da-reactions-users-modal-row tools"></div>');
            $tools.append(`<img src="data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIKCSB2aWV3Qm94PSIwIDAgMzQyLjk0NyAzNDIuOTQ3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAzNDIuOTQ3IDM0Mi45NDc7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KCTxwb2x5Z29uIHBvaW50cz0iMzQyLjk0NywyMS4yMTMgMzIxLjczNCwwIDE3MS40NzMsMTUwLjI2IDIxLjIxMywwIDAsMjEuMjEzIDE1MC4yNiwxNzEuNDczIDAsMzIxLjczNCAyMS4yMTMsMzQyLjk0NwoJCTE3MS40NzMsMTkyLjY4NiAzMjEuNzM0LDM0Mi45NDcgMzQyLjk0NywzMjEuNzM0IDE5Mi42ODYsMTcxLjQ3MyAiLz4KPC9zdmc+" alt="All" class="da-reactions-users-modal-toggle toggleReaction0" data-id="0">`)
            for (let tool of userReactions.buttons) {
                $tools.append($(`<img src="${tool.image}" alt="${tool.label}" class="da-reactions-button da-reactions-users-modal-toggle da-reactions-toggle-reaction${tool.ID} ${tool.current ? 'current' : ''}" data-id="${tool.ID}">`).data('reaction', tool.ID));
            }
            $modal.prepend($tools);
        }

        let pageNum = parseInt(userReactions.pagination.index, 10);
        let pageCount = parseInt(Math.ceil(userReactions.pagination.total / userReactions.pagination.size));

        let $paginator = $('<div class="da-reactions-users-modal-paginator da-reactions-data"></div>')
            .data('type', requestData.type)
            .data('id', requestData.id)
            .data('limit', requestData.limit)
            .data('nonce', requestData.nonce)
            .data('reaction', requestData.reaction);

        if (pageNum > 1) {
            $paginator.append($('<span class="da-reactions-users-modal-paginator-back">&larr;</span>').data('pagenum', (pageNum - 1)));
        }
        $paginator.append('<span class="da-reactions-users-modal-paginator-text">' + pageNum + ' / ' + pageCount + '</span>');
        if (pageNum < pageCount) {
            $paginator.append($('<span class="da-reactions-users-modal-paginator-next">&rarr;</span>').data('pagenum', (pageNum + 1)));
        }

        $modal.append($paginator);


        $('body').append($modal_background);
    }

    /**
     * Remove modal popup created with showUsersModal
     *
     * @since 3.0.0
     */
    function removeUsersModal() {
        $('#da-reactions-users-modal-background').remove();
    }

    /**
     * Display a tooltip with latest user’s reactions
     *
     * @param userReactions
     * @param mouseEvent
     *
     * @since 3.0.0
     */
    function showUserTooltip(userReactions, mouseEvent) {
        removeUserTooltip();
        if (!userReactions.length) {
            return;
        }
        let $tooltip = $('<div id="da-reactions-users-tooltip"></div>')
            .css({left: mouseEvent.clientX, top: mouseEvent.clientY - 20});
        let $tooltip_inner = $('<div>');
        $tooltip.append($tooltip_inner);
        let count = 0;
        for (let userReaction of userReactions) {
            count++;
            let $row = $('<div class="da-reactions-users-tooltip-row"></div>');
            $row.append(`<img src="${userReaction.image}" alt="${userReaction.label}">`);
            $row.append(`<span>${userReaction.display_name}</span>`);
            $tooltip_inner.append($row);
        }
        $('body').append($tooltip);
    }

    /**
     * Change coordinates of tooltip created by showUserTooltip to follow mouse
     *
     * @param mouseEvent
     *
     * @since 3.0.0
     */
    function moveUserTooltip(mouseEvent) {
        $('#da-reactions-users-tooltip')
            .css({left: mouseEvent.clientX, top: mouseEvent.clientY - 20});
    }

    /**
     * Remove tooltip created by showUserTooltip
     *
     * @since 3.0.0
     */
    function removeUserTooltip() {
        $('#da-reactions-users-tooltip').html('').remove();
    }

    /**
     * Callback for mouseover on count badge
     *
     * @param event
     *
     * @since 3.0.0
     */
    function mouseOverCounter(event) {
        let my_container = $(this).closest('.da-reactions-data, .da-reactions-container-async.gutenberg-block'),
            my_type = $(my_container).data('type'),
            my_id = $(my_container).data('id'),
            my_nonce = $(my_container).data('nonce') || DaReactions.nonce,
            my_reaction = $(my_container).data('reaction') || '',
            result = loadFromCache('mouseOverCount', my_type, my_id, my_reaction, 1),
            data = {
                'action': 'get_users_reactions',
                'type': my_type,
                'id': my_id,
                'nonce': my_nonce,
                'reaction': my_reaction,
                'limit': parseInt(DaReactions.tooltip_result_limit, 10)
            };

        if (!result || result.success !== 'ok') {
            $.ajax({
                url: DaReactions.ajax_url,
                method: 'post',
                cache: false,
                data,
                success: function (result) {
                    if (result.success === 'ok') {
                        saveToCache('mouseOverCount', my_type, my_id, my_reaction, result, 1);
                        showUserTooltip(result.reactions, event);
                    }
                }
            });
        } else if (result.success === 'ok') {
            showUserTooltip(result.reactions, event);
        }
    }

    /**
     * Callback for mousemove on count badge
     *
     * @param event
     *
     * @since 3.0.0
     */
    function mouseMoveCounter(event) {
        if ($(event.target).is('.count')) {
            moveUserTooltip(event);
        } else {
            removeUserTooltip();
        }
    }

    /**
     * Callback for mouseout from count badge
     *
     * @since 3.0.0
     */
    function mouseOutCounter() {
        removeUserTooltip();
    }

    /**
     * Loads reactions on placeholder
     */
    function loadReactions() {
        if (!$(this).data('spotted')) {
            $.ajax({
                context: this,
                cache: false,
                data: {
                    action: 'load_buttons',
                    type: $(this).data('type'),
                    id: $(this).data('id'),
                    nonce: $(this).data('nonce') || DaReactions.nonce
                },
                method: 'post',
                success: function (result) {
                    $(this).html(result);
                },
                url: DaReactions.ajax_url
            })
        }
    }

    /**
     * Utility function to format big numbers
     *
     * @param number
     * @returns {string}
     *
     * @since 1.0.0
     */
    function numberFormatter(number) {
        number = (typeof number !== 'undefined') ? number : 0;
        let si = [
            {value: 1, symbol: ""},
            {value: 1E3, symbol: "K"},
            {value: 1E6, symbol: "M"},
            {value: 1E9, symbol: "G"},
            {value: 1E12, symbol: "T"},
            {value: 1E15, symbol: "P"},
            {value: 1E18, symbol: "E"},
            {value: 1E21, symbol: "Z"},
            {value: 1E23, symbol: "Y"}
        ];
        let rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
        let i;
        for (i = si.length - 1; i > 0; i--) {
            if (number >= si[i].value) {
                break;
            }
        }
        return (number / si[i].value).toFixed(2).replace(rx, "$1").replace('.00', '') + si[i].symbol;
    }

    /**
     * All actions are down here
     *
     * @since 1.0.0
     */
    $(document).ready(function () {

        let $daReactionsDocument = $(document);

        /**
         * Enables Async load of reactions
         *
         * @since 1.0.0
         */
        $daReactionsDocument.scrollSpot(loadReactions, ".da-reactions-container-async");

        /**
         * Enables click on reaction button through generic selector
         *
         * @since 2.0.4
         */
        $daReactionsDocument.on('click', '.reaction img', clickedReaction);

        /**
         * Enables click on reaction count badge though .da-reactions-outer selector
         *
         * @since 3.0.0
         */
        if (!!DaReactions.display_detail_modal) {
            $daReactionsDocument.on('click', '.da-reactions-outer .count', clickedCount);
        }

        if (!!DaReactions.display_detail_modal) {
            $daReactionsDocument.on('click', '.da-reactions-users-modal-paginator-next', clickedCount);
        }

        if (!!DaReactions.display_detail_modal) {
            $daReactionsDocument.on('click', '.da-reactions-users-modal-paginator-prev', clickedCount);
        }

        /**
         * Enables click on outer count badge for “reveal” template
         *
         * @since 3.0.0
         */
        if (!!DaReactions.display_detail_modal) {
            $daReactionsDocument.on('click', '.da-reactions-outer .count', clickedCount);
        }

        /**
         * Enables click on mobile toggle hamburger
         *
         * @since 2.0.4
         */
        $daReactionsDocument.on('click', '.reactions-toggle', clickedToggle);

        /**
         * Enables click on image to open widget in “reveal” template
         *
         * @since 3.0.0
         */
        $daReactionsDocument.on('click', '.da-reactions-reveal img', function () {
            $(this).closest('.da-reactions-reveal').toggleClass('active');
        });

        /**
         * Close .da-reactions-reveal on click outside
         *
         * @since 2.1.1
         */
        $daReactionsDocument.on('mouseup', function (event) {
            let $currentActive = $('.da-reactions-reveal.active:eq(0)');
            if (!$currentActive.is(event.target) && $currentActive.has(event.target).length === 0) {
                $currentActive.removeClass('active');
            }
        });

        /**
         * Show reaction users on mouseover
         *
         * @since 3.0.0
         */
        if (!!DaReactions.display_detail_tooltip) {
            $daReactionsDocument.on('mouseover', '.da-reactions-outer .count', mouseOverCounter);
        }

        /**
         * Hide reaction user modal on click outside
         *
         * @since 3.0.0
         */
        if (!!DaReactions.display_detail_modal) {
            $daReactionsDocument.on('click', '#da-reactions-users-modal-background', removeUsersModal);
        }

        /**
         * Enable click on modal reactions toggle visibility
         *
         * @since 3.0.0
         */
        if (!!DaReactions.display_detail_modal_toolbar) {
            $daReactionsDocument.on('click', '.da-reactions-users-modal-toggle', clickedModalToggle);
        }

        /**
         * Move tooltip of users on mouseover
         *
         * @since 3.0.0
         */
        if (!!DaReactions.display_detail_tooltip) {
            $daReactionsDocument.on('mousemove', mouseMoveCounter);
        }

        /**
         * Hide reaction users on mouseout
         *
         * @since 3.0.0
         */
        if (!!DaReactions.display_detail_tooltip) {
            $daReactionsDocument.on('mouseout', '.da-reactions-outer .count', mouseOutCounter);
        }

        /**
         * Enables scrollSpot
         */
        // $(".da-reactions-container-async").scrollSpot(loadReactions);
    });

})(jQuery);
