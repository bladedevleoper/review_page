<?php
//database connection class
//Swap with the autoload_register to load the classes automatically
require ('classes/DatabaseConnection.php');

$database = new DatabaseConnection;

//need to look at what these type of functions do
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if($post['submit']){

	$fullname = $post['fullname'];
	$comments = $post['comments'];

	//inset into the database query
	$database->query('INSERT INTO site_reviews (fullname, comments) VALUES(:fullname, :comments)');

	$database->bind(':fullname', $fullname);
	$database->bind(':comments', $comments);
	$database->execute();
	if($database->lastInsertId()){

		echo '<p>Review Added</p>';
	}

}

$database->query('SELECT * FROM site_reviews');
$rows = $database->resultsSet();

?>
<!Doctype html>
<html>
<head>
<title>Review Page</title>
</head>
<body>

<div>
<h3>Current Reviews</h3>

<?php foreach($rows as $row) : ?>
<div>
	<h3><?php echo $row['fullname']; ?></h3>
	<p><?php echo $row['comments']; ?> </p>
	<span><?php echo $row['date']; ?></span>
</div>
<?php endforeach; ?>
</div>

<h3>Please leave a review</h3>
<!-- php review form -->
<form action="" method="post">
	<label>Full Name</label></br>
	<input type="text" name="fullname"></br>
	<label>Comments</label></br>
	<textarea name="comments"></textarea></br>
	<input type="submit" name="submit" value="submit">

</form>


</body>
</html>