<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<?php $get_id = $_GET['edit']; ?>

<?php
if (isset($_POST['edit'])) {
	$deptname = $_POST['departmentname'] ?? '';

	if ($deptname) {
		$query = 'UPDATE departments SET
             dep_title = ?
             WHERE dep_id = ?
         ';

		$stmt = $mysqli->prepare($query);

		$stmt->bind_param('si', $deptname, $get_id);

		$stmt->execute();

		$_SESSION['flash_messages']['success'] = 'Departement Updated successfully!';

		header('Location: department.php');
		exit;
	}
}
?>

<body>

	<?php include('includes/navbar.php') ?>

	<?php include('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container mt-5 py-5">

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
				<div class="row">
					<div class="col-lg-8  col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<h2 class="mb-30 h4">Edit Department</h2>
							<section>
								<?php
								$query = "SELECT * from departments where dep_id = '$get_id'";
								$result = $mysqli->query($query);
								$data = $result->fetch_assoc();
								if (!$data) {
									header('Location: department.php');
									exit;
								}
								?>
								<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Department Name</label>
												<input name="departmentname" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $data['dep_title']; ?>">
											</div>
										</div>
									</div>
									<div class="">
										<div class="dropdown">
											<input class="btn btn-primary" type="submit" value="UPDATE" name="edit" id="edit">
										</div>
									</div>
								</form>
							</section>
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