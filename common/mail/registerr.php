<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Welcome to Dunia Pay</title>

        <style type="text/css">


            #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
            body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
            /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
            .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
            #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
            /* End reset */


            img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
            a img {border:none;}
            .image_fix {display:block;}


            p {margin: 1em 0;}

            /** Hotmail header color reset: Hotmail replaces your header color styles with a green color on H2, H3, H4, H5, and H6 tags. In this example, the color is reset to black for a non-linked header, blue for a linked header, red for an active header (limited support), and purple for a visited header (limited support).  Replace with your choice of color. The !important is really what is overriding Hotmail's styling. Hotmail also sets the H1 and H2 tags to the same size.

            Bring inline: Yes.
            **/
            h1, h2, h3, h4, h5, h6 {color: black !important;}

            h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

            h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
                color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
            }

            h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
                color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
            }

            /** Outlook 07, 10 Padding issue: These "newer" versions of Outlook add some padding around table cells potentially throwing off your perfectly pixeled table.  The issue can cause added space and also throw off borders completely.  Use this fix in your header or inline to safely fix your table woes.

            More info: http://www.ianhoar.com/2008/04/29/outlook-2007-borders-and-1px-padding-on-table-cells/
            http://www.campaignmonitor.com/blog/post/3392/1px-borders-padding-on-table-cells-in-outlook-07/

            H/T @edmelly

            Bring inline: No.
            **/
            table td {border-collapse: collapse;}

            /** Remove spacing around Outlook 07, 10 tables

            More info : http://www.campaignmonitor.com/blog/post/3694/removing-spacing-from-around-tables-in-outlook-2007-and-2010/

            Bring inline: Yes
            **/
            table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }

            /* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email, bring your styles inline.  Your link colors will be uniform across clients when brought inline.

            Bring inline: Yes. */
            a {color: orange;}

            /* Or to go the gold star route...
            a:link { color: orange; }
            a:visited { color: blue; }
            a:hover { color: green; }
            */

            /***************************************************
            ****************************************************
            MOBILE TARGETING

            Use @media queries with care.  You should not bring these styles inline -- so it's recommended to apply them AFTER you bring the other stlying inline.

            Note: test carefully with Yahoo.
            Note 2: Don't bring anything below this line inline.
            ****************************************************
            ***************************************************/

            /* NOTE: To properly use @media queries and play nice with yahoo mail, use attribute selectors in place of class, id declarations.
            table[class=classname]
            Read more: http://www.campaignmonitor.com/blog/post/3457/media-query-issues-in-yahoo-mail-mobile-email/
            */
            @media only screen and (max-device-width: 480px) {

                /* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers that look like, but are not phone numbers.  Use these two blocks of code to "unstyle" any numbers that may be linked.  The second block gives you a class to apply with a span tag to the numbers you would like linked and styled.

                Inspired by Campaign Monitor's article on using phone numbers in email: http://www.campaignmonitor.com/blog/post/3571/using-phone-numbers-in-html-email/.

                Step 1 (Step 2: line 224)
                */
                a[href^="tel"], a[href^="sms"] {
                    text-decoration: none;
                    color: black; /* or whatever your want */
                    pointer-events: none;
                    cursor: default;
                }

                .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                    text-decoration: default;
                    color: orange !important; /* or whatever your want */
                    pointer-events: auto;
                    cursor: default;
                }
            }

            /* More Specific Targeting */

            @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
                /* You guessed it, ipad (tablets, smaller screens, etc) */

                /* Step 1a: Repeating for the iPad */
                a[href^="tel"], a[href^="sms"] {
                    text-decoration: none;
                    color: blue; /* or whatever your want */
                    pointer-events: none;
                    cursor: default;
                }

                .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                    text-decoration: default;
                    color: orange !important;
                    pointer-events: auto;
                    cursor: default;
                }
            }

            @media only screen and (-webkit-min-device-pixel-ratio: 2) {
                /* Put your iPhone 4g styles in here */
            }

            /* Following Android targeting from:
            http://developer.android.com/guide/webapps/targeting.html
            http://pugetworks.com/2011/04/css-media-queries-for-targeting-different-mobile-devices/  */
            @media only screen and (-webkit-device-pixel-ratio:.75){
                /* Put CSS for low density (ldpi) Android layouts in here */
            }
            @media only screen and (-webkit-device-pixel-ratio:1){
                /* Put CSS for medium density (mdpi) Android layouts in here */
            }
            @media only screen and (-webkit-device-pixel-ratio:1.5){
                /* Put CSS for high density (hdpi) Android layouts in here */
            }
            /* end Android targeting */
        </style>

        <!-- Targeting Windows Mobile -->
        <!--[if IEMobile 7]>
        <style type="text/css">

        </style>
        <![endif]-->

        <!-- ***********************************************
        ****************************************************
        END MOBILE TARGETING
        ****************************************************
        ************************************************ -->

        <!--[if gte mso 9]>
        <style>
                /* Target Outlook 2007 and 2010 */
        </style>
        <![endif]-->
    </head>
    <body>
        <!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
        <table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
            <tr>
                <td>

                    <!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
                    <table cellpadding="0" cellspacing="0" border="0" align="center">
                        <tr>
                            <td width="200" valign="top"></td>
                            <td width="200" valign="top"></td>
                            <td width="200" valign="top"></td>
                        </tr>
                    </table>

                    <!-- End example table -->

                    <!-- Yahoo Link color fix updated: Simply bring your link styling inline. -->


                    <!-- Gmail/Hotmail image display fix: Gmail and Hotmail unwantedly adds in an extra space below images when using non IE browsers.  This can be especially painful when you putting images on top of each other or putting back together an image you spliced for formatting reasons.  Either way, you can add the 'image_fix' class to remove that space below the image.  Make sure to set alignment (don't use float) on your images if you are placing them inline with text.-->

                    <p> Hello <?= (isset($model->first_name)) ? $model->first_name . ',' : "there " ?></p>

                    <p> Welcome and we are truly grateful to you for your registration
                        .”</p>

                    <p>Please click the below link to activate your account or copy paste to the browser</p>
                    <?php $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one(); ?>

                    <?php if ($config->website == $_SERVER['HTTP_HOST']) {
                        ?>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/site/activation?auth=<?= ($model->auth_key) ? $model->auth_key : '' ?>&username=<?= ($model->email) ? $model->email : '' ?>">http://<?= $_SERVER['HTTP_HOST'] ?>/site/activation?auth=<?= ($model->auth_key) ? $model->auth_key : '' ?>&username=<?= ($model->email) ? $model->email : '' ?></a>

                    <?php } else { ?>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/abrajcms/site/activation?auth=<?= ($model->auth_key) ? $model->auth_key : '' ?>&username=<?= ($model->email) ? $model->email : '' ?>">http://<?= $_SERVER['HTTP_HOST'] ?>/abrajcms/site/activation?auth=<?= ($model->auth_key) ? $model->auth_key : '' ?>&username=<?= ($model->email) ? $model->email : '' ?></a>

                    <?php } ?>



                    <p>Thank You,</p>
                    <p>Lootah Biofuels</p>
                    <!-- Step 2: Working with telephone numbers (including sms prompts).  Use the "mobile_link" class with a span tag to control what number links and what doesn't in mobile clients. -->


                </td>
            </tr>
        </table>
        <!-- End of wrapper table -->
    </body>
</html>
