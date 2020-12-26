jQuery(document).ready(function ($) {

    $('.wpra-plugin-container').each(function () {
        let $plugin_container = $(this);
        // if it is regular reactions check if it needs narrowing
        // if share buttons does not fit container then narrow them
        if ($plugin_container.outerWidth() < $plugin_container.find('.wpra-share-wrap').outerWidth()) {
            $plugin_container.find('.wpra-share-wrap').addClass('wpra-share-wrap-narrow');
        }
        // if classic reactions does not fit to its container then narrow it
        if ($plugin_container.find('.wpra-reactions').outerWidth() > $plugin_container.parent().width()) {
            console.log('badimcan');
            $plugin_container.addClass('wpra-narrow-container');
            let reaction_count = $plugin_container.find('.wpra-reaction').length;
            let reactions_width = $plugin_container.width();
            $plugin_container.find('.wpra-reaction').css('width', reactions_width / reaction_count + 'px');
            $plugin_container.find('.wpra-reaction').css('height', reactions_width / reaction_count + 'px');
            $plugin_container.addClass('wpra-rendered');
        } else {
            $plugin_container.addClass('wpra-rendered');
        }
    });

    $(document).on('click', '.wpra-reaction', function () {

        if ($(this).hasClass('active')) {
            return;
        }

        let container = $(this).parents('.wpra-reactions-container');
        let wrapper = container.parent();
        let reacted_to = $(this).attr('class').split(" ")[0];
        let post_id = container.attr('data-post_id');
        let containers = $('[data-post_id=' + post_id + ']');

        if (container.data('show_count')) {
            let current_data_count = parseInt($(this).attr('data-count'));
            let active = containers.find('.active');
            let active_count = parseInt(active.attr('data-count'));

            let revert_count = 0;
            if (active_count > 1) {
                revert_count = active_count - 1;
            }
            if (revert_count == 0) {
                active.find('.wpra-arrow-badge').hide();
            } else {
                active.find('.wpra-arrow-badge').show();
            }
            if (active_count < 1000) {
                active.find('.wpra-arrow-badge .count-num').html(revert_count);
            }
            active.attr('data-count', revert_count);

            if (isNaN(current_data_count)) {
                current_data_count = 0;
            }

            containers.find('.wpra-reaction').removeClass("active");
            containers.find('.' + reacted_to).addClass("active");
            containers.find('.' + reacted_to).find('.wpra-plus-one').html(current_data_count + 1);

            containers.find('.wpra-reaction').find('.wpra-plus-one').removeClass("triggered");
            containers.find('.' + reacted_to).find('.wpra-plus-one').addClass("triggered");

            if (current_data_count < 1000) {
                containers.find('.active .wpra-arrow-badge .count-num').html(current_data_count + 1);
            }
            containers.find('.active').attr("data-count", current_data_count + 1);
            containers.find('.active .wpra-arrow-badge').show();

            if (active_count > 0) {
                containers.find('.active .wpra-arrow-badge').removeClass('hide-count');
            }
        } else {
            containers.find('.wpra-reaction').removeClass("active");
            containers.find('.' + reacted_to).addClass("active");
        }

        if (container.data('enable_share')) {
            container.find('.wpra-share-wrap').css('display', 'flex');
            if (wrapper.outerWidth() < container.outerWidth()) {
                container.find('.wpra-share-wrap').addClass('wpra-share-wrap-narrow');
            }
        }

        $.ajax({
            url: wpra.ajaxurl,
            dataType: 'text',
            type: 'post',
            data: {
                action: 'wpra_react',
                reacted_to: reacted_to,
                post_id: post_id,
                checker: container.data('secure')
            },
            beforeSend: function () {
            },
            success: function (data, textStatus, jQxhr) {
            },
            complete: function () {
            }
        });

        let reveal_wrap = container.parents('.wpra-button-reveal-wrap');

        if (reveal_wrap.length > 0) {
            let $reacted_emoji = reveal_wrap.find('.wpra-reacted-emoji');
            let $reactions_wrap = reveal_wrap.find('.wpra-reactions-wrap');
            let $reveal_toggle = reveal_wrap.find('.wpra-reveal-toggle');
            let clicked_text = $reveal_toggle.data('text_clicked');

            $reacted_emoji.html('');
            $reactions_wrap.hide();
            reveal_wrap.data('user_reacted', true);

            // if share popup enabled then change button text and class
            if ($reveal_toggle.data('enable_share_popup')) {
                $reveal_toggle.text(clicked_text);
                $reveal_toggle.addClass('share-popup-toggle');
            }
        }

    });

    $(document).on('click', '.share-btn-facebook', function () {
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + location.href, '_blank', 'width=626, height=436');
    });

    $(document).on('click', '.share-btn-twitter', function () {
        window.open('https://twitter.com/intent/tweet?text=' + location.href, '_blank', 'width=626, height=436');
    });

    $(document).on('click', '.share-btn-email', function () {
        location.href = 'mailto:?Subject=Shared%20with%20wpreactions&body=' + location.href;
    });

});

