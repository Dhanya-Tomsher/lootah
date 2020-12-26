
<html>
        <head>
                <title>emailer</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        </head>
        <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
                <!-- Save for Web Slices (emailer.psd) -->
                <div style="margin:auto; width:776px; border:solid 2px #404241; margin-top:40px; margin-bottom:40px;">
                        <table id="Table_01" width="776" border="0" cellpadding="0" cellspacing="0" align="center">
                                <?= $this->render("_mailheader") ?>
                                <tr>
                                        <td>
                                                <div style="padding: 2em">
                                                        <br>
                                                        Hi <?=$name?><br><br>
                                                        <?php echo $message ?>



                                                </div>
                                        </td>
                                </tr>

                                 <?= $this->render("_mailfooter") ?>
                        </table></div>
                <!-- End Save for Web Slices -->
        </body>
</html>