<?php include 'root/process.php'; ?>
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
	<title>Kitude Sacco - Auth Forgot Password</title>
</head>

<body class="" style="background-image: url('uploadx/kitude-bg.png'); background-size: cover; background-repeat: no-repeat;">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					<form class="row g-3" method="post" action="">
						<div class="p-3">
							<!-- <div class="text-center">
								<img src="assets/images/icons/forgot-2.png" width="100" alt="" />
							</div> -->
							<div class="mb-3 text-center">
								<img src="uploadx/logo-transparent.png" width="120" alt="" />
							</div>
							<h4 class="mt-5 font-weight-bold">Forgot Password?</h4>
							<p class="text-muted">Enter your Registered Phone Number to reset the password</p>
							<div class="my-4">
								<label class="form-label">Phone Number</label>
								<input type="text" maxlength="10" class="form-control" placeholder="Eg. 07XXXXXXXX" pattern="[0-9]*" required />
							</div>
							<div class="d-grid gap-2">
								<button type="submit" name="reset_account_btn" class="btn btn-primary">Reset Account</button>
								 <a href="auth-login" class="btn btn-light"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>
</html>