<?php
session_start();
$_SESSION['member']="admin";
require_once('includes/connection.inc.php');
if(isset($_GET['book_id'])&&$_SESSION['member']=="admin"){
	$book_id=$_GET['book_id'];
	//echo $book_id;
	$sql="SELECT book_id,  member_id, reserve_date, due_date, inventory_current FROM  book_history WHERE book_id=$book_id";
	//$sql="SELECT book_id, book_title FROM books WHERE book_id=$book_id";
	$result=mysqli_query($conn, $sql);
	

} else{
	echo "You have reached this page by error";
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Library -- My Reserve history</title>
<link href="css_styles/book_forms.css" rel="stylesheet" type="text/css" />
<script src="javascripts/striptable.js" type="text/javascript"></script>
</head>

<body>

<div id="content">
<h2>Book Borrow History</h2>
<small>If no results showed below, means no borrow history</small>
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col">Book ID</th>
    <th scope="col">Member ID</th>
    <th scope="col">Reserve Date</th>
    <th scope="col">Due Date</th>
    <th scope="col">Numbers Available</th>
  </tr>

<?php 

  while($row = $result->fetch_assoc()) { ?>
  <tr>
    <td><?php echo $row['book_id']; ?></td>
    <td><?php echo $row['member_id']; ?></td>
    <td><?php echo $row['reserve_date']; ?></td>
    <td><?php echo $row['due_date']; ?></td>
    <td><?php echo $row['inventory_current']; ?></td>
  </tr>
<?php
  } 
  
  ?>
</table>
</div>
</body>
</html>