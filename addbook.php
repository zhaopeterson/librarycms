<?php
 require_once("includes/connection.inc.php");
 $errors=array();
if (isset($_POST['insert'])) {
	  // create database connection

  // initialize flag
  $OK = false;
  //check the book_isbn input
  if(!empty($_POST['book_isbn'])&&strlen($_POST['book_isbn'])==13){
  $book_isbn=$_POST['book_isbn'];
  } else {
	 $errors['book_isbn']="you need to put in the isbn number and make sure it is 13 digit";
  }
  
  //check to see if the genre id is selected
  if(!empty($_POST['genre_id'])){
  $genre_id=$_POST['genre_id']; 
  }else{
	 $errors['genre_id']="You need to select a category"; 
	 //echo $errors['genre_id'];
  }
  
  
  $author_id=$_POST['author_id']; 
  
  //check the input of a book title
  if(!empty($_POST['book_title'])){
  $book_title=$_POST['book_title']; 
  }else{
	  $errors['book_title']="You must put a book title!";
  }
  $book_description=$_POST['book_description']; 
  $book_format=$_POST['book_format']; 
  $book_binding=$_POST['book_binding']; 
  //publish date
  if(!empty($_POST['publish_date'])){
  $publish_date=$_POST['publish_date']; 
  } else {
	  $errors['publish_date']="You need to put in the publish date";
  }
  //check book inventory input
  if(!empty($_POST['book_inventory'])){
  $book_inventory=$_POST['book_inventory']; 
  } else{
	  $errors['book_inventory']="You must put a number here";
	
  }
  
  //check the sue length input
  if(!empty($_POST['due_length'])){
  $due_length=intval($_POST['due_length']);
  } else{
	  $errors['due_length']="You must put down number of days here";
  }
 
// initialize prepared statement to insert to the authors table

if(empty($_POST['author_id'])&&empty($errors)){
  $stmt = $conn->stmt_init();
  // create SQL
  $sql_author = 'INSERT INTO authors(author_lastname, author_firstname, author_middlename)
		  VALUES(?, ?, ?)';
  if ($stmt->prepare($sql_author)) {
	// bind parameters and execute statement
	$stmt->bind_param('sss', $_POST['author_lastname'], $_POST['author_firstname'], $_POST['author_middlename']);
    // execute and get number of affected rows
	$stmt->execute();
	
	}
	
	//check the results
	if(mysqli_stmt_affected_rows($stmt)==1){
		$author_id=mysqli_stmt_insert_id($stmt);
		//echo $author_id;
		}
  mysqli_stmt_close($stmt);
}//end of is post
  
if(empty($errors)){
  // initialize prepared statement to insert to the books table
  $stmt = $conn->stmt_init();
  // create SQL
  $sql = 'INSERT INTO books (book_isbn, genre_id, author_id, book_title, book_description, book_format, book_binding, publish_date, book_inventory, due_length)
		  VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  if ($stmt->prepare($sql)) {
	// bind parameters and execute statement
	$stmt->bind_param('siisssssii', $book_isbn, $genre_id, $author_id, $book_title, $book_description, $book_format, $book_binding, $publish_date, $book_inventory, $due_length);
    // execute and get number of affected rows
	$stmt->execute();
	if ($stmt->affected_rows > 0) {
	  $OK = true;
	}
  }
}
			//end of if empty error
  
  
  
  // redirect if successful or display error
  if ($OK) {
	header('Location: http://localhost/libraryCMS/booklist.php');
	exit;
  } else {
	$error = $stmt->error;
  }
}//end of isset insert
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
  <form action="" method="post" name="addbook">
    <p><span class="label_style">Add Book ISBN*:</span>
      <input name="book_isbn" id="book_isbn" type="text" /> &#160;
      <?php echo '<span class="warning">'.$errors['book_isbn'].'</span>';?>
    </p>
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
      &#160; <?php echo '<span class="warning">'.$errors['genre_id'].'</span>';?>
    </p>
    <p><span class="label_style">Add the Book Title*:</span>
      <input name="book_title" size"40" cols="60" id="book_title" type="text" />
       &#160; <?php echo '<span class="warning">'.$errors['book_title'].'</span>';?>
    </p>
    <!--the following code first check to see if the author exist, if not, add through the input fields-->
    <p> <span class="label_style">Choose an author*: </span>
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
      <small>(note: authors in the system could be found on this drop down list)</small> </p>
    <!-- the follwoing code check if the authors are already in the list-->
    <p><span class="add_author">Add an Author*: </span> Last Name
      <input name="author_lastname" id="author_lastname" />
      First Name:
      <input name="author_firstname" id="author_firstname" />
      Middle Name:
      <input name="author_middlename" id="author_middlename" /><br/>
      <small>(note: add an author if it is not on the list)</small>
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
      &#160; <?php echo '<span class="warning">'.$errors['publish_date'].'</span>';?>
    </p>
    <p><span class="label_style">Book Inventory*:</span>
      <input name="book_inventory" id="book_inventory" type="text" />
      &#160; <?php echo '<span class="warning">'.$errors['book_inventory'].'</span>';?>
    </p>
    <p><span class="label_style">Due Length (days)*:</span>
      <input name="due_length" id="due_length" type="text" />
      &#160; <?php echo '<span class="warning">'.$errors['due_length'].'</span>';?>
    </p>
    <p align="center">
      <input type="submit" name="insert" value="Insert New Book" id="insert">
    </p>
  </form>
</div>
<!--end of content div-->
</body>
</html>