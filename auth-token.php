<?php  
include 'root/process.php';
$phone = $_SESSION['phone'];
if (empty($phone)) {
    header("Location: ".SITE_URL.'/auth-login');
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="uploadx/logo-bg.png" type="image/png">
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/sass/app.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Kitude Sacco - Auth Token</title>
	<style type="text/css">
        .verification-input {
          font-size: 32px !important;
          letter-spacing: 10px;
          text-align: center;
          border-radius: 10px !important;
          border: 1px solid #DCDCE9 !important;
          width: 180px !important;
          padding: 0 10px !important;
          margin: auto;
          min-height: 70px !important;
          font-weight: 700;
          color: #27173E !important;
          box-shadow: none !important;
          background: #fff !important;
        }

        .verification-input:focus {
          border-color: #27173E !important;
        }
    </style>
</head>

<body class="" style="background-image: url('uploadx/kitude-bg.png'); background-size: cover; background-repeat: no-repeat;">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					 <a href="auth-login" class="btn btn-light text-primary"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
					<form class="row g-3" method="post" action="">
						<input type="hidden" value="<?=$phone; ?>" name="phone">
						<div class="p-3">
							<div class="text-center">
								<img src="assets/images/icons/forgot-2.png" width="100" alt="" />
							</div>
							 <center> <h3 class="mt-5 font-weight-bold">Enter 5-digit verification code</h3> </center>
							<div class="my-4">
								<input type="text" name="otp" id="inputCode" maxlength="10" class="form-control verification-input" placeholder="•••••" id="smscode" pattern="[0-9]*" required />
							</div>
							<div class="d-grid gap-2">
								<button type="submit" name="verify_account_btn" class="btn btn-primary">Verify Account</button>
							</div>
						</div>
					</form>

					<div class="col-12 text-center">
             <div class="page-redirect text-center mt-30">
                  <form method="POST" action="">
                      <input type="hidden" value="<?=$phone; ?>" name="phone">
                       <p>You need another Token?  <button class="btn text-primary" type="submit" name="resent_token_btn"><b>Resend</b></button></p>
                  </form>
              </div>
          </div> <!-- end col -->
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>
</html>