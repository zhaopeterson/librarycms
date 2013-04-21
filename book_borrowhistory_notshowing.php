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
	$row=$result->fetch_assoc();
	//echo $book_id."<br/>";
	
	//echo "You have succesfully get to the book borrow history page";

		echo '<table align="center">
		<tr>
	<td>'. $row['book_id'].'</td><td>'.$row['member_id'].'</td><td>'.$row['reserve_date'].'</td><td>'.$row['due_date'].'</td><td>'.$row['inventory_current'].'</td>	
	</tr>
	</table>';

	if (empty($row)){
		$message="No one had borrowed this book yet";
	}

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
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col">Book ID</th>
    <th scope="col">Member ID</th>
    <th scope="col">Reserve Date</th>
    <th scope="col">Due Date</th>
    <th scope="col">Numbers Available</th>
  </tr>
<h2>Book Borrow History</h2>
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