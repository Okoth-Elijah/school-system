<?php include 'header.php'; ?>
	<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">System Theme</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?=SITE_URL; ?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Current: <b class="text text-primary"><?=ucwords($theme->theme_code); ?></b></li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
	  
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table mb-0" id="example">
						<thead class="table-light">
							<tr>
								<th>TNo#</th>
								<th>Theme Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<!-- `theme_id`, `userid`, `theme_code` -->
						<?php $user_theme = $dbh->query("SELECT * FROM theme_settings ");
						$x = 1;
						while($rx = $user_theme->fetch(PDO::FETCH_OBJ)){?>
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<div class="ms-2">
											<h6 class="mb-0 font-14">#<?=$x++; ?></h6>
										</div>
									</div>
								</td>
								<td><?=ucwords($rx->theme_code); ?></td>
								<td>
									<div class="d-flex order-actions">
										<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#exampleModalTheme<?=$rx->theme_id?>" class=""><i class='bx bxs-edit'></i></a>
									</div>
								</td>
							</tr>
						<?php include 'change-theme.php'; } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
	<!--end page wrapper -->
<?php include 'footer.php'; ?>