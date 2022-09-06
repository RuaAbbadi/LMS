<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'];
	if (!$delete) {
		header('Location: employee.php');
		exit;
	}

	$query = 'DELETE FROM employees  WHERE emp_id = ?';

	$stmt = $mysqli->prepare($query); // mysqli_stmt

	$stmt->bind_param('i', $delete);

	$stmt->execute();

	$_SESSION['flash_messages']['success'] = 'Employee Deleted succssfully!';


	// Redirect
	header('Location: employee.php');
	exit;
}

?>

<body>

	<?php include('includes/navbar.php') ?>

	<?php include('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<?php if (isset($_SESSION['flash_messages']['success'])) : ?>
			<div class="alert alert-success mt-3 btn-block">
				<?= $_SESSION['flash_messages']['success'] ?>
				<?php
				unset($_SESSION['flash_messages']['success']);
				?>
			</div>
		<?php endif ?>
		<div class="pd-ltr-20">
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<?php
						$query = "SELECT emp_id from employees";
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

						$query = "SELECT * from employees where role = 'Staff' ";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$staffcount = $result->num_rows;
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($staffcount); ?></div>
								<div class="font-14 text-secondary weight-500">Employees</div>
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

						$query = "SELECT * from employees where role = 'Admin'";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$admincount = $result->num_rows;
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($admincount); ?></div>
								<div class="font-14 text-secondary weight-500">Administrators</div>
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
					<h2 class="text-danger h4">ALL EMPLOYEES</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">EMP NAME</th>
								<th>EMAIL</th>
								<th>DEPARTMENT</th>
								<th>ADDRESS</th>
								<th>POSITION</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php
								$query = "SELECT * from employees LEFT JOIN departments ON employees.department = departments.dep_title  where role != 'Admin' ORDER BY employees.emp_id";
								$result = $mysqli->query($query);
								while ($row = $result->fetch_assoc()) :
									$id = $row['emp_id'];
								?>
									<td class="table-plus">
										<div class="name-avatar d-flex align-items-center">
											<div class="txt">
												<div class="weight-600"><?php echo $row['name'] ?></div>
											</div>
										</div>
									</td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['dep_title']; ?></td>
									<td><?php echo $row['address']; ?></td>
									<td><?php echo $row['role']; ?></td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="edit_employee.php?edit=<?php echo $row['emp_id']; ?>"><i class="dw dw-edit2"></i> Edit</a>
												<a class="dropdown-item" href="employee.php?delete=<?php echo $row['emp_id'] ?>"><i class="dw dw-delete-3"></i> Delete</a>
											</div>
										</div>
									</td>
							</tr>
						<?php endwhile ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php') ?>
</body>

</html>