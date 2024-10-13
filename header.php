<?php include 'root/process.php';
if (empty($_SESSION['userid'])) {
    header("Location: ".SITE_URL.'/auth-login');
} else {
    //`userid`, `fullname`, `email`, `phone`, `role`, `account_status`, `pic`, `token`, `date_registered`
    $interface = $_SESSION['role'];
    $fullname   = $_SESSION['fullname'];
    $email   = $_SESSION['email'];
    $phone   = $_SESSION['phone'];
    $userid = $_SESSION['userid'];
    $date_registered = $_SESSION['date_registered'];
}
?>
<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="uploadx/logo-bg.png" type="image/png">
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	
	<link href="assets/sass/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link rel="stylesheet" href="assets/sass/semi-dark.css">
	<link rel="stylesheet" href="assets/sass/bordered-theme.css">
	<title>Kitude sacco</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="uploadx/logo-transparent.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">KITUDE SACCO</h4>
				</div>
				<div class="mobile-toggle-icon ms-auto"><i class='bx bx-x'></i>
				</div>
			 </div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="<?=SITE_URL; ?>">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-group"></i>
						</div>
						<div class="menu-title">Manage Staffs</div>
					</a>
					<ul>
						<li> <a href="add-staff-member"><i class='bx bx-radio-circle'></i>Add Staff</a>
						<li> <a href="administrators"><i class='bx bx-radio-circle'></i>Administrators</a>
						</li>
						<li> <a href="managers"><i class='bx bx-radio-circle'></i>Managers</a>
						</li>
						<li> <a href="cashiers"><i class='bx bx-radio-circle'></i>Cashiers</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-group"></i>
						</div>
						<div class="menu-title">Manage Customers</div>
					</a>
					<ul>
						<li> <a href="add-staff-member"><i class='bx bx-radio-circle'></i>Add New Customer</a>
						<li> <a href="administrators"><i class='bx bx-radio-circle'></i>Administrators</a>
						</li>
						<li> <a href="managers"><i class='bx bx-radio-circle'></i>Managers</a>
						</li>
						<li> <a href="cashiers"><i class='bx bx-radio-circle'></i>Cashiers</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="logout" target="_blank">
						<div class="parent-icon"><i class="bx bx-power-off"></i>
						</div>
						<div class="menu-title">Logout</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar">
				<nav class="navbar navbar-expand gap-2 align-items-center">
					<div class="mobile-toggle-menu d-flex"><i class='bx bx-menu'></i>
					</div>

					  <div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center gap-1">
							
							<li class="nav-item dark-mode d-none d-sm-flex">
								<a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
								</a>
							</li>

							<li class="nav-item dropdown dropdown-app">
								<div class="dropdown-menu dropdown-menu-end p-0">
									<div class="app-container p-2 my-2">
									  <div class="row gx-0 gy-2 row-cols-3 justify-content-center p-2">
										</div><!--end row-->
									</div>
								</div>
							</li>

							<li class="nav-item dropdown dropdown-large">
								<div class="dropdown-menu dropdown-menu-end">
									<div class="header-notifications-list">
									</div>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<div class="dropdown-menu dropdown-menu-end">
									<div class="header-message-list">
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown px-3">
						<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="uploadx/man.png" class="user-img" alt="user avatar">
							<div class="user-info">
								<p class="user-name mb-0"><?=$_SESSION['firstname'].' '.$_SESSION['lastname']; ?></p>
								<p class="designattion mb-0">
									<?php if($_SESSION['role'] == 'admin'){ 
										echo 'Administrator';
									}elseif ($_SESSION['role'] == 'manager') {
									echo 'Manager';
									}elseif ($_SESSION['role'] == 'cashier') {
										echo 'Cashier';
									}else{
										echo 'Customer';
									} ?>
								</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item d-flex align-items-center" href="user-profile"><i class="bx bx-user fs-5"></i><span>Profile</span></a>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i class="bx bx-cog fs-5"></i><span>Settings</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i class="bx bx-log-out-circle"></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
