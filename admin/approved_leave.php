<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<body>
	<?php include('includes/navbar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-danger h4">APPROVED LEAVES</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">EMP NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>LEAVE STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php 
								$reg_status=1;
                                $query = "SELECT leaves.id as leaveid,employees.name,employees.emp_id,leaves.type,leaves.publish_date,leaves.admin_status
								 from leaves join employees on leaves.empid=employees.emp_id
								 where  leaves.admin_status = '$reg_status'";
                                $result = $mysqli->query($query);
								while ( $row = $result->fetch_assoc() ) {
                                    ?>
								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['name']?></div>
										</div>
									</div>
								</td>
								<td><?php echo $row['type']; ?></td>
	                            <td><?php echo $row['publish_date']; ?></td>
	                            <td><?php $stats=$row['admin_status'];
	                             if($stats==1){
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php } if($stats==0)  { ?>
	                             <span style="color: blue">Pending</span>
	                             <?php } ?>
	                            </td>
								<td>
									<div class="table-actions">
										<a title="VIEW" href="leave_details.php?leaveid=<?php echo $row['leaveid'];?>"><i class="dw dw-eye" data-color="#265ed7"></i></a>	
									</div>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
			   </div>
			 </div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<script src="../vendors/scripts/core.js"></script>
	<script src="../vendors/scripts/script.min.js"></script>
	<script src="../vendors/scripts/process.js"></script>
	<script src="../vendors/scripts/layout-settings.js"></script>
	<script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

	<!-- buttons for Export datatable -->
	<script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="../src/plugins/datatables/js/vfs_fonts.js"></script>
	
	<script src="../vendors/scripts/datatable-setting.js"></script></body>
</body>
</html>