<?php include 'header.php';
$currentUrl = $_SERVER['REQUEST_URI'];
$parts = explode('/', $currentUrl);
$uid = $parts[count($parts) - 2]; 
$fullnameWithHyphens = $parts[count($parts) - 1];
$fullname = str_replace('-', ' ', $fullnameWithHyphens);
$_SESSION['udetail_userid'] = $uid;
$_SESSION['udetail_fullname'] = $fullname;
$user = dbRow("SELECT * FROM users WHERE userid = '$uid' ");
?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3"><b class="text-muted"><?=ucwords($user->firstname); ?>'s</b> Profile</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?=SITE_URL;?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page"><?=ucwords($user->firstname.' '.$user->lastname); ?></li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="container">
			<div class="main-body">
				<div class="row">
					<?php 
					if (isset($_SESSION['status'])) {
						echo $_SESSION['status'];
						unset($_SESSION['status']);
					}
					if (isset($_SESSION['loader'])) {
						echo $_SESSION['loader'];
						unset($_SESSION['loader']);
					} ?>
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<div class="d-flex flex-column align-items-center text-center">
									<?php if(empty($user->pic)){?>
									<img src="uploadx/man.png" alt="Admin" class="rounded-rectange p-1 bg-primary" width="110">
									<?php }else{ ?>
									<img src="<?=$user->pic;?>" alt="<?=ucwords($user->firstname.' '.$user->lastname);?>" class="rounded-rectange p-1 bg-primary" width="210">
									<?php } ?>
									<div class="mt-3">
										<h4><?=ucwords($user->firstname.' '.$user->lastname);?></h4>
										<p class="text-muted font-size-sm">
											<?php if($user->role == 'admin'){ 
													echo 'Administrator';
												}elseif ($user->role == 'manager') {
												echo 'Manager';
												}elseif ($user->role == 'cashier') {
													echo 'Cashier';
												}else{
													echo 'Customer';
												} ?>
											</p>
										<a data-bs-toggle="modal" data-bs-target="#user-pic<?=$user->userid?>" class="btn btn-primary"><i class="bx bx-attachment"></i>Change Photo</a>&nbsp;&nbsp;&nbsp;<a href="take-photo/<?=$user->userid;?>/<?= str_replace(' ', '-', strtolower($user->firstname . '-' . $user->lastname)); ?>" class="btn btn-success">Take Photo</a>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="card">
							<div class="card-body">
								<h6 class="mb-0 text-uppercase"><b class="text-muted"><?=ucwords($user->firstname); ?>'s</b> Accounts Info - <a data-bs-toggle="modal" data-bs-target="#new-account<?=$user->userid?>" style="font-size: 14px;" class="btn btn-dark">Add New Account</a></h6>
								<hr/>
								<div class="table-responsive">
									<table class="table mb-0" id="example">
										<thead class="table-light">
											<tr>
												<th>ACCNO#</th>
												<th>ACC TYPE</th>
												<th>ACC STATUS</th>
												<th>View Details</th>
											</tr>
										</thead>
										<tbody>
										<?php $account_numbx = $dbh->query("SELECT * FROM customer_accounts WHERE userid = '".$user->userid."' ");
										$x = 1; 
										while($rx = $account_numbx->fetch(PDO::FETCH_OBJ)){
											$acctype = dbRow("SELECT * FROM account_types WHERE acc_id = '".$rx->acc_id."' ");
											?>
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<div class="ms-2">
															<h6 class="mb-0 font-14"><?=$rx->account_number; ?></h6>
														</div>
													</div>
												</td>
												<td><?=ucwords($acctype->acc_type); ?></td>
												<td><?=$rx->acc_status; ?></td>
												<td><a href="accountd/<?=$user->userid;?>/<?= str_replace(' ', '-', strtolower($user->firstname . '-' . $user->lastname)); ?>" class="btn btn-primary btn-sm radius-30 px-4">Check Account</a></td>
											</tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<h6>ID Type</h6>
								<?php if (empty($user->id_type)) { ?>
									<a data-bs-toggle="modal" data-bs-target="#exampleModalIdType<?=$user->userid?>" class="btn btn-primary">Add ID Type</a>
								<?php }else{ ?>
									<div class="card-body alert alert-secondary">
										<h6>ID Type: <?=$user->id_type;?></h6>
										<h6>ID NIN: <?=$user->id_number;?></h6>
									</div>
								<?php } ?>
								<h6 class="mb-0 text-uppercase">ID Photos</h6>
								<hr/>
								<?php if (empty($user->id_front)) { ?>
									<h6 class="alert alert-info text-center"><i class="fadeIn animated bx bx-info-circle"></i> Front Photo is Missing</h6>
									<a data-bs-toggle="modal" data-bs-target="#exampleModalFront<?=$user->userid?>" class="btn btn-primary">Add Front ID Photo</a>
								<?php }else{?>
								<div class="col">
									<div class="card radius-15">
										<div class="p-4 border radius-15 text-center">
											<p><b>Front Photo</b></p>
											<img src="<?=$user->id_front; ?>" width="410" height="210" class="rounded-rectange shadow" alt="">
											<hr>
											<?php if (empty($user->id_back)) {?>
											<a data-bs-toggle="modal" data-bs-target="#exampleModalBack<?=$user->userid?>" class="btn btn-primary">Add Back ID Photo</a>
											<?php }else{?>
											<p><b>Back Photo</b></p>
											<img src="<?=$user->id_back; ?>" width="410" height="210" class="rounded-rectange shadow" alt="">
										<?php } ?>
										</div>
									</div>
								</div>
								<?php } ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
include 'id-front-photo.php';
include 'id-back-photo.php';
include 'user-profile-pic.php';
include 'user-id-type.php';
include 'new-account.php';
include 'footer.php';
?>