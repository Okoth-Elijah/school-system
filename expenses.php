<?php include 'header.php'; ?>
	<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">All Expenses</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?=SITE_URL; ?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Expenses</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="card">
			<div class="card-body">
				<div class="d-lg-flex align-items-center mb-4 gap-3">
				  <div class="ms-auto"><a href="new-customer" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Expense</a></div>
				</div>
				<div class="table-responsive">
					<h5>Lists Of All Expenses</h5>
					<table class="table mb-0" id="example">
						<thead class="table-light">
							<tr>
								<th>No#</th>
								<th>Category</th>
								<th>Title</th>
								<th>Amount</th>
								<th>Date Added</th>
								<th>Added By</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						// `expense_id`, `expc_id`, `expense_title`, `expense_amount`, `expense_date`, `added_by`
						$resx = $dbh->query("SELECT * FROM expenses e, expense_category ec WHERE e.expc_id = ec.expc_id ORDER BY e.expense_id DESC ");
						$x = 1; 
						while($rx = $resx->fetch(PDO::FETCH_OBJ)){
						$user  = dbRow("SELECT * FROM users WHERE userid = '".$rx->userid."' ");?>
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<div class="ms-2">
											<h6 class="mb-0 font-14">#<?=$x++; ?></h6>
										</div>
									</div>
								</td>
								<td><?=$rx->expc_name; ?></td>
								<td><?=$rx->expense_title; ?></td>
								<td>UShs <?=number_format($rx->expense_amount,2); ?></td>
								<td><?=ucwords($rx->firstname.' '.$rx->lastname); ?></td>
								<td><?=date('jS M, Y', strtotime($rx->expense_date)); ?></td>
								<td><?=ucwords($user->firstname.' '.$user->lastname); ?></td>
								<td>
									<div class="d-flex order-actions">
										<a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
										<a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
									</div>
								</td>
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