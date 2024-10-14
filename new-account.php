<div class="modal fade" id="new-account<?=$user->userid?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><b><?=$user->firstname;?>'s</b> New Account Details</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="form-group" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="userid" value="<?=$user->userid?>">
				<div class="modal-body">
					<!-- `account_number`, `acc_id`, `userid`, `opening_amount`, `account_balance`, `acc_status`, `acc_opening_time`, `acc_opening_date` -->
					<div class="card">
						<div class="card-body">
							<div class="mb-3">
								<label>Account Types</label>
								<select class="form-select form-select-sm" name="acc_id" required>
									<option value="">--select Account Type--</option>
									<?php $dacc = $dbh->query("SELECT * FROM account_types ");
									while ($val = $dacc->fetch(PDO::FETCH_OBJ)) {?>
									<option value="<?=$val->acc_id; ?>"><?=$val->acc_type; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="mb-3">
								<label>Opening Amount</label>
								<input type="text" name="opening_amount" class="form-control" placeholder="Eg, 10,000" oninput="addCommas(this)" required>
							</div>
						</div>
					</div>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" name="save_new_account_btn" class="btn btn-primary">Generate Account</button>
				</div>
			</form>
		</div>
	</div>
</div>