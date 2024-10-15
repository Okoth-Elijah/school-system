<?php include 'header.php'; ?>
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Report</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Cashier</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="card">
			<div class="card-body">
				<div class="content container-fluid">
					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">Cashier Report</h3>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-md-12">
							<div class="card card-info">
				                <div class="card-body">
				                    <form role="form" method="post" action="">
										<div class="row">
									        <div class="col-sm-4">
												<div class="form-group">
												 <label> <b> Start Date: </b> </label>
												 <input type="date" class="form-control" name="start_date" max="<?=$today;?>" value="" required /> 
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												 <label> <b> End Date: </b> </label>
												 <input type="date"  class="form-control" name="end_date" max="<?=$today;?>" value=""  /> 
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												<label> &nbsp;</label>
												<br/>
													<input type="submit" name="get_report" value="Generate" class="btn btn-primary btn-md"/>
												</div>
											</div>
									</div>
				                    </form>
									<form method="post" action="">
									<div class="col-sm-12">
										<div class="form-group">
										<label> &nbsp;</label>
											<button type="submit" name="get_daily" class="btn btn-success btn-sm"> <i class="fa fa-bar-chart"> </i> Daily Report </button>
											<button type="submit" name="get_weekly" class="btn btn-success btn-sm"> <i class="fa fa-bar-chart"> </i> Weekly Report </button>
											<button type="submit" name="get_monthly" class="btn btn-success btn-sm"> <i class="fa fa-bar-chart"> </i> Monthly Report </button>
										</div>
									</div>
									</form>
				                </div>
				          </div>
						</div>

						<?php
							if(isset($_POST['get_report'])){
							extract($_POST);
							if($start_date <= $today && $end_date <= $today){
							$sql = $dbh->query("SELECT * FROM users WHERE role ='admin' AND date_registered BETWEEN 
						  	'$start_date' AND '$end_date' order by date_registered DESC");

						  	$number = $dbh->query("SELECT count(*) FROM users WHERE role ='admin' AND date_registered BETWEEN 
						  '$start_date' AND '$end_date' order by date_registered DESC")->fetchColumn();
						   if($number  > 0){ ?>
							<br/>
				            <div class="col-lg-12">
							<a href="<?=$_SERVER['REQUEST_URI'];?>#" class="btn btn-primary btn-sm" onclick="PrintContent('report')" > <i class="fa fa-print fa-fw"> </i>&nbsp;Print Report </a> 
							<br> </br>
								<div class="card card-info" id="report">
				                    <div class="panel-heading">
				                    	<img src="uploadx/headed-paper-transparent.png" style="width: 100%; " />
				                        <h4 class="page-title"> GENERATED Cashier'S REPORT 
										(TOTAL ADMIN: <strong style="color:red"> <?=number_format($number)?> </strong>)
										</h4>
				                    </div>
				                    <!-- /.panel-heading -->
				                    <div class="card-body">
									 <table width="100%" class="table table-striped table-bordered table-hover" >
				                            <thead>
				                                <tr>
												    <th> Date </th>
												    <th> Fullname </th>
				                                    <th> Gender </th>
													<th> Phone </th>
													<th> Physical Address </th>
													<th> Parish </th>
													<th> Sub County </th>
													<th> District </th>
													
				                                </tr>
				                            </thead>
				                            <tbody>
											<?php while($rows = $sql->fetch(PDO::FETCH_OBJ)){
												?>
												<tr class="odd gradeX">
				                                    <td><?=$rows->date_registered ?> </td>
													<td><?=$rows->firstname.' '.$rows->lastname; ?> </td>
													<td><?=$rows->gender?> </td>
													<td><?=$rows->phone?> </td>
													<td><?=$rows->physical_address?> </td>
													<td><?=$rows->parish?> </td>
													<td><?=$rows->sub_county?> </td>
													<td><?=$rows->district?> </td>
												</tr>
										<?php }?> 
				                            </tbody>
				                        </table>
										<hr/>
										<p> <i> Cashier Report Generated at <b style="color:red"><?=$dtime?> </i> </b> </p>
				                        <!-- /.table-responsive -->
				                    </div>
				                    <!-- /.panel-body -->
				                </div>	
				            </div>
						   <?php
						   }else{
							  echo "<script>
							alert('*** No Admin found ***');
							window.location =".$_SERVER['REQUEST_URI'].";
							</script>"; 
						   }
							}else{
								echo "<script>
								alert(' *** Start date or End date can not can exceed today ***');
								window.location =".$_SERVER['REQUEST_URI'].";
								</script>";
							}
							}elseif(isset($_POST['get_daily'])){
							 $start_date = $today;
							 $end_date = $today;
							$sql = $dbh->query("SELECT * FROM users WHERE role ='admin' AND date_registered BETWEEN 
						  	'$start_date' AND '$end_date' order by date_registered DESC");

						  	$number = $dbh->query("SELECT count(*) FROM users WHERE role ='admin' AND date_registered BETWEEN 
						  '$start_date' AND '$end_date' order by date_registered DESC")->fetchColumn();
						   if($number  > 0){
							   ?>
							    <br/>
				            <div class="col-lg-12">
							<a href="#" class="btn btn-primary btn-sm" onclick="PrintContent('report')" > <i class="fa fa-print fa-fw"> </i>&nbsp;Print Report </a> 
							<br> </br>
								<div class="card card-info" id="report">
				                    <div class="panel-heading">
				                    	<img src="uploadx/headed-paper-transparent.png" style="width: 100%; " />
				                        <h4 class="page-title"> DAILY Cashier'S REPORT 
										(TOTAL OFFICERS: <strong style="color:red"> <?=number_format($number)?> </strong>)
										</h4>
				                    </div>
				                    <!-- /.panel-heading -->
				                    <div class="card-body">
									 <table width="100%" class="table table-striped table-bordered table-hover" >
				                            <thead>
				                                <tr>
												    <th> Date </th>
												    <th> Fullname </th>
				                                    <th> Gender </th>
													<th> Phone </th>
													<th> Physical Address </th>
													<th> Parish </th>
													<th> Sub County </th>
													<th> District </th>
													
				                                </tr>
				                            </thead>
				                            <tbody>
											<?php while($rows = $sql->fetch(PDO::FETCH_OBJ)){
												?>
												<tr class="odd gradeX">
				                                    <td><?=$rows->date_registered ?> </td>
													<td><?=$rows->firstname.' '.$rows->lastname; ?> </td>
													<td><?=$rows->gender?> </td>
													<td><?=$rows->phone?> </td>
													<td><?=$rows->physical_address?> </td>
													<td><?=$rows->parish?> </td>
													<td><?=$rows->sub_county?> </td>
													<td><?=$rows->district?> </td>
												</tr>
										<?php }?> 
				                            </tbody>
				                        </table>
										<hr/>
										<p> <i> Cashier Report Generated at <b style="color:red"><?=$dtime?> </i> </b> </p>
				                        <!-- /.table-responsive -->
				                    </div>
				                    <!-- /.panel-body -->
				                </div>	
				            </div>
						   <?php
						   }else{
							echo "<script>
							alert('*** No Admin officer found ***');
							window.location =".$_SERVER['REQUEST_URI'].";
							</script>"; 
						   }
							}elseif(isset($_POST['get_weekly'])){
							 $start_date = getWeek();
							 $end_date = $today;
							$sql = $dbh->query("SELECT * FROM users WHERE role ='admin' AND date_registered BETWEEN 
						  	'$start_date' AND '$end_date' order by date_registered DESC");

						  	$number = $dbh->query("SELECT count(*) FROM users WHERE role ='admin' AND date_registered BETWEEN 
						  '$start_date' AND '$end_date' order by date_registered DESC")->fetchColumn();
						   if($number  > 0){
							   ?>
							    <br/>
				            <div class="col-lg-12">
							<a href="#" class="btn btn-primary btn-sm" onclick="PrintContent('report')" > <i class="fa fa-print fa-fw"> </i>&nbsp;Print Report </a> 
							<br> </br>
								<div class="card card-info" id="report">
				                    <div class="panel-heading">
				                    	<img src="uploadx/headed-paper-transparent.png" style="width: 100%; " />
				                        <h4 class="page-title"> WEEKLY Cashier REPORT 
										(TOTAL SALES: <strong style="color:red"> <?=number_format($number)?> </strong>)
										</h4>
				                    </div>
				                    <!-- /.panel-heading -->
				                    <div class="card-body">
									 <table width="100%" class="table table-striped table-bordered table-hover" >
				                            <thead>
				                                <tr>
												    <th> Date </th>
												    <th> Fullname </th>
				                                    <th> Gender </th>
													<th> Phone </th>
													<th> Physical Address </th>
													<th> Parish </th>
													<th> Sub County </th>
													<th> District </th>
													
				                                </tr>
				                            </thead>
				                            <tbody>
											<?php while($rows = $sql->fetch(PDO::FETCH_OBJ)){
												?>
												<tr class="odd gradeX">
				                                    <td><?=$rows->date_registered ?> </td>
													<td><?=$rows->firstname.' '.$rows->lastname; ?> </td>
													<td><?=$rows->gender?> </td>
													<td><?=$rows->phone?> </td>
													<td><?=$rows->physical_address?> </td>
													<td><?=$rows->parish?> </td>
													<td><?=$rows->sub_county?> </td>
													<td><?=$rows->district?> </td>
												</tr>
										<?php }?> 
				                            </tbody>
				                        </table>
										<hr/>
										<p> <i> Cashier Report Generated at <b style="color:red"><?=$dtime?> </i> </b> </p>
				                        <!-- /.table-responsive -->
				                    </div>
				                    <!-- /.panel-body -->
				                </div>	
				            </div>
						   <?php
						   }else{
							 echo "<script>
								alert('*** No Admin found ***');
								window.location =".$_SERVER['REQUEST_URI'].";
								</script>";  
						   }
							}elseif(isset($_POST['get_monthly'])){
							$start_date = monthly();
							$end_date = $today;
							$sql = $dbh->query("SELECT * FROM users WHERE role ='admin' AND date_registered BETWEEN 
						  	'$start_date' AND '$end_date' order by date_registered DESC");

						  	$number = $dbh->query("SELECT count(*) FROM users WHERE role ='admin' AND date_registered BETWEEN 
						  '$start_date' AND '$end_date' order by date_registered DESC")->fetchColumn();
						   if($number  > 0){
							   ?>
							    <br/>
				            <div class="col-lg-12">
							<a href="#" class="btn btn-primary btn-sm" onclick="PrintContent('report')" > <i class="fa fa-print fa-fw"> </i>&nbsp;Print Report </a> 
							<br> </br>
								<div class="card card-info" id="report">
				                    <div class="panel-heading">
				                    	<img src="uploadx/headed-paper-transparent.png" style="width: 100%; " />
				                        <h4 class="page-title"> MONTHLY Cashier REPORT 
										(TOTAL ADMINS: <strong style="color:red"> <?=number_format($number)?> </strong>)
										</h4>
				                    </div>
				                    <!-- /.panel-heading -->
				                    <div class="card-body">
									 <table width="100%" class="table table-striped table-bordered table-hover" >
				                            <thead>
				                                <tr>
												    <th> Date </th>
												    <th> Fullname </th>
				                                    <th> Gender </th>
													<th> Phone </th>
													<th> Physical Address </th>
													<th> Parish </th>
													<th> Sub County </th>
													<th> District </th>
													
				                                </tr>
				                            </thead>
				                            <tbody>
											<?php while($rows = $sql->fetch(PDO::FETCH_OBJ)){
												?>
												<tr class="odd gradeX">
				                                    <td><?=$rows->date_registered ?> </td>
													<td><?=$rows->firstname.' '.$rows->lastname; ?> </td>
													<td><?=$rows->gender?> </td>
													<td><?=$rows->phone?> </td>
													<td><?=$rows->physical_address?> </td>
													<td><?=$rows->parish?> </td>
													<td><?=$rows->sub_county?> </td>
													<td><?=$rows->district?> </td>
												</tr>
										<?php }?> 
				                            </tbody>
				                        </table>
										<hr/>
										<p> <i> Cashier Report Generated at <b style="color:red"><?=$dtime?> </i> </b> </p>
				                        <!-- /.table-responsive -->
				                    </div>
				                    <!-- /.panel-body -->
				                </div>	
				            </div>
						   <?php
						   }else{
							echo "<script>
							alert('*** No Admin found ***');
							window.location =".$_SERVER['REQUEST_URI'].";
							</script>";  
						} } ?>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<!--end page content -->
</div>
<?php include 'footer.php'; ?>