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
                    <tr> <td> <b> Customer.: <?=ucwords($user->firstname.' '.$user->lastname);?> </b> </td> </tr>
                    <tr> <td> <b> Account No.: <?=$acct->account_number;?> </b> </td> </tr>
                    <tr> <td><?php echo $dtime;?> </td> </tr>
                </table>
                <hr style="border:1px dashed #000;margin:2px" />
                <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" >
                    <p><b>PAYMENT HISTORY: </b></p>
                <?php $account_nubz = $dbh->query("SELECT * FROM account_payment_history WHERE account_number = '".$acct->account_number."' ");
                    $x = 1; 
                    while($rx = $account_nubz->fetch(PDO::FETCH_OBJ)){?>
                        <tr>
                            <td>
                                <b>Ugx. <?=number_format($rx->accph_amount); ?></b> - <?=$rx->accph_time; ?>
                            </td>
                        </tr>
                <?php } ?>
                </table>

            <hr style="border:1px dashed #000;margin:2px" />
            <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" >
                <tr>
                    <td><b>AMOUNT PAID: </b></td>
                    <td></td>
                    <td><b>USh <?=number_format($acct->opening_amount_paid); ?></b></td>
                </tr>
            </table>
            <hr style="border:1px dashed #000;margin:2px" />
            <table style="width:100%;font-size:12px;font-family:'Fake Receipt', arial" >
                <tr>
                    <td><b>TOTAL BALANCE: </b></td>
                    <td></td>
                    <td><b>USh <?=number_format($acct->opening_amount-$acct->opening_amount_paid); ?></b></td>
                </tr>
            </table>
            <hr style="border:1px dashed #000;margin:2px" />
            <center style="font-size:12px;font-family:'Fake Receipt', arial"> 
                <i> Thank you!!!
            </center>
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