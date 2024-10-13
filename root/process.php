<?php 
include('config.php');
$errors = array();
foreach ($errors as $error) {
    echo $errors;
}

if (isset($_POST['register_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
        //`userid`, `firstname`, `lastname`, `gender`, `phone`, `business_location`, `role`, `password`, `account_number`, `account_status`, `date_registered`
        $check = $dbh->query("SELECT phone FROM users WHERE phone='$phone' ")->fetchColumn();
        if(!$check){
            $firstname = addslashes($firstname);
            $lastname = addslashes($lastname);
            $phone = addslashes($phone);
            $phone = addslashes($phone);
            $gender = addslashes($gender);
            $pwd = sha1($password);
            $result = $dbh->query("INSERT INTO users VALUES(NULL,'$firstname','$lastname','$gender','$phone','$business_location','$role','$pwd','$account_number','active','$today')");
            if($result){
                //`mfee_id`, `membership_amount`, `account_number`, `date_time_paid`, `date_paid`
                $dbh->query("INSERT INTO welfare VALUES(NULL, '$account_number', '0','$today') ");
                $dbh->query("INSERT INTO savings VALUES(NULL, '$account_number', '0','$today') ");
                $dbh->query("INSERT INTO membership_fee VALUES(NULL, '0', '$account_number', '$dtime','$today') ");
                $dbh->query("INSERT INTO ceremonials VALUES(NULL, '0', '$account_number', '$dtime','$today') ");
                $message = "KITUDE SACCO. Hi ".$firstname.', your account is created successfully, Your Phone No '.$phone.' and Pass '.$password;
                @json_decode(send_sms_yoola_api($phone, $message), true);
                $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Registration is Successful</div>';
                $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
                header("refresh:2; url=admin-members");
            }else{
                $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Email Address registration failed</div>';
            }
        }else{
        $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
            This Phone number already exist
            </div>';
        }
    }
}elseif (isset($_POST['register_btn_customer'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
        //`userid`, `firstname`, `lastname`, `gender`, `phone`, `business_location`, `role`, `password`, `account_number`, `account_status`, `date_registered`
        $check = $dbh->query("SELECT phone FROM users WHERE phone='$phone' ")->fetchColumn();
        if(!$check){
            $firstname = addslashes($firstname);
            $lastname = addslashes($lastname);
            $gender = addslashes($gender);
            $phone = addslashes($phone);
            $business_location = addslashes($business_location);
            $pwd = sha1($password);
            $sql = "INSERT INTO users VALUES(NULL,'$firstname','$lastname','$gender','$phone','$business_location','customer','$pwd','$account_number','active','$today')";
            $result = dbCreate($sql);
            if($result == 1){
                // `welfare_id`, `account_number`, `account_balance`, `welfare_last_paid`
                //`ceremonial_id`, `ceremonial_amount`, `account_number`, `date_time_paid`, `date_paid`
                $dbh->query("INSERT INTO welfare VALUES(NULL, '$account_number', '0','$today') ");
                $dbh->query("INSERT INTO savings VALUES(NULL, '$account_number', '0','$today') ");
                $dbh->query("INSERT INTO membership_fee VALUES(NULL, '0', '$account_number', '$dtime','$today') ");
                $dbh->query("INSERT INTO ceremonials VALUES(NULL, '0', '$account_number', '$dtime','$today') ");
                $message = "KITUDE SACCO. Hi ".$firstname.', your account is created successfully, Your Phone No '.$phone.' and Pass '.$password;
                @json_decode(send_sms_yoola_api($phone, $message), true);
                $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Registration is Successful</div>';
                $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
                header("refresh:2; url=normal-members");
            }else{
                $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Phone registration failed</div>';
            }
        }else{
       $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
            This Phone number already exists in the system
            </div>';
        }
    }
}elseif (isset($_POST['login_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
        $password = sha1($password);
        $result = $dbh->query("SELECT * FROM users WHERE phone = '$phone' AND password = '$password' AND account_status = 'active' ");
        $result1 = $dbh->query("SELECT * FROM users WHERE phone = '$phone' AND password = '$password' AND account_status = 'pending' ");
        if ($result->rowCount() == 1) {
            $rows = $result->fetch(PDO::FETCH_OBJ);
            //`userid`, `firstname`, `lastname`, `gender`, `phone`, `email`, `password`, `id_type`, `id_number`, `id_front`, `id_back`, `physical_address`, `parish`, `sub_county`, `district`, `account_status`, `role`, `token`, `date_registered`
            $token = rand(11111, 99999);
            $dbh->query("UPDATE users SET token = '$token' WHERE userid = '".$rows->userid."' ");
            $message = "HAMZ BOOK SHOP. Hi ".$rows->fullname.', your Login Token is '.$token;
            @json_decode(send_sms_yoola_api($phone, $message), true);
            $_SESSION['phone'] = $phone;
            $_SESSION['loader'] = '<center><div class="spinner-border text-dark"></div></center>';
            $_SESSION['status'] = '<div class="card card-body alert alert-dark text-center">Account mateched, New Token generated Successfully</div>';
            header("refresh:3; url=".SITE_URL.'/token');

           //  $_SESSION['userid'] = $row->userid;
           //  $_SESSION['firstname'] = $row->firstname;
           //  $_SESSION['lastname'] = $row->lastname;
           //  $_SESSION['phone'] = $row->phone;
           //  $_SESSION['gender'] = $row->gender;
           //  $_SESSION['role'] = $row->role;
           //  $_SESSION['account_number'] = $row->account_number;
           //  $_SESSION['account_status'] = $row->account_status;
           //  $_SESSION['date_registered'] = $row->date_registered;  
           //  $_SESSION['status'] = '<div class=" card card-body alert alert-success text-center">
           // Account Matched, Token sent your Phone[{$phone}].</div>';
           //  $_SESSION['loader'] = '<center><div class="spinner-border text-center text-success"></div></center>';
           //  header("refresh:2; url=auth-token");
        }elseif ($result1->rowCount() == 1) {
            $token = rand(11111,99999);
            $dbh->query("UPDATE users SET token = '$token' WHERE phone = '$phone' ");
            $rx = dbRow("SELECT * FROM users WHERE phone = '$phone' ");
            $fullname = $rx->firstname .' '.$rx->lastname;
            $subj = "KITUDE SACCO - Account Verification Token";
            $body = "Hello {$fullname}, your account verification token is: <br>
                <h1><b>{$token}</b></h1>";
            GoMail($email,$subj,$body);
            $_SESSION['email'] = $email;
            $_SESSION['status'] = '<div class="alert alert-success text-center">Verification token is sent to your email successfully, Please enter the OTP send to you via Email to complete registration process</div>';
            header("refresh:3; url=".HOME_URL.'/token');
        }else{
            $_SESSION['status'] = '<div id="note1" class="card card-body alert alert-danger text-center">
            Invalid account, Try again.<center><img src="'.SITE_URL.'/uploadx/invalid-account.png" width="40"/></center></div>';
        }
    }else{
        $_SESSION['status'] = '<div id="note1" class="card card-body alert alert-danger text-center">
        Wrong Token inserted</div>';
    }

}elseif (isset($_POST['verify'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
    $result = $dbh->query("SELECT * FROM users WHERE token = '$otp' AND email = '$email' " );
    if ($result->rowCount() == 1) {
        $dbh->query("UPDATE users SET account_status = 'Active' WHERE token = '$otp' AND email = '$email' ");
        $subj = "POST KAZI - Account Verification Successful";
        $body = "Hello {$email} your account is activated successfully.";
        GoMail($email,$subj,$body);
        $_SESSION['loader'] = '<center><div class="spinner-border text-center text-success"></div></center>';
        $_SESSION['status'] = '<div class="card card-body alert alert-success text-center">
        <strong>Account verified Successfully, Redirecting to Login...</strong></div>';
        header("refresh:2; url=login");
    }else{
        $_SESSION['status'] = '<div class="card card-body alert alert-warning text-center">
        Account Verification Failed., please check your Token and try again.</div>';
    }
}

}elseif (isset($_POST['resent_token_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
        $result = $dbh->query("SELECT * FROM users WHERE email = '$email' " );
        if ($result->rowCount() == 1) {
            $token = rand(11111,99999);
            $dbh->query("UPDATE users SET token = '$token' WHERE email = '$email' ");
            $rx = dbRow("SELECT * FROM users WHERE email = '$email' ");
            $subj = "POST KAZI - Account Verification Token";
            $body = "Hello {$rx->fullname} you account verification token is: <br>
                <h1><b>{$token}</b></h1>";
            GoMail($email,$subj,$body);
            $_SESSION['email'] = $email;
            $_SESSION['status'] = '<div class="alert alert-success text-center">Verification token is sent to your email successfully, Please enter the OTP send to you via Email to complete registration process</div>';
            header("refresh:3; url=".SITE_URL.'/token');
        }else{
            $_SESSION['status'] = '<div class="card card-body alert alert-warning text-center">
            Account Verification Failed., please check your Token and try again.</div>';
        }
    }

}elseif (isset($_POST['adding_new_welfare_payment_btn'])) {
    trim(extract($_POST));
    $welfare_amount = $_POST['welfare_amount'];
    // Remove commas from the number
    $welfare_amount = str_replace(',', '', $welfare_amount);
    $account_number = addslashes($account_number);
    $check = $dbh->query("SELECT account_number, date_paid FROM welfare_history WHERE (account_number='$account_number' AND date_paid = '$today' ) ")->fetchColumn();
    if(!$check){
        $result = $dbh->query("UPDATE welfare SET account_balance = account_balance + '$welfare_amount', welfare_last_paid = '$today' WHERE account_number = '$account_number' ");
        if ($result) {
            //update welfare payment history
            //`wh_id`, `account_number`, `amount_paid`, `datetime_paid`, `date_paid`
            $dbh->query("INSERT INTO welfare_history VALUES(NULL,'$account_number','$welfare_amount','$dtime','$today') ");
            $user = dbRow("SELECT * FROM users WHERE account_number = '$account_number' ");
            $message = "KITUDE SACCO ".$user->firstname.', Your Welfare payment of USh '.number_format($welfare_amount).' have been received.Thx';
            @json_decode(send_sms_yoola_api($user->phone, $message), true);
            $_SESSION['status'] = '<div class="alert alert-success alert-dismissible">'.$user->firstname.', Welfare account credited successfully.</div>';
            $_SESSION['loader'] = '<center><div class="spinner-border text-success"></div></center>';
            header("refresh:2; url=".SITE_URL.'/welfare');
        }else{
            $_SESSION['status'] = '<div class="alert alert-warning alert-dismissible" id="note1">Error occured, try again later.</div>';
        }
    }else{
        $_SESSION['status'] = '<div class="alert alert-warning alert-dismissible text-center" id="note1">You have already paid welfare today, but you can pay again tomorrow.</div>';
    }
}elseif (isset($_POST['add_saving_details_btn'])) {
    trim(extract($_POST));
    $amount = $_POST['amount'];
    $amount = str_replace(',', '', $amount);
    $account_number = addslashes($account_number);
    $check = $dbh->query("SELECT account_number, saving_last_date FROM saving_history WHERE (account_number='$account_number' AND saving_last_date = '$today' ) ")->fetchColumn();
    if(!$check){
        $result = $dbh->query("UPDATE savings SET amount  = amount  + '$amount', saving_last_date = '$today' WHERE account_number = '$account_number' ");
        if ($result) {
            //`saving_id`, `account_number`, `saving_amount`, `saving_date_time`, `saving_last_date`
            $dbh->query("INSERT INTO saving_history VALUES(NULL,'$account_number','$amount','$dtime','$today') ");
            $user = dbRow("SELECT * FROM users WHERE account_number = '$account_number' ");
            $message = "KITUDE SACCO ".$user->firstname.', Your savings payment of USh '.number_format($amount).' have been received.Thx';
            @json_decode(send_sms_yoola_api($user->phone, $message), true);
            $_SESSION['status'] = '<div class="alert alert-success alert-dismissible">'.$user->firstname.', Savings credited successfully.</div>';
            $_SESSION['loader'] = '<center><div class="spinner-border text-success"></div></center>';
            header("refresh:2; url=".SITE_URL.'/savings');
        }else{
            $_SESSION['status'] = '<div class="alert alert-warning alert-dismissible" id="note1">Error occured, try again later.</div>';
        }
    }else{
        $_SESSION['status'] = '<div class="alert alert-warning alert-dismissible text-center" id="note1">You have already paid Savings today, but you can pay again tomorrow.</div>';
    }
}elseif (isset($_POST['update_user_btn'])) {
    trim(extract($_POST));
    //`userid`, `firstname`, `lastname`, `gender`, `phone`, `business_location`, `role`, `password`, `account_number`, `account_status`, `date_registered`
    $firstname = addslashes($firstname);
    $lastname = addslashes($lastname);
    $phone = addslashes($phone);
    $email = addslashes($email);
    $role = addslashes($role);
    $sql = $dbh->query("UPDATE users SET firstname = '$firstname', lastname = '$lastname', phone = '$phone', gender = '$gender', role = '$role' WHERE userid = '$userid' ");
    if ($sql) {
    $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">User Account details updated successfully!. </div>';
     $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
    header("refresh:2; url= ".$_SERVER['REQUEST_URI']);
    }else{
    $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Error Occured, sorry, our team is notified, shortly we going to work on it!. </div>';
    }
}elseif (isset($_POST['edit_update_user_profile_btn'])) {
    trim(extract($_POST));
    // `userid`, `firstname`, `lastname`, `phone`, `gender`, `email`, `password`, `role`, `token`, `account_status`, `date_registered`, `business_location`
    $sql = $dbh->query("UPDATE users SET firstname = '$firstname', lastname = '$lastname', phone = '$phone', gender = '$gender', email = '$email' WHERE userid = '$userid' ");
    if ($sql) {
    $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Profile info updated successfully!. </div>';
    header("refresh:2; url=".SITE_URL.'/users');
    }else{
    $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Error Occured, sorry, our team is notified, shortly we going to work on it!. </div>'; 
    }
}elseif (isset($_REQUEST['delete-work_experience'])) {
    $delete = dbDelete('work_description', 'work_experience_id', $_REQUEST['delete-work_experience']);
    if($delete)
    {
    //   $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Work deleted successfully is deleted successfully. </div>';
    header("Location: resume");
   }else{
       header("Location: resume");
  } 
}elseif (isset($_REQUEST['delete-award'])) {
    $delete = dbDelete('award_desc_table', 'award_infor_id', $_REQUEST['delete-award']);
    if($delete)
    {
    //   $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Award deleted successfully is deleted successfully. </div>';
    header("Location: resume");
   }else{
       header("Location: resume");
  } 
}elseif (isset($_POST['upload_first_product_pic_details_btn'])) {
    // `pdt_id`,`pdt_landing_pic`, `pdt_second_pic`, `pdt_third_pic`, `pdt_status`
    trim(extract($_POST));
    $filename = trim($_FILES['pdt_landing_pic']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $pdt_landing_pic = $chk . $ext;
    $target_file = "uploads/" . $pdt_landing_pic;
    $urlx = SITE_URL . "/uploads/". $pdt_landing_pic;
    $result = $dbh->query("UPDATE products SET pdt_landing_pic = '$urlx' WHERE pdt_id = '$pdt_id' ");
    if (move_uploaded_file($_FILES['pdt_landing_pic']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result) {
       header("Location: products");
    }
}elseif (isset($_POST['upload_second_product_pic_details_btn'])) {
    // `pdt_id`,`, `pdt_second_pic`, `pdt_third_pic`, `pdt_status`
    trim(extract($_POST));
    $filename = trim($_FILES['pdt_second_pic']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $pdt_second_pic = $chk . $ext;
    $target_file = "uploads/" . $pdt_second_pic;
    $urlx = SITE_URL . "/uploads/". $pdt_second_pic;
    $result = $dbh->query("UPDATE products SET pdt_second_pic = '$urlx' WHERE pdt_id = '$pdt_id' ");
    if (move_uploaded_file($_FILES['pdt_second_pic']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result) {
       header("Location: products");
    }
}elseif (isset($_POST['upload_third_product_pic_details_btn'])) {
    // `pdt_id`,`, `pdt_second_pic`, `pdt_third_pic`, `pdt_status`
    trim(extract($_POST));
    $filename = trim($_FILES['pdt_third_pic']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $pdt_third_pic = $chk . $ext;
    $target_file = "uploads/" . $pdt_third_pic;
    $urlx = SITE_URL . "/uploads/". $pdt_third_pic;
    $result = $dbh->query("UPDATE products SET pdt_third_pic = '$urlx' WHERE pdt_id = '$pdt_id' ");
    if (move_uploaded_file($_FILES['pdt_third_pic']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result) {
       header("Location: products");
    }
}elseif (isset($_REQUEST['update_product_photo_details_btn'])) {
     // `pdt_id`,`, `pdt_second_pic`, `pdt_third_pic`, `pdt_status`
    trim(extract($_POST));
    $filename = trim($_FILES['pdt_photo']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $pdt_photo = $chk . $ext;
    $target_file = "uploads/" . $pdt_photo;
    $urlx = SITE_URL . "/uploads/". $pdt_photo;
    $result = $dbh->query("UPDATE products SET pdt_landing_pic = '$urlx' WHERE pdt_id = '$pdt_id' ");
    if (move_uploaded_file($_FILES['pdt_photo']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result) {
       header("Location: products");
    }
}elseif (isset($_REQUEST['delete-skill'])) {
    $delete = dbDelete('skill_table', 'id', $_REQUEST['delete-skill']);
    if($delete){
    //   $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Skill deleted successfully is deleted successfully. </div>';
      header("Location: resume");
   }else{
       header("Location: resume");
  } 
}   elseif (isset($_POST['add_product_details_btn'])) {
    trim(extract($_POST));
    //`stock_id`, `stock_category`, `stock_artnumber`, `stock_location`, `stok_carton`, `stock_pairs`, `stock_pair_price`, `stock_date`
    $check = $dbh->query("SELECT pdt_artnumber FROM products WHERE pdt_artnumber='$pdt_artnumber' ")->fetchColumn();
    if(!$check){
        $pdt_category = addslashes($pdt_category);
        $pdt_artnumber = addslashes($pdt_artnumber);
        $pdt_location = addslashes($pdt_location);
        $pdt_desc = addslashes($pdt_desc);
        $pdt_pairs = str_replace(',', '', $pdt_pairs);
        $pdt_pair_price = str_replace(',', '', $pdt_pair_price);
        $pdt_package = str_replace(',', '', $pdt_package);
        $stock_query = $dbh->query("INSERT INTO stock VALUES(NULL,'$pdt_category','$pdt_artnumber','$pdt_location','$pdt_package','$pdt_pairs','$pdt_pair_price','$today') ");
        if ($stock_query) {
            $stock_id = $dbh->lastInsertId();
            $pdt_token = mt_rand();
            $result = $dbh->query("INSERT INTO products VALUES(NULL,'$stock_id', '$pdt_category', '$pdt_artnumber','$pdt_location','$pdt_package','$pdt_pairs','$pdt_pair_price','$pdt_desc','$today','', '', '','Available','$pdt_styles','$pdt_token') ");
            if ($result) {
                 //`sh_id`, `stock_id`, `stok_carton`, `stock_pairs`, `stock_pair_price`
                $dbh->query("INSERT INTO stock_history VALUES(NULL,'$stock_id','$pdt_package','$pdt_pair_price','$today') ");
                $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Product uploaded successfully.</div>';
                $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
                header("refresh:1; url=".$_SERVER['REQUEST_URI']);
            }else{
               $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Product Upload failed.</div>';
            }
        }
    }else{
        $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">
            Product with this Art Number already uploaded.
            </div>';
    }
}elseif (isset($_POST['adding_expense_btn'])) {
    trim(extract($_POST));
    $exp_title = addslashes($exp_title);
    $exp_desc = addslashes($exp_desc);
    $exp_amount = str_replace(',', '', $exp_amount);
    $result = $dbh->query("INSERT INTO expenses VALUES(NULL,'$exp_title','$exp_amount','$exp_by','$exp_desc','$today' ) ");
    if ($result) {
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Expense added successfully.</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:1; url=".$_SERVER['REQUEST_URI']);
    }else{
       $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Expense Adding failed.</div>';
    }
}elseif (isset($_POST['update_stock_details_btn'])) {
    trim(extract($_POST));
    // $pdt_pairs = str_replace(',', '', $pdt_pairs);
    $pdt_pair_price = str_replace(',', '', $pdt_pair_price);
    $pdt_package = str_replace(',', '', $pdt_package);
    $result = $dbh->query("INSERT INTO stock_history VALUES(NULL,'$stock_id','$pdt_package','$pdt_pair_price', '$today') ");
    if ($result) {
        //update products... and stock ... 
        $dbh->query("UPDATE products SET pdt_package = pdt_package + '$pdt_package', pdt_pair_price = '$pdt_pair_price', pdt_status = 'Available' WHERE stock_id = '$stock_id' ");
        $dbh->query("UPDATE stock SET stok_carton = stok_carton + '$pdt_package', stock_pair_price = '$pdt_pair_price' WHERE stock_id = '$stock_id' ");
        // $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Stock updated successfully.</div>';
        // $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("Location: products");
    }

}elseif (isset($_POST['change_password_btn'])) {
    trim(extract($_POST));
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    // Fetch the current user's password from the database
    $stmt = $dbh->query("SELECT password FROM users WHERE userid = '$userid' ");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_hashed_password = $result['password'];
    // Verify the current password
    if (sha1($current_password) == $current_hashed_password) {
        // Hash the new password
        $new_hashed_password = sha1($new_password);
        // Update the password in the database
        $stmt = $dbh->query("UPDATE users SET password = '$new_hashed_password' WHERE userid = '$userid' ");
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Password changed successfully...Redirecting to Login</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:2; url=logout");
    } else {
        // Display an error message
         $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
         <b>Current password is incorrect.</b></div>';
    }
}elseif (isset($_POST['update_stock_price_btn'])) {
    trim(extract($_POST));
    $pdt_pair_price = str_replace(',', '', $pdt_pair_price);
    $result = $dbh->query("UPDATE products SET pdt_pair_price = '$pdt_pair_price' WHERE stock_id = '$stock_id' ");
    if ($result) {
        $dbh->query("UPDATE stock_history SET stock_pair_price = '$pdt_pair_price' WHERE stock_id = '$stock_id' ORDER BY sh_id DESC ");
        $dbh->query("UPDATE stock SET stock_pair_price = '$pdt_pair_price' WHERE stock_id = '$stock_id' ");
        header("Location: products");
    }
}elseif (isset($_POST['add_payments_invoice_btn'])) {
    trim(extract($_POST));
    //`ph_id`, `order_invoice`, `amount_paid`, `date_paid`
    $amount_paid = str_replace(',', '', $amount_paid);
    $result = $dbh->query("INSERT INTO payment_history VALUES(NULL, '$order_invoice','$amount_paid', '$today') ");
    if ($result) {
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Invoice Payment updated successfully.</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:2; url=orders?completed");
    }
}

?>
