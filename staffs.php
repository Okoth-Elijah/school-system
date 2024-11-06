<?php include 'header.php'; ?>
	<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Staffs</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?=SITE_URL; ?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Staff Member</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="card">
			<div class="card-body">
				<div class="d-lg-flex align-items-center mb-4 gap-3">
				  <div class="ms-auto"><a href="new-staff" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New staff Member</a></div>
				</div>
				<div class="table-responsive">
					<table class="table mb-0" id="example">
						<thead class="table-light">
							<tr>
								<th>No#</th>
								<th>Full Name</th>
								<th>Phone</th>
								<th>Address</th>
								<th>Date</th>
								<th>View Details</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php $admin_user = $dbh->query("SELECT * FROM users WHERE role = 'manager' ORDER BY userid DESC ");
						$x = 1; 
						while($rx = $admin_user->fetch(PDO::FETCH_OBJ)){?>
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<div class="ms-2">
											<h6 class="mb-0 font-14">#<?=$x++; ?></h6>
										</div>
									</div>
								</td>
								<td><?=ucwords($rx->firstname.' '.$rx->lastname); ?></td>
								<td><?=$rx->phone; ?></td>
								<td><?=$rx->physical_address; ?></td>
								<td><?=date('jS M, Y', strtotime($rx->date_registered)); ?></td>
								<td><a href="udetails/<?=$rx->userid;?>/<?= str_replace(' ', '-', strtolower($rx->firstname . '-' . $rx->lastname)); ?>" class="btn btn-primary btn-sm radius-30 px-4">View Details</a></td>
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