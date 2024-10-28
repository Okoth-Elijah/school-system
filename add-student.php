<?php include 'header.php'; ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Student</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?=SITE_URL; ?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">New Student Form</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="row">
			<div class="col-xl-9 mx-auto">
				<?php 
					if (isset($_SESSION['status'])) {
						echo $_SESSION['status'];
						unset($_SESSION['status']);
					}
					if (isset($_SESSION['loader'])) {
						echo $_SESSION['loader'];
						unset($_SESSION['loader']);
					} ?>
				<form method="post" action="">
					<h6 class="mb-0 text-uppercase">Personal Info</h6>
					<hr/>
					<div class="card">
						<div class="card-body">
							<div class="input-group mb-3"> <span class="input-group-text" id="basic-addon1">Firstname</span>
								<input type="text" name="firstname" class="form-control" placeholder="Enter Firstname Here" aria-label="Firstname" value="<?=$firstname; ?>" aria-describedby="basic-addon1" required>
							</div>
							<div class="input-group mb-3"> <span class="input-group-text" id="basic-addon1">Lastname</span>
								<input type="text" name="lastname" class="form-control" value="<?=$lastname; ?>" placeholder="Enter Lastname Here" aria-label="Lastname" aria-describedby="basic-addon1" required>
							</div>
							<div class="input-group mb-3"> <span class="input-group-text" id="basic-addon1">Gender</span>
								<select class="form-control" name="gender" required>
									<option value="">--choose gender--</option>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
							</div>
						</div>
					</div>

					<h6 class="mb-0 text-uppercase">Address Details</h6>
					<hr/>
					<div class="card">
						<div class="card-body">
							<div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping">Physical Address</span>
								<input type="text" value="<?=$physical_address; ?>" name="physical_address" class="form-control" placeholder="Eg Kiwangala"  require aria-describedby="addon-wrapping">
							</div>
							<div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping">Parish</span>
								<input type="text" name="parish" value="<?=$parish; ?>" class="form-control" placeholder="Eg Kiwangala" require aria-label="parish" aria-describedby="addon-wrapping">
							</div>
							<div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping">Sub County</span>
								<input type="text" name="sub_county" value="<?=$sub_county; ?>" class="form-control" placeholder="Eg Kisekka" require aria-label="sub_county" aria-describedby="addon-wrapping">
							</div>
							<div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping">District</span>
								<input type="text" name="district" value="<?=$district; ?>" class="form-control" placeholder="Eg Lwengo" require aria-label="district" aria-describedby="addon-wrapping">
							</div>
						</div>
					</div>

					<h6 class="mb-0 text-uppercase">Contact Details</h6>
					<hr/>
					<div class="card">
						<div class="card-body">
							<div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping">Phone Number</span>
								<input type="text" name="phonee" value="<?=$phonee; ?>" class="form-control" placeholder="Eg 07XXXXXXXX" maxlength="10" pattern="[0-9]*" require aria-label="phone-number" aria-describedby="addon-wrapping">
							</div>
							<div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping">Email Address(Optional)</span>
								<input type="email" name="email" value="<?=$email; ?>" class="form-control" placeholder="Eg example@gmail.com" require aria-label="email-address" aria-describedby="addon-wrapping">
							</div>
						</div>
					</div>

					<h6 class="mb-0 text-uppercase">ID Details</h6>
					<hr/>
					<div class="card">
						<div class="card-body">
							<div class="mb-3">
								<label>ID Type</label>
								<select class="form-select form-select-sm" name="id_type" required>
									<option value="">--select ID Type--</option>
									<option value="National ID">National ID</option>
									<option value="Passport">Passport</option>
									<option value="Driving Permit">Driving Permit</option>
									<option value="Village ID">Village ID</option>
								</select>
							</div>
							<div class="mb-3">
								<label>ID Number/NIN</label>
								<input type="text" name="id_number"value="<?=$id_number; ?>" class="form-control" placeholder="ID Number/NIN">
							</div>
						</div>
					</div>

					<h6 class="mb-0 text-uppercase">User Login Credential</h6>
					<hr/>
					<div class="card">
						<div class="card-body">
							<div class="mb-3">
								<label>Password</label>
								<input type="password" name="password" class="form-control" placeholder="Enter Passport" required>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-body">
							<button type="submit" name="save_new_loan_officer_btn" class="btn btn-primary">Save Student</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--end row-->
	</div>
</div>
<?php include 'footer.php'; ?>