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
	<base href="http://localhost/schoolsystem/">
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
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link rel="stylesheet" href="assets/sass/semi-dark.css">
	<link rel="stylesheet" href="assets/sass/bordered-theme.css">
	<title>schoolsystem</title>
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
					<h4 class="logo-text">School System</h4>
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
						<li> <a href="administrators"><i class='bx bx-radio-circle'></i>Administrators</a></li>
						<li> <a href="teachers"><i class='bx bx-radio-circle'></i>Teachers</a></li>
						<li> <a href="cashiers"><i class='bx bx-radio-circle'></i>Parents</a></li>
						<li> <a href="loan-officer"><i class='bx bx-radio-circle'></i>Students</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-group"></i>
						</div>
						<div class="menu-title"> Manage Staffs</div>
					</a>
					<ul>
						<li> <a href="administrators"><i class='bx bx-radio-circle'></i>Teaching Staff</a></li>
						<li> <a href="managers"><i class='bx bx-radio-circle'></i>None Teaching Staff</a></li>
					</ul>
				</li>
				
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-money"></i>
						</div>
						<div class="menu-title">Admissions </div>
					</a>
					<ul>
						<li> <a href="all-savings"><i class='bx bx-radio-circle'></i>Application forms </a>
						<li> <a href="all-savings"><i class='bx bx-radio-circle'></i>Enrollment status  </a>
						<li> <a href="all-savings"><i class='bx bx-radio-circle'></i>Document Verification  </a>
						<li> <a href="all-savings"><i class='bx bx-radio-circle'></i>Admission Reports  </a>
					</ul>
				</li>

				<li>
					<a href="loan-officer">
						<div class="parent-icon"><i class="bx bx-group"></i></div>
						<div class="menu-title"> Manage Classes</div>
					</a>
				</li>
				<li>
					<a href="managers">
						<div class="parent-icon"><i class="bx bx-group"></i></div>
						<div class="menu-title"> Manage subjects</div>
					</a>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-group"></i>
						</div>
						<div class="menu-title">Attendence </div>
					</a>
					<ul>
						<li> <a href="new-customer"><i class='bx bx-radio-circle'></i>Attendance Records </a></li>
						<li> <a href="all-customers"><i class='bx bx-radio-circle'></i>Absence tracking </a></li>	
						<li> <a href="all-customers"><i class='bx bx-radio-circle'></i>Attendence % </a></li>	
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-credit-card-front"></i>
						</div>
						<div class="menu-title">Timetable </div>
					</a>
					<ul>
						<li> <a href="manage-accounts"><i class='bx bx-radio-circle'></i>Class schedules </a></li>
						<li> <a href="pending-acounts"><i class='bx bx-radio-circle'></i>Teacher assignments</a></li>
						<li> <a href="parital-acounts"><i class='bx bx-radio-circle'></i>Room allocations</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-bookmark-minus"></i>
						</div>
						<div class="menu-title">Grades </div>
					</a>
					<ul>
						<li> <a href="loan-applications"><i class='bx bx-radio-circle'></i>Grade entry </a></li>
						<li> <a href="pending-loans"><i class='bx bx-radio-circle'></i>Report cards</a></li>
						<li> <a href="approved-loans"><i class='bx bx-radio-circle'></i>Performance analytics </a></li>
						<li> <a href="ongoing-loans"><i class='bx bx-radio-circle'></i>Subject assessments</a></li>
					</ul>
				</li>


				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-list-ol"></i>
						</div>
						<div class="menu-title">Library</div>
					</a>
					<ul>
						<li> <a href="pending-loans"><i class='bx bx-radio-circle'></i>Book catalog </a></li>
						<li> <a href="approved-loans"><i class='bx bx-radio-circle'></i>check-out System </a></li>
						<li> <a href="ongoing-loans"><i class='bx bx-radio-circle'></i>Overide notices</a></li>
						<li> <a href="ongoing-loans"><i class='bx bx-radio-circle'></i>Inventory management</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Resourses</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Facilities  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Equipment inventory  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Maintenance requests </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Bookings</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Room reservations </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Equipment bookings  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Scheduling conflicts </a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Payments</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Fee structures  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Payment history  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Invoice generation </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Payment reminders</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Transportation</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Bus routes  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Student assignments  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Real time tracking </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Driver management </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Home work</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Assignment details  </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Submission tracking </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Feedback details </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Due dates </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Analytics</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Student performance </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Financial reports </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Attendence trends </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Custom reports </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Communication</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Messaging system </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Announcements </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Notifications </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">LMS</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Course materials </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Online quizzes </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Discussion forums </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Progress tracking </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Inventory</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Supplies tracking</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Re-order levels</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Supplier management</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Usage reports</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Parent portal</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Child's grades</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Attendence records</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Communication logs</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Event notifications</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Events</div>
					</a>
					<ul>
						<li> <a href="expense-categories"><i class='bx bx-radio-circle'></i>Event calendar</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Reg management</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Participant lists</a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Event reminders</a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-shape-polygon"></i>
						</div>
						<div class="menu-title">Help Center</div>
					</a>
					<ul>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>FAQs </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>support tickating </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>User guides </a></li>
						<li> <a href="expenses"><i class='bx bx-radio-circle'></i>Contact information </a></li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-cog"></i>
						</div>
						<div class="menu-title">Settings</div>
					</a>
					<ul>
						<li> <a href="user-profile"><i class='bx bx-radio-circle'></i>User Profile</a></li>
						<li> <a href="themes"><i class='bx bx-radio-circle'></i>System preferences</a></li>
						<li> <a href="change-password"><i class='bx bx-radio-circle'></i>Notification settings</a></li>
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
