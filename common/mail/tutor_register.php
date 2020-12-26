<?php echo $this->render('_mailheader'); ?>
<tr>

    <!-- Banner Image: BEGIN -->
<tr>
    <td bgcolor="#ffffff">
        <img src="http://tomsher.com/tradeflo/images/banner.jpg" aria-hidden="true" width="620" height="400" alt="alt_text" border="0" align="center" style="width: 100%; max-width: 620px; height: auto; background: #dddddd; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
    </td>
</tr>
<tr>
    <td bgcolor="#ffffff">
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td class="header-td" style="padding:64px 60px 13px 40px; font-family: 'Poppins', sans-serif; text-align:center;">
                    <h1 class="h1-title" style="padding:0px 0px 10px 0px; font-family: 'Poppins', sans-serif; font-size: 24px; line-height: 41px; color: #111111; font-weight: 600;"><a href="#" class="h1-title-a" style="color: #111111; text-decoration: none;">Hello Gopu,</a></h1>
                    <p class="header-p" style="margin: 0; font-size: 14px; line-height: 26px; color: #767676; font-weight: normal;">Welcome and we are truly grateful to you for your registration .</p>

                    <p class="header-p" style="margin: 0; font-size: 14px; line-height: 26px; color: #767676; font-weight: normal;">Your name and email address were submitted for a free-trial registration to Tradeflo. Please click the below link to activate your account or copy paste to the browser.

                    </p>
                    <p class="header-p" style="margin: 0; font-size: 14px; line-height: 26px; color: #767676; font-weight: normal;"><a style="word-break: break-all; display: block;" href="http://<?= $_SERVER['HTTP_HOST'] ?>/mindmax/home/activation?auth=<?= ($model->auth_key) ? $model->auth_key : '' ?>&username=<?= ($model->email) ? $model->email : '' ?>" target="_blank">http://<?= $_SERVER['HTTP_HOST'] ?>/mindmax/home/activation?auth=<?= ($model->auth_key) ? $model->auth_key : '' ?>&username=<?= ($model->email) ? $model->email : '' ?></a>

                    </p>
                </td>
        </table>
    </td>
</tr>
<!-- End example table -->



<tr>
    <td class="cta-bg-2" style="background: #ffffff; padding: 15px 0 60px 0px; font-family: 'Poppins', sans-serif;">
        <!-- Button : BEGIN -->
        <table border="0" cellpadding="0" cellspacing="0" style="margin: auto;" role="presentation" aria-hidden="true">
            <tbody><tr>
                    <td style="border-radius: 3px; background: #4285f4; text-align: center;">
                        <a  href="http://<?= $_SERVER['HTTP_HOST'] ?>/mindmax/home/activation?tutor_otp=<?= ($model->tutor_otp) ? $model->tutor_otp : '' ?>&username=<?= ($model->email) ? $model->email : '' ?>" class="cta-button" style="background: #4285f4; font-family: 'Poppins', sans-serif;font-size: 14px; line-height: 26px; text-align: center; text-decoration: none; display: block; padding: 10px 40px 10px 40px; border-radius: 3px; font-weight: normal; color:#FFF;">
                            <span style="color:#ffffff;" class="button-link">Activate Now</span>
                        </a>
                    </td>
                </tr>
            </tbody></table>
        <!-- Button : END -->
    </td>
</tr>
<!-- Step 2: Working with telephone numbers (including sms prompts).  Use the "mobile_link" class with a span tag to control what number links and what doesn't in mobile clients. -->

<?php echo $this->render('_mailfooter'); ?>
<tr>
