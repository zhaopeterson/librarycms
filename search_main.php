<?php
require_once('includes/connection.inc.php');
if(isset($_POST['search'])){
	$input_searchterm=$_POST['search_term'];

	//start search with any ISBN number
	if ($_POST['search_option']=='book_isbn'){

$sql = "SELECT book_id, book_isbn, book_title, CONCAT( author_firstname, ' ', author_lastname ) AS author
FROM books INNER JOIN authors USING ( author_id )
WHERE book_isbn =$input_searchterm";
$result = $conn->query($sql);	


    $anymatch=mysqli_num_rows($result);
    if ($anymatch==0){
     echo "Sorry, we were not able to find any book with this ISBN number";	
     }
	}//end of isbn search option

//start search with any category number
	if ($_POST['search_option']=='genre_name'){
		echo $input_searchterm;
$sql = "SELECT book_id, book_isbn, book_title, CONCAT( author_firstname, ' ', author_lastname ) AS author
FROM books INNER JOIN authors USING ( author_id ) INNER JOIN genres
WHERE books.genre_id=genres.genre_id AND genre_name LIKE '%$input_searchterm%'";
$result = $conn->query($sql);	


    $anymatch=mysqli_num_rows($result);
    if ($anymatch==0){
     echo "Sorry, we were not able to find any book under this category name";	
     }
	}//end of isbn search option

//search by authot

	if ($_POST['search_option']=='author_name'){
		echo $input_searchterm;
$sql = "SELECT book_id, book_isbn, book_title, CONCAT( author_firstname, ' ', author_lastname ) AS author
FROM books INNER JOIN authors USING ( author_id )
WHERE author_lastname LIKE '%$input_searchterm%'";
$result = $conn->query($sql);	


    $anymatch=mysqli_num_rows($result);
    if ($anymatch==0){
     echo "Sorry, we were not able to find any book under this author's name";	
     }
	}//end of author search option
	
	//search by book title
if ($_POST['search_option']=='book_title'){
		echo $input_searchterm;
$sql = "SELECT book_id, book_isbn, book_title, CONCAT( author_firstname, ' ', author_lastname ) AS author
FROM books INNER JOIN authors USING ( author_id )
WHERE book_title LIKE '%$input_searchterm%'";
$result = $conn->query($sql);	


    $anymatch=mysqli_num_rows($result);
    if ($anymatch==0){
     echo "Sorry, we were not able to the exact match for this title";	
     }
	}//end of author search option










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

<h2>Welcome to Whatever Library</h2>
<p>You can use the drop down menu to select a search method and then type in the search keyword.
<form action="" method="post" name="searchform" id="searchform">
<p align="center"><select name="search_option" id="search_option">
<option>Search By</option>
<option value="book_isbn" <?php if ($_POST && $_POST['search_option'] == 'book_isbn') {
					  echo 'selected';
					} ?>
                    >ISBN</option>
<option value="genre_name" <?php if ($_POST && $_POST['search_option'] == 'genre_name') {
					  echo 'selected';
					} ?>
                    >Categories</option>
<option value="author_name" <?php if ($_POST && $_POST['search_option'] == 'author_name') {
					  echo 'selected';
					} ?>
                    >Authors</option>
<option value="book_title" <?php if ($_POST && $_POST['search_option'] == 'book_title') {
					  echo 'selected';
					} ?>
                    >Book Title</option>

</select>
<input type="text" size="60" name="search_term" id="search_term" /></p>
<p align="center"><input type="submit" value="&#160; Search &#160;" name="search" id="search" ></p>
</form>
<?php if(isset($_POST['search']) ){
		if( isset($_POST['search_option']) && (!empty($_POST['search_term']))){
			echo '<h3>Here is the search results</h3>';
while($row = $result->fetch_assoc()) {
	
	echo '<p>'.$row['author'].'--- '.'<a href="book_detail.php?book_id='.$row['book_id'],'">'.$row['book_title'].'</a></p>';	
	}//end of while loop
	} else{
		echo "<p class='warning'>You need to select the search option first and key in the search term</p>";
	}
}//end of isset SEARCH
	?>
</div><!--end of content div-->
</body>
</html>