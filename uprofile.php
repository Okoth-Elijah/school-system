<div class="modal fade" id="user-pic<?=$uuser->userid?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><b><?=ucwords($uuser->firstname.' '.$uuser->lastname);?>'s</b> Profile Photo</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="form-group" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="userid" value="<?=$uuser->userid?>">
				<div class="modal-body">
					<div class="card">
						<div class="card-body">
							<div class="input-group mb-3"> 
								<input type="file" class="form-control" name="pic" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" accept=".png, jpeg, .jpg" required>
							</div>
						</div>
					</div>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" name="user_profile_pic_photo_btn" class="btn btn-primary">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>