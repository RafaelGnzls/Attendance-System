<?php
//set random name for the image, used time() for uniquenes

date_default_timezone_set('Asia/Manila');
$filename =  date("Y m d_H i s").'.jpg';
$filepath = 'cam/';
if(!is_dir($filepath))
	mkdir($filepath);
if(isset($_FILES['webcam'])){	
	move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);
	echo $filepath.$filename;
}
?>
 