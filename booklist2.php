<?php
require_once('includes/connection.inc.php');
// create database connection
//$conn = dbConnect('read');
$sql = 'SELECT book_isbn, CONCAT(author_lastname, ", ", author_firstname) AS author, genre_name, book_title, book_inventory  FROM books, authors, genres WHERE books.author_id=authors.author_id and books.genre_id=genres.genre_id;';
$result = $conn->query($sql) or die(mysqli_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Library CMS</title>
<link href="css_styles/book_forms.css" rel="stylesheet" type="text/css" />
<script src="javascripts/striptable.js" type="text/javascript"></script>
</head>

<body>

<div id="content">
<p>You have added the book successfully, here is the list of book in our system</p>
<h2>Book Lists</h2>
<table width="960" border="0" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th scope="col">ISBN number</th>
    <th scope="col">Author</th>
    <th scope="col">Category</th>
    <th scope="col">Book Title</th>
    <th scope="col">Inventory</th> 
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  </thead>
  
   <?php 
   $count=1;
   while($row = $result->fetch_assoc()) 
   
   { 
   
   if ($count%2 !=0){
   ?>
 
   <tr class="even">
    <td><?php echo $row['book_isbn']; ?></td>
    <td><?php echo $row['author']; ?></td>
    <td><?php echo $row['genre_name']; ?></td>
    <td><?php echo $row['book_title']; ?></td>

    <td><?php echo $row['book_inventory']; ?></td>
    <td><a href="book_update.php?article_id=<?php echo $row['book_id']; ?>">EDIT</a></td>
    <td><a href="book_delete.php?article_id=<?php echo $row['book_id']; ?>">DELETE</a></td>
  </tr>
   
  <?php
    
   } else {
	    ?>
	    
	    
   <tr >
    <td><?php echo $row['book_isbn']; ?></td>
    <td><?php echo $row['author']; ?></td>
    <td><?php echo $row['genre_name']; ?></td>
    <td><?php echo $row['book_title']; ?></td>

    <td><?php echo $row['book_inventory']; ?></td>
    <td><a href="book_update.php?article_id=<?php echo $row['book_id']; ?>">EDIT</a></td>
    <td><a href="book_delete.php?article_id=<?php echo $row['book_id']; ?>">DELETE</a></td>
  </tr>
  <?php 
 
  } 
   $count++;
   }?>
</table>
</div>
</body>
</html>