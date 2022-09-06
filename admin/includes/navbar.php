
<?php

$name=$_SESSION['name'] ?? '';


?>

<div class="header">
		<div class="header-left">
		<h6 class="mx-4"> Leaves Management System</h6>
			
		</div>
		<div class="header-right">
			<div class="dashboard-setting user-notification">
			
			</div>
			
			<div class="user-info-dropdown">
				<div class="dropdown">

					<?php $query="select * from employees where emp_id = ?";
					  $stmt = $mysqli->prepare($query);
					  $stmt->execute([$session_id]);
					  $result = $stmt->get_result();
					  $row = $result->fetch_assoc();
						?>

					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						
						<span class="user-name mt-2 me-2"><?php echo  $row['name']; ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="change_password.php"><i class="dw dw-help"></i> Reset Password</a>
						<a class="dropdown-item" href="../logout.php"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>
			
		</div>
	</div>