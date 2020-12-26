<?php

use WP_Reactions\Lite\Helper;
use WP_Reactions\Lite\Configuration;
use WP_Reactions\Lite\Shortcode;
use WP_Reactions\Lite\FieldManager\Switcher;

$tooltip1 = $tooltip2 = '';
extract($data);
$is_regular = (Configuration::$current_options['activation'] == 'true' and Configuration::$current_options['behavior'] == 'regular');

?>
<div class="wpe-behaviors">
    <div class="row">
        <div class="col-md-6">
            <div class="option-wrap">
                <div class="wpra-features">
                    <div class="wpra-features-item border-bottom-1">
                        <div class="wpra-features-item-title">
                            <h3><?php _e('Classic Reactions Lite', 'wpreactions-lite'); ?></h3>
                            <div class="wpra-behavior-chooser">
                                <?php
                                (new Switcher())
                                    ->setId('regular')
                                    ->setName('global_behavior')
                                    ->setValue($is_regular)
                                    ->setChecked(true)
                                    ->build();
                                ?>
                            </div>
                        </div>
                        <p> <?php _e('Turn on to engage your users with 6 classic JoyPixels, lightning fast, SVG emoji reactions, 3 social sharing platforms, on-page analytics, overhead badges, call to action and design wizard.', 'wpreactions-lite'); ?> </p>
                    </div>
                    <div class="wpra-features-item border-bottom-1">
                        <div class="wpra-features-item-title">
                            <h3> <?php _e('Classic Reactions', 'wpreactions-lite'); ?>
                                <div class="wpra-pro-badge">PRO</div>
                            </h3>
                            <div class="wpra-behavior-chooser">
                                <?php
                                //		                    Helper::tooltip( $tooltip1 );
                                (new Switcher())
                                    ->setId('pro_feature_1')
                                    ->setName('pro_feature_1')
                                    ->setValue(true)
                                    ->setChecked(false)
                                    ->setDisabled()
                                    ->build();
                                ?>
                            </div>
                        </div>
                        <p> <?php _e('Choose from 100 JoyPixels licensed Lottie animated emojis, 100 SVG emojis and 9 social media platforms. Generate shortcode easily and paste your reactions anywhere. Set your own user counts. Global activation with extended features.Collect user reaction data on pages and posts. This is a pro feature.', 'wpreactions-lite'); ?> </p>
                    </div>
                    <div class="wpra-features-item">
                        <div class="wpra-features-item-title">
                            <h3> <?php _e('Button Reactions', 'wpreactions-lite'); ?>
                                <div class="wpra-pro-badge">PRO</div>
                            </h3>
                            <div class="wpra-behavior-chooser">
                                <?php
                                //		                    Helper::tooltip( $tooltip1 );
                                (new Switcher())
                                    ->setId('pro_feature_1')
                                    ->setName('pro_feature_1')
                                    ->setValue(true)
                                    ->setChecked(false)
                                    ->setDisabled()
                                    ->build();
                                ?>
                            </div>
                        </div>
                        <p><?php _e('Create the ultimate button for your animated emojis to pop out and shock your users when emojis reveal themselves. After users react to your content our dual action button triggers a social popup overlay for increased social engagement. Button Reactions shares all of the core features and from Classic Reactions Pro including JoyPixels emojis. This is a pro feature.', 'wpreactions-lite'); ?> </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="option-wrap">
                <?php
                $active_class = ($options['activation'] == 'true') ? 'p-active' : '';
                ?>
                <div class="primary-color-blue wpra-light-activation-title <?php echo $active_class; ?>">
                    <span><?php _e('Your Reactions are live!', 'wpreactions-lite'); ?></span>
                    <span><?php _e('Your Reactions are not showing', 'wpreactions-lite'); ?></span>
                    <div class="reset-button-holder">
                        <span class="wpra-reset-options">
                            <span class="dashicons dashicons-image-rotate"></span>
                            <span><?php _e('Reset', 'wpreactions-lite'); ?></span>
                        </span>
                        <?php Helper::tooltip('reset-button'); ?>
                    </div>
                </div>
                <div class="wpra-behavior-preview" style="min-height: 410px;">
                    <?php
                    $behavior_preview = $options;
                    $behavior_preview['post_id'] = -1;
                    echo Shortcode::build($behavior_preview);
                    ?>
                </div>
            </div>
            <button id="customize"
                    class="btn btn-open-blue btn-lg w-100" <?php Helper::is_disabled(Configuration::$current_options['activation']); ?>>
                <span class="dashicons dashicons-admin-customizer"></span>
                <?php _e('Customize Now', 'wpreactions-lite'); ?>
            </button>
        </div>
    </div>
</div>
