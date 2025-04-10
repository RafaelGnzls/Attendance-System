<?php
//set random name for the image, used time() for uniquenes
// include 'index.php'; 

// $qry = "SELECT concat('00-',LPAD(AUTO_INCREMENT, 3, 0)) FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'attpay' AND TABLE_NAME = 'emp_attendance'";
// $res = mysqli_query($db,$qry);
// $out1 = mysqli_fetch_array($res);

date_default_timezone_set('Asia/Manila');
$time = date("Y m d_H i s");
$filename =  'CLTS_'. $time.'.jpg';
$filepath = 'cam/';
if(!is_dir($filepath))
	mkdir($filepath);
if(isset($_FILES['webcam'])){	
	move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);
	echo $filepath.$filename;
}
?>
 