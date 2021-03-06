<?php
session_start();
require_once('includes/connection.inc.php');
$_SESSION['member']="admin"; //this value should be passed on from session 
if($_SESSION['member'] == 'admin'){
	$member_id=$_SESSION['member'];
$sql="SELECT reserves.reserve_id, member_id, COUNT(*) AS book_quantity, book_title, reserve_date, due_date
FROM reserves INNER JOIN reserves_content INNER JOIN books
WHERE books.book_id = reserves_content.book_id
AND reserves_content.reserve_id = reserves.reserve_id GROUP BY reserve_id";
$result=mysqli_query($conn, $sql);
$row=$result->fetch_assoc();
} else {
	echo '<p align="center">You need to login to see your reserve list!';
	echo '<a href="login.php">Login</a>';
}
$reserve_number=$row['reserve_id'];
$book_title=$row['book_title'];
$reserve_date=$row['reserve_date'];
$due_date=$row['due_date'];
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
<h2>Library Reserve List</h2>
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col">Reserve Date</th>
    <th scope="col">Reserve Number</th>
     <th scope="col">Member ID</th>
    <th scope="col">Number of Books on Ressearve</th>
    
    <th scope="col">Due Date</th>
  </tr>

  <?php 

  while($row = $result->fetch_assoc()){
	  ?>
  <tr>
  
    <td><?php echo $row['reserve_date']; ?></td>
    <td><?php echo '<a href="reserve_itemdetail.php?reserve_id='.$row['reserve_id'].'">'.$row['reserve_id'].'</a>'; ?></td>
     <td><?php echo $row['member_id']; ?></td>
        <td><?php echo $row['book_quantity']; ?></td>
   
    <td><?php echo $row['due_date']; ?></td>
  </tr>

<?php
} ?>
</table>
</div>
</body>
</html>