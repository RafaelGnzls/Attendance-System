<?php
include("admin/controller.php");
ini_set('display_errors', 0);
ini_set('display_errors', false);
date_default_timezone_set('Asia/Manila');


// $attendance_id = 
$current_time = date("h:i:s A");
$today = date("D - F d, Y");
$date = date("Y-m-d");
$in = date("H:i:s");
$out = "12:00:00";
// // $out1 = 0;

// $qry = "SELECT concat('00-',LPAD(AUTO_INCREMENT, 3, 0)) FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'attpay' AND TABLE_NAME = 'emp_attendance'";
// $res = mysqli_query($db,$qry);
// $out1 = mysqli_fetch_array($res);

if(isset($_POST['attendance']))
{
  $_SESSION['expire'] =  date("H:i:s", time() + 1);
  $code = $_POST['operation'];
  if($code == "time-in")
  {
    $id = $_POST['emp_id'];
    $sql = "SELECT * FROM emp_list WHERE emp_card = '$id'";
    $result = mysqli_query($db, $sql);
    if(!$row = $result->fetch_assoc()) {
      $_SESSION['mess'] = "<div id='time' class='alert alert-danger' role='alert'>
                              <i class='fas fa-times'></i>  Employee ID is not registered !
                              </div>";
      header("Location: AUB.php");
    }
    else {
      $sql2 = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
      $result2 = mysqli_query($db, $sql2);
      if(!$row2 = $result2->fetch_assoc()) {
        $fname = $row['emp_fname'];
        $lname = $row['emp_lname'];
        $full = $lname . ', ' . $fname;
        $card = $row['emp_card'];

        $first = new DateTime($in);
        $second = new DateTime($out);
        $interval = $first->diff($second);
        $hrs = $interval->format('%h');
        $mins = $interval->format('%i');
        $mins = $mins/60;
        $int = $hrs + $mins;;
        if($int > 4){
          $int = $int - 1;
        }
        $time = date("Y m d_H i s");
        $filename =  'AUB_'. $time.'.jpg';
        $filepath = 'cam/';        
        $sql3 = "INSERT INTO emp_attendance (employee_id, employee_name, attendance_date, attendance_timein, attendance_timeout, attendance_hour, timein_cam)
                                     VALUES ('$id', '$full', '$date', '$in', '$out', '$int', '$filename')";
        $result3 = mysqli_query($db, $sql3);
        echo $filepath.$filename;
        $_SESSION['mess'] = "<center><div id='time' class='alert alert-success' role='alert'>
                              <i class='fas fa-check'></i>  Time in: $full </center></div>";
        header("Location: AUB.php");

      }
      else {
        $_SESSION['mess'] = "<div id='time' class='alert alert-warning' role='alert'>
                                <i class='fas fa-exclamation'></i>  You already have Timed In
                                </div>";
        header("Location: AUB.php");

      }
    }
  }
  if($code == "time-out")
  {
    $id = $_POST['emp_id'];

    $sql = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
    $result = mysqli_query($db, $sql);
    if(!$row = $result->fetch_assoc()) {
      $_SESSION['mess'] = "<div id='time' class='alert alert-danger' role='alert'>
                              <i class='fas fa-times'></i> You did not Timed in !
                              </div>";
      header("Location: AUB.php");

    }
    else {
      $query = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
      $queryres = mysqli_query($db, $query);
      while($rowres = mysqli_fetch_array($queryres))
      {
        $timein = $row['attendance_timein'];
      }
      $first = new DateTime($timein);
      $second = new DateTime($in);
      $interval = $first->diff($second);
      $hrs = $interval->format('%h');
      $mins = $interval->format('%i');
      $mins = $mins/60;
      $int = $hrs + $mins;
      if($int > 4){
        $int = $int - 1;}
      $time = date("Y m d_H i s");
      $filename =  'AUB_'. $time.'.jpg';
      $filepath = 'cam/'; 
      $sql2 = "UPDATE emp_attendance SET attendance_timeout = '$in', attendance_hour = '$int', timeout_cam = '$filename' WHERE employee_id = '$id' AND attendance_date = '$date' ";
      $result2 = mysqli_query($db, $sql2);
      echo $filepath.$filename; 
      $_SESSION['mess'] = "<center> <div id='time' class='alert alert-success' role='alert'>
                            <i class='fas fa-check'></i>  Timed Out </center></div>";
      header("Location: AUB.php");

      }
    
  }
  if($code == "morn-in")
  {
    $id = $_POST['emp_id'];

    $sql = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date' AND mor_in is null";
    $result = mysqli_query($db, $sql);
    if(!$row = $result->fetch_assoc()) {
      $_SESSION['mess'] = "<center><div id='time' class='alert alert-danger' role='alert'>
                              <i class='fas fa-times'></i> You already have Break In! </center>
                              </div>";
      header("Location: AUB.php");

    }
    else {
      $query = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
      $queryres = mysqli_query($db, $query);
      while($rowres = mysqli_fetch_array($queryres))
      {
        $timein = $row['attendance_timein'];
      }
      $first = new DateTime($timein);
      $second = new DateTime($in);
      $interval = $first->diff($second);
      $hrs = $interval->format('%h');
      $mins = $interval->format('%i');
      $mins = $mins/60;
      $int = $hrs + $mins;
      if($int > 4){
        $int = $int - 1;
      }
      $time = date("Y m d_H i s");
      $filename =  'AUB_'. $time.'.jpg';
      $filepath = 'cam/'; 
      $sql2 = "UPDATE emp_attendance SET mor_in = '$in', attendance_hour = '$int', morin_cam = '$filename' WHERE employee_id = '$id' AND attendance_date = '$date' AND mor_in is null";
      $result2 = mysqli_query($db, $sql2);
      echo $filepath.$filename;
      $_SESSION['mess'] = "<center> <div id='time' class='alert alert-success' role='alert'>
                            <i class='fas fa-check'></i> MORNING COFFEE BREAK IN</center></div>";
      header("Location: AUB.php");

     }
    
  }
  if($code == "morn-out")
  {
    $id = $_POST['emp_id'];

    $sql = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'AND mor_out is null";
    $result = mysqli_query($db, $sql);
    if(!$row = $result->fetch_assoc()) {
      $_SESSION['mess'] = "<center><div id='time' class='alert alert-danger' role='alert'>
                              <i class='fas fa-times'></i>  You already have Break Out! </center>
                              </div>";
      header("Location: AUB.php");

    }
    else {
      $query = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
      $queryres = mysqli_query($db, $query);
      while($rowres = mysqli_fetch_array($queryres))
      {
        $timein = $row['attendance_timein'];
      }
      $first = new DateTime($timein);
      $second = new DateTime($in);
      $interval = $first->diff($second);
      $hrs = $interval->format('%h');
      $mins = $interval->format('%i');
      $mins = $mins/60;
      $int = $hrs + $mins;
      if($int > 4){
        $int = $int - 1;
      }
      $time = date("Y m d_H i s");
      $filename =  'AUB_'. $time.'.jpg';
      $filepath = 'cam/';
      $sql2 = "UPDATE emp_attendance SET mor_out = '$in', attendance_hour = '$int', morout_cam = '$filename' WHERE employee_id = '$id' AND attendance_date = '$date'";
      $result2 = mysqli_query($db, $sql2);
      echo $filepath.$filename;
      $_SESSION['mess'] = "<center> <div id='time' class='alert alert-success' role='alert'>
                            <i class='fas fa-check'></i> MORNING COFFEE BREAK OUT</center></div>";
      header("Location: AUB.php");

    }
  }
  if($code == "lunch-in")
  {
    $id = $_POST['emp_id'];

    $sql = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date' AND lunch_in is null";
    $result = mysqli_query($db, $sql);
    if(!$row = $result->fetch_assoc()) {
      $_SESSION['mess'] = "<center><div id='time' class='alert alert-danger' role='alert'>
                              <i class='fas fa-times'></i>  You already have Break In! </center>
                              </div>";
      header("Location: AUB.php");

    }
    else {
      $query = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
      $queryres = mysqli_query($db, $query);
      while($rowres = mysqli_fetch_array($queryres))
      {
        $timein = $row['attendance_timein'];
      }
      $first = new DateTime($timein);
      $second = new DateTime($in);
      $interval = $first->diff($second);
      $hrs = $interval->format('%h');
      $mins = $interval->format('%i');
      $mins = $mins/60;
      $int = $hrs + $mins;
      if($int > 4){
        $int = $int - 1;
      }
      $time = date("Y m d_H i s");
      $filename =  'AUB_'. $time.'.jpg';
      $filepath = 'cam/';
      $sql2 = "UPDATE emp_attendance SET lunch_in = '$in', attendance_hour = '$int', lunchin_cam = '$filename' WHERE employee_id = '$id' AND attendance_date = '$date'";
      $result2 = mysqli_query($db, $sql2);
      echo $filepath.$filename;
      $_SESSION['mess'] = "<center> <div id='time' class='alert alert-success' role='alert'>
                            <i class='fas fa-check'></i> LUNCH BREAK IN</center></div>";
      header("Location: AUB.php");

    }
  }
   if($code == "lunch-out")
  {
    $id = $_POST['emp_id'];

    $sql = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date' and lunch_out is null";
    $result = mysqli_query($db, $sql);
    if(!$row = $result->fetch_assoc()) {
      $_SESSION['mess'] = "<center><div id='time' class='alert alert-danger' role='alert'>
                              <i class='fas fa-times'></i>  You already have Break Out! </center>
                              </div>";
      header("Location: AUB.php");

    }
    else {
      $query = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
      $queryres = mysqli_query($db, $query);
      while($rowres = mysqli_fetch_array($queryres))
      {
        $timein = $row['attendance_timein'];
      }
      $first = new DateTime($timein);
      $second = new DateTime($in);
      $interval = $first->diff($second);
      $hrs = $interval->format('%h');
      $mins = $interval->format('%i');
      $mins = $mins/60;
      $int = $hrs + $mins;
      if($int > 4){
        $int = $int - 1;
      }
      $time = date("Y m d_H i s");
      $filename =  'AUB_'. $time.'.jpg';
      $filepath = 'cam/';
      $sql2 = "UPDATE emp_attendance SET lunch_out = '$in', attendance_hour = '$int', lunchout_cam = '$filename' WHERE employee_id = '$id' AND attendance_date = '$date'";
      $result2 = mysqli_query($db, $sql2);
      echo $filepath.$filename;
      $_SESSION['mess'] = "<center> <div id='time' class='alert alert-success' role='alert'>
                            <i class='fas fa-check'></i> LUNCH BREAK OUT</center></div>";
      header("Location: AUB.php");

    }
  }
   if($code == "aft-in")
  {
    $id = $_POST['emp_id'];

    $sql = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date' AND coff_in is null";
    $result = mysqli_query($db, $sql);
    if(!$row = $result->fetch_assoc()) {
      $_SESSION['mess'] = "<center><div id='time' class='alert alert-danger' role='alert'>
                              <i class='fas fa-times'></i>  You already have Timed in ! </center>
                              </div>";
      header("Location: AUB.php");

    }
    else {
      $query = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
      $queryres = mysqli_query($db, $query);
      while($rowres = mysqli_fetch_array($queryres))
      {
        $timein = $row['attendance_timein'];
      }
      $first = new DateTime($timein);
      $second = new DateTime($in);
      $interval = $first->diff($second);
      $hrs = $interval->format('%h');
      $mins = $interval->format('%i');
      $mins = $mins/60;
      $int = $hrs + $mins;
      if($int > 4){
        $int = $int - 1;
      }
      $time = date("Y m d_H i s");
      $filename =  'AUB_'. $time.'.jpg';
      $filepath = 'cam/';
      $sql2 = "UPDATE emp_attendance SET coff_in = '$in', attendance_hour = '$int', coffin_cam = '$filename' WHERE employee_id = '$id' AND attendance_date = '$date'";
      echo $filepath.$filename;
      $result2 = mysqli_query($db, $sql2);
      $_SESSION['mess'] = "<center> <div id='time' class='alert alert-success' role='alert'>
                            <i class='fas fa-check'></i> AFTERNOON COFFEE BREAK IN</center></div>";
      header("Location: AUB.php");

    }
  }
   if($code == "aft-out")
  {
    $id = $_POST['emp_id'];

    $sql = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date' AND coff_out is null";
    $result = mysqli_query($db, $sql);
    if(!$row = $result->fetch_assoc()) {
      $_SESSION['mess'] = "<center><div id='time' class='alert alert-danger' role='alert'>
                              <i class='fas fa-times'></i>  You already have Break Out! </center>
                              </div>";
      header("Location: AUB.php");

    }
    else {
      $query = "SELECT * FROM emp_attendance WHERE employee_id = '$id' AND attendance_date = '$date'";
      $queryres = mysqli_query($db, $query);
      while($rowres = mysqli_fetch_array($queryres))
      {
        $timein = $row['attendance_timein'];
      }
      $first = new DateTime($timein);
      $second = new DateTime($in);
      $interval = $first->diff($second);
      $hrs = $interval->format('%h');
      $mins = $interval->format('%i');
      $mins = $mins/60;
      $int = $hrs + $mins;
      if($int > 4){
        $int = $int - 1;
      }
      $time = date("Y m d_H i s");
      $filename =  'AUB_'. $time.'.jpg';
      $filepath = 'cam/';
      $sql2 = "UPDATE emp_attendance SET coff_out = '$in', attendance_hour = '$int', coffout_cam = '$filename' WHERE employee_id = '$id' AND attendance_date = '$date'";
      $result2 = mysqli_query($db, $sql2);
      echo $filepath.$filename;
      $_SESSION['mess'] = "<center> <div id='time' class='alert alert-success' role='alert'>
                            <i class='fas fa-check'></i> AFTERNOON COFFEE BREAK OUT</center></div>";
      header("Location: AUB.php");

    }
  }
}
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="X-UA-Compatible" content="chrome=1">
  <title>Attendance and Payroll System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="admin/dist/js/1.js"></script>
  <script src="admin/dist/js/2.js"></script>
  <script src="admin/dist/js/3.js"></script>
  <style type="text/css">
  .mt20{
    margin-top:20px;
  }
  .result{
    font-size:20px;
  }
  .bold{
    font-weight: bold;
  }
  #my_camera{
    width: 320px;
    height: 250px;
    transform: scaleX(-1);
    margin-bottom: 10px;
  }
img{
  width: 200px;
  height: 250px;
  padding-top: 50px;
}
.card
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo" style="padding-top: 100px">
    <img src="img/logo.gif" style="width: 250px">
  </div>
  <!-- /.login-logo -->

  <div class="card">
    <div class="card-body login-card-body">
      <!-- <?php echo $out1[0]; ?> -->
      <p class="login-box-msg">Enter Employee ID</p>


      <form method="POST">

        <div class="input-group mb-3">
          <select name="operation" class="form-control">
            <option value="time-in">1. Time In</option>            
            <option value="morn-in">2. Start Morning Break </option>
            <option value="morn-out">3. End Morning Break </option>
            <option value="lunch-in">4. Start Lunch Break</option>
            <option value="lunch-out">5. End Lunch Break</option>
            <option value="aft-in">6. Start Afternoon Coffee Break</option>
            <option value="aft-out">7. End Afternoon Coffee Break</option>
            <option value="time-out">8. Time Out</option>
          </select>
        </div>

        <div class="input-group mb-3">
          <input type="text" name="emp_id" class="form-control" placeholder="Employee ID">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-id-card"></span>
            </div>
          </div>
        </div>
        
        <div id="my_camera" mx-auto></div>
        <input type="submit" name="attendance" value="Take Snapshot" onClick="take_snapshot()" hidden></button>
        <!-- <center><input type=button value="Take Snapshot" onClick="take_snapshot()"></center> -->
        
      </form>
        
    </div>

    <?php
    echo $_SESSION['mess'];
    echo $_SESSION['success'];

    $dd = date("H:i:s");

    if($dd == $_SESSION['expire'])
    {
      session_unset();
    }
    ?>

  </div>
</div>
<div class="time" style="font-size: 20px; text-align: center; font-weight: bold; margin-bottom: 100px;d">
<p id="date"><?php echo $today; ?></p>
<div id="clock"></div>
<br><br>
</div>

  <script>
        function updateClock() {
            var clockElement = document.getElementById("clock");
            var now = new Date();
            var hours = now.getHours() % 12 || 12; // Convert to 12-hour format
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            var meridiem = now.getHours() >= 12 ? 'PM' : 'AM';

            clockElement.textContent = hours + ":" + minutes + ":" + seconds + " " + meridiem;
        }

        setInterval(updateClock, 1000); // Update every second
        updateClock(); // Initial update
    </script>

<!-- SCRIPT WEBCAM -->
<!-- <div id="results" ></div> -->
 
<!-- Script -->
<script type="text/javascript" src="webcam.min.js"></script>

<!-- Code to handle taking the snapshot and displaying it locally -->
<script language="JavaScript">

 // Configure a few settings and attach camera
 Webcam.set({
  image_format: 'jpeg',
  jpeg_quality: 90,
  margin: 0
 });
 Webcam.attach( '#my_camera' );

 // preload shutter audio clip
 var shutter = new Audio();
 shutter.autoplay = true;
 shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';

function take_snapshot() {
 // play sound effect
 shutter.play();
 
 // take snapshot and get image data
 Webcam.snap( function(data_uri) {
 
  Webcam.upload( data_uri, 'saveAUB.php', function(code, text,Name) {
                    document.getElementById('results').innerHTML = 
                    '' + 


 // display results in page
 //document.getElementById('results').innerHTML = 
 '<img src="'+data_uri+'"/>';
    
  
    
  
 } ); 
  
  
 } );
}

</script>
<!-- END OF SCRIPT WEBCAM  -->
<script src="admin/plugins/jquery/jquery.min.js"></script>
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="admin/dist/js/adminlte.min.js"></script>
<script src="admin/plugins/moment/moment.min.js"></script>
<script src="admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="admin/plugins/toastr/toastr.min.js"></script>


<script type="text/javascript">
var interval = setInterval(function() {
   var momentNow = moment();
   $('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));
   // $('#time').html(momentNow.format('hh:mm:ss A'));
 }, 100);
</script>


</body>
</html>
