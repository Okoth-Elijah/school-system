<?php include 'header.php';
$uuser = dbRow("SELECT * FROM users WHERE userid = '$userid' "); 
$fullname = str_replace(' ', '-', strtolower($uuser->firstname . '-' . $uuser->lastname));
$xid = $uuser->userid;
$_SESSION['up_userid'] = $xid;
$_SESSION['up_fullname'] = $fullname;
?>
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">User Profile</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?=SITE_URL;?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">User Profile</li>
					</ol>
				</nav>
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
									<?php if(empty($uuser->pic)){?>
									<img src="uploadx/man.png" alt="Admin" class="rounded-rectangle p-1 bg-primary" width="110">
									<?php }else{ ?>
									<img src="<?=$uuser->pic;?>" alt="<?=ucwords($uuser->firstname.' '.$uuser->lastname);?>" class="rounded-rectangle p-1 bg-primary" width="110">
									<?php } ?>
									<div class="mt-3">
										<h4><?=ucwords($_SESSION['firstname'].' '.$_SESSION['lastname']);?></h4>
										<p class="text-muted font-size-sm">
											<?php if($_SESSION['role'] == 'admin'){ 
													echo 'Administrator';
												}elseif ($_SESSION['role'] == 'manager') {
												echo 'Manager';
												}elseif ($_SESSION['role'] == 'cashier') {
													echo 'Cashier';
												}elseif ($_SESSION['role'] == 'cashier') {
													echo 'Loan Officer';
												}else{
													echo 'Customer';
												} ?>
											</p>
										<a data-bs-toggle="modal" data-bs-target="#user-pic<?=$uuser->userid?>" class="btn btn-primary"><i class="bx bx-attachment"></i>Change Photo</a>&nbsp;&nbsp;&nbsp;<a href="take-photo/<?=$uuser->userid;?>/<?= str_replace(' ', '-', strtolower($uuser->firstname . '-' . $uuser->lastname)); ?>" class="btn btn-success">Take Photo</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="card">
							<div class="card-body">
								<h6>ID Type</h6>
								<?php if (empty($uuser->id_type)) { ?>
									<a data-bs-toggle="modal" data-bs-target="#exampleModalIdType<?=$uuser->userid?>" class="btn btn-primary">Add ID Type</a>
								<?php }else{ ?>
									<div class="card-body alert alert-secondary">
										<h6>ID Type: <?=$uuser->id_type;?></h6>
										<h6>ID NIN: <?=$uuser->id_number;?></h6>
									</div>
								<?php } ?>
								<h6 class="mb-0 text-uppercase">ID Photos</h6>
								<hr/>
								<?php if (empty($uuser->id_front)) { ?>
									<h6 class="alert alert-info text-center"><i class="fadeIn animated bx bx-info-circle"></i> Front Photo is Missing</h6>
									<a data-bs-toggle="modal" data-bs-target="#exampleModalFront<?=$uuser->userid?>" class="btn btn-primary">Add Front ID Photo</a>
								<?php }else{?>
								<div class="col">
									<div class="card radius-15">
										<div class="p-4 border radius-15 text-center">
											<p><b>Front Photo</b></p>
											<img src="<?=$uuser->id_front; ?>" width="410" height="210" class="rounded-rectange shadow" alt="">
											<hr>
											<?php if (empty($uuser->id_back)) {?>
											<a data-bs-toggle="modal" data-bs-target="#exampleModalBack<?=$uuser->userid?>" class="btn btn-primary">Add Back ID Photo</a>
											<?php }else{?>
											<p><b>Back Photo</b></p>
											<img src="<?=$uuser->id_back; ?>" width="410" height="210" class="rounded-rectange shadow" alt="">
										<?php } ?>
										</div>
									</div>
								</div>
								<?php } ?>

							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
												<th>Phone</th>
												<th>Position</th>
												<th>Office</th>
												<th>Age</th>
												<th>Start date</th>
												<th>Salary</th>
											</tr>
										</thead>
										<tbody>
						<!-- `userid`, `firstname`, `lastname`, `gender`, `phone`, `email`, `password`, `id_type`, `id_number`, `id_front`, `id_back`, `pic`, `physical_address`, `parish`, `sub_county`, `district`, `account_status`, `role`, `token`, `date_registered` -->
											<tr>
												<td>Tiger Nixon</td>
												<td>System Architect</td>
												<td>Edinburgh</td>
												<td>61</td>
												<td>2011/04/25</td>
												<td>$320,800</td>
											</tr>
										</tbody>
									</table>
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