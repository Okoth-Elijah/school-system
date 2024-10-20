<?php include 'header.php'; ?>
	<div class="page-wrapper">
		<div class="page-content">
			<!--breadcrumb-->
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
				<div class="breadcrumb-title pe-3">Expense Categories</div>
				<div class="ps-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 p-0">
							<li class="breadcrumb-item"><a href="<?=SITE_URL;?>"><i class="bx bx-home-alt"></i></a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">Expenses</li>
						</ol>
					</nav>
				</div>
			</div>
			<?php 
			if (isset($_SESSION['status'])) {
				echo $_SESSION['status'];
				unset($_SESSION['status']);
			}
			if (isset($_SESSION['loader'])) {
				echo $_SESSION['loader'];
				unset($_SESSION['loader']);
			} ?>
			<form class="" method="post" action="">
				<div class="card">
					<div class="card-body">
						<div class="row row-cols-1 g-3 row-cols-lg-auto align-items-center">
						   <div class="col">
							  <input type="text" name="expc_name" class="form-control" id="input51" placeholder="Enter Expense Category" required>
						   </div>
						 <div class="col">
							<button type="submit" name="save_new_expense_category_btn" class="btn btn-primary px-4">Save Category</button>
						 </div>
						</div><!--end row-->
					</div>
				</div>
			</form>


			<div class="card">
				<div class="card-body">
					<div class="d-lg-flex align-items-left mb-4 gap-3">
					  	<h4>List of Expense Categories</h4>
					</div>
					<hr>
					<div class="table-responsive">
						<table class="table mb-0" id="example">
							<thead class="table-light">
								<tr>
									<th>No#</th>
									<th>Categories</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							//`expc_id`, `expc_name`, `expc_slug`
							$datax = $dbh->query("SELECT * FROM expense_category ");
							$x = 1; 
							while($rx = $datax->fetch(PDO::FETCH_OBJ)){?>
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div class="ms-2">
												<h6 class="mb-0 font-14">#<?=$x++; ?></h6>
											</div>
										</div>
									</td>
									<td><?=ucwords($rx->expc_name); ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
<?php include 'footer.php'; ?>