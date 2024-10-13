<div class="modal fade" id="exampleModalTheme<?=$rx->theme_id?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Theme Details</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="form-group" method="post" action="">
				<input type="hidden" value="<?=$rx->theme_id?>">
				<input type="hidden" value="<?=$_SESSION['userid']; ?>" name="userid">
				<div class="modal-body">
					<div class="card">
						<div class="card-body">
							<div class="input-group mb-3">
								<label class="input-group-text" for="inputGroupSelect01">Options</label>
								<select class="form-select" name="theme_code" id="inputGroupSelect01" required>
									<option value="" selected>Choose Theme...</option>
									<option value="light">Light</option>
									<option value="bodered-theme">Bodered Theme</option>
									<option value="semi-dark">Semi Dark</option>
									<option value="dark">Dark</option>
								</select>
							</div>
						</div>
					</div>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" name="theme_btn" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>