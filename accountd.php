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
					<?php 
					if (isset($_SESSION['status'])) {
						echo $_SESSION['status'];
						unset($_SESSION['status']);
					}
					if (isset($_SESSION['loader'])) {
						echo $_SESSION['loader'];
						unset($_SESSION['loader']);
					} ?>
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
										<h6>Amount Paid: <b class="text-primary">USh <?=number_format($acct->opening_amount_paid); ?></b></h6>
										<h6>Balance: <b class="text-primary">USh <?=number_format($acct->opening_amount-$acct->opening_amount_paid); ?></b></h6>
									</div>
								</div>
								<hr class="my-4" />
								<ul class="list-group list-group-flush">
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><i class="fadeIn animated bx bx-credit-card-front"></i> Account Type: </h6>
										<span class="text-secondary"><b><?=ucwords($accty->acc_type); ?></b></span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><i class="fadeIn animated bx bx-credit-card-front"></i> Opening Amount</h6>
										<span class="text-secondary">USh <?=number_format($acct->opening_amount);?></span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><i class="fadeIn animated bx bx-credit-card-front"></i> Account Status</h6>
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
										<h6 class="mb-0"><i class="fadeIn animated bx bx-credit-card-front"></i> Time Opened</h6>
										<span class="text-secondary"><?=$acct->acc_opening_time; ?></span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><i class="fadeIn animated bx bx-credit-card-front"></i> Date Opened</h6>
										<span class="text-secondary"><?=$acct->acc_opening_date; ?></span>
									</li>
								</ul>
							</div>
						</div>

						<div class="card">
							<div class="card-body">
								<h5 class="mb-0 text-uppercase">Customer Deposits - <a data-bs-toggle="modal" data-bs-target="#new-account<?=$user->userid?>" style="font-size: 14px;" class="btn btn-sm btn-primary">Deposit Now</a></h5>
								<hr/>
								<div class="table-responsive">
									<table class="table mb-0">
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
												<td><a href="accountd/<?=$rx->account_number;?>/<?= str_replace(' ', '-', strtolower($user->firstname . '-' . $user->lastname)); ?>" class="btn btn-primary btn-sm radius-30 px-4">Check Account</a></td>
											</tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="card">
							<div class="card-body">
								<form class="" method="post" action="">
									<input type="hidden" value="<?=$acct->account_number; ?>" name="account_number">
									<input type="hidden" value="<?=$_SESSION['userid']; ?>" name="userid">
									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0">Activation Balance</h6>
										</div>
										<div class="col-sm-9 text-secondary">
											<input type="text" name="accph_amount" class="form-control" placeholder="Eg, 5,000" oninput="addCommas(this)" required />
										</div>
									</div>
									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0">Payment Status</h6>
										</div>
										<div class="col-sm-9 text-secondary">
											<select class="form-control" name="acc_status" required>
												<option value="">--select payment status--</option>
												<option value="pending">Pending</option>
												<option value="partial">Partial Payment</option>
												<option value="paid">Paid Full Amount</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-9 text-secondary">
											<input type="submit" name="account_number_activation_payments_btn" class="btn btn-primary px-4" value="Save Payments" />
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="card">
											<div class="card-body">

												<h6 class="mb-0 text-uppercase"><b class="text-muted"><?=ucwords($user->firstname); ?>'s</b> Accounts No - <b class="text-primary"><?=$acct->account_number; ?></b> <a href="<?=$_SERVER['REQUEST_URI'];?>" class="btn btn-primary btn-sm" onclick="PrintContent('report')" > <i class="fa fa-print fa-fw"> </i>&nbsp;Print </a>, <a href="print-account-opening/<?=$acct->account_number.'/'.str_replace(' ', '-', strtolower($udetailsFullname));?>" class="btn btn-success btn-sm"> <i class="fa fa-print fa-fw"> </i>&nbsp;Print on XP Printer </a> </h6>
												<hr/>
												<div class="table-responsive" id="report">
												<img src="uploadx/headed-paper-transparent.png" style="width: 100%; " />
												<hr/>
												<h5>
													Account Opening Payment History <br>
													Customer: <?=ucwords($user->firstname.' '.$user->lastname); ?><br>
													Account No: <b class="text-primary"><?=$acct->account_number; ?></b><br>
												</h5>
													<table class="table mb-0">
														<thead class="table-light">
															<tr>
																<th>NO#</th>
																<th>AMOUNT PAID</th>
																<th>DATE PAID</th>
																<th>TIME PAID</th>
															</tr>
														</thead>
														<tbody>
														<!-- `accph_id`, `account_number`, `accph_amount`, `accph_time`, `accph_date`, `recieved_by` -->
														<?php $account_nubz = $dbh->query("SELECT * FROM account_payment_history WHERE account_number = '".$acct->account_number."' ");
														$x = 1; 
														while($rx = $account_nubz->fetch(PDO::FETCH_OBJ)){?>
															<tr>
																<td>
																	<div class="d-flex align-items-center">
																		<div class="ms-2">
																			<h6 class="mb-0 font-14"><?=$x++; ?></h6>
																		</div>
																	</div>
																</td>
																<td>USh <b><?=number_format($rx->accph_amount); ?></b></td>
																<td><?=date('jS F, Y',strtotime($rx->accph_date)); ?></td>
																<td><?=$rx->accph_time; ?></td>
															</tr>
														<?php } ?>
														</tbody>
													</table>
													<h4>Total Paid : USh <?=number_format($acct->opening_amount_paid); ?></h4>
													<h6>Balance: <b class="text-primary">USh <?=number_format($acct->opening_amount-$acct->opening_amount_paid); ?></b></h6>
													<p> <i> Payment Report Generated at <b style="color:red"><?=$dtime?> </i> </b> </p>
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
	</div>
</div>
<?php include 'footer.php'; ?>