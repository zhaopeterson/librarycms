<?php
require_once('includes/connection.inc.php');
// create database connection
//$conn = dbConnect('read');
$sql = 'SELECT book_id, book_isbn, CONCAT(author_lastname, ", ", author_firstname) AS author, genre_name, book_title, book_inventory  FROM books, authors, genres WHERE books.author_id=authors.author_id and books.genre_id=genres.genre_id';
$result = $conn->query($sql) or die(mysqli_error());

if ($_POST['sort'] && $_POST['sort_term'] == 'book_isbn') {
	$book_isbn=$_POST['sort_term'];
	//echo "book_isbn";
	$sql_isbn = 'SELECT book_id, book_isbn, CONCAT(author_lastname, ", ", author_firstname) AS author, genre_name, book_title, book_inventory  FROM books, authors, genres WHERE books.author_id=authors.author_id and books.genre_id=genres.genre_id ORDER BY book_isbn ASC';
	$result_isbn = $conn->query($sql_isbn) or die(mysqli_error());
} 

if ($_POST['sort'] && $_POST['sort_term'] == 'genre_name') {
	$genre_name=$_POST['sort_term'];
	//echo "genre_name";
	$sql_genre = 'SELECT book_id, book_isbn, CONCAT(author_lastname, ", ", author_firstname) AS author, genre_name, book_title, book_inventory  FROM books, authors, genres WHERE books.author_id=authors.author_id and books.genre_id=genres.genre_id ORDER BY genre_name';
	$result_genre = $conn->query($sql_genre) or die(mysqli_error());
} 

if ($_POST['sort'] && $_POST['sort_term'] == 'author_name') {
	$author_author=$_POST['sort_term'];
	//echo "genre_name";
	$sql_author = 'SELECT book_id, book_isbn, CONCAT(author_lastname, ", ", author_firstname) AS author, genre_name, book_title, book_inventory  FROM books, authors, genres WHERE books.author_id=authors.author_id and books.genre_id=genres.genre_id ORDER BY author ASC';
	$result_author = $conn->query($sql_author) or die(mysqli_error());
} 
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
  <p>&#160;</p>
  <form action="" method="post" name="sortform" id="sortform">
    <select name="sort_term" id="sort_term">
      <option>Sorting By</option>
      <option value="book_isbn" <?php if ($_POST && $_POST['sort_term'] == 'book_isbn') {
					  echo 'selected';
					} ?>
                    >ISBN</option>
      <option value="genre_name" <?php if ($_POST && $_POST['sort_term'] == 'genre_name') {
					  echo 'selected';
					} ?>
                    >Categories</option>
      <option value="author_name" <?php if ($_POST && $_POST['sort_term'] == 'author_name') {
					  echo 'selected';
					} ?>
                    >Authors</option>
    </select>
    <input type="submit" value="&#160; Sort &#160;" name="sort" id="sort" >
  </form>
  <table width="960" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th scope="col">ISBN number</th>
        <th scope="col">Author</th>
        <th scope="col">Category</th>
        <th scope="col">Book Title</th>
        <th scope="col">Inventory</th>
      </tr>
    </thead>
    <!--sorting by isbn number-->
    <?php if ($_POST['sort'] && $_POST['sort_term'] == 'book_isbn') {
  while($row = $result_isbn->fetch_assoc()) { ?>
    <tr>
      <td><?php echo $row['book_isbn']; ?></td>
      <td><?php echo $row['author']; ?></td>
      <td><?php echo $row['genre_name']; ?></td>
      <td><?php echo '<a href="book_detail.php?book_id='.$row['book_id'].'">'.$row['book_title'].'</a>';  ?></td>
      <td><?php echo $row['book_inventory']; ?></td>
    </tr>
    <?php } 
  }
  if ($_POST['sort'] && $_POST['sort_term'] == 'book_isbn'){
  exit();
  }
  ?>
    <!--sorting by genre-->
    <?php if ($_POST['sort'] && $_POST['sort_term'] == 'genre_name') {
  while($row = $result_genre->fetch_assoc()) { ?>
    <tr>
      <td><?php echo $row['book_isbn']; ?></td>
      <td><?php echo $row['author']; ?></td>
      <td><?php echo $row['genre_name']; ?></td>
      <td><?php echo '<a href="book_detail.php?book_id='.$row['book_id'].'">'.$row['book_title'].'</a>';  ?></td>
      <td><?php echo $row['book_inventory']; ?></td>
    </tr>
    <?php } 
  }
  if ($_POST['sort'] && $_POST['sort_term'] == 'genre_name'){
  exit();
  }
  ?>
    <!-- sort by authors-->
    <?php if ($_POST['sort'] && $_POST['sort_term'] == 'author_name') {
  while($row = $result_author->fetch_assoc()) { ?>
    <tr>
      <td><?php echo $row['book_isbn']; ?></td>
      <td><?php echo $row['author']; ?></td>
      <td><?php echo $row['genre_name']; ?></td>
      <td><?php echo '<a href="book_detail.php?book_id='.$row['book_id'].'">'.$row['book_title'].'</a>';  ?></td>
      <td><?php echo $row['book_inventory']; ?></td>
    </tr>
    <?php } 
  }
  if ($_POST['sort'] && $_POST['sort_term'] == 'author_name'){
  exit();
  }
  ?>
    <!--default listing by book_id-->
    <?php 
 
   while($row = $result->fetch_assoc()) {
   
 ?>
    <tr >
      <td><?php echo $row['book_isbn']; ?></td>
      <td><?php echo $row['author']; ?></td>
      <td><?php echo $row['genre_name']; ?></td>
      <td><?php echo '<a href="book_detail.php?book_id='.$row['book_id'].'">'.$row['book_title'].'</a>';  ?></td>
      <td><?php echo $row['book_inventory']; ?></td>
    </tr>
    <?php 
 

   }?>
  </table>
</div>
</body>
</html>