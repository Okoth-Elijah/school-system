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
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Change Password</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
	  
		<div class="card">
		  <div class="card-body p-4">
			  <h5 class="card-title">Change Password</h5>
			  <hr/>
               <div class="form-body mt-4">
			    <div class="row">
				   <div class="col-lg-8-auto">
                   <div class="border border-3 p-4 rounded">
					<div class="mb-3">
						<label for="current-password" class="form-label">Current Password</label>
						<input type="password" name="current_password" class="form-control" id="current-password" placeholder="">
					 </div>

					 <div class="mb-3">
						<label for="new-password" class="form-label">New Password</label>
						<input type="password" name="new_password" class="form-control" id="new-password" placeholder="">
					 </div>

					  <div class="mb-3">
						<button type="submit" class="btn btn-primary" name="change_password_btn">Save Changes</button>
					  </div>
                    </div>
				   </div>
			   </div><!--end row-->
			</div>
		  </div>
	  </div>


	</div>
</div>
<?php include 'footer.php'; ?>