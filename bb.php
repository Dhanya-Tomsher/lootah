<?php
/**
 * This Is the Kit File To Be included For Transaction Request/Response
 */
include 'AWLMEAPI.php';

//create an Object of the above included class
$obj = new AWLMEAPI();

/* This is the response Object */
$resMsgDTO = new ResMsgDTO();

/* This is the request Object */
$reqMsgDTO = new ReqMsgDTO();

//This is the Merchant Key that is used for decryption also
$enc_key = "ff16753774f0fca7da770d545cf9a0d3";

/* Get the Response from the WorldLine */
$responseMerchant = $_REQUEST['merchantResponse'];

$response = $obj->parseTrnResMsg($responseMerchant, $enc_key);
?>
<style>
    body{
        font-family:'Verdana, sans-serif';
        font-size:12px;
    }
    .wrapper{
        width:980px;
        margin:0 auto;
    }
    table{

    }
    tr{
        padding:5px
    }
    td{
        padding:5px;
    }
    input{
        padding:5px;
    }
</style>


<?php
$amt = $response->getTrnAmt() / 100;
if ($response->getAddField1() == "Laksyah Products") {
    if ($response->getStatusCode() == "S") {
        header("location:https://laksyah.com/beta/index.php/CheckOut/OrderSuccess/payid/" . $response->getOrderId() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    } else {
        header("location:https://laksyah.com/beta/index.php/CheckOut/OrderFailed/payid/" . $response->getOrderId() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    }
} else if ($response->getAddField1() == "Laksyah Payment") {
    if ($response->getStatusCode() == "S") {
        header("location:https://laksyah.com/beta/index.php/Myaccount/MakePaymentSuccess/enquiry_id/" . $response->getAddField2() . "/history_id/" . $response->getAddField3() . "/payment_id/" . $response->getAddField4() . "/tranid/" . $response->getOrderId() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    } else {
        header("location:https://laksyah.com/beta/index.php/Myaccount/MakePaymentError/enquiry_id/" . $response->getAddField2() . "/history_id/" . $response->getAddField3() . "/payment_id/" . $response->getAddField4() . "/tranid/" . $response->getOrderId() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    }
} else if ($response->getAddField1() == "Laksyah Direct Payment") {
    if ($response->getStatusCode() == "S") {
        header("location:https://laksyah.com/beta/index.php/Myaccount/MakeDirectPaymentSuccess/payment_id/" . $response->getAddField3() . "/tranid/" . $response->getOrderId() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    } else {
        header("location:https://laksyah.com/beta/index.php/Myaccount/MakeDirectPaymentError/payment_id/" . $response->getAddField3() . "/tranid/" . $response->getOrderId() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    }
} else if ($response->getAddField1() == "Laksyah Wallet") {
    if ($response->getStatusCode() == "S") {
        header("location:https://laksyah.com/beta/index.php/myWallet/CreditSuccess/payid/" . $response->getOrderId() . "/user_id/" . $response->getAddField4() . "/wallet_id/" . $response->getAddField3() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    } else {
        header("location:https://laksyah.com/beta/index.php/myWallet/CreditError");
    }
} else if ($response->getAddField1() == "Laksyah Giftcard") {
    if ($response->getStatusCode() == "S") {
        header("location:https://laksyah.com/beta/index.php/Giftcard/OrderSuccess/payid/" . $response->getOrderId() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    } else {
        header("location:https://laksyah.com/beta/index.php/Giftcard/OrderFailed/payid/" . $response->getOrderId() . "/tid/" . $response->getPgMeTrnRefNo() . "/amt/" . $amt);
    }
}
?>
<form action="testTxnStatus.php" method="POST" >
    <center> <H3>Transaction Status </H3></center>
    <table>
        <tr><!-- PG transaction reference number-->
            <td><label for="txnRefNo">Transaction Ref No. :</label></td>
            <td><?php echo $response->getPgMeTrnRefNo(); ?></td>
            <!-- Merchant order number-->
            <td><label for="orderId">Order No. :</label></td>
            <td><?php echo $response->getOrderId(); ?> </td>
            <!-- Transaction amount-->
            <td><label for="amount">Amount :</label></td>
            <td><?php echo $amt; ?></td>
        </tr>
        <tr><!-- Transaction status code-->
            <td><label for="statusCode">Status Code :</label></td>
            <td><?php echo $response->getStatusCode(); ?></td>

            <!-- Transaction status description-->
            <td><label for="statusDesc">Status Desc :</label></td>
            <td><?php echo $response->getStatusDesc(); ?></td>

            <!-- Transaction date time-->
            <td><label for="txnReqDate">Transaction Request Date :</label></td>
            <td><?php echo $response->getTrnReqDate(); ?></td>
        </tr>
        <tr>
            <!-- Transaction response code-->
            <td><label for="responseCode">Response Code :</label></td>
            <td><?php echo $response->getResponseCode(); ?></td>

            <!-- Bank reference number-->
            <td><label for="statusDesc">RRN :</label></td>
            <td><?php echo $response->getRrn(); ?></td>
            <!-- Authzcode-->
            <td><label for="authZStatus">AuthZCode :</label></td>
            <td><?php echo $response->getAuthZCode(); ?></td>
        </tr>
        <tr>	<!-- Additional fields for merchant use-->
            <td><label for="addField1">Add Field 1 :</label></td>
            <td><?php echo $response->getAddField1(); ?></td>

            <td><label for="addField2">Add Field 2 :</label></td>
            <td><?php echo $response->getAddField2(); ?></td>

            <td><label for="addField3">Add Field 3 :</label></td>
            <td><?php echo $response->getAddField3(); ?></td>
        </tr>
        <tr>
            <td><label for="addField4">Add Field 4 :</label></td>
            <td><?php echo $response->getAddField4(); ?></td>

            <td><label for="addField5">Add Field 5 :</label></td>
            <td><?php echo $response->getAddField5(); ?></td>

            <td><label for="addField6">Add Field 6 :</label></td>
            <td><?php echo $response->getAddField6(); ?></td>
        </tr>
        <tr>
            <td><label for="addField7">Add Field 7 :</label></td>
            <td><?php echo $response->getAddField7(); ?></td>

            <td><label for="addField8">Add Field 8 :</label></td>
            <td><?php echo $response->getAddField8(); ?></td>
        </tr>

    </table>
</form>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

