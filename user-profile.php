<?php include 'header.php'; ?>
		<!--start page wrapper -->
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
											<img src="uploadx/man.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
											<div class="mt-3">
												<h4><?=ucwords($_SESSION['firstname'].' '.$_SESSION['lastname']);?></h4>
												<p class="text-secondary mb-1">Full Stack Developer</p>
												<p class="text-muted font-size-sm">
													<?php if($_SESSION['role'] == 'admin'){ 
															echo 'Administrator';
														}elseif ($_SESSION['role'] == 'manager') {
														echo 'Manager';
														}elseif ($_SESSION['role'] == 'cashier') {
															echo 'Cashier';
														}else{
															echo 'Customer';
														} ?>
													</p>
												<a class="btn btn-primary"><i class="bx bx-photo-album"></i>Change Photo</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<div class="card">
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Full Name</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" value="John Doe" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Email</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" value="john@example.com" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Phone</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" value="(239) 816-9029" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Mobile</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" value="(320) 380-4539" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Address</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" value="Bay Area, San Francisco, CA" />
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9 text-secondary">
												<input type="button" class="btn btn-primary px-4" value="Save Changes" />
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