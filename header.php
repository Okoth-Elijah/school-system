<?php include 'root/process.php';
if (empty($_SESSION['userid'])) {
    header("Location: ".SITE_URL.'/auth-login');
} else {
    //`userid`, `fullname`, `email`, `phone`, `role`, `account_status`, `pic`, `token`, `date_registered`
    $interface = $_SESSION['role'];
    $fullname   = $_SESSION['firstname'].' '.$_SESSION['lastname'];
    $phone   = $_SESSION['phone'];
    $userid = $_SESSION['userid'];
    $date_registered = $_SESSION['date_registered'];
    //fetching user's theme
    $theme = dbRow("SELECT * FROM theme_settings WHERE userid = '".$_SESSION['userid']."' ");
    $act_user = dbRow("SELECT * FROM users WHERE userid = '$userid' ");

    list($startOfWeek, $endOfWeek) = getThisWeek();
    //total admins 
    $tadmins = $dbh->query("SELECT * FROM users WHERE role = 'admin' ")->rowCount();
    $admin_this_week = $dbh->query("SELECT * FROM users WHERE role = 'admin' AND date_registered BETWEEN '$startOfWeek' AND '$endOfWeek'")->rowCount();

    //total customers 
    $tcustomers = $dbh->query("SELECT * FROM users WHERE role = 'customer' ")->rowCount();
    //customers this week...
	$cus_this_week = $dbh->query("SELECT * FROM users WHERE role = 'customer' AND date_registered BETWEEN '$startOfWeek' AND '$endOfWeek'")->rowCount();
	//account types
	$total_account_typesB = $dbh->query("SELECT * FROM account_types ")->rowCount();
	//total opened accounts 
	$toaccs =  $dbh->query("SELECT * FROM customer_accounts ")->rowCount();

	//account opening revenue...
	$acc_opening_revenue = $dbh->query("SELECT SUM(opening_amount_paid) AS totalacc_open_revenue FROM customer_accounts ");
	$taor = $acc_opening_revenue->fetch(PDO::FETCH_OBJ);	

	//deleting expenses.. 
	if (isset($_REQUEST['del-exp'])) {
		$id = base64_decode($_GET['del-exp']);
		$res = $dbh->query("DELETE FROM expenses WHERE expense_id = '$id' ");
		if ($res) {
			$_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Expense added Successfully</div>';
	        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
	        header("Location: expenses");
	    }else{

		}
	}

}

?>
<!doctype html>
<html lang="en" data-bs-theme="<?=$theme->theme_code; ?>">
<head>
	<!-- Required meta tags -->
	<base href="http://localhost/managehubpro.com/">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/schll-favicon.png" type="image/png">
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link rel="stylesheet" href="cdn.jsdelivr.net/npm/select2%404.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="cdn.jsdelivr.net/npm/select2-bootstrap-5-theme%401.3.0/dist/select2-bootstrap-5-theme.min.css" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	
	<link href="assets/sass/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<!--Icons  -->
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
	

	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link rel="stylesheet" href="assets/sass/semi-dark.css">
	<link rel="stylesheet" href="assets/sass/bordered-theme.css">
	<link rel="stylesheet" href="assets/css/styles.css">
	
	<title>Manage-Hub-Pro</title>
	<script type="text/javascript">
	   // JavaScript function for printing using div element
	    function PrintContent(el){
	        var restorepage = document.body.innerHTML;
	        var printcontent = document.getElementById(el).innerHTML;
	        document.body.innerHTML = printcontent;
	        window.print();
	        document.body.innerHTML = restorepage;
	    }
	</script>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="assets/images/schll-logo.png" class="logo-icon" alt="logo icon" style="width:3em; height:4.5em;" >
				</div>
				<div>
					<h4 class="logo-text "  style="font-size:1.4em;">Manage Hub Pro</h4>
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
				<hr>
				
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-group"></i>
						</div>
						<div class="menu-title"> Manage Users</div>
					</a>
					<ul>
						<li> <a href="administrators"><i class='bx bx-radio-circle'></i>administrators</a></li>
						<li> <a href="staffs"><i class='bx bx-radio-circle'></i>Staffs</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-user-headset"></i>
						</div>
						<div class="menu-title">Manage Service </div>
					</a>
					<ul>
						<li> <a href="all-savings"><i class='bx bx-radio-circle'></i>Services </a>
						<li> <a href="all-savings"><i class='bx bx-radio-circle'></i>Request Tracking </a>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rs-to-do"></i>
						</div>
						<div class="menu-title">Manage Task </div>
					</a>
					<ul>
						<li> <a href="new-customer"><i class='bx bx-radio-circle'></i>Task Assignment </a></li>
						<li> <a href="all-customers"><i class='bx bx-radio-circle'></i>Progress Tracking </a></li>	
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-broadcast-tower"></i>
						</div>
						<div class="menu-title">Communication </div>
					</a>
					<ul>
						<li> <a href="manage-accounts"><i class='bx bx-radio-circle'></i>Internal Messaging </a></li>
						<li> <a href="pending-acounts"><i class='bx bx-radio-circle'></i>Notifications</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-bookmark-minus"></i>
						</div>
						<div class="menu-title">Support Ticketing </div>
					</a>
					<ul>
						<li> <a href="loan-applications"><i class='bx bx-radio-circle'></i>Ticketing Creation </a></li>
						<li> <a href="pending-loans"><i class='bx bx-radio-circle'></i>Status Tracking</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-point-of-sale-bill"></i>
						</div>
						<div class="menu-title">Billings</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Invoice Generation </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Payment Processing  </a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rs-newspaper"></i>
						</div>
						<div class="menu-title">Reporting</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Custom Reports </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Performance Analysis  </a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-camera-cctv"></i>
						</div>
						<div class="menu-title">Security</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Data Protection  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>User Authentication  </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-customize"></i>
						</div>
						<div class="menu-title">Customization</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Custom Fields  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i> Workflow Setup </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-master-plan-integrate"></i>
						</div>
						<div class="menu-title">Integrations</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>API Access </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Third-Party Integration </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-compliance"></i>
						</div>
						<div class="menu-title">Compliance</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Standards Adherence </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Audit Trails </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-users"></i>
						</div>
						<div class="menu-title">Multi-User Access</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>User Collaboration</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Manage Permission</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fi fi-rr-interrogation"></i>
						</div>
						<div class="menu-title">Help Center</div>
					</a>
					<ul>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>FAQs </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>support tickating </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>User guides </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>ConUnemployment Ratetact information </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-cog"></i>
						</div>
						<div class="menu-title">Settings</div>
					</a>
					<ul>
						<li> <a href="themes"><i class='bx bx-radio-circle'></i>User Preferences</a></li>
						<li> <a href="#"><i class='bx bx-radio-circle'></i>System Configuration</a></li>
						<li> <a href="change-password"><i class='bx bx-radio-circle'></i>Access Control</a></li>
						<li> <a href="user-profile"><i class='bx bx-radio-circle'></i>Manage Profile</a></li>
						
					</ul>
				</li>

				<li>
					<a href="logout">
						<div class="parent-icon"><i class="bx bx-power-off"></i>
						</div>
						<div class="menu-title">Logout</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--start header -->
		<header>
			<div class="topbar">
				<nav class="navbar navbar-expand gap-2 align-items-center">
					<div class="mobile-toggle-menu d-flex"><i class='bx bx-menu'></i>
					</div>

					  <div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center gap-1">
							
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
							<?php if (empty($act_user->pic)) {
								if ($act_user->gender == 'male') {?>
									<img src="uploadx/man.png" class="user-img" alt="user avatar">
								<?php }else{ ?>
									<img src="<?=$act_user->pic; ?>" class="user-img" alt="user avatar">
								<?php }}else{ 
								if ($act_user->gender == 'woman') { ?>
									<img src="uploadx/woman.png" class="user-img" alt="user avatar">
								<?php }else{ ?>
									<img src="<?=$act_user->pic; ?>" class="user-img" alt="user avatar">
								<?php } }?>
							<div class="user-info">
								<p class="user-name mb-0"><?=ucwords($_SESSION['firstname'].' '.$_SESSION['lastname']); ?></p>
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
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="logout" onclick="return confirm('Do you really want to Logout?. '); "><i class="bx bx-log-out-circle"></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
