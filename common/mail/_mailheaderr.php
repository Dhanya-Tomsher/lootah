<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <title>TradeFlow</title> <!-- The title tag shows in email notifications-->
    <style>
	  * {
                font-family: 'Poppins', 'Poppins', sans-serif;
        }
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }
		
		/*Hero area H1 css and paragraph css*/
		.header-td{
			padding: 40px 60px 30px 40px; 
			font-family: 'Poppins', sans-serif;
			}
		.h1-title{
			font-family: 'Poppins', sans-serif; 
			font-size: 24px; 
			line-height: 42px; 
			color: #111111; 
			font-weight: 600;
			}
		.h1-title-a{
			color: #111111;
			text-decoration: none;
			}
		.header-p{
			margin: 0; 
			font-size: 14px; 
			line-height: 26px; 
			color: #767676; 
			font-weight: normal;
			}
			
		/*Services area H2 Anchor link color css*/
		.h2-title{
			margin: 0 0 10px 0; 
			font-family: 'Poppins', sans-serif; 
			font-size: 17px; 
			font-weight: 600;
			line-height: 27px; 
			color: #333333; 
			}
		.h2-title-a{
			color: #333333;
			text-decoration: none;
			}
			
		/*Services area Paragraph css*/
			.services-td-1{
			padding: 30px 60px 32px 40px;
			font-family: 'Poppins', sans-serif;
			}		
			.services-td-2{
			padding: 32px 60px 40px 40px;
			font-family: 'Poppins', sans-serif;
			}
		 .services-p{
			 margin: 0; 
			 font-family: 'Poppins', sans-serif; 
			 font-size: 13px; 
			 line-height: 25px; 
			 color: #4d4d4d; 
			 font-weight: normal;
			 }
			 
		/*Call to action css of bottom*/ 
		.cta-h1{
			margin: 0 0 10px 0; 
			font-family: 'Poppins', sans-serif; 
			font-size: 34px; 
			line-height: 48px; 
			color: #ffffff; 
			font-weight: 600;
			}
		
		/*Call to action css of botton*/ 
		.cta-button{
				background: #e74c3c;
				font-family: 'Poppins', sans-serif;font-size: 14px;
				line-height: 26px;
				text-align: center;
				text-decoration: none;
				display: block;
				padding: 10px 40px 10px 40px;
				border-radius: 3px;
				font-weight: normal; 
				color:#FFF;
				}
				
			.cta-bg-1{
				background: #4285f4; 
				padding: 80px 0px 30px 0px;
				font-family: 'Poppins', sans-serif; 
				text-align: center;
				}
			.cta-bg-2{
				background: #4285f4; 
				padding: 0px 0px 80px 0; 
				font-family: 'Poppins', sans-serif;
				}
			.address-p{
				margin: 0; 
				font-family: 'Poppins', sans-serif; 
				font-size: 10px; 
				line-height: initial; 
				color: #515151; 
				font-weight: normal;
				}
				
			 .subscribe-p{
				 margin: 0; 
				 font-family: 'Poppins', sans-serif; 
				 font-size: 10px; 
				 line-height: initial; 
				 color: #515151; 
				 font-weight: normal;
				 }
			  .subscribe-a{
				  color:#4285f4;
				  text-decoration:underline;
				  }

        *[x-apple-data-detectors],
        .x-gmail-data-detectors, 
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .a6S {
	        display: none !important;
	        opacity: 0.01 !important;
        }
        img.g-img + div {
	        display:none !important;
	   	}
        .button-link {
            text-decoration: none !important;
        }
		.button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }
		.button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }
		
        /* Media Queries */
        @media screen and (max-width: 620px) {
			.email-container p {
				font-size: 14px !important;
				line-height: 26px !important;
			}
        }
		@media screen and (max-width: 480px) {
			 td[class="split-mob-1"] {
				padding-right:10px !important;
			 }
			  td[class="split-mob-3"] {
				padding-right:10px !important;
			 }
		}
        @media screen and (max-width: 375px) {
			 img[class="banner"] {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }
			table[class="container"]{
				width:320px !important;
				}
			 td[class="split-mob-1"] {
				padding-bottom:15px !important;
				display:block !important;
				width:100% !important;
			 }
			  td[class="split-mob-2"] {
				display:block !important;
				width:100%; !important;
			 }
			 td[class="split-mob-3"] {
				display:block !important;
				width:100%; !important;
			 }
			 td[class="split-mob-4"] {
				display:block !important;
				width:100%; !important;
			 }
			.email-container p {
				font-size: 13px !important;
    			line-height: 25px !important;
			}
			.header-td{
				padding: 20px 15px 15px 20px !important;;
				font-family: 'Poppins', sans-serif !important;;
				}
			td.services-td-1{
				padding: 10px 20px 15px 20px !important;;
				font-family: 'Poppins', sans-serif !important;;
				}
			.services-td-2{
				padding: 10px 20px 15px 20px !important;;
				font-family: 'Poppins', sans-serif !important;;
				}
			.cta-bg-1 {
				background: #4285f4 !important;;
				padding: 40px 0px 15px 0px !important;;
				font-family: 'Poppins', sans-serif !important;;
				text-align: center !important;;
			}
			.cta-h1{
				color: #ffffff !important;
				font-family: "Poppins",sans-serif !important;
				font-size: 24px !important;
				font-weight: 600 !important;
				line-height: 40px !important;
				margin: 0 0 10px !important;
				}
        }

    </style>
    
    <!--[if gte mso 9]>
    <xml>
      <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
     </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    
</head>
<body width="100%" bgcolor="#cccccc" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background: #cccccc; text-align: left;">

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: 'Poppins', sans-serif;">
            Welcome to TradeFlo. 
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!--
            Set the email width. Defined in two places:
            1. max-width for all clients except Desktop Windows Outlook, allowing the email to squish on narrow but never go wider than 620px.
            2. MSO tags for Desktop Windows Outlook enforce a 620px width.
        -->
        <div style="max-width: 620px; margin: auto;" class="email-container">
            <!--[if mso]>
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="620" align="center">
            <tr>
            <td>
            <![endif]-->

            <!-- Email Header : BEGIN --><!-- Email Header : END -->

            <!-- Email Body : BEGIN -->
            <table class="container" role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 620px;">
					 <tr>
                                <td style="background: #ffffff; padding: 26px 0px 26px 0px;font-family: 'Poppins', sans-serif; text-align: center;">
 								<img src="http://tomsher.com/tradeflo/images/logo-main.png" aria-hidden="true" style="height:auto; width:100px"  alt="alt_text" border="0" align="center" style="width: 147px; max-width: 147px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                </td>
                            </tr>