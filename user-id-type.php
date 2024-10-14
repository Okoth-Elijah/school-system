<div class="modal fade" id="exampleModalIdType<?=$user->userid?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><b><?=$user->firstname;?>'s</b> ID Details</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="form-group" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="userid" value="<?=$user->userid?>">
				<div class="modal-body">
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
								<input type="text" name="id_number" class="form-control" placeholder="ID Number/NIN">
							</div>
						</div>
					</div>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" name="user_id_type_details_btn" class="btn btn-primary">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>