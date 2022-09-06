<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'] ?? '';
	if (!$delete) {
		header('Location: leave_history.php');
		exit;
	}

	$query = 'DELETE FROM leaves  WHERE id = ?';

	$stmt = $mysqli->prepare($query); // mysqli_stmt

	$stmt->bind_param('i', $delete);

	$stmt->execute();

	$_SESSION['flash_messages']['success'] = 'Leave Deleted successfully!';

	// Redirect
	header('Location:leave_history.php');
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
						$query = "SELECT id from leaves where empid= '$session_id'";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$empcount = $result->num_rows;
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($empcount); ?></div>
								<div class="font-14 text-secondary weight-500">All Applied Leave</div>
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
						$status = 1;
						$query = "SELECT * from leaves where empid = '$session_id' AND admin_status = $status ";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$count_reg_leave = $result->num_rows;
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($count_reg_leave); ?></div>
								<div class="font-14 text-secondary weight-500">Approved</div>
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
						$status = 0;
						$query = "SELECT * from leaves where empid = '$session_id' AND admin_status = $status ";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$count_pending_leave = $result->num_rows;
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($count_pending_leave); ?></div>
								<div class="font-14 text-secondary weight-500">Pending</div>
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
						$status = 2;
						$query = "SELECT * from leaves where empid = '$session_id' AND admin_status = $status ";
						$result = $mysqli->query($query);
						$row = $result->fetch_assoc();
						$count_reject_leave = $result->num_rows;
						?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($count_reject_leave); ?></div>
								<div class="font-14 text-secondary weight-500">Rejected</div>
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
					<h2 class="text-blue text-center h4"> MY LEAVES</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead class="text-center">
							<tr>
								<th class="table-plus">LEAVE TYPE</th>
								<th>START DATE </th>
								<th>END DATE </th>
								<th>LEAVE STATUS</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody class="text-center">
							<tr>

								<?php
								$query = "SELECT * from leaves where empid = '$session_id'";
								$result = $mysqli->query($query);
								if ($result->num_rows > 0) {

									while ($row = $result->fetch_assoc()) {
								?>
										<td><?php echo htmlentities($row['type']); ?></td>
										<td><?php echo htmlentities($row['start_date']); ?></td>
										<td><?php echo htmlentities($row['end_date']); ?></td>
										<td><?php $stats = $row['admin_status'];
											if ($stats == 1) {
											?>
												<span style="color: green">Approved</span>
											<?php }
											if ($stats == 2) { ?>
												<span style="color: red">Not Approved</span>
											<?php }
											if ($stats == 0) { ?>
												<span style="color: blue">Pending</span>
											<?php } ?>

										</td>
										<td>
											<a href="leave_history.php?delete=<?php echo htmlentities($row['id']); ?>" data-color="#e95959"><span class="btn btn-danger"><i class="icon-copy dw dw-delete-3"></i></span></a>
										</td>
							</tr>
					          <?php 
									}
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