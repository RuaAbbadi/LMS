<?php
include('includes/functions.php');
session_start();
include('includes/config.php');
if ($_POST) {
	$username = $_POST['username'] ?? '';
	$password = md5($_POST['password']) ?? '';

	if ($username && $password) {

		$status = 1;

		$query = "SELECT * FROM employees where email = ?  AND password = ? AND  status = ? LIMIT 1";
		$stmt = $mysqli->prepare($query);
		$stmt->execute([$username, $password, $status]);
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		if ($row &&  $row['password']) {
			if ($row['role'] == 'Admin') {
				login($row);
				if(!empty($_POST["remember"]))   
				{  
				 setcookie ("member_login",$_POST['username'],time()+ (60 * 60));  
				 setcookie ("member_password",$_POST['password'],time()+ (60 * 60));
				}  
				else  
				{  
				 if(isset($_COOKIE["member_login"]))   
				 {  
				  setcookie ("member_login","");  
				 }  
				 if(isset($_COOKIE["member_password"]))   
				 {  
				  setcookie ("member_password","");  
				 }  
				}  
				header('Location:admin/admin_dashboard.php');
			} else {
				login($row);
				header('Location:employee/index.php');
			}
		}
		$_SESSION['flash_messages']['error'] = 'Invalid email and password combination!!';
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
	<link rel="icon" type="image/png" sizes="32x32" href="./assets/images/logo.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/styles/core.css">
	<link rel="stylesheet" type="text/css" href="assets/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="assets/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
</head>

<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<h2 class="text-primary btn btn-block">Leaves Management System</h2>
				</a>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
			
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Leaves Management System</h2>
						</div>
						<form name="signin" method="post">

							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg" placeholder="Email" name="username" id="username" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>"/>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="Password" name="password" id="password" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>"/>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="checkbox" class=" " name="remember" vlaue="1" id="flexCheckDefault" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> /> 
								<div class="">
									<label class="btn btn=primary" for="flexCheckDefault">
										Remeber me.
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<input class="btn btn-primary btn-lg btn-block" name="signin" id="signin" type="submit" value="Sign In">
										<?php if (isset($_SESSION['flash_messages']['error'])) : ?>
											<div class="alert alert-danger btn-block">
												<?= $_SESSION['flash_messages']['error'] ?>
												<?php
												unset($_SESSION['flash_messages']['error']);
												?>
											</div>
										<?php endif ?>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</body>

</html>