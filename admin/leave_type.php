<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<?php
if (isset($_GET['delete'])) {
	$leave_type_id = $_GET['delete'] ?? '';

	if (!$leave_type_id) {
		header('Location: leave_type.php');
		exit;
	}

	$query = 'DELETE FROM leavestype  WHERE id = ?';

	$stmt = $mysqli->prepare($query); // mysqli_stmt

	$stmt->bind_param('i', $leave_type_id);

	$stmt->execute();

	$_SESSION['flash_messages']['success'] = 'Leave Type Deleted successfully!';


	// Redirect
	header('Location: leave_type.php?success=1');
	exit;
}
?>

<?php
if (isset($_POST['add'])) {
	$leavetype = $_POST['leavetype'] ?? '';
	$description = $_POST['description'] ?? '';


	//check if leave type already exits
	$query = 'SELECT * FROM leavestype  WHERE leave_type = ?';
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('s', $leavetype);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$errors['leave'] = 'leave already exists!';
		echo "<script>alert('leave Already exist');</script>";
	}

	if (!$errors) {

		$query = 'INSERT INTO leavestype (leave_type,description) VALUES (?,?)';
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param('ss', $leavetype, $description);
		$stmt->execute();

		$_SESSION['flash_messages']['success'] = 'leave type created successfully!';

		header('Location:leave_type.php');
		exit;
	}
}

?>

<body>

	<?php include('includes/navbar.php') ?>

	<?php include('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>

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
			<div class="min-height-200px ">
				<div class="row mt-5">
					<div class="col-lg-5 col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<h2 class="mb-30 h4 pt-4">New Leave Type</h2>
							<section>
								<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Leave Type</label>
												<input name="leavetype" type="text" class="form-control" required="true" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Leave Description</label>
												<textarea name="description" style="height: 5em;" class="form-control text_area" type="text"></textarea>
											</div>
										</div>
									</div>
									<div>
										<div class="dropdown">
											<input class="btn btn-primary" type="submit" value="Add" name="add" id="add">
										</div>
									</div>
								</form>
							</section>
						</div>
					</div>

					<div class="col-lg-7 col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<h2 class="mb-30 h4 pt-4">Leave Type List</h2>
							<div class="pb-20">
								<table class="data-table table stripe hover nowrap">
									<thead  class="text-center">
										<tr>
											<th class="table-plus">LEAVETYPE</th>
											<th class="table-plus">DESCRIPTION</th>
											<th class="datatable-nosort">ACTION</th>
										</tr>
									</thead>
									<tbody  class="text-center">

										<?php $query = "SELECT * from leavestype";
										$result = $mysqli->query($query);
										$cnt = 1;
										while ($row = $result->fetch_assoc()) :
										?>
											<tr>
												<td> <?php echo htmlentities($row['leave_type']); ?></td>
												<td><?php echo htmlentities($row['description']); ?></td>
												<td>
													<div class="table-actions">
														<a href="edit_leave_type.php?edit=<?php echo htmlentities($row['id']); ?>" data-color="#265ed7"><span class="btn btn-success"><i class="icon-copy dw dw-edit2"></i></span></a>
														<a href="leave_type.php?delete=<?php echo htmlentities($row['id']); ?>" data-color="#e95959"><span class="btn btn-danger"><i class="icon-copy dw dw-delete-3"></i></span></a>
													</div>
												</td>
											</tr>
										<?php
											$cnt++;
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