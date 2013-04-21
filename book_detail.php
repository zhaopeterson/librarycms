<?php
//make database connection
require_once('includes/connection.inc.php');

if (isset($_GET['book_id']) && is_numeric($_GET['book_id'])) {
  $book_id = (int) $_GET['book_id'];
} else {
  $book_id = 0;
}
//echo $book_id;
$sql = "SELECT book_id, book_isbn, CONCAT(author_lastname, ', ', author_firstname) AS author, genre_name, book_title, book_description, book_format, book_binding, publish_date, book_inventory, due_length  FROM books INNER JOIN authors USING (author_id) INNER JOIN genres USING (genre_id) WHERE book_id=$book_id";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Book Form</title>
<link href="css_styles/book_forms.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="content">
<h2>Book Detail Page</h2>
<p>&raquo; <a href="booklist_sort.php">Back to the booklist page</a></p>
<h3><?php if($row){
	echo $row['book_title'];
} else{
	echo 'There is a system error. No record found';
}
?>
</h3>
<p><?php if($row) {
	echo "<p ><span class='caption_style'>ISBN: </span>".$row['book_isbn']."</p>"; 
	echo "<p ><span class='caption_style'>Category: </span>".$row['genre_name']."</p>"; 
	echo "<p><span  class='caption_style'>Author: </span>".$row['author']."</p>";
	echo "<p ><span class='caption_style'>Description: </span>".$row['book_description']."</p>"; 
    echo "<p ><span class='caption_style'>Format: </span>".$row['book_format']."</p>"; 
	echo "<p ><span class='caption_style'>Binding: </span>".$row['book_binding']."</p>"; 
	echo "<p ><span class='caption_style'>Inventory: </span>".$row['book_inventory']."</p>"; 
    echo "<p ><span class='caption_style'>Publish Date: </span>".$row['publish_date']."</p>"; 
	echo "<p ><span class='caption_style'>Due Length: </span>".$row['due_length']." days.</p>"; 

} 
echo "<a href=\"reserve_book.php?book_id=$book_id\">Reserve Book</a>";


?></p>




</div><!--end of content div-->
</body>
</html>