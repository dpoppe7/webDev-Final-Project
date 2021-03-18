<!DOCTYPE html>
<html lang="en">
<head>
	<title>MyFaceSpace: Edit Account</title>
	
	<style>
		label {
			display: inline-block;
			width: 100px;			
			margin-bottom: 7px;
		}		
	</style>
	
</head>
<body>

<?php

session_start();

// Replace YOUR_USERNAME with your username!
$images_upload_dir_full = "/home/YOUR_USERNAME/public_html/myfacespace/images";
$images_upload_url = "/~YOUR_USERNAME/myfacespace/images";

// To use functions that upload and resize images
require('image_util.php');   

// For connecting to the database
require("database.php");	

// Connect and select database
$mysqli = ConnectToDatabase();
	
if ($_SERVER['REQUEST_METHOD'] == 'GET') {	
	// Get user data from database
		
	$username = $_SESSION['username'];
	
	$sql = "SELECT * FROM account WHERE username='$username'";
	$result = $mysqli->query($sql) or
		ShowError("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");

	$row = $result->fetch_assoc();
	if (!$row)
		ShowError("Unable to find the record for user $username.");
	
	$name = $row['name'];
	$profile_img = "$images_upload_url/$username.jpg";
	
?>
    <h2>Edit Account</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="5000000">

		<label for="name">Name</label><input type="text" id="name" name="name" value="<?= $name ?>"><br>
		<label>Username</label><?= $username ?><br>
		<label for="password">Password</label><input type="password" name="password" id="password"><br>
		<label for="imgfile">Profile Image</label><img src="<?= $profile_img ?>">
			<p><input type="file" name="imgfile" id="imgfile"></p>
		<br>
		<input type="submit" value="Save">
    </form>

</body>
</html>
<?php

}
else {  // POST

	if (!isset($_POST['name']))
		ShowError("Name could not be found. This could be due to the image submitted being too
			large. Go back and select an image that is no larger than " . ini_get('upload_max_filesize')
			. ".");	
	
	// Get submitted data and verify it wasn't left blank
	$name = trim($mysqli->real_escape_string($_POST['name']));
	$username = $_SESSION['username'];
	$password = trim($_POST['password']);
		
	if ($name == '')
		ShowError("Go back and enter your name.\n");

	if (ImageUploaded()) {		
		// This is the directory the uploaded images will be placed in.
		// It must have privileges sufficient for the web server to write to it
		if (!is_writeable($images_upload_dir_full)) 
			ShowError("The directory $images_upload_dir_full is not writeable.\n");


		$image_filename = "$images_upload_dir_full/$username.jpg";
		
		// Save the uploaded image to the given filename
		$error_msg = UploadSingleImage($image_filename);
		if ($error_msg != "") {
			ShowError($error_msg);
		}	
		
		// Save uploaded image with a maximum width or height of 300 pixels
		CreateThumbnailImage($image_filename, $image_filename, 300);
		
		// Create a very small thumbnail of the image to be used later
		$image_thumbnail = $username . "_thumb.jpg";
		CreateThumbnailImage($image_filename, "$images_upload_dir_full/$image_thumbnail", 60);
	}
	
	// Update record 
	$sql = "UPDATE account SET name='$name' ";
	if ($password != "") {
		// Get the Bcrypt hash of the password for inserting into the database
		$password_hash = password_hash($password, PASSWORD_BCRYPT);
		$sql .= ", password='$password_hash'";
	}
		
	$sql .= " WHERE username='$username'";
	
	$mysqli->query($sql) or
		ShowError("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
	
	print "<h1>Account Successfully Modified</h1>\n" .
		"<p><img src='$images_upload_url/$username.jpg' style='float:left; margin: 0pt 10pt 10px 10px;'>" .
		"<h2>$name</h2></p>\n".
		"<p><a href='edit_account.php'>Edit Account</a></p>\n";
		
	$_SESSION['name'] = $name;
	
}  // end POST


function ShowError($error) {
?>
    <h1>Unable to edit the account</h1>
    <p><?= $error ?></p>
	<p><a href="javascript:history.back()">Go back</a></p>
</body>
</html>
<?php
    exit;
} 
?> 

