<?php include 'header.php';
$currentUrl = $_SERVER['REQUEST_URI'];
$parts = explode('/', $currentUrl);
$uid = $parts[count($parts) - 2]; 
$user = dbRow("SELECT * FROM users WHERE userid = '$uid' ");
 ?>
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
						<li class="breadcrumb-item active" aria-current="page"><?=ucwords($user->firstname.' '.$user->lastname); ?></li>
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
										<h4><?=ucwords($user->firstname.' '.$user->lastname);?></h4>
										<p class="text-muted font-size-sm">
											<?php if($user->role == 'admin'){ 
													echo 'Administrator';
												}elseif ($user->role == 'manager') {
												echo 'Manager';
												}elseif ($user->role == 'cashier') {
													echo 'Cashier';
												}else{
													echo 'Customer';
												} ?>
											</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="card">
							<div class="card-body">
								<h6 class="mb-0 text-uppercase">Light Contact List</h6>
								<hr/>
								<div class="col">
									<div class="card radius-15">
										<div class="card-body text-center">
											<div class="p-4 border radius-15">
												<img src="assets/images/avatars/avatar-3.png" width="110" height="110" class="rounded-circle shadow" alt="">
												<h5 class="mb-0 mt-5">John B. Roman</h5>
												<p class="mb-3">Graphic Designer</p>
												<div class="list-inline contacts-social mt-3 mb-3"> <a href="javascript:;" class="list-inline-item bg-facebook text-white border-0"><i class="bx bxl-facebook"></i></a>
													<a href="javascript:;" class="list-inline-item bg-twitter text-white border-0"><i class="bx bxl-twitter"></i></a>
													<a href="javascript:;" class="list-inline-item bg-google text-white border-0"><i class="bx bxl-google"></i></a>
													<a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0"><i class="bx bxl-linkedin"></i></a>
												</div>
												<div class="d-grid"> <a href="#" class="btn btn-outline-primary radius-15">Contact Me</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							
								<h6>Front ID Photo</h6>
								<div class="table-responsive">
									<table class="table mb-0">
										<thead>
											<tr>
												<th scope="col">#</th>
												<th scope="col">First</th>
												<th scope="col">Last</th>
												<th scope="col">Handle</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row">1</th>
												<td>Mark</td>
												<td>Otto</td>
												<td>@mdo</td>
											</tr>
											<tr>
												<th scope="row">2</th>
												<td>Jacob</td>
												<td>Thornton</td>
												<td>@fat</td>
											</tr>
											<tr>
												<th scope="row">3</th>
												<td colspan="2">Larry the Bird</td>
												<td>@twitter</td>
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