<?php
//this page displays the contents of the reservation cart

//This page also let the user update of the content of the cart
session_start();
require_once('includes/connection.inc.php');

//check the form has been submitted to update the cart
if(isset($_POST['submitted'])){
	//change any quantities
	foreach($_POST['qty'] as $k => $v){
		//must be intergers
		$book_id=(int)$k;
		$qty=(int)$v;
		if($qty==0){//delete
		unset($_SESSION['cart'][$book_id]);	
		} elseif ($qty >0) {//change quantity
		$_SESSION['cart'][$book_id]['quantity']=$qty;
		
		}
		
	}//end of FOREACH
}//end of submitted IF

//display the cart if it is not empty....
if(!empty($_SESSION['cart'])){
	
	$sql="SELECT book_id, CONCAT_WS(' ', author_firstname, author_middlename, author_lastname) AS Book_Author, book_title, due_length FROM authors, books WHERE books.author_id= authors.author_id AND books.book_id IN (";
																																																			foreach ($_SESSION['cart'] as $book_id => $value){
	$sql .= $book_id.',';																																																	}
	$sql=substr($sql, 0, -1). ') ORDER BY authors.author_lastname ASC';
	$result=mysqli_query($conn, $sql);
	//create a form and a table
	echo '<form action="view_reserve_book.php" method="post">
	<table border="1" width="60%" cellspacing="3" cellpadding="3" align="center">
	<tr>
	<td align="left" width="30%"><b>Author</b></td>
	<td align="left" width="30"><b>Book Name</b></td>
	<td align="center" width="20%"><b>Qty</b></td>
	<td align="center" width="20%"><b>Due in Days</b></td>
	</tr>
	';
	//print each item
	
	while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
		//print each row
		echo "\t<tr>
		<td align=\"left\"> {$row['Book_Author']}</td>
		<td align=\"right\">{$row['book_title']}</td>
		<td align=\"center\"><input type=\"text\" size=\"3\" name=\"qty[{$row['book_id']}]\" value=\"{$_SESSION['cart'][$row['book_id']]['quantity']}\" /></td>
			<td align=\"right\">{$row['due_length']}</td>
		
		
		</tr>\n";
	}//end of the while loop
	mysqli_close($conn);//close the database connection
	echo '</table>
	<div align="center"><input type="submit" name="submit" value="Update My Reservation" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	</form><p align="center">Enter a quantity of 0 to remove the item<br/><br /><a href="checkout.php">Checkout</a></p>';
} else{
	echo '<p align="center">Your cart is currently empty.</p>';

	
	
	
	
	
	
}//end of not empty seetion cart

?>
