<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<?php include('../includes/config.php') ?>

<body>
	<?php include('includes/navbar.php') ?>
	<?php include('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>
	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="row pb-5">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<?php
						$query = "SELECT emp_id from  employees ";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$empcount = $result->num_rows;
						?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($empcount); ?></div>
								<div class="font-14 text-secondary weight-500">Total Employees</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$admin_status = 1;
						$query = "SELECT id from leaves where admin_status=$admin_status";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$leavecount = $result->num_rows;
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Approved Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#09cc06"><span class="icon-copy fa fa-hourglass"></span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$admin_status = 0;
						$query = "SELECT id from leaves where admin_status=$admin_status";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$leavecount = $result->num_rows;
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Pending Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-hourglass-end" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$admin_status = 2;
						$query = "SELECT id from leaves where admin_status=$admin_status";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$leavecount = $result->num_rows;
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Rejected Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-box mb-30">
				<div class="pd-20">
					<h2 class="text-danger h4">LATEST LEAVES </h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">Emp NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>LEAVE STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
								$query = "SELECT leaves.id as lid,employees.name,employees.emp_id,leaves.type,leaves.publish_date,leaves.admin_status
								from leaves join employees on leaves.empid=employees.emp_id order by lid desc " ;
							   $result = $mysqli->query($query);
								while ($row = $result->fetch_assoc()) {
								?>
									<td class="table-plus">
										<div class="name-avatar d-flex align-items-center">
											<div class="txt mr-2 flex-shrink-0">
											</div>
											<div class="txt">
												<div class="weight-600"><?php echo $row['name'] ?></div>
											</div>
										</div>
									</td>
									<td><?php echo $row['type']; ?></td>
									<td><?php echo $row['publish_date']; ?></td>
									<td><?php $stats = $row['admin_status'];
										if ($stats == 1) {
										?>
											<span style="color: green">Approved</span>
										<?php }
										if ($stats == 2) { ?>
											<span style="color: red">Rejected</span>
										<?php }
										if ($stats == 0) { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="leave_details.php?leaveid=<?php echo $row['lid']; ?>"><i class="dw dw-eye"></i> View</a>
											</div>
										</div>
									</td>
							</tr>
						<?php
								} ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>

	<!-- js -->

	<?php include('includes/scripts.php') ?>
</body>

</html>