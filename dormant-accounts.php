<?php include 'header.php'; ?>
	<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Accounts</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?=SITE_URL; ?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Dormant Accounts</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="card">
			<div class="card-body">
				<h4>Customer Dormant Accounts</h4>
				<div class="table-responsive">
					<table class="table mb-0" id="example">
						<thead class="table-light">
							<tr>
								<th>No#</th>
								<th>Customer Details</th>
								<th>Account Details</th>
								<th>Account Dates</th>
								<!-- <th>Actions</th> -->
							</tr>
						</thead>
						<tbody>
						<?php $accountz = $dbh->query("SELECT * FROM customer_accounts WHERE acc_status = 'dormant' ORDER BY acc_opening_date DESC ");
						$x = 1; 
						while($rx = $accountz->fetch(PDO::FETCH_OBJ)){
							$accty = dbRow("SELECT * FROM account_types WHERE acc_id = '".$rx->acc_id."' ");
							$usx = dbRow("SELECT * FROM users WHERE userid = '".$rx->userid."' "); ?>
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<div class="ms-2">
											<h6 class="mb-0 font-14"><?=$x++; ?></h6>
										</div>
									</div>
								</td>
								<td>
									<?php if(empty($usx->pic)){?>
									<img src="uploadx/man.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="80" height="80">
									<?php }else{ ?>
									<img src="<?=$usx->pic;?>" alt="<?=ucwords($usx->firstname.' '.$usx->lastname);?>" class="rounded-rectange p-1 bg-primary" width="80" height="80">
									<?php } ?><br>
									Customer Name: <b><?=ucwords($usx->firstname.' '.$usx->lastname); ?></b><br>
									Phone: <b><?=$usx->phone; ?></b><br>
									Address: <b><?=$usx->physical_address; ?></b><br>
									District: <b><?=$usx->district;?></b><br>
									Parish: <b><?=$usx->parish;?></b>
								</td>
								<td>
									Account Type: <b><?=$accty->acc_type; ?></b><br>
									Acc.No: <b><?=ucwords($rx->account_number); ?></b><br>
									Activation Balc: <b>USh <?=number_format($rx->opening_amount - $rx->opening_amount_paid);?></b>
								</td>
								<td>
									<b>Opening Date: <?=date('jS M, Y', strtotime($rx->acc_opening_date)); ?></b><hr>
									<b>Opening Time: <?=$rx->acc_opening_time; ?></b>
								</td>
								<!-- <td>
									<a href="udetails/<?=$rx->userid;?>/<?= str_replace(' ', '-', strtolower($rx->firstname . '-' . $rx->lastname)); ?>" class="btn btn-primary btn-sm radius-30 px-4">View Details</a>
								</td> -->
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
	<!--end page wrapper -->
<?php include 'footer.php'; ?>