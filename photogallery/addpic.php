<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = "";
$albumname = $_SESSION["albumname"];
$username = $_SESSION["username"];
$description = "";
$albumname_err = "";
$photolink_err = "";
$photolink = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["name"]))){//username -> name changed
        $albumname_err = "Please enter photo name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM photos WHERE imagename = ? and albumname = ? and username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss",$param_imagename, $param_albumname,  $param_username);
            
            // Set parameters
            $param_imagename= trim($_POST["name"]);
			$param_albumname=$albumname;
			$param_username=$username;
			
			
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $albumname_err = "This photo name is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate Photolink
    if(empty($albumname_err) && isset($_FILES["photoli"]))
	{
				$photolink = $username.$name.($_FILES["photoli"]["name"]);
				$target = "./photos/".$photolink;
				
				//$url = "location: nothing.php?photolink=".$target;
				
				
				
				
	}
     else{
        //$photolink = trim($_POST["photolink"]);
		$photolink_err="Please choose a file to upload";
		
    }
    
	// Album Description
	
    // Check input errors before inserting in database
    if(empty($albumname_err) && empty($photolink_err) && move_uploaded_file($_FILES["photoli"]["tmp_name"], $target)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO photos (imagename, albumname, username, photo_link) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_albumname, $param_username, $param_photo);
            
            // Set parameters
			$param_name = $name;
			$param_albumname = $albumname;
            $param_username = $username;
			$param_photo = $photolink;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to albums page
                $url = "location: openalbum.php?albumname=".$albumname;

				header($url);
				exit;
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add new Photo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
		create {font: 14px sans-serif; text-align: right;}
    </style>
</head>
<create>

	<div class="page-header">
	<p>
		<a href="welcome.php" class="btn btn-warning"> Home</a>
		<a href="albums.php" class="btn btn-success"> Go Back</a>
		<a href="logout.php" class="btn btn-danger">Sign Out</a>
	<p>
	</div>
</create>
<body>
    <div class="wrapper">
        <h2>Add new Photo</h2>
        <p>Please fill below details for adding new Photo.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group <?php echo (!empty($albumname_err)) ? 'has-error' : ''; ?>">
                <label>Photo Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $albumname_err; ?></span>
            </div>    

            <div class="form-group">
                <label>Choose Cover Photo</label>
                <input type="file" name="photoli" class="form-control" value="<?php echo $photolink; ?>">
                <span class="help-block"><?php echo $photolink_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>
