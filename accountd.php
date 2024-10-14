<?php include 'header.php';
$currentUrl = $_SERVER['REQUEST_URI'];
$parts = explode('/', $currentUrl);
$accid = $parts[count($parts) - 2]; 
$fullnameWithHyphens = $parts[count($parts) - 1];
$fullnamed = str_replace('-', ' ', $fullnameWithHyphens);
$acct = dbRow("SELECT * FROM customer_accounts WHERE account_number = '$accid' ");
$user = dbRow("SELECT * FROM users WHERE userid = '".$acct->userid."' ");
$accty = dbRow("SELECT * FROM account_types WHERE acc_id  = '".$acct->acc_id."' ");

$_SESSION['accdetail_userid'] = $user->userid;
$_SESSION['accdetail_fullname'] = $fullnamed;
?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Account Detail</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page"><?=ucwords($user->firstname.' '.$user->lastname); ?></li>
					</ol>
				</nav>
			</div>
			<div class="ms-auto">
				<div class="btn-group">
					<?php if (isset($_SESSION['accdetail_userid']) && isset($_SESSION['accdetail_fullname'])) {
				        $udetailsUserid = $_SESSION['accdetail_userid'];
				        $udetailsFullname = $_SESSION['accdetail_fullname']; ?>
				        <a href="udetails/<?=$udetailsUserid.'/'. str_replace(' ', '-', strtolower($udetailsFullname))?>" class="btn btn-primary"><i class="fadeIn animated bx bx-arrow-back"></i> Go Back</a>
				    <?php } ?>
				</div>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="container">
			<div class="main-body">
				<div class="row">
					<div class="col-lg-4">
						<div class="card">
							<div class="card-body">
								<div class="d-flex flex-column align-items-center text-center">
									<?php if(empty($user->pic)){?>
									<img src="uploadx/man.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
									<?php }else{ ?>
									<img src="<?=$user->pic;?>" alt="<?=ucwords($user->firstname.' '.$user->lastname);?>" class="rounded-circle p-1 bg-primary" width="110">
									<?php } ?>

									<div class="mt-3">
										<h4><?=ucwords($user->firstname.' '.$user->lastname); ?></h4>
										<p class="text-secondary mb-1"><?=ucwords($user->role); ?></p>
										<h6>Account No: <b class="text-primary"><?=$acct->account_number; ?></b></h6>
									</div>
								</div>
								<hr class="my-4" />
								<ul class="list-group list-group-flush">
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><i class="fadeIn animated bx bx-list-check"></i>Account Type: </h6>
										<span class="text-secondary"><b><?=ucwords($accty->acc_type); ?></b></span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0">Opening Amount</h6>
										<span class="text-secondary">USh <?=number_format($acct->opening_amount);?></span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0">Account Status</h6>
										<?php if ($acct->acc_status == 'pending') { ?>
											<span class="text-warning">Pending</span>
										<?php }elseif ($acct->acc_status == 'partial') { ?>
											<span class="text-info">Partial Payments</span>
										<?php }elseif ($acct->acc_status == 'paid') { ?>
											<span class="text-success">Paid</span>
										<?php }else{?>
											<span class="text-secondary">Domant Account</span>
										<?php } ?>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram me-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
										<span class="text-secondary">codervent</span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook me-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
										<span class="text-secondary">codervent</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="card">
							<div class="card-body">
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Full Name</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="text" class="form-control" value="John Doe" />
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Email</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="text" class="form-control" value="john@example.com" />
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Phone</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="text" class="form-control" value="(239) 816-9029" />
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Mobile</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="text" class="form-control" value="(320) 380-4539" />
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Address</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="text" class="form-control" value="Bay Area, San Francisco, CA" />
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3"></div>
									<div class="col-sm-9 text-secondary">
										<input type="button" class="btn btn-primary px-4" value="Save Changes" />
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-body">
										<h5 class="d-flex align-items-center mb-3">Project Status</h5>
										<p>Web Design</p>
										<div class="progress mb-3" style="height: 5px">
											<div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<p>Website Markup</p>
										<div class="progress mb-3" style="height: 5px">
											<div class="progress-bar bg-danger" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<p>One Page</p>
										<div class="progress mb-3" style="height: 5px">
											<div class="progress-bar bg-success" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<p>Mobile Template</p>
										<div class="progress mb-3" style="height: 5px">
											<div class="progress-bar bg-warning" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<p>Backend API</p>
										<div class="progress" style="height: 5px">
											<div class="progress-bar bg-info" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>