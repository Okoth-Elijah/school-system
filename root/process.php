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
            $token = rand(11111, 99999);
            $dbh->query("UPDATE users SET token = '$token' WHERE userid = '".$rows->userid."' ");
            $message = "KITUDE SACCO. Hi ".$rows->firstname.' '.$rows->lastname.', your Login Token is '.$token;
            @json_decode(send_sms_yoola_api($phone, $message), true);
            $_SESSION['phone'] = $phone;
            $_SESSION['loader'] = '<center><div class="spinner-border text-success"></div></center>';
            $_SESSION['status'] = '<div class="card card-body alert alert-success text-center">Account mateched, New Token generated Successfully.<center><img src="'.SITE_URL.'/uploadx/success.png" width="40"/></center></div>';
            header("refresh:3; url=".SITE_URL.'/auth-token');
        }elseif ($result1->rowCount() == 1) {
            $rx = dbRow("SELECT * FROM users WHERE phone = '$phone' ");
            $fullname = $rx->firstname .' '.$rx->lastname;
            $_SESSION['status'] = '<div class="alert alert-success text-center">Hello <b>'.$fullname.'</b>, Contact Admin for Support</div>';
        }else{
            $_SESSION['status'] = '<div id="note1" class="card card-body alert alert-danger text-center">
            Invalid account, Try again.<center><img src="'.SITE_URL.'/uploadx/invalid-account.png" width="40"/></center></div>';
        }
    }else{
        $_SESSION['status'] = '<div id="note1" class="card card-body alert alert-danger text-center">
        Wrong Token inserted</div>';
    }

}elseif (isset($_POST['verify_account_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
        $result = $dbh->query("SELECT * FROM users WHERE phone = '$phone' AND token = '$otp' " );
        if ($result->rowCount() == 1) {
        $row = $result->fetch(PDO::FETCH_OBJ);
        $_SESSION['userid'] = $row->userid;
        $_SESSION['firstname'] = $row->firstname;
        $_SESSION['lastname'] = $row->lastname;
        $_SESSION['phone'] = $row->phone;
        $_SESSION['gender'] = $row->gender;
        $_SESSION['role'] = $row->role;
        $_SESSION['account_status'] = $row->account_status;
        $_SESSION['date_registered'] = $row->date_registered;  
        if ($result->rowCount() > 0) {
            $_SESSION['loader'] = '<center><div class="spinner-border text-success"></div></center>';
            $_SESSION['status'] = '<div class="card card-body alert alert-success text-center">
            <strong>Login Successful, Redirecting...</strong></div>';
            header("refresh:3; url=".SITE_URL);
            }else{
                $_SESSION['status'] = '<div class="card card-body alert alert-danger text-center">
                Login failed, please check your login details again</div>';
            }
    }else{
            $_SESSION['status_err'] = '<div class="card card-body alert alert-danger text-center">
                    <strong>Wrong Token inserted</strong></div>';
        }
    }
}elseif (isset($_POST['resent_token_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
        $result = $dbh->query("SELECT * FROM users WHERE phone = '$phone' " );
        if ($result->rowCount() == 1) {
            $token = rand(11111,99999);
            $dbh->query("UPDATE users SET token = '$token' WHERE phone = '$phone' ");
            $rx = dbRow("SELECT * FROM users WHERE phone = '$phone' ");
             $message = "KITUDE SACCO. Hi ".$rx->firstname.' '.$rx->lastname.', your Login Token is '.$token;
            @json_decode(send_sms_yoola_api($phone, $message), true);
            $_SESSION['phone'] = $phone;
            $_SESSION['status'] = '<div class="alert alert-success text-center">Verification token is sent to your phone successfully.</div>';
            header("refresh:3; url=".SITE_URL.'/auth-token');
        }else{
            $_SESSION['status'] = '<div class="card card-body alert alert-danger text-center">
            Account Verification Failed., please check your Token and try again.</div>';
        }
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
}elseif (isset($_POST['theme_btn'])) {
    trim(extract($_POST));
    // `theme_id`, `userid`, `theme_code`
   $theme_code = addslashes($theme_code);
    $result = $dbh->query("UPDATE theme_settings SET theme_code = '$theme_code' WHERE userid = '$userid'");
    if ($result) {
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Theme updated successfully.</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:2; url=".SITE_URL.'/themes');
    }else{
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Error has occured.</div>';
    }
}elseif (isset($_POST['id_front_photo_btn'])) {
    trim(extract($_POST));
    $filename = trim($_FILES['id_front']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $id_front = $chk . $ext;
    $target_file = "uploadx/" . $id_front;
    $urlx = SITE_URL . "/uploadx/". $id_front;
    $result = $dbh->query("UPDATE users SET id_front = '$urlx' WHERE userid = '$userid' ");
    if (move_uploaded_file($_FILES['id_front']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result) {
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">ID Front Photo Saved successfully.</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:2; url=".$_SERVER['REQUEST_URI']);
    }
}elseif (isset($_POST['id_back_photo_btn'])) {
    trim(extract($_POST));
    $filename = trim($_FILES['id_back']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $id_back = $chk . $ext;
    $target_file = "uploadx/" . $id_back;
    $urlx = SITE_URL . "/uploadx/". $id_back;
    $result = $dbh->query("UPDATE users SET id_back = '$urlx' WHERE userid = '$userid' ");
    if (move_uploaded_file($_FILES['id_back']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result) {
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">ID Back Photo Saved successfully.</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:2; url=".$_SERVER['REQUEST_URI']);
    }
}elseif (isset($_POST['user_profile_pic_photo_btn'])) {
    trim(extract($_POST));
    $filename = trim($_FILES['pic']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $pic = $chk . $ext;
    $target_file = "uploadx/" . $pic;
    $urlx = SITE_URL . "/uploadx/". $pic;
    $result = $dbh->query("UPDATE users SET pic = '$urlx' WHERE userid = '$userid' ");
    if (move_uploaded_file($_FILES['pic']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result) {
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">profile Photo Saved successfully.</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:2; url=".$_SERVER['REQUEST_URI']);
    }
}elseif (isset($_POST['user_id_type_details_btn'])) {
    trim(extract($_POST));
    $res = $dbh->query("UPDATE users SET id_type = '$id_type', id_number = '$id_number' WHERE userid = '$userid' ");
    $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">User ID Details Saved successfully.</div>';
    $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
    header("refresh:2; url=".$_SERVER['REQUEST_URI']);
}elseif (isset($_POST['save_customer_btn'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT phone FROM users WHERE phone='$phonee' ")->fetchColumn();
    if(!$check){
        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $gender = addslashes($gender);
        $phone = addslashes($phone);
        $email = addslashes($email);
        $id_type = addslashes($id_type);
        $physical_address = addslashes($physical_address);
        $parish = addslashes($parish);
        $sub_county = addslashes($sub_county);
        $district = addslashes($district);
        $id_type = addslashes($id_type);
        $id_number = addslashes($id_number);
        $result = $dbh->query("INSERT INTO users VALUES(NULL,'$firstname','$lastname','$gender','$phonee','$email','','$id_type','$id_number','','','','$physical_address','$parish','$sub_county','$district','pending','customer','','$today')");
        if($result){        
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Customer account created Successfully</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:2; ".SITE_URL.'/all-customers');
        }else{
            $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Customer registration failed</div>';
        }
    }else{
    $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
        User with this Phone number already exist
        </div>';
    }
}elseif (isset($_POST['save_new_system_admin_btn'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT phone FROM users WHERE phone='$phonee' ")->fetchColumn();
    if(!$check){
        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $gender = addslashes($gender);
        $phone = addslashes($phone);
        $email = addslashes($email);
        $id_type = addslashes($id_type);
        $physical_address = addslashes($physical_address);
        $parish = addslashes($parish);
        $sub_county = addslashes($sub_county);
        $district = addslashes($district);
        $id_type = addslashes($id_type);
        $id_number = addslashes($id_number);
        $password = sha1($password);
        $result = $dbh->query("INSERT INTO users VALUES(NULL,'$firstname','$lastname','$gender','$phonee','$email','$password','$id_type','$id_number','','','','$physical_address','$parish','$sub_county','$district','active','admin','','$today')");
        if($result){
            $message = "KITUDE SACCO. Hi ".$firstname.', your account is created successfully,To login, user Phone: '.$phone.' and Pass '.$password;
            @json_decode(send_sms_yoola_api($phone, $message), true);     
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Admin account created Successfully</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:2; ".SITE_URL.'/administrators');
        }else{
            $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Admin registration failed</div>';
        }
    }else{
    $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
        User with this Phone number already exist
        </div>';
    }
}elseif (isset($_POST['save_new_manager_btn'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT phone FROM users WHERE phone='$phonee' ")->fetchColumn();
    if(!$check){
        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $gender = addslashes($gender);
        $phone = addslashes($phone);
        $email = addslashes($email);
        $id_type = addslashes($id_type);
        $physical_address = addslashes($physical_address);
        $parish = addslashes($parish);
        $sub_county = addslashes($sub_county);
        $district = addslashes($district);
        $id_type = addslashes($id_type);
        $id_number = addslashes($id_number);
        $password = sha1($password);
        $result = $dbh->query("INSERT INTO users VALUES(NULL,'$firstname','$lastname','$gender','$phonee','$email','$password','$id_type','$id_number','','','','$physical_address','$parish','$sub_county','$district','active','manager','','$today')");
        if($result){
            $message = "KITUDE SACCO. Hi ".$firstname.', your account is created successfully,To login, user Phone: '.$phone.' and Pass '.$password;
            @json_decode(send_sms_yoola_api($phone, $message), true);     
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Manager account created Successfully</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:2; ".SITE_URL.'/managers');
        }else{
            $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Manager registration failed</div>';
        }
    }else{
    $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
        User with this Phone number already exist
        </div>';
    }
}elseif (isset($_POST['save_new_loan_officer_btn'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT phone FROM users WHERE phone='$phonee' ")->fetchColumn();
    if(!$check){
        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $gender = addslashes($gender);
        $phone = addslashes($phone);
        $email = addslashes($email);
        $id_type = addslashes($id_type);
        $physical_address = addslashes($physical_address);
        $parish = addslashes($parish);
        $sub_county = addslashes($sub_county);
        $district = addslashes($district);
        $id_type = addslashes($id_type);
        $id_number = addslashes($id_number);
        $password = sha1($password);
        $result = $dbh->query("INSERT INTO users VALUES(NULL,'$firstname','$lastname','$gender','$phonee','$email','$password','$id_type','$id_number','','','','$physical_address','$parish','$sub_county','$district','active','loan_officer','','$today')");
        if($result){
            $message = "KITUDE SACCO. Hi ".$firstname.', your account is created successfully,To login, user Phone: '.$phone.' and Pass '.$password;
            @json_decode(send_sms_yoola_api($phone, $message), true);     
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Loan Officer account created Successfully</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:2; ".SITE_URL.'/loan-officer');
        }else{
            $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Loan Officer registration failed</div>';
        }
    }else{
    $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
        User with this Phone number already exist
        </div>';
    }
}elseif (isset($_POST['save_new_cashier_btn'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT phone FROM users WHERE phone='$phonee' ")->fetchColumn();
    if(!$check){
        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $gender = addslashes($gender);
        $phone = addslashes($phone);
        $email = addslashes($email);
        $id_type = addslashes($id_type);
        $physical_address = addslashes($physical_address);
        $parish = addslashes($parish);
        $sub_county = addslashes($sub_county);
        $district = addslashes($district);
        $id_type = addslashes($id_type);
        $id_number = addslashes($id_number);
        $password = sha1($password);
        $result = $dbh->query("INSERT INTO users VALUES(NULL,'$firstname','$lastname','$gender','$phonee','$email','$password','$id_type','$id_number','','','','$physical_address','$parish','$sub_county','$district','active','cashier','','$today')");
        if($result){
            $message = "KITUDE SACCO. Hi ".$firstname.', your account is created successfully,To login, user Phone: '.$phone.' and Pass '.$password;
            @json_decode(send_sms_yoola_api($phone, $message), true);     
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Manager account created Successfully</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:2; ".SITE_URL.'/managers');
        }else{
            $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Manager registration failed</div>';
        }
    }else{
    $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
        User with this Phone number already exist
        </div>';
    }
}elseif (isset($_POST['save_new_account_type_btn'])) {
    trim(extract($_POST));
        if (count($errors) == 0) {
        //`acc_id`, `acc_type`
            $acc_type = addslashes($acc_type);
        $check = $dbh->query("SELECT acc_type FROM account_types WHERE acc_type='$acc_type' ")->fetchColumn();
        if(!$check){
            $result = $dbh->query("INSERT INTO account_types VALUES(NULL, '$acc_type') ");
            if($result){
                $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">New Account Type Added Successfully</div>';
                $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
                header("refresh:2; url=".SITE_URL.'/manage-accounts');
            }else{
                $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Email Address registration failed</div>';
            }
        }else{
        $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">
            This Phone number already exist
            </div>';
        }
    }
}elseif (isset($_POST['save_new_account_btn'])) {
    trim(extract($_POST));
    //`account_number`, `acc_id`, `userid`, `opening_amount`, `opening_amount_paid`, `account_balance`, `acc_status`, `acc_opening_time`, `acc_opening_date`
    $opening_amount = str_replace(',', '', $opening_amount);
    $accountNumber = getNextAccountNumber($dbh);
    $accno = getNextAccountNumberWithoutUnderscore($dbh);
    $result = $dbh->query("INSERT INTO customer_accounts VALUES('$accountNumber','$acc_id','$userid','$opening_amount','0','0','pending','$dtime','$today') ");
     if($result){
        //customer withdraw collections.. 
        // `cw_id`, `account_number`, `cw_amount`, `cw_time`, `cw_date`
        $dbh->query("INSERT INTO customer_withdraws VALUES(NULL, '$accountNumber', '0','$dtime', '$today') ");
        $customer = dbRow("SELECT * FROM users WHERE userid = '$userid' ");
        $acct = dbRow("SELECT * FROM account_types WHERE acc_id = '$acc_id' ");
        $message = "KITUDE SACCO: Hi ".$customer->firstname.' '.$customer->lastname.', Your '.$acct->acc_type.' is created successfully and Acc.No is: '.$accno.'. Thx';
        @json_decode(send_sms_yoola_api($customer->phone, $message), true);
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Account generated Successfully</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:2; url=".$_SERVER['REQUEST_URI']);
    }else{
        $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Error occured when generating account. </div>';
    }
}elseif (isset($_POST['account_number_activation_payments_btn'])) {
    trim(extract($_POST));
    //`account_number`, `acc_id`, `userid`, `opening_amount`, `opening_amount_paid`, `account_balance`, `acc_status`, `acc_opening_time`, `acc_opening_date`

    //`accph_id`, `account_number`, `accph_amount`, `accph_time`, `accph_date`, `recieved_by`
    $accph_amount = str_replace(',', '', $accph_amount);
    $acc_status = addslashes($acc_status);
    $result = $dbh->query("INSERT INTO account_payment_history VALUES(NULL,'$account_number','$accph_amount', '$dtime','$today','$userid') ");
    if ($result) {
        $res = $dbh->query("UPDATE customer_accounts SET opening_amount_paid = opening_amount_paid + '$accph_amount', acc_status = '$acc_status' WHERE account_number = '$account_number' ");
        if ($res) {
            //`userid`, `firstname`, `lastname`, `gender`, `phone`, `email`, `password`, `id_type`, `id_number`, `id_front`, `id_back`, `pic`, `physical_address`, `parish`, `sub_county`, `district`, `account_status`, `role`, `token`, `date_registered`accph_amount
            $cx = dbRow("SELECT * FROM customer_accounts WHERE account_number = '$account_number' ");
            $ux = dbRow("SELECT * FROM users WHERE userid = '".$cx->userid."' ");
            //sending message to the customer about amount paid now...
            $acb = $cx->opening_amount - $cx->opening_amount_paid;
            $message = "KITUDE SACCO. Hello ".$firstname.', You just paid USh: '.$accph_amount.' and activation fee balz: '.$acb;
            @json_decode(send_sms_yoola_api($ux->phone, $message), true);  
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Activation account payments received Successfully</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:2; url=".$_SERVER['REQUEST_URI']);
        }
    }
}elseif (isset($_POST['save_new_expense_category_btn'])) {
    trim(extract($_POST));
    // `expc_id`, `expc_name`, `expc_slug`
    $slug = preg_replace("/[^a-z0-9- ]/", "", strtolower($expc_name));
    $slug = preg_replace("/[^a-z0-9-]/", "-" , $slug); 
    $expc_name = addslashes($expc_name);
    $check = $dbh->query("SELECT expc_slug FROM expense_category WHERE (expc_slug='$slug' ) ")->fetchColumn();
     if ($check) {
        $new_slug = rand(11111,55555).'.'.$slug;
        $result = $dbh->query("INSERT INTO expense_category VALUES(NULL,'$expc_name','$new_slug') ");
        if ($result) {
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Expense Category added Successfully</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:2; url=".$_SERVER['REQUEST_URI']);
        }else{
            $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">Expense creation Failed. </div>';
        }
    }else{
        $result = $dbh->query("INSERT INTO expense_category VALUES(NULL,'$expc_name','$slug') ");
        if ($result) {
           $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Expense Category added Successfully</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:2; url=".$_SERVER['REQUEST_URI']);
        }else{
            $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">Expense creation Failed. </div>';
        }
    } 

    if (move_uploaded_file($_FILES['stp_photo']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
}elseif (isset($_POST['save_new_expense_btn'])) {
     trim(extract($_POST));
    // `expense_id`, `expc_id`, `expense_title`, `expense_amount`, `expense_date`, `added_by`
     $expense_amount = str_replace(',', '', $expense_amount);
     $expense_title = addslashes($expense_title);
    $result = $dbh->query("INSERT INTO expenses VALUES(NULL,'$expc_id','$expense_title', '$expense_amount', '$today', '$userid') ");
    if ($result) {
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Expense added Successfully</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:2; url=".$_SERVER['REQUEST_URI']);
    }else{
        $_SESSION['status'] = '<div id="note2" class="alert alert-warning text-center">Expense creation Failed. </div>';
    }
}

?>
