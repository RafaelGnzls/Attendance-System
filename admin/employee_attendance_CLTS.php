<?php
include("controller.php");
?>

<?php $date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d"); ?>
<?php $date2 = isset($_GET['date2']) ? $_GET['date2'] : date("Y-m-d"); ?><!-- 
<?php $sales_agent_id = isset($_GET['sales_agent_id']) ? $_GET['sales_agent_id'] : date("Y-m-d"); ?> -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Attendance Report</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">

      </div>
    </form>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
          <span class="hidden-xs"><?php echo $_SESSION['name']; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header" style="max-height: 150px; overflow:hidden; background:darkslategrey;">
            <div class="image">
              <img src="dist/img/user2-160x160.jpg" style="border-radius: 50%;width: 100x;height: 100px;" alt="User Image">
            </div>
          </span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Settings</a>
          <div class="dropdown-divider"></div>
          <form method="POST">
            <button type="submit" name="logout" class="dropdown-item dropdown-footer">Logout</a>
          </form>
        </div>
      </li>

    </ul>
  </nav>



   <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #222d32;">

    <a href="employee_attendance_CLTS.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Attendance Report</span>
    </a>


      <div class="sidebar">

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['name']; ?></a>
        </div>
      </div>


      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">REPORTS</li>
          <li class="nav-item">
            <a href="employee_attendance_CLTS.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
         
        </ul>
      </nav>

    </div>

  </aside>

  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Attendance</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <?php $date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d"); ?>
    <?php $date2 = isset($_GET['date2']) ? $_GET['date2'] : date("Y-m-d"); ?>
    <!-- <?php $campaign_id = isset($_GET['campaign_id']) ? $_GET['campaign_id'] : date("Y-m-d"); ?> -->

    <section class="content">
      <div class="container-fluid">
        <form action="" id="filter-form">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="date" class="control-label">Choose Date</label>
                    <input type="date" class="form-control form-control-sm rounded-0" name="date" id="date" value="<?= date("Y-m-d", strtotime($date)) ?>" required="required">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <input type="date" class="form-control form-control-sm rounded-0" name="date2" id="date2" value="<?= date("Y-m-d", strtotime($date2)) ?>" required="required"> 
                  </div>
                </div>
                <!-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
                    <div class="form-group">
                         <label for="campaign_id" class="control-label">Select Campaign</label>
                          <select name="campaign_id" id="campaign_id" class="form-control form-control rounded-0">
                         <option value="" disabled <?= !isset($campaign_id) ? "selected" : "" ?>></option>
                            <option value="" <?= isset($campaign_id) && in_array($campaign_id,[null,""]) ? "selected" : "" ?>>Select Campaign</option>
                             <?php 
                            $qry = $db->query("SELECT * from ref_campaign");
                                        while($row = $qry->fetch_assoc()):

                            ?>
                            <option value="<?= $row['campaign_id'] ?>"<?= isset($campaign_id) && $campaign_id == $row['campaign_id'] ? "selected" : "" ?>><?= $row['campaign_name']?></option>
                              <?php endwhile; ?>
                        </select>
                    </div>
                </div> -->
                <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <button class="btn btn-primary btn-sm bg-gradient-primary rounded-0"><i class="fa fa-filter"></i> Filter</button>         
                  </div>
                </div> 
            </div>
        </form>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="example1" class="table table-bordered dataTable no-footer" role="grid" aria....- describedby="example1_info">

                <thead style="font-size: 14px; font-weight: bold;">
                  <tr>
                    <th>Date</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Time In</th>
                    <th>Morning Break In</th>
                    <th>Morning Break out</th>
                    <th>Lunch In</th>
                    <th>Lunch Out</th>
                    <th>Afternoon Break In</th>
                    <th>Afternoon Break Out</th>
                    <th>Time Out</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

               <?php
                $sql = "SELECT * FROM emp_attendance, emp_list, emp_sched, ref_campaign WHERE emp_attendance.employee_id = emp_list.emp_card AND emp_list.sched_id = emp_sched.sched_id and emp_list.campaign_id = ref_campaign.campaign_id
and emp_attendance.attendance_date  between '{$date}' and '{$date2}' and ref_campaign.campaign_id = '4' order by emp_attendance.attendance_date,emp_attendance.employee_name";
                $result = mysqli_query($db, $sql);
                
                while($row = mysqli_fetch_array($result))
                {
                  if($row['attendance_timein'] <= $row['sched_in']){
                ?>
                    <tr style="text-align: center;">
                      <td><?php echo $row['attendance_date']; ?></td>
                      <td><?php echo $row['employee_id']; ?></td>
                      <td><?php echo $row['employee_name']; ?></td>
                      <td><?php echo date('g:i: A', strtotime( $row['attendance_timein']));?><span class="float-right badge bg-success">On Time</span></td>
                      
                      <td><?php 
                        if($row['mor_in'] >= $row['morr_in']){
                          $time_in = $row['mor_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }
                        }
                        ?>
                      </td>
                      <td><?php 
                        if($row['mor_out'] <= $row['morr_out']){
                          $time_in = $row['mor_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-success">On Time</span>', $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['mor_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-danger">Late</span>', $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['lunch_in'] <= $row['lunchh_in']){
                          $time_in = $row['lunch_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['lunch_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['lunch_out'] <= $row['lunchh_out']){
                          $time_in = $row['lunch_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-success">On Time</span>', $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['lunch_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-danger">Late</span>', $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['coff_in'] <= $row['cofff_in']){
                          $time_in = $row['coff_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                 echo $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['coff_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['coff_out'] <= $row['cofff_out']){
                          $time_in = $row['coff_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-success">On Time</span>', $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['coff_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-danger">Late</span>', $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php echo date('h:i: A', strtotime( $row['attendance_timeout']));?></td>
                      <!-- MODAL FOR VIEW -->
                      <!-- MODAL TRIGGER MODAL -->
                      <td align="center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?= $row['attendance_id']?>"><span class="fa fa-eye text-dark"></span> View
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal<?= $row['attendance_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" style="max-width: 85%;">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['employee_name']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <table id="example1" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="example1_info" style="text-align: center;">
                                  <colgroup>
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                     <col width="11%">
                                  </colgroup>
                                    <thead >
                                    <tr>
                                      <th>Date</th>
                                      <th>Time In</th>
                                      <th>Morning Coffee In</th>
                                      <th>Morning Coffee Out</th>
                                      <th>Lunch In</th>
                                      <th>Lunch Out</th>
                                      <th>Afternoon Coffee In</th>
                                      <th>Afternoon Coffee Out</th>
                                      <th>Time Out</th>
                                    </tr>
                                    </thead>
                                    <tbody >
                                      <tr>
                                        <td style="padding: 40px;"><?php echo $row['attendance_date']; ?></td>
                                        <td><img src="../cam/<?= $row['timein_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['morin_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['morout_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['lunchin_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['lunchout_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['coffin_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['coffout_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['timeout_cam']?>" style="width: 100px; height:100px;"></td>
                                      </tr>
                                    </tbody>
                                </table>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                <?php
                  }
                  else {
                    ?>
                    <tr style="text-align: center;">
                      <td><?php echo $row['attendance_date']; ?></td>
                      <td><?php echo $row['employee_id']; ?></td>
                      <td><?php echo $row['employee_name']; ?></td>
                      <td><?php echo date('g:i: A', strtotime( $row['attendance_timein']));?><span class="float-right badge bg-danger">Late</span></td>
                      
                      <td><?php 
                        if($row['mor_in'] >= $row['morr_in']){
                          $time_in = $row['mor_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['mor_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['mor_out'] <= $row['morr_out']){
                          $time_in = $row['mor_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in, '<span class="float-right badge bg-success">On Time</span>';
                            }
                        }
                        else{
                          $time_in = $row['mor_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-danger">Late</span>', $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['lunch_in'] >= $row['lunchh_in']){
                          $time_in = $row['lunch_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['lunch_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['lunch_out'] <= $row['lunchh_out']){
                          $time_in = $row['lunch_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-success">On Time</span>', $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['lunch_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-danger">Late</span>', $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['coff_in'] <= $row['cofff_in']){
                          $time_in = $row['coff_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in;
                            }
                        }
                        else{
                          $time_in = $row['coff_in'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo  $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php 
                        if($row['coff_out'] <= $row['cofff_out']){
                          $time_in = $row['coff_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo $formatted_time_in, '<span class="float-right badge bg-success">On Time</span>';
                            }
                        }
                        else{
                          $time_in = $row['coff_out'];
                            if (strtotime($time_in) === false) {
                                // Handle the case where $time_in is not a valid date/time string
                                echo " ";
                            } else {
                                // Convert the time variable to a Unix timestamp if it's a string
                                if (!is_numeric($time_in)) {
                                    $time_in = strtotime($time_in);
                                }

                                // Format the time in 12-hour format
                                $formatted_time_in = date("g:i A", $time_in);

                                // Echo the formatted time
                                echo '<span class="float-right badge bg-danger">Late</span>', $formatted_time_in;
                            }

                        }

                        ?>
                      </td>
                      <td><?php echo date('h:i: A', strtotime( $row['attendance_timeout']));?></td>
                      <!-- MODAL FOR VIEW -->
                      <!-- MODAL TRIGGER MODAL -->
                      <td align="center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?= $row['attendance_id']?>"><span class="fa fa-eye text-dark"></span> View
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal<?= $row['attendance_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" style="max-width: 85%;">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['employee_name']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <table id="example1" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="example1_info" style="text-align: center;">
                                  <colgroup>
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                    <col width="11%">
                                     <col width="11%">
                                  </colgroup>
                                    <thead >
                                    <tr>
                                      <th>Date</th>
                                      <th>Time In</th>
                                      <th>Morning Coffee In</th>
                                      <th>Morning Coffee Out</th>
                                      <th>Lunch In</th>
                                      <th>Lunch Out</th>
                                      <th>Afternoon Coffee In</th>
                                      <th>Afternoon Coffee Out</th>
                                      <th>Time Out</th>
                                    </tr>
                                    </thead>
                                    <tbody >
                                      <tr>
                                        <td style="padding: 40px;"><?php echo $row['attendance_date']; ?></td>
                                        <td><img src="../cam/<?= $row['timein_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['morin_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['morout_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['lunchin_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['lunchout_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['coffin_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['coffout_cam']?>" style="width: 100px; height:100px;"></td>
                                        <td><img src="../cam/<?= $row['timeout_cam']?>" style="width: 100px; height:100px;"></td>
                                      </tr>
                                    </tbody>
                                </table>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php
                  //end bracket for else
                  }
                }
                //end bracket for php tbody
                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>

</div>


<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
<script>
  $(function(){
         $('select#emp_id').select2({
            placeholder:"Select Employee here",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
    $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=admin/employee_attendance&"+$(this).serialize()
        })
        $('#print').click(function(){
            var h = $('head').clone()
            var ph = $($('noscript#print-header').html()).clone()
            var p = $('#printout').clone()
            h.find('title').text('Status Report - Print View')
             var el = $('<div>')
            el.append(h)
            el.append(ph)
            el.append(p)
            start_loader()
           var nw = window.open("", "_blank", "width="+($(window).width() * .8)+", height="+($(window).height() * .8)+", left="+($(window).width() * .1)+", top="+($(window).height() * .1))
                 nw.document.write(el.html())
                 nw.document.close()
                 setTimeout(()=>{
                     nw.print()
                     setTimeout(()=>{
                        nw.close()
                        end_loader()
                     },300)
                 },500)
    })
    })
  
</script>
</body>
</html>