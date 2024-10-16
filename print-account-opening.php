<?php 
include 'root/process.php';
$currentUrl = $_SERVER['REQUEST_URI'];
$parts = explode('/', $currentUrl);
$accid = $parts[count($parts) - 2]; 
$fullnameWithHyphens = $parts[count($parts) - 1];
$fullnamed = str_replace('-', ' ', $fullnameWithHyphens);
$acct = dbRow("SELECT * FROM customer_accounts WHERE account_number = '$accid' ");
$user = dbRow("SELECT * FROM users WHERE userid = '".$acct->userid."' ");
$accty = dbRow("SELECT * FROM account_types WHERE acc_id  = '".$acct->acc_id."' ");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="http://localhost/kitudesacco/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Print</title>
    <style type="text/css">
        * {
        font-size: 12px;
        font-family: 'Times New Roman';
        }
        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }
        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }
        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }
        td.price,
        th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }
        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 155px;
            max-width: 155px;
        }
        img {
            max-width: inherit;
            width: inherit;
        }
        @media print {
            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
</head>
    <body>
        <div class="ticket">
            <center><img src="uploadx/logo-transparent.png" style="width: 100px; " alt="Logo"></center>
            <p class="centered">KITUDE SACCO</p>
            <p class="centered">
                <br>Tel: 0703551093,0772521668</p>
                    <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial">
                        <tr> <td style="font-size:14px"> <b> ACC OPENING RECEIPT HISTORY</b> </td> </tr>
                        <tr> <td> <b> Receipt No.: <?=$rx->barcode;?> </b> </td> </tr>
                        <tr> <td><?php echo $dtime;?> </td> </tr>
                        <?php $cod = dbRow("SELECT * FROM clients WHERE cid = '".$rx->cid."' "); ?>
                        <tr> <td> Client: <strong><?=ucwords($cod->fname.'&nbsp;'.$cod->lname);?>&nbsp;</strong> </td> </tr>
                    </table>
                    <hr style="border:1px dashed #000;margin:2px" />
                    <table style="width:100%;font-size:10px;font-family:'Fake Receipt', arial" >
                        <tr>    
                            <td > Loan Installment <?=$rx->loan_installments; ?> Time(s)</td>
                            <td> </td>
                            <!-- <td> Interest Rate <?=$rx->interest_rate; ?> %</td> -->
                        </tr>
                    </table>
                    <hr style="border:1px dashed #000;margin:2px" />
                    <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" >
                        <tr>    
                            <td> Subtotal Recieved: </td>
                            <td> </td>
                            <td style="float:right;margin-right:20px"> UGX <?=number_format($rx->loan_amount);?> </td>
                        </tr>
                        <tr>    
                            <td> <b> TOTAL RECIEVED:  </b></td>
                            <td> </td>
                            <td style="float:right;margin-right:20px">  <b> UGX <?=number_format($rx->loan_amount);?> </b></td>
                        </tr>
                    </table>
                    <hr style="border:1px dashed #000;margin:2px" />
                    <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" >
                        <tr>
                            <td><b>TOTAL TO BE PAYMENT: </b></td>
                            <td></td>
                            <td>
                                <?php 
                                $pi = ($rx->loan_amount * $rx->interest_rate)/100;
                                echo '<b> UGX. '.(number_format($pi + $rx->loan_amount)).'</b>';  ?>
                            </td>
                        </tr>
                    </table>
                    <hr style="border:1px dashed #000;margin:2px" />
                    <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" >
                        <tr>
                            <td><b>DAILY PAYMENT: </b></td>
                            <td></td>
                            <td>
                                <?php 
                                $pi = ($rx->loan_amount * $rx->interest_rate)/100;
                                $daily_payment = ($pi + $rx->loan_amount)/ $rx->loan_installments;
                                echo '<b> UGX. '.number_format($daily_payment).'</b>';  ?>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <?php $hissx = $dbh->query("SELECT SUM(deposit) AS 'Deposit', phid, loan_id, cid FROM payment_history WHERE cid = '".$rx->cid."'  ");
                        $rro = $hissx->fetch(PDO::FETCH_OBJ); ?>
                <hr style="border:1px dashed #000;margin:2px" />
                <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" >
                    <tr>
                        <td><b>AMOUNT PAID: </b></td>
                        <td></td>
                        <td><b>UGX.<?=number_format($rro->Deposit); ?></b></td>
                    </tr>
                </table>
                <hr style="border:1px dashed #000;margin:2px" />
                <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" >
                    <tr>
                        <td><b>TOTAL BALANCE: </b></td>
                        <td></td>
                        <?php $pi = (($rx->loan_amount * $rx->interest_rate)/100 + $rx->loan_amount); ?>
                        <td><b>UGX. <?=number_format($pi - $rro->Deposit); ?></b></td>
                    </tr>
                </table>
                <hr style="border:1px dashed #000;margin:2px" />
                <hr style="border:1px dashed #000;margin:2px" />
                 <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" border="1" >
                    <?php 
                    $payhistory = $dbh->query("SELECT * FROM payment_history WHERE loan_id = '".$rx->loan_id."' AND cid = '".$rx->cid."' ");
                    while($rr = $payhistory->fetch(PDO::FETCH_OBJ)){ ?>
                    <tr>
                        <td><b> Amount</b></td>
                        <td><b>UGX. <?=number_format($rr->deposit); ?></b><br></td>
                        <td><?=$rr->date_paid; ?><br></td>
                    </tr>
                    <?php } ?>
                </table>
                <br/>
                 <center>
                    <?php $pcci = dbRow("SELECT * FROM client_photos WHERE cid = '".$rx->cid."' "); ?>
                    <img style="width: 100px; " src="<?=$pcci->client_photo; ?>">
                    </center>
                <center style="font-size:12px;font-family:'Fake Receipt', arial"> <i> Thank you!!! </i> </center>
            <p class="centered">Thanks for your !
                <br>parzibyte.me/blog</p>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
        <script>
            const $btnPrint = document.querySelector("#btnPrint");
            $btnPrint.addEventListener("click", () => {
                window.print();
            });
        </script>
    </body>
</html>