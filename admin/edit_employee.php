<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<?php $get_id = $_GET['edit']; ?>
<?php
if (isset($_POST['add_staff'])) {

	$name = $_POST['name'] ?? '';
	$email = $_POST['email'] ?? '';
	$gender = $_POST['gender'] ?? '';
	$department = $_POST['department'] ?? '';
	$address = $_POST['address'] ?? '';
	$user_role = $_POST['user_role'] ?? '';
	$phonenumber = $_POST['phonenumber'] ?? '';

	if ($email && $gender && $department && $address && $user_role && $phonenumber) {
		$query = 'UPDATE employees SET
            name = ?,
            email=?,
            gender=?,
            department=?,
            address=?,
            role=?,
            phonenumber=?
            WHERE emp_id=?
        ';

		$stmt = $mysqli->prepare($query);

		$stmt->bind_param('sssssssi', $name, $email, $gender, $department, $address, $user_role, $phonenumber, $get_id);

		$stmt->execute();

		$_SESSION['flash_messages']['success'] = 'Employee Updated successfully!';

		header('Location: employee.php');
		exit;
	}
}

?>

<body>

	<?php include('includes/navbar.php') ?>

	<?php include('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>

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
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px mt-4 py-4">
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Edit Employee</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="">
							<section>
								<?php
								$query = "SELECT * from employees where emp_id = '$get_id'";
								$result = $mysqli->query($query);
								$data = $result->fetch_assoc();
								?>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Employee's Name :</label>
											<input name="name" type="text" class="form-control wizard-required" required="true" autocomplete="off" value="<?php echo $data['name']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Email Address :</label>
											<input name="email" type="email" class="form-control" required="true" autocomplete="off" value="<?php echo $data['email']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Password :</label>
											<input name="password" type="password" placeholder="**********" class="form-control" readonly required="true" autocomplete="off" value="<?php echo $data['password']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Gender :</label>
											<select name="gender" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $data['gender']; ?>"><?php echo $data['gender']; ?></option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Phone Number :</label>
											<input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $data['phonenumber']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Address :</label>
											<input name="address" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $data['address']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Department :</label>
											<select name="department" class="custom-select form-control" required="true" autocomplete="off">
												<?php
												$query = "SELECT * from employees join departments where emp_id= '$get_id'";
												$result = $mysqli->query($query);
												$staff = $result->fetch_assoc();
												?>
												<option value="<?php echo $staff['dep_title']; ?>"><?php echo $staff['dep_title']; ?></option>
												<?php
												$query = "SELECT * from departments";
												$result = $mysqli->query($query);
												while ($row = $result->fetch_assoc()) :
												?>
													<option value="<?php echo $row['dep_title']; ?>"><?php echo $row['dep_title']; ?></option>
												<?php endwhile ?>
											</select>
										</div>
									</div>
									<?php
									$query = "SELECT * from employees where emp_id = '$get_id'";
									$result = $mysqli->query($query);
									$data = $result->fetch_assoc();
									?>

									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>User Role :</label>
											<select name="user_role" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $data['role']; ?>"><?php echo $data['role']; ?></option>
												<option value="Admin">Admin</option>
												<option value="Staff">Staff</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label style="font-size:16px;"><b></b></label>
											<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Update Employee</button>
									</div>
								</div>
							</section>
						</form>
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