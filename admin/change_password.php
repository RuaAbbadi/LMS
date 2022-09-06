<?php
include('../includes/config.php');
include('../includes/session.php');


if ($_POST) {
	$username = $_POST['username'] ?? '';
	$opassword = md5($_POST['opassword']) ?? '';
	$npassword = md5($_POST['npassword']) ?? '';
	$cpassword = md5($_POST['cpassword']) ?? '';

	if ($username && $opassword && $npassword && $cpassword) {

		$query = "SELECT * FROM employees where email = ? AND role='Admin' AND password = ? LIMIT 1";
		$stmt = $mysqli->prepare($query);
		$stmt->execute([$username, $opassword]);
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();


		if ($row &&  $row['password']) {
			$query = 'UPDATE employees SET
        password = ?
        WHERE email = ? 
         ';
			$stmt = $mysqli->prepare($query);

			$stmt->bind_param('ss', $npassword, $username);

			$stmt->execute();

			$_SESSION['flash_messages']['success'] = 'Password changed successfully!';
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Leaves Manager</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../assets/images/logo.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/styles/core.css">
	<link rel="stylesheet" type="text/css" href="../assets/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
</head>

<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<h2 class="text-primary btn btn-block">Leave Management System</h2>
				</a>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<?php if (isset($_SESSION['flash_messages']['success'])) : ?>
				<div class="alert alert-success mt-3 btn-block">
					<?= $_SESSION['flash_messages']['success'] ?>
					<?php
					unset($_SESSION['flash_messages']['success']);
					?>
				</div>
			<?php endif ?>
			<div class="row align-items-center">
				<div class="login-box bg-white box-shadow border-radius-10">
					<div class="login-title">
						<h2 class="text-center text-primary">Change Your Password</h2>
					</div>
					<form name="changePassword" method="post">
						<div class="input-group custom">
							<input type="text" class="form-control form-control-lg" placeholder="Email" name="username" id="username">
							<div class="input-group-append custom">
								<span class="input-group-text"><i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="input-group custom">
							<input type="password" class="form-control form-control-lg" placeholder="Old Password" name="opassword" id="password">
							<div class="input-group-append custom">
								<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
							</div>
						</div>
						<div class="input-group custom">
							<input type="password" class="form-control form-control-lg" placeholder="New Password" name="npassword" id="password">
							<div class="input-group-append custom">
								<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
							</div>
						</div>
						<div class="input-group custom">
							<input type="password" class="form-control form-control-lg" placeholder="Confirm Password" name="cpassword" id="password">
							<div class="input-group-append custom">
								<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="input-group mb-0">
									<input class="btn btn-primary btn-lg btn-block" name="signin" id="signin" type="submit" value="Change Password">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="assets/scripts/core.js"></script>
	<script src="assets/scripts/script.min.js"></script>
	<script src="assets/scripts/process.js"></script>
	<script src="assets/scripts/layout-settings.js"></script>
</body>

</html>