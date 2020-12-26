/* global wpNavMenu */

(function ($) {
    'use strict';

    function addLinkToMenu(url, label) {
        wpNavMenu.addLinkToMenu(url, label, null, function () {
            // Remove the ajax spinner
            $('.customlinkdiv .spinner').removeClass('is-active');
            // Set custom link form back to defaults
            $('#custom-menu-item-name').val('').blur();
            $('#custom-menu-item-url').val('').attr('placeholder', 'https://');
        });
    }

    $(document).ready(function () {
        $('#menu-settings-column').bind('click', function (e) {
            const target = e.target;

            if ($(target).is('#submit-da-reactions-menu-item')) {
                $('#da-reactions-checklist-pop input:checked').each(function() {
                    addLinkToMenu($(this).val(), $(this).attr('name'));
                    $(this).prop('checked', false);
                })
            }
        });
    })

}(jQuery));
