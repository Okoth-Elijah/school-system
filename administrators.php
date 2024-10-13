<?php include 'header.php'; ?>
	<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Staff Member</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?=SITE_URL; ?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Administrators</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
	  
		<div class="card">
			<div class="card-body">
				<div class="d-lg-flex align-items-center mb-4 gap-3">
					<div class="position-relative">
						<input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
					</div>
				  <div class="ms-auto"><a href="javascript:;" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Admin</a></div>
				</div>
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="table-light">
							<tr>
								<th>Order#</th>
								<th>Company Name</th>
								<th>Status</th>
								<th>Total</th>
								<th>Date</th>
								<th>View Details</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
			<!-- `userid`, `firstname`, `lastname`, `gender`, `phone`, `email`, `password`, `id_type`, `id_number`, `id_front`, `id_back`, `physical_address`, `parish`, `sub_county`, `district`, `account_status`, `role`, `token`, `date_registered` -->
						<?php $admin_user = $dbh->query("SELECT * FROM users WHERE role = 'admin' ");
						while($rx = $admin_user->fetch(PDO::FETCH_OBJ)){?>
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<div>
											<input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
										</div>
										<div class="ms-2">
											<h6 class="mb-0 font-14">#OS-000354</h6>
										</div>
									</div>
								</td>
								<td>Gaspur Antunes</td>
								<td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>FulFilled</div></td>
								<td>$485.20</td>
								<td>June 10, 2020</td>
								<td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
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