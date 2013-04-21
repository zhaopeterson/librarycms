<?php
session_start();
require_once('includes/connection.inc.php');
$_SESSION['member']="1"; //this value should be passed on from session 
if($_SESSION['member'] == '1'){
	$member_id=$_SESSION['member'];
$sql="SELECT reserves.reserve_id, book_title, reserve_date, due_date
FROM reserves, reserves_content, books
WHERE books.book_id = reserves_content.book_id
AND reserves_content.reserve_id = reserves.reserve_id AND member_id=$member_id";
$result=mysqli_query($conn, $sql);
$row=$result->fetch_assoc();
} else {
	echo '<p align="center">You need to login to see your reserve history!';
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
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col">Reserve Number</th>
    <th scope="col">Book Title</th>
    <th scope="col">Reserve Date</th>
    <th scope="col">Due Date</th>
  </tr>
<h2>My Researve History</h2>
  <?php while($row = $result->fetch_assoc()){
	  ?>
  <tr>
    <td><?php echo $row['reserve_id']; ?></td>
    <td><?php echo $row['book_title']; ?></td>
    <td><?php echo $row['reserve_date']; ?></td>
    <td><?php echo $row['due_date']; ?></td>
  </tr>

<?php
} ?>
</table>
</div>
</body>
</html>