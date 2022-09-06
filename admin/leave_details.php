<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<?php
// code for update the read notification status
$isread = 1;
$did = intval($_GET['leaveid']);
date_default_timezone_set('Asia/Kolkata');
$admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));

$query = 'UPDATE leaves SET
 IsRead= ?
 WHERE id = ?
';
$stmt = $mysqli->prepare($query);

$stmt->bind_param('ii', $isread, $did);

$stmt->execute();

// code for action taken on leave
if (isset($_POST['update'])) {
    $did = intval($_GET['leaveid']) ?? 0;
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 0;


    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));

    if ($status === '2') {

        $query = 'UPDATE leaves SET
                   adminRemark = ?,
                   admin_status=?,
                   AdminRemarkDate=?
                    WHERE id = ?
                ';

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('sisi', $description, $status, $admremarkdate, $did);

        $stmt->execute();
    } elseif ($status === '1') {


        $query = 'UPDATE leaves, employees SET
                  leaves.adminRemark = ?,
                  leaves.admin_status=?,
                  leaves.AdminRemarkDate=?
                    WHERE leaves.empid = employees.emp_id
                    AND leaves.id=?
                ';

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('sisi', $description, $status, $admremarkdate, $did);

        $stmt->execute();

        $_SESSION['flash_messages']['success'] = 'Your Action was taken successfully!';
        header('Location: admin_dashboard.php');
	    exit;

        


    }
}

?>

<style>
    input[type="text"] {
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }

    .btn-outline:hover {
        color: #fff;
        background-color: #524d7d;
        border-color: #524d7d;
    }

    textarea {
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }

    textarea.text_area {
        height: 8em;
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }
</style>

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
            <div class="min-height-200px">
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Leave Details</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <form method="post" action="">

                        <?php
                        if (!isset($_GET['leaveid']) && empty($_GET['leaveid'])) {
                            header('Location: admin_dashboard.php');
                        } else {

                            $lid = intval($_GET['leaveid']);

                            $query = "SELECT leaves.id as lid,employees.name,employees.emp_id,employees.gender,employees.phonenumber,employees.email,leaves.type,leaves.start_date,leaves.end_date,leaves.description,leaves.publish_date,leaves.status,leaves.adminRemark,leaves.admin_status,leaves.AdminRemarkDate from leaves join employees on leaves.empid=employees.emp_id where leaves.id=$lid";
                            $result = $mysqli->query($query);
                            $cnt = 1;
                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                        ?>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size:16px;"><b>Full Name</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($row['name']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size:16px;"><b>Email Address</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($row['email']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size:16px;"><b>Phone Number</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($row['phonenumber']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size:16px;"><b>Leave Type</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($row['type']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size:16px;"><b>Applied Date</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($row['publish_date']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="font-size:16px;"><b>Leave Period</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="From <?php echo htmlentities($row['start_date']); ?> to <?php echo htmlentities($row['end_date']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label style="font-size:16px;" class="col-sm-12 col-md-2 col-form-label"><b>Leave Reason</b></label>
                                        <div class="col-sm-12 col-md-10">
                                            <textarea name="" class="form-control text_area" readonly type="text"><?php echo htmlentities($row['description']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label style="font-size:16px;"><b>Action Taken Date</b></label>
                                                <?php
                                                if ($row['AdminRemarkDate'] == "") : ?>
                                                    <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NOT APPROVED YET"; ?>">
                                                <?php else : ?>
                                                    <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($row['AdminRemarkDate']); ?>">
                                                <?php endif ?>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label style="font-size:16px;"><b>Leaves Status</b></label>
                                                <?php $stats = $row['admin_status']; ?>
                                                <?php
                                                if ($stats == 1) : ?>
                                                    <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
                                                <?php
                                                elseif ($stats == 2) : ?>
                                                    <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
                                                <?php
                                                else : ?>
                                                    <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
                                                <?php endif ?>
                                            </div>
                                        </div>

                                        <?php
                                        if (($stats == 0) or ($stats == 2)) {

                                        ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label style="font-size:16px;"><b></b></label>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-primary" id="action_take" data-toggle="modal" data-target="#success-modal">Take Action</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <form name="adminaction" method="post">
                                                <div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center font-18">
                                                                <h4 class="mb-20">Leave take action</h4>
                                                                <select name="status" required class="custom-select form-control">
                                                                    <option value="">Choose your action</option>
                                                                    <option value="1">Approved</option>
                                                                    <option value="2">Rejected</option>
                                                                </select>
                                                                <div class="form-group">
                                                                    <label></label>
                                                                    <textarea id="textarea1" name="description" class="form-control" required placeholder="Description" length="300" maxlength="300"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <input type="submit" class="btn btn-primary" name="update" value="Submit">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        <?php } ?>
                                    </div>
                        <?php $cnt++;
                                }
                            }
                        } ?>
                    </form>
                </div>

            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

    <?php include('includes/scripts.php') ?>
</body>

</html>