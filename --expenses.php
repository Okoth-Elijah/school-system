<?php include 'header.php'; ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Expenses</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Form Layouts</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="row">
			<div class="col-xl-6 mx-auto">


				<div class="card">
					<div class="card-body p-4">
						<h5 class="mb-4">Expense Form</h5>
						<form class="row g-3">
							<div class="col-md-12">
								<label for="input25" class="form-label">First Name</label>
								 <div class="input-group">
									<span class="input-group-text"><i class='bx bx-user'></i></span>
									<input type="text" class="form-control" id="input25" placeholder="First Name">
								  </div>
							</div>
							<div class="col-md-12">
								<label for="input26" class="form-label">Last Name</label>
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-user'></i></span>
									<input type="text" class="form-control" id="input26" placeholder="Last Name">
								  </div>
							</div>
							<div class="col-md-12">
								<label for="input27" class="form-label">Email</label>
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-envelope'></i></span>
									<input type="text" class="form-control" id="input27" placeholder="Email">
								  </div>
							</div>
							<div class="col-md-12">
								<label for="input28" class="form-label">Password</label>
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
									<input type="password" class="form-control" id="input28" placeholder="Password">
								  </div>
							</div>
							<div class="col-md-12">
								<label for="input29" class="form-label">DOB</label>
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-calendar'></i></span>
									<input type="text" class="form-control" id="input29" placeholder="DOB">
								  </div>
							</div>
							<div class="col-md-12">
								<label for="input30" class="form-label">Country</label>
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-flag'></i></span>
									<select class="form-select" id="input30">
										<option selected>Open this select menu</option>
										<option value="1">One</option>
										<option value="2">Two</option>
										<option value="3">Three</option>
									  </select>
								  </div>
							</div>
							<div class="col-md-12">
								<label for="input31" class="form-label">Zip</label>
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-pin'></i></span>
									<input type="text" class="form-control" id="input31" placeholder="Zip">
								  </div>
							</div>
							<div class="col-md-12">
								<label for="input32" class="form-label">City</label>
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-buildings'></i></span>
									<input type="text" class="form-control" id="input32" placeholder="City">
								  </div>
							</div>
							<div class="col-md-12">
								<label for="input33" class="form-label">State</label>
								<div class="input-group">
									<span class="input-group-text"><i class='bx bxs-city'></i></span>
									<select class="form-select" id="input33">
										<option selected>Open this select menu</option>
										<option value="1">One</option>
										<option value="2">Two</option>
										<option value="3">Three</option>
									  </select>
								  </div>
							</div>
							<div class="col-md-12">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="input34">
									<label class="form-check-label" for="input34">Check me out</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="d-md-flex d-grid align-items-center gap-3">
									<button type="button" class="btn btn-primary px-4">Submit</button>
									<button type="button" class="btn btn-light px-4">Reset</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
			</div>
		</div>
		<!--end row-->

	</div>
</div>
<?php include'footer.php'; ?>