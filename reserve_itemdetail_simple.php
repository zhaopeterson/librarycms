<?php
session_start();
require_once('includes/connection.inc.php');
$_SESSION['member']="admin"; //this value should be passed on from session 
if($_SESSION['member'] == 'admin' && (isset($_GET['reserve_id']))){
	$member_id=$_SESSION['member'];
	$reserve_id=$_GET['reserve_id'];
	echo $reserve_id." is the reserve id";
$sql="SELECT reserve_id, book_id, quantity, due_date
FROM reserves_content
WHERE  reserve_id=$reserve_id";
$result=mysqli_query($conn, $sql);
//$row=$result->fetch_assoc();
} else {
	echo '<p align="center">You need to login to see your reserve list!';
	echo '<a href="login.php">Login</a>';
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Library -- My researve history</title>
<link href="css_styles/book_forms.css" rel="stylesheet" type="text/css" />
<script src="javascripts/striptable.js" type="text/javascript"></script>
</head>

<body>

<div id="content">
<h2>My Reserve History</h2>
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <th scope="col">Reserve Number</th>
     <th scope="col">Reserve Date</th>
     <th scope="col">Member ID</th>
    <th scope="col">Book Title</th>
    <th scope="col">Due Date</th>
  </tr>

  <?php 

  while($row = $result->fetch_assoc()){
	  ?>
  <tr>
    <td><?php echo $row['reserve_id']; ?></td>
    <td><?php echo $row['book_id']; ?></td>  
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['due_date']; ?></td>
  </tr>

<?php
} ?>
</table>
</div>
</body>
</html>