<?php
session_start();
require_once('includes/connection.inc.php');
if(isset($_GET['book_id'])&&is_numeric($_GET['book_id'])){ //check for a book_id
$book_id=(int)$_GET['book_id'];
//check to see if the cart already has this book reserved
//if so increment the quantity
if(isset($_SESSION['cart'][$book_id])){
	$_SESSION['cart'][$book_id]['quantity']++;//add another

//display a message
echo '<p align="center">Another copy of this book has been added to your reservation cart.</p>';
echo "<p align='center'><a href='booklist_sort.php'>Reserve More Books</a></p>";
		echo "<p align='center'><a href='view_reserve_book.php'>View Reservation</a></p>";
} else {//new book to add to cart
	//Get the book_inventory from the database
	$sql="SELECT book_inventory FROM books WHERE books.book_id=$book_id";
	$result = $conn->query($sql);
     $row = $result->fetch_assoc();
	if(mysqli_num_rows($result) ==1){
		if ($row['book_inventory'] !=0){
		$new_bookinventoy=$row['book_inventory']-1;
		//echo $new_bookinventoy;
		$_SESSION['cart'][$book_id]=array('quantity'=>1);
		//echo var_dump($_SESSION['cart'][$book_id]);
		echo "<p align='center'>The book has been added to your reservation cart</p>";
		echo "<p align='center'><a href='booklist.php'>Reserve More Books</a></p>";
		echo "<p align='center'><a href='view_reserve_book.php'>View Reservation</a></p>";
		//$sql="UPDATE books SET book_inventory=$new_bookinventoy WHERE books.book_id=$book_id";
		//$result=mysqli_query($conn, $sql);
		}else{
		echo "<p align='center'>The book is currently unavailable, please check back in a few days when someone returns it.</p>";
	     }//end of book inventory=0 IF
	}//end of mysqli_numb_rows ==1 IF

}//end of isset session cart

} //end of $_GET['book_id'] IF
else{
	echo "<p align='center'>This page has been accessed by error!</p>";
}
?>
