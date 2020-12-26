<?php
$user=  \common\models\UserAddress::find()->where(['user_id'=>$order->user_id,'id'=>$order->user_id])->one();
$user_address=  \common\models\UserAddress::find()->where(['id' => $order->ship_address_id])->one();
$billing_address =  \common\models\UserAddress::find()->where(['id' => $order->bill_address_id])->one();
$order_details=  \common\models\OrderedProducts::find()->where(['order_id'=>$order->id])->all();
$state=common\models\States::findOne($billing_address->state); 
$country=common\models\Countries::findOne($billing_address->country_id); 
$billing_address =\common\models\UserAddress::find()->where(['id' => $order->bill_address_id])->one();
?>


<html>
        <head>
                <title>Dunia Pay.com: New Order to admin # <?php echo $order->id; ?></title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        </head>
        <style>

        </style>
        <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
                <!-- Save for Web Slices (emailer.psd) -->
                <div style="margin:auto; width:776px; border:solid 2px #404241; margin-top:40px; margin-bottom:40px;">
                        <table id="Table_01" width="776" border="0" cellpadding="0" cellspacing="0" align="center" style=" font-family: 'Open Sans',arial, sans-serif;">
                              <?= $this->render("_mailheader") ?>
                                <tr>
                                        <td valign="top">
                                                <h1 style="font-size:22px;font-weight:normal;line-height:22px;margin:13px 0 12px 9px;text-align:left;">Hello, Admin
                                                        <span style="float: right;font-size: 13px;padding: 10px;font-weight: bold; padding-top: 0px;">Order ID #<?php echo $order->id; ?></span>
                                                </h1>
                                                <p style="font-size:13px;line-height:16px;margin: 0px 12px 8px 9px;text-align:left;">
                                                        A order from   <?php echo $user->first_name." ".$user->last_name; ?><small>(placed on <?php
                                                                echo
                                                                date("F d , Y", strtotime($order->created_on));
                                                                ?>)</small>
                                                </p>
                                        </td>
                                </tr>
                               <tr>
                                        <td>
                                                <table cellspacing="0" cellpadding="0" border="0" width="776" style="    font-family: 'Open Sans',arial, sans-serif;font-size: 13px;">
                                                        <thead>
                                                                <tr>
                                                                        <th align="left" width="325" bgcolor="#EAEAEA" style="    font-family: 'Open Sans',arial, sans-serif;font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Billing Information:</th>
                                                                        <th width="10"></th>
                                                                        <th align="left" width="325" bgcolor="#EAEAEA" style="font-family:'Open Sans',arial, sans-serif;font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Payment Method:</th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                                <tr>
                                                                        <td valign="top" style="font-size:13px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                                                
                                                                             
                                                                              
                                                                               
                                                                                
                                                                                 
                                                                            
                                                                          <?=$billing_address->first_name." ".$billing_address->last_name  ?> <br>
                                                                          <?= $billing_address->address_1 !="" ? $billing_address->address_1. '<br>' : ''; ?> 
                                                                          <?=$billing_address->address_2 !="" ? $billing_address->address_2. '<br>' : ''; ?>
                                                                          <?=$billing_address->postcode;  ?><br>
                                                                          <?=$billing_address->city;  ?><br>
                                                                          <?=$state->state_name;?> <br>
                                                                          <?= $country->country_name;?><br>

                                                                               





                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                        <td valign="top" style="font-family: 'Open Sans',arial, sans-serif;font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                                                <p style="text-transform: uppercase;font-weight: bold;padding-top:20px;">pay via <?php
                                                                                        if ($order->payment_mode == 1) {
                                                                                                echo "CREDIT/DEBIT CARD OR NET BANKING";
                                                                                        } elseif ($order->payment_mode == 2) {
                                                                                                echo "Paypal";
                                                                                        } elseif ($order->payment_mode == 3) {
                                                                                                echo "Cash On Delivery";
                                                                                        } elseif ($order->payment_mode == 4) {
                                                                                                $wallet_amt = $order->wallet;
                                                                                                if ($order->netbanking != '') {
                                                                                                        $payment_amt = $order->netbanking;
                                                                                                        $method = 'CREDIT/DEBIT CARD OR NET BANKING';
                                                                                                } else if ($order->paypal != '') {
                                                                                                        $payment_amt = $order->paypal;
                                                                                                        $method = 'Paypal';
                                                                                                }
                                                                                                echo "<br>Credit Amount = " . $wallet_amt;
                                                                                                echo "<br>" . $method . " = " . $payment_amt;
                                                                                        }
                                                                                        ?></p>



                                                                        </td>
                                                                </tr>
                                                        </tbody>
                                                </table>
                                                <br>

                                                <table cellspacing="0" cellpadding="0" border="0" width="776" style="    font-family: 'Open Sans',arial, sans-serif;font-size: 13px;">
                                                        <thead>
                                                                <tr>
                                                                        <th align="left" width="364" bgcolor="#EAEAEA" style="font-family:'Open Sans',arial, sans-serif;font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Shipping Information:</th>
                                                                        <th width="10"></th>
                                                                        <th align="left" width="364" bgcolor="#EAEAEA" style="font-family:'Open Sans',arial, sans-serif;font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Shipping Method:</th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                                <tr>
                                                                        <td valign="top" style="font-size:13px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                                              <?php echo $user_address->first_name." ".$user_address->last_name; ?><br>
                                                                                 <?= $user_address->address_1 !="" ? $user_address->address_1. '<br>' : ''; ?> 
                                                                                <?=$user_address->address_2 !="" ? $user_address->address_2. '<br>' : ''; ?>
                                                                                <?php echo $user_address->postcode; ?><br>
                                                                                <?=$state->state_name;?> <br>
                                                                                <?= $country->country_name;?><br>  
                                                                            
                                                                                &nbsp;
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                        <td valign="top" style="font-size:13px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                                                                <?php
                                                                                if ($shipping_charge == 0 || $shipping_charge == '') {
                                                                                        echo " Free Shipping";
                                                                                } else {
                                                                                        ?>
                                                                                        Shipping Rate:<?php
                                                                                       // echo Yii::app()->Currency->convertCurrencyCode($shipping_charge);
                                                                                }
                                                                                ?> ( delivered within 3-14 working days )
                                                                                &nbsp;
                                                                        </td>
                                                                </tr>
                                                        </tbody>
                                                </table>
                                                <br>
                                                <table cellspacing="0" cellpadding="0" border="0" width="776" style="border:1px solid #eaeaea;font-family: 'Open Sans',arial, sans-serif;">
                                                        <thead>
                                                                <tr>
                                                                        <th align="left" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Item</th>
                                                                        <th align="left" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Code</th>
                                                                        <th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Qty</th>
                                                                        <th align="right" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Subtotal</th>
                                                                        <th align="right" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px">Options</th>
                                                                </tr>
                                                        </thead>

                                                        <tbody bgcolor="#F6F6F6">
                                                                <?php
                                                              $total=0;
                                                         $shipping=0;   
                                                                foreach ($order_details as $orders)  {
                                                                 $product_names = \common\models\Products::find()->where(['id' => $orders->product_id])->one();
                                                                  $product=  common\models\ProductDescription::find()->where(['product_id'=>$product_names->id])->one();     
                                                                  $sub=$orders->amount * $orders->quantity;      
                                                                      $get_options = explode(',', $orders->options);
                                                                        ?>
                                                                        <tr>
                                                                                <td align="left" valign="top" style="font-size:11px;padding:3px 9px;padding-top:10px; padding-bottom:10px;border-bottom:1px dotted #cccccc;">
                                                                                        <strong style="font-size:11px;text-transform: uppercase;"><?php echo $product->product_name; ?></strong>
                                                                                       
                                                                                </td>
                                                                                <td align="left" valign="top" style="font-size:11px;padding:3px 9px;padding-top:10px;padding-bottom:10px;border-bottom:1px dotted #cccccc;"><?php echo $product_names->product_code; ?></td>
                                                                                <td align="center" valign="top" style="font-size:11px;padding:3px 9px;padding-top:10px;padding-bottom:10px;border-bottom:1px dotted #cccccc;"><?php echo $orders->quantity; ?></td>
                                                                                <td align="right" valign="top" style="font-size:11px;padding:3px 9px;padding-top:10px;padding-bottom:10px;border-bottom:1px dotted #cccccc;">


                                                                                        <span><?= $sub?></span>                                        </td>
                                                                                        <td>
                                                                                               <?php if ($get_options != NULL) { ?>
                                                                                                <?php foreach ($get_options as $get_option) { ?>
                                                                                                        <?php $exp_val = explode(':', $get_option); ?>
                                                                                                        <?php
                                                                                                        $filter_bundle = common\models\Filter::findOne($exp_val[0]);
                                                                                                        $filter_v = \common\models\FilterData::findOne($exp_val[1]);
                                                                                                        ?>
                                                                                                    <?php /* <?php echo $filter_bundle->name; ?> : <span><?php echo $filter_v->data; ?></span>&nbsp; <img src="<?= Yii::getAlias('@web'); ?>/uploads/filter-cmb-image/<?= $product_filt_combinaton->id?>/<?= $product_filt_combinaton->combination_image?>" width="50px" height="50px"/> */ ?><br/>
                                                                                
                                                                                                    <?php } ?>
                                                                                                <?php } ?>
                                                                                                </td>
                                                                        </tr>
                                                              <?php
                                                              $total +=$sub;
                                                              $shipping +=$orders->shipping_charge;
                                                                }
                                                                
                                                                
                                                                ?>
                                                                <tr>
                                              
                                                                        <td colspan="3" align="right" style="padding:13px 9px 0 0;font-size:13px;">
                                                                                Subtotal                    </td>
                                                                        <td align="right" style="padding:13px 9px 0 0;font-size:13px;">
                                                                                <span><?= $total;?></span>                    </td>
                                                                </tr>
                                                                <tr>
                                                                        <td colspan="3" align="right" style="padding:3px 9px;font-size:13px;">
                                                                                Shipping &amp; Handling                    </td>
                                                                        <td align="right" style="padding:3px 9px;font-size:13px;">
                                                                                <span><?=$shipping;?></span>                    </td>
                                                                </tr>
                                                              
                                                                <tr>
                                                                        <td colspan="3" align="right" style="padding:3px 9px 13px 0;font-size:13px;">
                                                                                <strong>Grand Total</strong>
                                                                        </td>
                                                                        <td align="right" style="padding:3px 9px 13px 0;font-size:13px;">
                                                                                <strong><span><?= $total + $shipping;?></span></strong>
                                                                        </td>
                                                                </tr>
                                                                  <tr>
                                                                    <td></td>
                                                                </tr>
                                                        </tbody>
                                                </table>

                                                <br>
                                                <p style="font-size:12px;margin:0 0 10px 0"></p>
                                        </td>
                                </tr>


  <?= $this->render("_mailfooter") ?>
                               
                        </table></div>
                <!-- End Save for Web Slices -->
        </body>
</html>
