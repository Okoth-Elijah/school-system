<?php include 'header.php'; ?>
<div class="page-wrapper">
	<div class="page-content">
		<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			<div class="col">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0 text-secondary">Revenue</p>
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
								<p class="mb-0 text-secondary">Projects</p>
								<h4 class="my-1"><?=number_format($tadmins); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$admin_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-rs-workflow-alt"></i>
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
								<p class="mb-0 text-secondary">Pending Projects</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-ss-pending"></i>
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
								<p class="mb-0 text-secondary">Ongoing Projects</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-rr-operation"></i>
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
								<p class="mb-0 text-secondary">Completed Projects</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-br-progress-complete"></i>
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
								<p class="mb-0 text-secondary">Customers</p>
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
								<p class="mb-0 text-secondary">Services</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-rr-user-headset"></i>
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
								<p class="mb-0 text-secondary">Total Tickets</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fadeIn animated bx bx-bookmark-minus"></i>
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
								<p class="mb-0 text-secondary">Pending Tickets</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-ss-pending"></i>
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
								<p class="mb-0 text-secondary">Completed Tickets</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-br-progress-complete"></i>
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
								<p class="mb-0 text-secondary">Invoices</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-rs-cash-register"></i>
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
								<p class="mb-0 text-secondary">Pending Invoices</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-ss-pending"></i>
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
								<p class="mb-0 text-secondary">Paid Invoices</p>
								<h4 class="my-1"><?=number_format($tcustomers); ?></h4>
								<p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>New this Week (<?=$cus_this_week; ?>)</p>
							</div>
							<div class="widgets-icons bg-light-info text-info ms-auto"><i class="fi fi-br-document-paid"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>