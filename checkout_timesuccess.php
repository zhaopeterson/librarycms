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
	
	//prepare query to insert to the reserves_content table
	$stmt=$conn->stmt_init();
	$sql_rc="INSERT INTO reserves_content(reserve_id, book_id, quantity, due_date) VALUES (?,?,?,?)";
	$stmt->prepare($sql_rc);
	$stmt->bind_param('iiis', $reserve_id, $book_id, $qty, $due_date);
	//excecute each query, count the total affected
	$affected=0;
	echo '<p align="center">Here are a list of books you reserved and their due dates, please make sure to return them on time to avoid fines!</p>';
	echo '<table align="center" border="1" cellspacing="3" cellpadding="3">
	<tr>
	<th>Book Name</th><th>Number of Books</th><th>Due Date</th>
	</tr>
	';
	foreach($_SESSION['cart'] as $book_id => $item){
	$qty=$item['quantity'];
	//this value needs to be trieve from books table and do match on reservation time and due length right now I just assign a string
	$sql_rd="SELECT reserve_date FROM reserves WHERE reserve_id=$reserve_id";
	$result_rd=mysqli_query($conn, $sql_rd);
	$row_rd=$result_rd->fetch_assoc();
	$reserve_date=$row_rd['reserve_date'];

	//get the due length from the books table
	$sql_b="SELECT book_title, book_inventory, due_length FROM books WHERE book_id=$book_id";
	$result_b=mysqli_query($conn, $sql_b);
	$row_b=$result_b->fetch_assoc();
	$due_length=$row_b['due_length'];

	$due_dateT=time($reserve_date)+(int)($due_length*60*60*24);//$due_dateT is due date in time() format
	$due_date=date("Y-m-d h:i:s", $due_dateT); //convert the $due_dateT to "Y-m-d h:i:s" format and insert


	//update books table about the inventory
	if($qty<=$row_b['book_inventory']){
	$inventory_ini=$row_b['book_inventory'];
	$new_bookinventory=$row_b['book_inventory']-$qty;
	$sql="UPDATE books SET book_inventory=$new_bookinventory WHERE books.book_id=$book_id";
		$result=mysqli_query($conn, $sql);
		//echo out the list of the books on the reservation list	
	echo '<tr>
	<td>'.$row_b['book_title'].'</td><td>'.$qty.'</td><td>'.$due_date.'</td>
	</tr>
	';
	} else{
		echo "There is not enough books in the system for your to reserve.";
		exit();
	}
	
	$affected2=0;
	echo "book_id is:".$book_id."<br/>";
	echo "member_id is:".$member."<br/>";
	echo "quantity: ".$qty."<br/>";
	echo $reserve_date."<br/>"; 
	echo $due_date."<br/>";
	echo "Initial Inventory: ".$inventory_ini."<br/>";
	echo "Current inventory: ".$new_bookinventory."<br/>";
		//prepare to insert to book history table
		$stmt2=$conn->stmt_init();
		//$sql_bh="INSERT INTO book_history (book_id, member_id, member_quantity, reserve_date, due_date, inventory_initial, inventory_current) VALUES ($book_id,$member,$qty,$reserve_date,$due_date,'5','5')";
		$sql_bh="INSERT INTO book_history2(book_id, member_id, member_quantity, reserve_date, due_date) VALUES (?,?,?,?,?)";
		//$result_bh=mysqli_query($conn, $sql_bh);
		
		$stmt2->prepare($sql_bh);
		$stmt2->bind_param('iiiss', $book_id, $member, $qty, $reserve_date, $due_date);
		mysqli_stmt_execute($stmt2);
	$affected2 +=mysqli_stmt_affected_rows($stmt2);
	if($affected2){
		echo "Book history table successfully inserted!";
	} else{
		echo "Can not insert to the book history table!";
	}
	
	
	
	mysqli_stmt_execute($stmt);
	
	$affected +=mysqli_stmt_affected_rows($stmt);
	}//end of foreach
	echo '</table>';
	//close the prepare statement
	mysqli_stmt_close($stmt);
	
	//report on the success
	if($affected ==count($_SESSION['cart'])){
		//commit the transaction
		mysqli_commit($conn);
		
		
		
		
		//clear cart
		unset($_SESSION['cart']);
		//message to the customer;
		echo '<p align="center">Thank you for your reservation. You can pick up the books during our regular office hours shortly.</p>';
		
		
		
		
		
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
