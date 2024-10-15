<?php include 'header.php'; ?>
<!--end header -->
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Revenue Today</p>
								<h4 class="my-1">USh 0.00</h4>
								<p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>This Week USh 0.00 </p>
							</div>
							<div class="widgets-icons bg-light-success text-success ms-auto"><i class="fadeIn animated bx bx-money"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total Staff Members</p>
								<h4 class="my-1"><?=number_format($tadmins); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$admin_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-group'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total Customers</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-group'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total Account Types</p>
								<h4 class="my-1"><?=number_format($total_account_typesB); ?></h4>
							</div>
							<div class="widgets-icons bg-light-danger text-danger ms-auto"><i class="fadeIn animated bx bx-list-check"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total Opened Accounts</p>
								<h4 class="my-1"><?=number_format($toaccs); ?></h4>
							</div>
							<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="fadeIn animated bx bx-credit-card-front"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total Pending Accounts</p>
								<h4 class="my-1"><?=number_format($toaccs); ?></h4>
							</div>
							<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="fadeIn animated bx bx-credit-card-front"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total Active Accounts</p>
								<h4 class="my-1"><?=number_format($toaccs); ?></h4>
							</div>
							<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="fadeIn animated bx bx-credit-card-front"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total Savings</p>
								<h4 class="my-1">Ush 0.00</h4>
							</div>
							<div class="text-primary ms-auto font-35"><i class="fadeIn animated bx bx-money"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Pending Loans</p>
								<h4 class="my-1">0</h4>
							</div>
							<div class="text-danger ms-auto font-35"><i class='bx bxl-github'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Approved Loans</p>
								<h4 class="my-1">0</h4>
							</div>
							<div class="text-warning ms-auto font-35"><i class='bx bxl-firefox'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Ongoing Loans</p>
								<h4 class="my-1">0</h4>
							</div>
							<div class="text-warning ms-auto font-35"><i class='bx bxl-firefox'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Completed Loans</p>
								<h4 class="my-1">0</h4>
							</div>
							<div class="text-warning ms-auto font-35"><i class='bx bxl-firefox'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Total Loan Amounts</p>
								<h4 class="my-1">USh 0.00</h4>
							</div>
							<div class="text-warning ms-auto font-35"><i class='bx bxl-firefox'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Expenses</p>
								<h4 class="my-1">USh 0.00</h4>
							</div>
							<div class="text-success ms-auto font-35"><i class="fadeIn animated bx bx-money"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Current Theme</p>
								<h4 class="my-1"><?=ucwords($theme->theme_code); ?> <a href="themes" style="font-size:14px; ">Change Theme <i class="fadeIn animated bx bx-color-fill"></i> </a></h4>
							</div>
							<div class="text-success ms-auto font-35"><i class="fadeIn animated bx bx-color-fill"></i> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>