<?php
use WP_Reactions\Lite\Helper;
global $wpra_lite;
?>
<div class="wpreactions primary-color-blue wpra-pro-page">
    <!-- top bar -->
    <?php
    Helper::getTemplate(
        'view/admin/components/top-bar',
        array(
            "section_title" => "",
            "logo" => Helper::getAsset('images/wpj_logo.png'),
        )
    );
    ?>

    <div class="wpra-option-heading d-flex align-items-center justify-content-between heading-left">
        <div>
            <h4>
                <span><?php _e('Upgrade to WP Reactions Pro', 'wpreactions-lite'); ?></span>
            </h4>
            <span><?php _e('Take your user engagement to the next level with new Lottie animated emoji reactions and endless ways to customize them', 'wpreactions-lite'); ?></span>
        </div>
        <a href="https://wpreactions.com/pricing" target="_blank" class="btn-blue"><i class="qa qa-star"></i><?php _e('Go Pro', 'wpreactions    '); ?></a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="option-wrap">
                <div class="pro-features-list">
                    <ul>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('100 JoyPixels Lottie animated emoji reactions', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('100 JoyPixels SVG static emoji reactions', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Our emoji picker lets you mix, match and arrange', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Classic Reactions with extended features', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Button Reactions is the ultimate animated button', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Global Activation with extended features', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Generate shortcode easily and paste anywhere', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Loaded with the top social media platforms', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Extended overhead user-count and badge options', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Collect user reaction data on each page/post', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Endless emoji combinations and styling options', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Premium customer support', 'wpreactions-lite'); ?>
                        </li>
                        <li><span class="dashicons dashicons-yes"></span>
                            <?php _e('Monthly automatic, awesome updates', 'wpreactions-lite'); ?>
                        </li>
                    </ul>
                </div>
                <div class="mt-4">
                    <h5 class="fw-700"><?php _e('We’re always adding new features', 'wpreactions-lite'); ?></h5>
                    <p class="mb-3"><?php _e('Keep your visitors engaged on your pages and posts for longer with premium features
                        that deliver real-time user engagement while increasing social sharing.', 'wpreactions-lite'); ?></p>
                    <a class="btn btn-purple fw-700 w-100" href="https://wpreactions.com/pricing" target="_blank"><?php _e('GET YOUR PREMIUM LICENSE TODAY $29', 'wpreactions-lite'); ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="option-wrap d-flex align-items-center">
                <div class="w-75">
                    <h5 class="fw-700"><?php _e('TRY OUR PRO VERSION', 'wpreactions-lite'); ?></h5>
                    <p class="m-0">
                        <?php _e('Take WP Reactions PRO for a test drive and see what you are missing. Our Wordpress
                        demo site is ready for you to test all of our premium features.', 'wpreactions-lite'); ?>
                        <a href="https://demo.wpreactions.com" target="_blank"> <?php _e('Click here to visit our demo site.', 'wpreactions-lite'); ?></a>
                    </p>
                </div>
                <div class="text-center w-25">
                    <span class="dashicons dashicons-dashboard"
                          style="font-size: 90px;width: auto; height: auto;"></span>
                </div>
            </div>
            <div class="option-wrap d-flex align-items-center">
                <div class="w-75">
                    <h5 class="fw-700"><?php _e('Limited Time Offer', 'wpreactions-lite'); ?></h5>
                    <p class="m-0"><?php _e('Save 40% off WP Reactions PRO and start engaging your users today. We guarantee you
                        will love it or your money back.', 'wpreactions-lite'); ?></p>
                </div>
                <a target="_blank" href="https://wpreactions.com/pricing/" class="btn w-25 btn-blue ml-3"><?php _e('Get Offer', 'wpreactions-lite'); ?></a>
            </div>
            <div class="option-wrap d-flex align-items-center">
                <div class="mr-3 mt-4 mb-4">
                    <img style="width: 200px;" src="<?php echo Helper::getAsset('images/money-back.png'); ?>">
                </div>
                <div class="">
                    <h5 class="fw-700"><?php _e('100% Zero-Risk Money Back Guarantee', 'wpreactions-lite'); ?></h5>
                    <p><?php _e('You are fully protected by our 100% Zero Risk Guarantee. If you are not fully satisfied for any
                        reason, simply contact us within 14 days and we will happily refund 100% of your money. No
                        questions asked.', 'wpreactions-lite'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
