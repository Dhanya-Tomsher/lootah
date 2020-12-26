(function (blocks, element) {
    const el = element.createElement;
    const bl = blocks.registerBlockType;

    let iconSvg = el('svg', {width: 20, height: 20},
        el('path', {d: "M10,0C4.478,0,0,4.478,0,10c0,5.521,4.478,10,10,10c5.521,0,10-4.479,10-10C20,4.478,15.521,0,10,0zM5.039,9.226c-0.786,0-1.425,0.765-1.425,1.705H2.576c0-1.512,1.104-2.742,2.462-2.742s2.463,1.23,2.463,2.742H6.463C6.463,9.991,5.825,9.226,5.039,9.226z M10,18.049c-3.417,0-6.188-2.41-6.188-5.382h12.375C16.188,15.639,13.418,18.049,10,18.049zM16.387,10.931c0-0.94-0.639-1.705-1.426-1.705c-0.785,0-1.424,0.765-1.424,1.705h-1.039c0-1.512,1.105-2.742,2.463-2.742s2.463,1.23,2.463,2.742H16.387z"})
    );

    bl('da-reactions/gutenberg-block', {
        title: 'Reactions',
        icon: iconSvg,
        category: 'widgets',
        attributes: {
            myId: {
                type: 'string',
                source: 'attribute',
                default: Math.floor(Math.random() * 8388607), /// Medium int max value is 8388607;
                selector: 'div.gutenberg-block',
                attribute: 'data-id'
            },
        },

        edit: (props) => {

            let dataId = props.attributes.myId;

            const twins = document.querySelectorAll(`div[data-id="${dataId}"]`)

            if (twins.length > 1) {
                dataId++;
                props.setAttributes({myId: dataId});
            }

            return el(
                'div',
                {
                    'class': 'da-reactions-container-async gutenberg-block',
                    'data-id': dataId
                },
                [
                    el(
                        'img',
                        {
                            src: DaReactionsGutenbergBlock.preview_image
                        }
                    )
                ]
            );
        },

        save: (props) => {
            let dataId = props.attributes.myId;

            return el(
                'div',
                {},
                [
                    el(
                        'div',
                        {
                            class: 'da-reactions-outer'
                        },
                        [
                            el(
                                'div',
                                {
                                    'class': 'da-reactions-container-async gutenberg-block',
                                    'data-id': dataId,
                                    'data-type': DaReactionsGutenbergBlock.item_type
                                },
                                el(
                                    'div',
                                    {
                                        'class': 'da-reactions-' + DaReactionsGutenbergBlock.use_template
                                    }, {},
                                    [
                                        el(
                                            'img',
                                            {
                                                src: DaReactionsGutenbergBlock.loader_url,
                                                width: DaReactionsGutenbergBlock.button_size,
                                                height: DaReactionsGutenbergBlock.button_size,
                                                style: `width:${DaReactionsGutenbergBlock.button_size}px;height:${DaReactionsGutenbergBlock.button_size}px;`
                                            }
                                        )
                                    ]
                                )
                            )
                        ]
                    )
                ]
            );
        }
    });

}(window.wp.blocks, window.wp.element));
