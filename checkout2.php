<?php
session_start();
require_once('includes/connection.inc.php');
//This page insert the reserve information into the table

//this page would ocme after the view_reserve-book page
//this page also needs the member_id passed through $_session['user']

//assume the page the member is looged in and that thispge has access member id through the session
$member=1; //temporarily assign the value 

//turn autocommit off
mysqli_autocommit($conn, FALSE);

//add the reserves to the reserves table
$sql="INSERT INTO reserves (member_id, reserve_date) VALUES ($member, NOW())";
$result=mysqli_query($conn, $sql);
if(mysqli_affected_rows($conn)==1){
	//need the reserve ID;
	$reserve_id=mysqli_insert_id($conn);
	
	//insert the specific reserve contents into the database
	
	//prepare query
	$stmt=$conn->stmt_init();
	$sql_rc="INSERT INTO reserves_content(reserve_id, book_id, quantity, due_date) VALUES (?,?,?,?)";
	$stmt->prepare($sql_rc);
	$stmt->bind_param('iiis', $reserve_id, $book_id, $qty, $due_date);
	//excecute each query, count the total affected
	$affected=0;
	foreach($_SESSION['cart'] as $book_id => $item){
	$qty=$item['quantity'];
	$due_date=mt; //this value needs to be trieve from books table and do math on reservation time and due length right now I just assign a string
	mysqli_stmt_execute($stmt);
	$affected +=mysqli_stmt_affected_rows($stmt);
	}//end of foreach
	//close the prepare statement
	mysqli_stmt_close($stmt);
	
	//report on the success
	if($affected ==count($_SESSION['cart'])){
		//commit the transaction
		mysqli_commit($conn);
		//clear cart
		unset($_SESSION['cart']);
		//message to the customer;
		echo '<p align="center">Thank you for your reservation. You can pick up the books udring our office hours shortly.</p>';
		//send emails or do whatever else
	} else {//rollback and report the problem
		mysqli_rollback($conn);
		
		echo '<p  align="center">Your reservation could not be processed due to a system error. check back shortly. We apologize for the inconvenience.</p>';
		//send information to the system adminstrator
	}
	
} else {//rollback and report the problem
echo '<p  align="center">Your reservation (database is not inserted) could not be processed due to a system error. check back shortly. We apologize for the inconvenience.</p>';
	
}//end of mysqli_affected_row



?>
