/*global DaReactionsAdmin*/

let Chart;
import {chartNoData} from './Chart.no-data';

if (DaReactionsAdmin.screen_name.id === 'dashboard') {
    Chart = require('chart.js');
    chartNoData();
}


import {jQueryRandom} from './jQuery.random';

jQueryRandom();


(function ($) {
    'use strict';

    $.fn.serializeObject = function () {
        let o = {};
        let a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    /**
     * Inject rgb color inside SVG markup
     * Used to generate preview in admin page
     * @param $img jQuery instance of SVG Node
     * @param callback Function to call after injection
     * @returns {boolean} false if unapplicable
     * @since 1.0.0
     */
    function applyColorToSvg($img, callback) {


        if (!$img) {
            return false;
        }

        let imgURL = $img.attr('src');
        let imgFill = $img.attr('data-fill');

        if (imgURL.substring(0, 26) !== 'data:image/svg+xml;base64,') {
            return false;
        }

        if (!imgFill) {
            return false;
        }

        $.get(imgURL, function (data) {
            // Get the SVG tag, ignore the rest
            let $svg = $(data).find('svg');

            let svgColors = [];
            let $shapeList = $svg.find('[fill]');

            $shapeList.each(function () {
                let currentColor = $(this).attr('fill');
                if ($.inArray(currentColor, svgColors) < 0) {
                    svgColors.push(currentColor);
                }
            });
            if (svgColors.length < 2) {
                $shapeList.removeAttr('fill');
            }

            // Add replaced image's fill to the new SVG
            if (typeof imgFill !== 'undefined') {
                $svg = $svg.attr('fill', imgFill);
            }
            let newSrc = 'data:image/svg+xml;base64,' + btoa($svg.prop('outerHTML'));
            $img.attr('src', newSrc);

            if (typeof callback === 'function') {
                callback(newSrc, $svg[0].outerHTML);
            }

        }, 'xml');

        return true;
    }

    function convertToBase64(img, callback) {
        $.get($(img).attr('src'), function (svg) {
            let svgSrc = svg.getElementsByTagName('svg')[0].outerHTML;
            let newSrc = 'data:image/svg+xml;base64,' + btoa(svgSrc);
            $(img).attr('src', newSrc);
            $(img).parent().find('input').val(svgSrc);
            if (typeof callback === 'function') {
                callback(newSrc, svgSrc);
            }
        });
    }

    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }

    function loadPreview() {
        let data = $('form').serializeObject();
        data.action = 'load_buttons_preview';
        data.nonce = DaReactionsAdmin.nonce;
        $.ajax({
            context: this,
            cache: false,
            data,
            method: 'post',
            success: function (result) {
                $('#reactions_preview').remove();
                $('body').append($('<div id="reactions_preview" class="da-reactions-data da-reactions-outer" data-type="preview" data-id="-1"></div>').html(result.html).append($('<style>').html(result.style)));
            },
            url: ajaxurl
        })
    }

    /**
     * Add a new Reaction Row to Admin page
     * Invoked when click "Add New" button
     * @param e ButtonEvent
     * @since 1.0.0
     */
    function onAddNewRow(e) {
        e.preventDefault();
        let id = 1000000 + Math.floor(Math.random() * 1000000);
        let image = $('.icon-select-window .icon img').random().attr('src');
        let color = '#' + ('000000' + Math.floor(Math.random() * 16777216).toString(16).toUpperCase()).slice(-6);
        let input_base_name = $('input[name="da-reactions_setting_name"]').val();
        let $row = $(`<tr>
                            <td class="da-reactions-list-column-sort">
                                <span class="dashicons dashicons-menu handle"></span>
                                <input type="hidden" class="input_position" name="${input_base_name}[${id}][sort_order]" value="999" />
                            </td>
                            <td class="da-reactions-list-column-icon">
                                <a
                                    href="#"
                                    data-id="${id}"
                                    class="change-image">
                                    <img src="${image}" alt="Change image" width="64" data-fill="${color}" />
                                    <input type="hidden" name="${input_base_name}[${id}][image]" value="${image}" />
                                </a>
                            </td>
                            <td class="da-reactions-list-column-color">
                                <label for="da-reactions-color-picker-${id}" class="screen-reader-text">Colore</label>
	                            <input id="da-reactions-color-picker-${id}" type="text" name="${input_base_name}[${id}][color]" data-colorpicker value="${color}" />
                            </td>
                            <td class="da-reactions-list-column-label">
	                            <input type="text" name="${input_base_name}[${id}][label]" value="Reaction" />
                            </td>
                            <td class="da-reactions-list-column-tools">
                                <a href="#" class="delete" data-id="${id}">
                                    <span class="dashicons dashicons-trash"></span>
                                </a>
                            </td>
                        </tr>`);


        $('#da-reactions-list tbody').append($row).find('.no-results').hide();
        $row.find('input[data-colorpicker]').wpColorPicker(getColorPickerSettings());
        $row.find('a.change-image').click(onChangeImage);
        $row.find('a.delete').click(onDeleteRow);

        let $img = $row.find('img');

        convertToBase64($img, function () {
            applyColorToSvg($img, function (src, svg) {
                $img.siblings('input').val(svg);
            });
        });
    }

    /**
     * Changes image on click on icon in popup
     * Invoked by click on a reaction in popup
     * @since 1.0.0
     */
    function onChangedImage() {
        let $img = $('.changing img');
        $img.attr('src', $(this).find('img').attr('src'));

        convertToBase64($img, function () {
            applyColorToSvg($img, function (src, svg) {
                $img.siblings('input').val(svg);
            });
        });
    }

    /**
     * Displays a popup to select new image
     * Invoked by click on a reaction in list
     * @since 1.0.0
     */
    function onChangeImage() {
        $('.changing').removeClass('changing');
        $(this).addClass('changing');

        $('.icon-select-window-background').addClass('open');
    }

    function onDeleteRow(e) {
        e.preventDefault();
        let $row = $(this).parents('tr');
        if (!$row.siblings(':visible').length) {
            $row.parents('table').find('.no-results').show();
        }
        if (confirm(DaReactionsAdmin['strings']['DELETE_REACTION_ROW_CONFIRM'])) {
            $row.remove();
        }
    }

    /**
     * Generate Color Picker preferences
     * Used to initialize colorpicker fields
     * @returns {{change: change, clear: clear, hide: boolean, palettes: boolean}}
     * @since 1.0.0
     */
    function getColorPickerSettings() {
        return {
            change: function (event, ui) {
                let $img = $(event.target).parents('tr').find('.da-reactions-list-column-icon img');
                $img.attr('data-fill', ui.color.toString());
                applyColorToSvg($img, function (src, svg) {
                    $img.siblings('input').val(svg);
                });
            },
            // a callback to fire when the input is emptied or an invalid color
            clear: function () {
            },
            // hide the color picker controls on load
            hide: true,
            // show a group of common colors beneath the square
            // or, supply an array of colors to customize further
            palettes: false
        };
    }

    /**
     * Get variables from querystring
     * @returns {Array}
     */
    function getUrlVars() {
        let vars = [], hash;
        let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (let i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    /**
     * All actions for document items are defined here
     */
    $(document).ready(function () {

        let queryStringVariables = getUrlVars() || {page: ''};

        const is_plugins_page = $('body').is('.plugins-php');
        const is_reactions_page = queryStringVariables.page === 'da-reactions';
        const is_settings_page = queryStringVariables.page === 'da-reactions_general_settings';
        const is_graphics_page = queryStringVariables.page === 'da-reactions_graphic_settings';

        const is_form_page = is_reactions_page || is_settings_page || is_graphics_page;
        if (is_form_page) {
            let pageForm = $('form');
            window.originalFormData = pageForm.serialize();

            window.onbeforeunload = function () {
                let currentFormData = $('form').serialize();
                if (!window.canGo && currentFormData !== window.originalFormData) {
                    return DaReactionsAdmin['strings']['EXIT_WITHOUT_SAVING'];
                }
            };

            pageForm.submit(function () {
                window.canGo = true;
            })
        }
        if (is_plugins_page) {

            /**
             * Displays a confirm prompt on uninstall before deleting all settings
             * Invoked when user clicks on "Disable" link on WordPress Plugins page
             * Only if remove_data_on_disable parameter is on
             *
             * @since 3.3.0
             */
            $('[data-slug^="' + DaReactionsAdmin['plugin_name'] + '"] span.deactivate a').on('click', function (event) {
                event.preventDefault();
                let urlRedirect = $(this).attr('href');
                const $confirmDialog = $("#da-reactions-dialog-confirm");

                $confirmDialog.dialog({
                    resizable: false,
                    height: "auto",
                    width: 400,
                    modal: true,
                    buttons: {
                        [DaReactionsAdmin.strings.CONFIRM_BUTTON_LABEL]: function () {
                            let userData = getFormData($confirmDialog.find('form'));
                            if (!userData.reason) {
                                /// Nothing to do, goodbye
                                window.location.href = urlRedirect;
                            } else {
                                /// User accepted to share at least basic data
                                userData = {...userData, ...DaReactionsAdmin.non_sensitive_data};
                                if (userData.send_details === 'on') {
                                    /// User accepted to share sensitive data with us. Horay!
                                    userData = {...userData, ...DaReactionsAdmin.sensitive_data}
                                }
                                /// This is executed ONLY if user set a reason to send.
                                $.ajax({
                                    url: "https://www.da-reactions-plugin.com/feedback/",
                                    method: "POST",
                                    data: userData,
                                    success: () => {
                                        window.location.href = urlRedirect;
                                    },
                                    error: () => {
                                        // window.location.href = urlRedirect;
                                    }
                                });
                            }
                        },
                        [DaReactionsAdmin.strings.CANCEL_BUTTON_LABEL]: function () {
                            $(this).dialog("close");
                        }
                    }
                });
            })

        }

        if (is_reactions_page) {

            /**
             * Enables colorpicker fields
             * Uses getColorPickerSettings to generate preferences
             *
             * @since 1.0.0
             */
            $('#da-reactions-list input[data-colorpicker]').wpColorPicker(getColorPickerSettings());

            /**
             * Enable sortable rows so reactions could be sorted with drag'n drop
             *
             * @since 1.0.0
             */
            $("#da-reactions-list .sortable").sortable({
                handle: ".handle",
                start: function (e, ui) {
                    ui.placeholder.height(ui.item.height());
                },
                update: function (/*e, ui*/) {
                    let i = 1;
                    $(this).find('.input_position').each(function () {
                        $(this).val(i++);
                    })
                }
            }).disableSelection();

            /**
             * Enables click on reactions in popup to change image
             *
             * @since 1.0.0
             */
            $('.icon-select-window a.close').on('click', function () {
                $('.icon-select-window-background').removeClass('open');
                $('.changing').removeClass('changing');
            });

            /**
             * Enables click on reactions in popup to change image
             *
             * @since 1.0.0
             */
            $('.icon-select-window .icon-list > div').on('click', onChangedImage);

            /**
             * Enables click on reactions to open a popup and select new image from library
             *
             * @since 1.0.0
             */
            $('#da-reactions-list a.change-image').on('click', onChangeImage);

            $('#da-reactions-list a.change-image img').each(function () {
                let $img = $(this);
                if ($img.attr('src').substr($img.attr('src').length - 4).toLowerCase() === '.svg') {
                    convertToBase64($img, function () {
                        applyColorToSvg($img, function () {
                            window.originalFormData = $('form').serialize();
                        });
                    });
                } else {
                    $(this).parent().find('input').val($(this).attr('src'));
                    window.originalFormData = $('form').serialize();
                }
            });

            /**
             * Enables delete button to remove a reaction from list
             *
             * @since 1.0.0
             */
            $('#da-reactions-list a.delete').on('click', onDeleteRow);

            /**
             * Enables click on Add New button to add a new row to list
             * Invokes onAddNewRow function
             *
             * @since 1.0.0
             */
            $('.add_new_reaction').on('click', onAddNewRow);
        }


        if (is_settings_page) {
            /**
             * Hides or Shows user role selector according to restiction value
             *
             * @since 1.0.0
             */
            $('.user_restrict_selector input[type=checkbox]').change(function () {
                if ($(this).is(':checked')) {
                    $('.user_type_selector').show();
                } else {
                    $('.user_type_selector').hide();
                }
            }).change();
        }

        if (is_graphics_page) {
            $('.refresh-preview').on('change', function () {
                loadPreview();
            });
            loadPreview();
        }

        if (!!Chart) {
            /**
             * Chart widget
             */
            $('.graph-canvas').each(function () {

                const $reactionsByContentType = $(this);
                const data = $reactionsByContentType.data('chart_data');
                const type = $reactionsByContentType.data('chart_type') || 'doughnut';

                if ($reactionsByContentType.length) {
                    const config = {
                        type,
                        data,
                        options: {
                            legend: {
                                position: 'top'
                            }
                        }
                    };
                    DaReactionsAdmin.chart = new Chart($reactionsByContentType[0], config);
                }

            })
        }
    });
})(jQuery);
