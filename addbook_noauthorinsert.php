<?php
 require_once("includes/connection.inc.php");
if (isset($_POST['insert'])) {
	  // create database connection

  // initialize flag
  $OK = false;
 

  // initialize prepared statement
  $stmt = $conn->stmt_init();
  // create SQL
  $sql = 'INSERT INTO books (book_isbn, genre_id, author_id, book_title, book_description, book_format, book_binding, publish_date, book_inventory, due_length)
		  VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  if ($stmt->prepare($sql)) {
	// bind parameters and execute statement
	$stmt->bind_param('siisssssii', $_POST['book_isbn'], $_POST['genre_id'], $_POST['author_id'], $_POST['book_title'], $_POST['book_description'], $_POST['book_format'], $_POST['book_binding'], $_POST['publish_date'], $_POST['book_inventory'], $_POST['due_length']);
    // execute and get number of affected rows
	$stmt->execute();
	if ($stmt->affected_rows > 0) {
	  $OK = true;
	}
  }
  // redirect if successful or display error
  if ($OK) {
	header('Location: http://localhost/libraryCMS/booklist.php');
	exit;
  } else {
	$error = $stmt->error;
  }
}
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
<h2>Add Book Form</h2>
<p>* is required fields</p>
<?php if (isset($error)) {
  echo "<p>Error: $error</p>";
} ?>
<form action="" method="post" name="addbook">

<p><span class="label_style">Add Book ISBN*:</span>
  <input name="book_isbn" id="book_isbn" type="text" /></p>
  
<p><span class="label_style">Choose a Genre*:</span>
<select name="genre_id" id="genre_id">
  <option value="">Select a Genre</option>
  <?php
 //get the list of genres
 $getGenres='SELECT genre_id, genre_name FROM genres ORDER BY genre_name';
 $genres=$conn->query($getGenres);
 while($row=$genres->fetch_assoc()){
	 ?>
  <option value="<?php echo $row['genre_id']; ?>"
     <?php
	 if ($row['genre_id']==$genre_id){
		 echo 'selected';
	 }
 ?>><?php echo $row['genre_name']; ?></option>
  <?php } ?>
</select>
</p>
<p><span class="label_style">Add the Book Title*:</span>
  <input name="book_title" id="book_title" type="text" /></p>

<p><span class="label_style">Choose an author*:
</span>
  <select name="author_id" id="author_id">
 <option value="">Select a Author</option>
 <?php
 //get the list of genres
 $getAuthors='SELECT author_id, author_firstname, author_lastname FROM authors ORDER BY author_lastname ASC';
 $authors=$conn->query($getAuthors);
 while($row=$authors->fetch_assoc()){
	 ?>
     <option value="<?php echo $row['author_id']; ?>"
     <?php
	 if ($row['author_id']==$author_id){
		 echo 'selected';
	 }
 ?>><?php echo $row['author_lastname'].", ".$row['author_firstname']; ?></option>
 <?php } ?>
 </select>
 <br />
 <small>(note: author was added via author form prior to the addbook form)</small>
</p>

<p><span class="label_style">Add Book Description:</span>
<textarea name="book_description" id="book_decription" cols="60" rows="4"></textarea>
</p>
<p><span class="label_style">Book Format:</span>
<select name="book_format" id="book_format">
  <option value="">Select a Format</option>
  <option value="printed book" <?php if ($_POST && $_POST['book_format'] == 'Printed Book') {
					  echo 'selected';
					} ?>>Printed Book</option>
  <option value="e-book" <?php if ($_POST && $_POST['book_format'] == 'e-Book') {
					  echo 'selected';
					} ?>>e-Book</option>
  <option value="audio book" <?php if ($_POST && $_POST['book_format'] == 'Audio Book') {
					  echo 'selected';
					} ?>>Audio Book</option>
  <option value="pdfs" <?php if ($_POST && $_POST['book_format'] == 'pdfs') {
					  echo 'selected';
					} ?>>pdfs</option>
</select>
</p>
<p><span class="label_style">Book Binding:</span>
<select name="book_binding" id="book_binding">
  <option value="">Select a Binding</option>
  <option value="hardcover" <?php if ($_POST && $_POST['book_binding'] == 'Hardcover') {
					  echo 'selected';
					} ?>>Hardcover</option>
  <option value="paperback" <?php if ($_POST && $_POST['book_binding'] == 'Paperback') {
					  echo 'selected';
					} ?>>Paperback</option>
  <option value="large print" <?php if ($_POST && $_POST['book_binding'] == 'Large Print') {
					  echo 'selected';
					} ?>>Large Print</option>
  <option value="board book" <?php if ($_POST && $_POST['book_binding'] == 'Board Book') {
					  echo 'selected';
					} ?>>Board Book</option>
</select>
</p>
<!-- the publish date will not be used to search, so just put in an value, no need to do drop down list for precise entering of the publishing date-->
<p><span class="label_style">Publish Date*:</span>
  <input name="publish_date" id="publish_date" type="text" />
</p>
<p><span class="label_style">Book Inventory*:</span>
<input name="book_inventory" id="book_inventory" type="text" />
</p>
<p><span class="label_style">Due Length (days)*:</span>
  <input name="due_length" id="due_length" type="text" />
</p>

<p align="center"> <input type="submit" name="insert" value="Insert New Book" id="insert"></p>

</form>

</div><!--end of content div-->
</body>
</html>