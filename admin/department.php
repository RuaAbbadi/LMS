<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<?php
if (isset($_GET['delete'])) {
	$department_id = $_GET['delete'] ?? '';
	if (!$department_id) {
		header('Location: department.php');
		exit;
	}

	$query = 'DELETE FROM departments  WHERE dep_id = ?';

	$stmt = $mysqli->prepare($query); // mysqli_stmt

	$stmt->bind_param('i', $department_id);

	$stmt->execute();

	$_SESSION['flash_messages']['success'] = 'Departement Deleted successfully!';

	// Redirect
	header('Location: department.php');
	exit;
}
?>
<?php

$errors = [];

if (isset($_POST['add'])) {
	$deptname = $_POST['departmentname'];

	//check if dep already exists or not
	$query = 'SELECT * FROM departments  WHERE dep_title = ?';
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('s', $deptname);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$errors['department'] = 'Department already exists!';
		echo
		"<script>alert('Department Already exist');</script>";
	}

	if (!$errors) {

		$query = 'INSERT INTO departments (dep_title) VALUES (?)';
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param('s', $_POST['departmentname']);
		$stmt->execute();

		$_SESSION['flash_messages']['success'] = 'Departement created successfully!';

		header('Location:department.php');
		exit;
	}
}

?>

<body>

	<?php include('includes/navbar.php') ?>

	<?php include('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay">
	</div>

	<div class="main-container ">
		<?php if (isset($_SESSION['flash_messages']['success'])) : ?>
			<div class="alert alert-success mt-3 btn-block">
				<?= $_SESSION['flash_messages']['success'] ?>
				<?php
				unset($_SESSION['flash_messages']['success']);
				?>
			</div>
		<?php endif ?>
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="row mt-5">
					<div class="col-lg-5 col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<h2 class="mb-30 h4 pt-4">New Department</h2>
							<section>
								<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Department Name</label>
												<input name="departmentname" type="text" class="form-control" required="true" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="">
										<div class="dropdown">
											<input class="btn btn-primary " type="submit" value="Add Department" name="add" id="add">
										</div>
									</div>
								</form>
							</section>
						</div>
					</div>
					<div class="col-lg-7 col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<h2 class="mb-30 h4 pt-4">Departments</h2>
							<div class="pb-20">
								<table class="data-table table stripe hover nowrap mt-4">
									<thead>
										<tr>
											<th class="table-plus">DEPARTMENT</th>
											<th class="datatable-nosort text-left">ACTION</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$query = "SELECT * from departments";
										$result = $mysqli->query($query);


										while ($row = $result->fetch_assoc()) :
										?>
											<tr>
												<td><?php echo htmlentities($row['dep_title']); ?></td>
												<td>
													<div class="table-actions">
														<a href="edit_department.php?edit=<?php echo htmlentities($row['dep_id']); ?>" data-color="#265ed7"><span class="btn btn-success"><i class="icon-copy dw dw-edit2"></i></span></a>
														<a href="department.php?delete=<?php echo htmlentities($row['dep_id']); ?>" data-color="#e95959"><span class="btn btn-danger"><i class="icon-copy dw dw-delete-3"></i></span></a>
													</div>
												</td>
											</tr>
										<?php
										endwhile
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<?php include('includes/scripts.php') ?>
</body>

</html>