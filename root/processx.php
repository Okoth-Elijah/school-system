<?php 
include('config.php');
$errors = array();
foreach ($errors as $error) {
    echo $errors;
}

if (isset($_POST['register_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
    // `userid`, `firstname`, `lastname`, `email`, `phone`, `role`, `account_status`, `token`, `date_registered`, `password`
    $check = $dbh->query("SELECT email FROM users WHERE email='$email' ")->fetchColumn();
    if(!$check){
        $password = sha1($password);
        $sql = "INSERT INTO users VALUES(NULL,'$firstname','$lastname','$email','$phone','client','active','','$today','$password')";
        $result = dbCreate($sql);
        if($result == 1){
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Registration is Successful, OTP sent to you via Email to complete registration process. <br>
                Check your <b>SPAM</b> mail for the <b>TOKEN</b></div>';
            $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Registration is Successful, Redirecting to Login</div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:3; url=login");
        }else{
            echo "<script>
              alert('Email Address registration failed');
              window.location = '".SITE_URL."/registration';
              </script>";
        }
    }else{
        $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">
            Email Address already registered
            </div>';
          // echo "<script>
          //   alert('Email Address already registered');
          //   window.location = '".SITE_URL."/register';
          //   </script>";
        }
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

}elseif (isset($_POST['login_btn'])) {
trim(extract($_POST));
if (count($errors) == 0) {
$password = sha1($password);
// `userid`, `firstname`, `lastname`, `email`, `phone`, `role`, `account_status`, `token`, `date_registered`
$result = $dbh->query("SELECT * FROM users WHERE email = '$email' AND password = '$password' ");
if ($result->rowCount() == 1) {
    $row = $result->fetch(PDO::FETCH_OBJ);
    $_SESSION['userid'] = $row->userid;
    $_SESSION['firstname'] = $row->firstname;
    $_SESSION['lastname'] = $row->lastname;
    $_SESSION['email'] = $row->email;
    $_SESSION['phone'] = $row->phone;
    $_SESSION['role'] = $row->role;
    $_SESSION['date_registered'] = $row->date_registered;  
    $_SESSION['status'] = '<div class=" card card-body alert alert-success text-center">
    Login Successful.</div>';
    $_SESSION['loader'] = '<center><div class="spinner-border text-center text-success"></div></center>';
    header("Location: ".SITE_URL);
    // header("refresh:1; url=".HOME_URL);
}else{
    $_SESSION['status'] = '<div id="note1" class="card card-body alert alert-warning text-center">
    Invalid account, Try again.</div>';
}

}else{
    $_SESSION['status'] = '<div id="note1" class="card card-body alert alert-danger text-center">
    Wrong Token inserted</div>';
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

}elseif (isset($_POST['shared_package_order_btn'])) {
trim(extract($_POST));
$invoice = rand(11999, 88999);
//`order_id`, `userid`, `package_id`, `order_status`, `domain_name`, `domain_status`, `domain_expiry_date`, `order_date`, `invoice`
$sql = $dbh->query("INSERT INTO orders VALUES(NULL,'$userid', '$package_id','Pending','$domain_name','$domain_status','-- -- --', '$today','$invoice') ");
if ($sql) {
$rx = dbRow("SELECT * FROM users WHERE userid = '$userid' ");
$pc = dbRow("SELECT * FROM packages WHERE package_id = '$package_id' ");
$invoice_url = SITE_URL.'/payments/invoice?tid='.$invoice;
$subj = "OSP WEB HOSTING - Package Order #Invoice{$invoice}";
$body = "Hello {$rx->fullname} your package <b>{$pc->package_name}</b> Order is taken successfully <br>
    <h4>Package Payment Link is <b>{$invoice_url}</b></h4>";
GoMail($rx->email,$subj,$body);
// $_SESSION['email'] = $email;
// $_SESSION['status'] = '<div class="alert alert-success text-center">Verification token is sent to your email successfully, Please enter the OTP send to you via Email to complete registration process</div>';
// header("refresh:3; url=".SITE_URL.'/auth-token');
echo "<script>
  alert('Package Order Taken successfully');
  window.location = '".HOME_URL."';
  </script>";
}
}elseif (isset($_POST['update_user_profile_btn'])) {
trim(extract($_POST));
$profile_desc = addslashes($profile_desc);
$check = $dbh->query("SELECT userid FROM profile_about WHERE userid = '$userid' ")->fetchColumn();
if (!$check) {
$sql = $dbh->query("INSERT INTO profile_about VALUES(NULL,'$userid','$profile_desc') ");
if ($sql) {
    $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Your profile is updated successfully!. </div>';
    // header("refresh: 2; url=profile");
}else{
    $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Error when updating user profile. Check and try again. </div>';
}
}else{
$_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">You just correct, you just updated your profile now. </div>';
// header("refresh:1; url=profile");
}

}elseif (isset($_POST['update_user_personal_interest_btn'])) {
    trim(extract($_POST));
    $personal_job_interest = addslashes($personal_job_interest);
    $sql = $dbh->query("UPDATE users SET personal_job_interest = '$personal_job_interest' WHERE userid = '$userid' ");
    if ($sql) {
    $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Your Profession is updated successfully!. </div>';
    }else{
    $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Error Occured, sorry, our team is notified, shortly we going to work on it!. </div>';
    }
}elseif (isset($_POST['edit_update_user_profile_btn'])) {
    trim(extract($_POST));
    $sql = $dbh->query("UPDATE profile_about SET profile_desc = '$edit_profile_info' WHERE userid = '$userid' ");
    if ($sql) {
    $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Profile info updated successfully!. </div>';
    }else{
    $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Error Occured, sorry, our team is notified, shortly we going to work on it!. </div>'; 
    }
}elseif (isset($_POST['add_user_education_btn'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT * FROM education_background WHERE userid = '$userid' ")->fetchColumn(); 
    if (!$check) {
    $sql = $dbh->query("INSERT INTO education_background VALUES(NULL, '$userid', '$eb_desc') ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Education background is saved successfully. </div>';
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Education background saving failed. </div>';
    }
    }else{
    header("Location: profile");
    }
}elseif (isset($_POST['edit_btn_user_education_btn'])) {
    trim(extract($_POST));
    $eb_descx = addslashes($eb_descx);
    $sql = $dbh->query("UPDATE education_background SET eb_desc = '$eb_descx' WHERE userid = '$userid' ");
    if ($sql) {
    $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Education background is updated successfully. </div>';
    }else{
    header("Location: profile");
    }
}elseif(isset($_POST['add_school_details'])){
    trim(extract($_POST));
    $school_name = addslashes($school_name);
    $course = addslashes($course);
    $sql = $dbh->query("INSERT INTO school_details VALUES(NULL, '$userid', '$school_name','$course','$start_year','$end_year','$desc_desc') ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">School detail is saved successfully. </div>';
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">School detail saving failed. </div>';
    }
}elseif (isset($_POST['add_work_experince'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT * FROM work_experience WHERE userid = '$userid' ")->fetchColumn(); 
    if (!$check) {
        $work_desc =addslashes($work_desc);
        $sql = $dbh->query("INSERT INTO work_experience VALUES(NULL, '$userid', '$work_desc') ");
        if ($sql) {
            $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Work and experience is saved successfully. </div>';
        }else{
            $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Work and experience saving failed. </div>';
        }
    }else{
        header("Location: profile");
    }
}
elseif (isset($_POST['edit_work_experince'])) {
    trim(extract($_POST));
    $work_descx = addslashes($work_descx);
    $sql = $dbh->query("UPDATE work_experience SET work_desc = '$work_descx' WHERE userid = '$userid' ");
    if ($sql) {
       $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Work and experience description is updated successfully. </div>';
    }else{
        header("Location: profile");
    }
}elseif(isset($_POST['add_work_experience_details'])){
    trim(extract($_POST));
    $job_name = addslashes($job_name);
    $campany_name = addslashes($campany_name);
    $work_description = addslashes($work_description);
    $sql = $dbh->query("INSERT INTO work_description VALUES(NULL, '$userid', '$job_name','$campany_name','$start_year','$end_year','$work_description') ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Work and Experience detail is saved successfully. </div>';
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Work and Experience detail saving failed. </div>';
    }
}elseif (isset($_POST['add_award'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT * FROM award_table WHERE userid = '$userid' ")->fetchColumn(); 
    if (!$check) {
        $award_desc = addslashes($award_desc);
        $sql = $dbh->query("INSERT INTO award_table VALUES(NULL, '$userid', '$award_desc') ");
        if ($sql) {
            $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Award description is saved successfully. </div>';
        }else{
            $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Award description saving failed. </div>';
        }
    }else{
        header("Location: profile");
    }
}
elseif (isset($_POST['edit_award'])) {
    trim(extract($_POST));
    $award_desc = addslashes($award_desc);
    $sql = $dbh->query("UPDATE award_table SET award_desc = '$award_desc' WHERE userid = '$userid' ");
    if ($sql) {
       $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Award description is updated successfully. </div>';
    }else{
        header("Location: profile");
    }
}
elseif(isset($_POST['add_award_details'])){
    trim(extract($_POST));
    $award_name = addslashes($award_name);
    $award_head = addslashes($award_head);
    $start_year = addslashes($start_year);
    $end_year = addslashes($end_year);
    $award_desc = addslashes($award_desc);
    $sql = $dbh->query("INSERT INTO award_desc_table VALUES(NULL, '$userid', '$award_name','$award_head','$start_year','$end_year','$award_desc') ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Work and Experience detail is saved successfully. </div>';
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Work and Experience detail saving failed. </div>';
    }

}elseif(isset($_POST['add_skill'])){
    trim(extract($_POST));
    $skill_name = addslashes($skill_name);
    $skill_percentage = addslashes($skill_percentage);
    $sql = $dbh->query("INSERT INTO skill_table VALUES(NULL, '$userid', '$skill_name','$skill_percentage') ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Skill is saved successfully. </div>';
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Skill saving failed. </div>';
    }
}elseif (isset($_POST['cv_upload_btn_btn'])) {
    trim(extract($_POST));
    //`id`,`image`,`status`
    $filename = trim($_FILES['cv_file']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $cv_file = $chk . $ext;
    $target_file = "../uploads/" . $cv_file;
    $url = SITE_URL . '/uploads/' . $cv_file;
    //`cv_id`, `userid`, `cv_url`, `cv_downloads`, `cv_last_updated`
    $result = dbCreate("INSERT INTO cvs VALUES(NULL,'$userid','$url',0,'$today')");
    if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result == 1) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">CV is saved successfully. </div>';
      
    } else {
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">CV saving failed. </div>';
    }
}elseif (isset($_POST['update_cv'])) {
    trim(extract($_POST));
    $cv_file = isset($cv_file) ? $cv_file : "";
    $cv_id = isset($cv_id) ? $cv_id : "";

    $sql = $dbh->query("UPDATE cvs SET cv_url = '$cv_file'  WHERE cv_id = '$cv_id' ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">CV is updated successfully. </div>';
    }
}elseif (isset($_POST['upload_cv_and_coverletter'])) {
    trim(extract($_POST));
    //`id`,`image`,`status`
    $filename = trim($_FILES['resume']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $resume = $chk . $ext;
    $target_file = "../uploads/" . $resume;
    $url = SITE_URL . '/uploads/' . $resume;
    //`cv_id`, `userid`, `cv_url`, `cv_downloads`, `cv_last_updated`
    $cover_letter = addslashes($cover_letter);
    $result = dbCreate("INSERT INTO cvs VALUES(NULL,'$userid','$url','$cover_letter',0,'$today')");
    if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result == 1) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">CV is saved successfully. </div>';
      
    } else {
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">CV saving failed. </div>';
    }
}elseif (isset($_POST['update_education'])) {
    trim(extract($_POST));
    $school_name = addslashes($school_name);
    $course = addslashes($course);
    $desc_desc = addslashes($desc_desc);
    $sql = $dbh->query("UPDATE school_details SET school_name = '$school_name', course = '$course',start_year = '$start_year',end_year='$end_year', desc_desc = '$desc_desc'  WHERE sch_id = '$sch_id' ");
    if ($sql) {
       $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Education information is updated successfully. </div>';
    }else{
        header("Location: resume");
    }
}
elseif (isset($_REQUEST['delete-education'])) {
  $delete = dbDelete('school_details', 'sch_id', $_REQUEST['delete-education']);
  if($delete){
    // $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Education information is deleted successfully. </div>';
    header("Location: resume");
 }else{
     header("Location: resume");
    // redirect_page('?resume');
} }
elseif (isset($_POST['change_password'])) {
    trim(extract($_POST));
    $password = sha1($password);
    $result = $dbh->query("SELECT password FROM users WHERE WHERE userid = '" . $_SESSION['userid'] . "' ");
    $old_pass = addslashes($old_pass);
    $new_pass = addslashes($new_pass);
    $change_pass = addslashes($change_pass);
    if($old_pass == $password){
        if($new_pass ==$change_pass){
            $sql = $dbh->query("UPDATE users SET password = '$new_pass' WHERE userid = '". $_SESSION['userid']. "' ");
            if ($sql) {
                $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Password is changed successfully. </div>';
            }else{
                $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Password change failed. </div>';
            }
        }
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Old password is incorrect. </div>';
    }
}elseif (isset($_POST['update_work_experience'])) {
    trim(extract($_POST));
    $work_description = addslashes($work_description);
    $job_name = addslashes($job_name);
    $campany_name = addslashes($campany_name);
    $start_year = addslashes($start_year);
    $end_year = addslashes($end_year);
    $sql = $dbh->query("UPDATE work_description SET job_name = '$job_name',
     campany_name = '$campany_name', start_year = '$start_year',end_year='$end_year', 
     work_description = '$work_description'  WHERE work_experience_id  = '$work_experience_id ' ");
    if ($sql) {
    //    $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Work and experience is updated successfully. </div>';
    header("Location: resume");
    }else{
        header("Location: resume");
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
}elseif (isset($_POST['update_profile_pic_btn__btn'])) {
    trim(extract($_POST));
    $filename = trim($_FILES['profile_pic']['name']);
    $chk = rand(1111111111111, 9999999999999);
    $ext = strrchr($filename, ".");
    $profile_pic = $chk . $ext;
    $target_file = "../uploads/" . $profile_pic;
    $urlx = SITE_URL . "/uploads/". $profile_pic;
    $result = $dbh->query("UPDATE users SET profile_pic = '$url' WHERE userid = '$userid' ");
    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
        $msg = "File uploaded Successfully";
    } else {
        $msg = "There was a problem uploading image";
    }
    if ($result) {
       header("Location: profile");
    }
}elseif (isset($_REQUEST['delete-skill'])) {
    $delete = dbDelete('skill_table', 'id', $_REQUEST['delete-skill']);
    if($delete)
    {
    //   $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Skill deleted successfully is deleted successfully. </div>';
      header("Location: resume");
   }else{
       header("Location: resume");
  } 
}   elseif (isset($_POST['submit_job_btn'])) {
    trim(extract($_POST));
    //`job_id`, `job_cat_id`, `userid`, `company_id`, `job_title`, `job_description`, `job_role`, `job_responsibility`, `job_experience`, `job_gender`, `job_qualification`, `job_type`, `job_deadline`, `job_status`, `job_currency`, `job_amount`, `job_increment_plan`, `job_location`, `job_country`, `applicants_needed`, `job_posted_date`, `job_slug`, `job_views`, `applicants`
    //`job_id`, `job_cat_id`, `userid`, `company_id`, `job_title`, `job_description`, `job_role`, `job_responsibility`, `job_experience`, `job_gender`, `job_qualification`, `job_type`, `job_deadline`, `job_status`, `job_currency`, `job_amount`, `job_increment_plan`, `job_location`, `job_country`, `applicants_needed`, `job_posted_date`, `job_slug`, `job_views`, `applicants`, `external_app_url`
    $slug = preg_replace("/[^a-z0-9- ]/", "", strtolower($job_title));
    $slug = preg_replace("/[^a-z0-9-]/", "-" , $slug); 
    $job_description = addslashes($job_description);
    $job_role = addslashes($job_role);
    $job_responsibility = addslashes($job_responsibility);
    $job_skill = addslashes($job_skill);
    $job_country = addslashes($job_country);
    $job_location = addslashes($job_location);
    $job_experience = addslashes($job_experience);
    $job_qualification = addslashes($job_qualification);
    $job_currency = addslashes($job_currency);
    // $job_posted_date = $now;
    $job_title = addslashes($job_title);
    $check = $dbh->query("SELECT job_slug FROM jobs WHERE (job_slug='$slug' ) ")->fetchColumn();
     if ($check) {
        $new_job = rand(11111,55555).'.'.$slug;
        $result = $dbh->query("INSERT INTO jobs VALUES(NULL, '$job_cat_id', '$userid','$company_id','$job_title','$job_description','$job_skill','$job_role','$job_responsibility','$job_experience', '$job_gender', '$job_qualification', '$job_type', '$job_deadline','Active','$job_currency', '$job_amount', '$job_increment_plan', '$job_location','$job_country','$applicants_needed', '$now', '$new_job',0,0,'$external_app_url') ");
        if ($result) {
            echo "<script>
              alert('Job Posted Successfully');
                window.location = '".SITE_URL."/post-job';
              </script>";
        }else{
            echo "<script>
              alert('Job Posted Failed');
                window.location = '".SITE_URL."/post-job';
              </script>";
        }
    }else{
        $result = $dbh->query("INSERT INTO jobs VALUES(NULL, '$job_cat_id', '$userid','$company_id','$job_title','$job_description','$job_role','$job_responsibility','$job_skill','$job_experience', '$job_gender', '$job_qualification', '$job_type', '$job_deadline','Active','$job_currency', '$job_amount', '$job_increment_plan', '$job_location','$job_country','$applicants_needed', '$now', '$slug',0,0,'$external_app_url') ");

        if ($result) {
            echo "<script>
              alert('Job Posted Successfully');
                window.location = '".SITE_URL."/post-job';
              </script>";
        }else{
            echo "<script>
              alert('Job Posted Failed');
                window.location = '".SITE_URL."/post-job';
              </script>";
        }
    }
}elseif (isset($_POST['update_user_hourly_rates_btn'])) {
    trim(extract($_POST));
    // Get the submitted number from the form
    $numberInput = $_POST['numberInput'];
    // Remove commas from the number
    $number = str_replace(',', '', $numberInput);
    // Now $number contains the numeric value without commas
    $your_currency = addslashes($your_currency);
    $sql = $dbh->query("UPDATE users SET salary = '$number', currency = '$your_currency' WHERE userid = '$userid' ");
    if ($sql) {
        echo "<script>
          alert('Hourly rate updated successfully');
            window.location = '".SITE_URL."/profile';
          </script>";
    }else{
        echo "<script>
          alert('Error Occured');
            window.location = '".SITE_URL."/profile';
          </script>";
    }
}elseif (isset($_POST['update_job_summary_btn'])) {
    trim(extract($_POST));
    $your_experience = addslashes($your_experience);
    $dobInput = addslashes($dobInput);
    $sql = $dbh->query("UPDATE users SET experience = '$your_experience', dob = '$dobInput' WHERE userid = '$userid' ");
    if ($sql) {
        echo "<script>
          alert('User Data updated successfully');
            window.location = '".SITE_URL."/profile';
          </script>";
    }else{
        echo "<script>
          alert('Error Occured');
            window.location = '".SITE_URL."/profile';
          </script>";
    }
}elseif (isset($_POST['add_company_profile_btn'])) {
    trim(extract($_POST));
    // `company_id`, `userid`, `job_cat_id`, `company_name`, `company_country`, `company_city`, `physical_address`, `company_logo`, `company_phone`, `company_email`, `company_website`, `company_views`, `company_slug`, `search_status`, `company_desc`, `est_since_date`, `team_size`, `company_date_added`
    $company_name = addslashes($company_name);
    $company_city = addslashes($company_city);
    $physical_address = addslashes($physical_address);
    $company_email = addslashes($company_email);
    $company_website = addslashes($company_website);
    $company_desc = addslashes($company_desc);
    $est_since_date = addslashes($est_since_date);
    $company_slug = preg_replace("/[^a-z0-9- ]/", "", strtolower($company_name));
    $company_slug = preg_replace("/[^a-z0-9-]/", "-" , $company_slug); 

    $check = $dbh->query("SELECT company_slug FROM companies WHERE (company_slug='$company_slug' ) ")->fetchColumn();
    if ($check) {
        $new_company = rand(000001,999999).'.'.$company_slug;
        $sql = $dbh->query("INSERT INTO companies VALUES(NULL,'$userid','$job_cat_id','$company_name','$company_country','$company_city','$physical_address','','$company_phone','$company_email','$company_website',0,'$new_company','$search_status','$company_desc','$est_since_date','$team_size','$today') ");
        if ($sql) {
            echo "<script>
                alert('Company deatils added successfully');
                window.location = '".SITE_URL."/company-profile';
            </script>";
        }else{
            echo "<script>
              alert('Error Occured');
                window.location = '".SITE_URL."/company-profile';
              </script>";
        }   
    }else{
        $sql = $dbh->query("INSERT INTO companies VALUES(NULL,'$userid','$job_cat_id','$company_name','$company_country','$company_city','$physical_address','','$company_phone','$company_email','$company_website',0,'$company_slug','$search_status','$company_desc','$est_since_date','$team_size','$today') ");
        if ($sql) {
             echo "<script>
              alert('Company deatils added successfully');
                window.location = '".SITE_URL."/company-profile';
              </script>";
        }else{
            echo "<script>
              alert('Error Occured');
                window.location = '".SITE_URL."/company-profile';
              </script>";
        }
    }
}elseif (isset($_POST['upload_cv_btn'])) {
    trim(extract($_POST));
    // `cv_id`, `userid`, `cv_url`, `cv_views`, `cv_last_updated`
     $filename = trim($_FILES['cv_url']['name']);
     $chk = rand(1111111111116,9999999999996);
     $ext = strrchr($filename, ".");
     $cv_url = $chk.$ext;
     $target_img = "../uploads/".$cv_url;
     $url = SITE_URL.'/uploads/'.$cv_url;
     if (count($errors) == 0) {
        //`cv_id`, `userid`, `cv_url`, `cover_letter`, `cv_downloads`, `cv_last_updated`
        $result = dbCreate("INSERT INTO cvs VALUES(NULL,'$userid','$url','',0,'$today')");
     if (move_uploaded_file($_FILES['cv_url']['tmp_name'], $target_img)) {
          $msg ="Image uploaded Successfully";
          }else{
            $msg ="There was a problem uploading Video Details";
          }
          if ($result == 1) {
             echo "<script>
              alert('CV uploaded successfully');
                window.location = '".SITE_URL."/jobs';
              </script>";
        }else{
            echo "<script>
              alert('Error Occured');
                window.location = '".SITE_URL."';
              </script>";
        }
    }
}
elseif (isset($_POST['submit_job_via_nav'])) {
    trim(extract($_POST));
    //`job_id`, `job_cat_id`, `userid`, `company_id`, `job_title`, `job_description`, `job_role`, `job_responsibility`, `job_experience`, `job_gender`, `job_qualification`, `job_type`, `job_deadline`, `job_status`, `job_currency`, `job_amount`, `job_increment_plan`, `job_location`, `job_country`, `applicants_needed`, `job_posted_date`, `job_slug`, `job_views`, `applicants`
    //`job_id`, `job_cat_id`, `userid`, `company_id`, `job_title`, `job_description`, `job_role`, `job_responsibility`, `job_experience`, `job_gender`, `job_qualification`, `job_type`, `job_deadline`, `job_status`, `job_currency`, `job_amount`, `job_increment_plan`, `job_location`, `job_country`, `applicants_needed`, `job_posted_date`, `job_slug`, `job_views`, `applicants`, `external_app_url`
    $slug = preg_replace("/[^a-z0-9- ]/", "", strtolower($job_title));
    $slug = preg_replace("/[^a-z0-9-]/", "-" , $slug); 
    $job_description = addslashes($job_description);
    $job_role = addslashes($job_role);
    $job_responsibility = addslashes($job_responsibility);
    $job_skill = addslashes($job_skill);
    $job_country = addslashes($job_country);
    $job_location = addslashes($job_location);
    $job_experience = addslashes($job_experience);
    $job_qualification = addslashes($job_qualification);
    $job_currency = addslashes($job_currency);
    // $job_posted_date = $now;
    $job_title = addslashes($job_title);
    $check = $dbh->query("SELECT job_slug FROM jobs WHERE (job_slug='$slug' ) ")->fetchColumn();
     if ($check) {
        $new_job = rand(11111,55555).'.'.$slug;
        $result = $dbh->query("INSERT INTO jobs VALUES(NULL, '$job_cat_id', '$userid','$company_id','$job_title','$job_description','$job_skill','$job_role','$job_responsibility','$job_experience', '$job_gender', '$job_qualification', '$job_type', '$job_deadline','Active','$job_currency', '$job_amount', '$job_increment_plan', '$job_location','$job_country','$applicants_needed', '$now', '$new_job',0,0,'$external_app_url') ");
        if ($result) {
            echo "<script>
              alert('Job Posted Successfully');
                window.location = '".SITE_URL."';
              </script>";
        }else{
            echo "<script>
              alert('Job Posted Failed');
                window.location = '".SITE_URL."';
              </script>";
        }
    }else{
        $result = $dbh->query("INSERT INTO jobs VALUES(NULL, '$job_cat_id', '$userid','$company_id','$job_title','$job_description','$job_role','$job_responsibility','$job_skill','$job_experience', '$job_gender', '$job_qualification', '$job_type', '$job_deadline','Active','$job_currency', '$job_amount', '$job_increment_plan', '$job_location','$job_country','$applicants_needed', '$now', '$slug',0,0,'$external_app_url') ");

        if ($result) {
            echo "<script>
              alert('Job Posted Successfully');
                window.location = '".SITE_URL."';
              </script>";
        }else{
            echo "<script>
              alert('Job Posted Failed');
                window.location = '".SITE_URL."';
              </script>";
        }
    }
}
elseif (isset($_POST['submit_talent_dashboard'])) {
    trim(extract($_POST));
  // `wid`, `userid`, `job_cat_id`, `wtd_desc`, `wtd_title`, `tools`, `basic_price`, `basic_desc`, `standard_price`, `standard_desc`, `premium_price`, `premium_desc`, `wtd_slug`, `landing_pic`, `second_pic`, `third_pic`
    $slug = preg_replace("/[^a-z0-9- ]/", "", strtolower($wtd_title));
    $slug = preg_replace("/[^a-z0-9-]/", "-" , $slug); 
    $userid = addslashes($userid);
    $job_cat_id = addslashes($job_cat_id);
    $wtd_title = addslashes($wtd_title);
    $wtd_desc = addslashes($wtd_desc);
    $tools = addslashes($tools);
    $basic_price = addslashes($basic_price);
    $basic_desc = addslashes($basic_desc);
    $standard_price = addslashes($standard_price);
    $standard_desc = addslashes($standard_desc);
    $premium_price = addslashes($premium_price);
    $premium_desc = addslashes($premium_desc);

    //checking if this talent already added...
    $check = $dbh->query("SELECT wtd_slug FROM talent_doing WHERE (wtd_slug='$slug' ) ")->fetchColumn();
     if ($check) {
        $new_slug = rand(11111,55555).'.'.$slug;
        $result = $dbh->query("INSERT INTO talent_doing VALUES(NULL,'$userid','$job_cat_id','$wtd_desc','$wtd_title','$tools','$basic_price','$basic_desc','$standard_price','$standard_desc','$premium_price','$premium_desc','$new_slug','','','','$today') ");
        if ($result) {
            echo "<script>
              alert('Talent added Successfully');
                window.location = '".SITE_URL."/my-talent';
              </script>";
        }else{
            echo "<script>
              alert('Talent Failed To Add');
                window.location = '".SITE_URL."/my-talent';
              </script>";
        }
    }else{
        $result = $dbh->query("INSERT INTO talent_doing VALUES(NULL,'$userid','$job_cat_id','$wtd_desc','$wtd_title','$tools','$basic_price','$basic_desc','$standard_price','$standard_desc','$premium_price','$premium_desc','$slug','','','','$today') ");
        if ($result) {
            echo "<script>
            alert('Talent added Successfully');
              window.location = '".SITE_URL."/my-talent';
            </script>";
        }else{
            echo "<script>
            alert('Talent Failed To Add');
              window.location = '".SITE_URL."/my-talent';
            </script>";
        }
    }
}elseif (isset($_REQUEST['delete-talent'])) {
    $id = base64_decode($_GET['delete-talent']);
    $res = $dbh->query("DELETE FROM talent_doing WHERE wid = '$id' ");
    header("Location: ".SITE_URL.'/my-talent');
}

?>