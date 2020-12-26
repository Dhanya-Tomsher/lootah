<?php
use WP_Reactions\Lite\Helper;
?>
<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e( 'User Reaction Counts', 'wpreactions' ); ?></span>
            <?php Helper::tooltip('fake-counts'); ?>
        </h4>
        <small><?php _e( 'Preset your counts to any number. If left blank, counts will start at "0".', 'wpreactions' ); ?></small>
    </div>
    <div class="row mt-3 fake-counts">
        <div class="form-group fake-count col">
            <div itemprop="gif" class="emoji-lottie-holder"></div>
            <input type="number" id="fake_reaction1" class="form-control" placeholder="0" min="0"/>
        </div>
        <div class="form-group fake-count col">
            <div itemprop="gif" class="emoji-lottie-holder"></div>
            <input type="number" id="fake_reaction2" class="form-control" placeholder="0" min="0"/>
        </div>
        <div class="form-group fake-count col">
            <div itemprop="gif" class="emoji-lottie-holder"></div>
            <input type="number" id="fake_reaction3" class="form-control" placeholder="0" min="0"/>
        </div>
        <div class="form-group fake-count col">
            <div itemprop="gif" class="emoji-lottie-holder"></div>
            <input type="number" id="fake_reaction4" class="form-control" placeholder="0" min="0"/>
        </div>
        <div class="form-group fake-count col">
            <div itemprop="gif" class="emoji-lottie-holder"></div>
            <input type="number" id="fake_reaction5" class="form-control" placeholder="0" min="0"/>
        </div>
        <div class="form-group fake-count col">
            <div itemprop="gif" class="emoji-lottie-holder"></div>
            <input type="number" id="fake_reaction6" class="form-control" placeholder="0" min="0"/>
        </div>
    </div>
</div>