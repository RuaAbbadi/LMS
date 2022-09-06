<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<body>
	<?php include('includes/navbar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
			<div class="card-box mb-30 mt-5 py-4">
				<div class="pd-20">
					<h2 class="text-blue h4 text-center">LEAVES HISTORY</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead class="text-center">
							<tr>
								<th class="table-plus">LEAVE TYPE</th>
								<th>START DATE </th>
								<th>END DATE </th>
								<th>LEAVE STATUS</th>
							</tr>
						</thead>
						<tbody class="text-center">
							<tr>
								
								 <?php 
                                   $query = "SELECT * from  leaves where empid = '$session_id'";
                                   $result = $mysqli->query($query);
                                   $cnt=1;

                                    while ( $row = $result->fetch_assoc() ) :
                                     ?>

								  <td><?php echo htmlentities($row['type']);?></td>
                                  <td><?php echo htmlentities($row['start_date']);?></td>
                                  <td><?php echo htmlentities($row['end_date']);?></td>
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
							</tr>
							<?php
                            $cnt++;
                            endwhile?>  
						</tbody>
					</table>
			   </div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>