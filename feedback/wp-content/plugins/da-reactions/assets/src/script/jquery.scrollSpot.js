export function jQueryScrollSpot() {

    (function ($) {
        "use strict";

        /**
         * Copyright 2018, Daniele Alessandra
         * Licensed under the MIT license.
         * https://www.danielealessandra.com
         *
         * @author Daniele Alessandra
         * @desc A small plugin that checks whether elements are within
         *       the user visible viewport of a web browser and calls
         *       a callback on it
         */

        $.fn.scrollSpot = function (callback, selector) {
            if ($(this).length < 1) {
                return;
            }

            let $me = this;

            function spotted(element) {
                let eTop = $(element).offset().top;
                let eBot = eTop + $(element).outerHeight();
                let vTop = $(window).scrollTop();
                let vBot = vTop + $(window).height();
                return eBot > vTop && eTop < vBot;
            }


            function check() {
                let collection = $me;

                if (!!selector) {
                    collection = $me.find(selector);
                }
                $(collection).each(function () {
                    if (spotted(this)) {
                        if (!!callback) {
                            callback.call(this);
                        }
                        $(this).addClass('in-viewport');
                        $(this).addClass('spotted');
                        $(this).data('spotted', true);
                        $(this).data('in-viewport', true);
                    } else {
                        $(this).removeClass('in-viewport');
                        $(this).data('in-viewport', false);
                    }
                });
            }

            if (!$me.find(selector).length) {
                const observer = new MutationObserver(check);
                observer.observe($me[0], { childList: true, characterData: true, attributes: true, subtree: true });
            }

            $(window).on('resize scroll', check);
            $(document).ready(check);

            return this;
        };

    }(jQuery));

}
