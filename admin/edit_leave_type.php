<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php
 if(isset($_POST['edit']))
{
	 $leavetype=$_POST['leavetype'] ??'';
	 $description=$_POST['description']??'';
	
     if ($leavetype &&  $description ) {
        $query = 'UPDATE leavestype SET
            leave_type = ?,
            description=?
            WHERE id = ?
        ';

          $stmt = $mysqli->prepare($query); 
 
         $stmt->bind_param('ssi', $leavetype, $description,$get_id);
 
         $stmt->execute();

		 $_SESSION['flash_messages']['success'] = 'leave type Updated successfully!';

         header('Location: leave_type.php');
         exit;
}
}

?>
<body>
	<?php include('includes/navbar.php')?>

	<?php include('includes/left_sidebar.php')?>

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
			<div class="min-height-200px">
					<div class="row  mt-5 pt-4">
						<div class="col-lg-8 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4 py-3">Edit Leave Type</h2>
								<section>
									<?php
                                    $query = "SELECT * from leavestype where id = '$get_id'";
                                    $result = $mysqli->query($query);
                                    $data = $result->fetch_assoc();
                                    if (!$data) {
                                           header('Location: leave_type.php');
                                      exit;
                                       }

									?>
									<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label >Leave Type</label>
												<input name="leavetype" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $data['leave_type']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Leave Description</label>
												<textarea name="description" style="height: 5em;" class="form-control text_area" type="text"><?php echo $data['description']; ?></textarea>
											</div>
										</div>
									</div>
									<div class="col-sm-12 text-right">
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

	<?php include('includes/scripts.php')?>
</body>
</html>