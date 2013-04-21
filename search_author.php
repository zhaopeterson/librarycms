<?php
require_once('includes/connection.inc.php');
if(isset($_POST['search'])){
	$input_lastname=$_POST['author_lastname'];
	//echo $input_lastname;
	
$sql = "SELECT book_isbn, book_title, author_lastname, author_firstname FROM books INNER JOIN authors USING (author_id) WHERE author_lastname LIKE '%$input_lastname%'";
$result = $conn->query($sql);	
while($row = $result->fetch_assoc()) {
	echo $row['book_title']."<br/>";	
	}

$anymatch=mysqli_num_rows($result);
if ($anymatch==0){
echo "Sorry, we were not able to find any book under this author's name";	
}
}//end of isset search

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

<h2>Search Author by Last Name</h2>
<form action="" method="POST" name="search_authorform">
<p> Last name: <br/>
<input type="text" name="author_lastname" id="author_lastanme" /></p>
<input type="submit" name="search" value="Search" id="search"/>

</form>
</div><!--end of content div-->
</body>
</html>