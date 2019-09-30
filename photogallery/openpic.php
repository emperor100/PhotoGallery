<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;

}




	
	require_once "config.php";
	$username = $_SESSION["username"];
	$albumname = $_SESSION["albumname"];
	$imagename = $_GET["imageid"];
	
	$sql = "SELECT * from photos where username = ? and albumname = ? and id = ? ";
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_albumname, $param_imagename);
		$param_username = $username;
		$param_albumname = $albumname;
		$param_imagename = $imagename;
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					mysqli_stmt_bind_result($stmt, $id, $imagename, $albumname, $username, $created, $photolink);
					
					(mysqli_stmt_fetch($stmt));

					
				}
				else {
			
			$url = "location: openalbums.php?albumname=".$albumname;

				header($url);
				exit;
		}
				
		}
		
		
		
	}
		
		
	//Here we are cheking if the album is marked as public or not.
	//If public then we will just Display the number of likes it has got.
	//If private then we will not display anything as marking the image as private will delete all likes it has got till now.
	$isPublic=(int)(0);
	$sql = "SELECT * from sharedphotos where imageid = ?";
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s",$param_imagename);
		
		$param_imagename = (int)($_GET["imageid"]);
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					$isPublic=(int)(1);
					
				}
				
				
		}
		
		
		
	}
	
	$likecount=0;
	
	if($isPublic)
	{
		
			
			$sql = "SELECT * from likedphotos where imageid = ?";
			if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s",$param_imagename);
			
			$param_imagename = (int)($_GET["imageid"]);
			
				if(mysqli_stmt_execute($stmt)){
						/* store result */
						
						mysqli_stmt_store_result($stmt);
						
						$likecount = (mysqli_stmt_num_rows($stmt));
						
						
						
				}
			
		
		
			}
			
			
		
	}

		
		
		


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Picture</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
		.gallery img {
    width: 20%;
    height: auto;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

		create {font: 14px sans-serif; text-align: right;}
		
    </style>
</head>

<body>





	<div class="page-header">
        <h1><b>Picture Name : <?php echo htmlspecialchars($imagename); ?></b></h1>
		<?php if($likecount) { ?>
		<h1><b>Hey! your beautiful pic got <?php echo htmlspecialchars($likecount); ?> like(s) </b></h1>
		<?php } ?>
    </div>

	
	
<create>
	<p>
		
		<a href="welcome.php" class="btn btn-default">Home</a> 
		<?php if ($isPublic) { ?>
		<a href="markprivate.php?imageid=<?php echo $id; ?>" class="btn btn-primary">Mark Private </a>
		<?php } else { ?>
		<a href="markpublic.php?imageid=<?php echo $id; ?>" class="btn btn-success">Mark Public </a>
		<?php } ?>
		<a href="albums.php" class="btn btn-info">Go to Albums</a>
		<a href="deletepic.php?imageid=<?php echo $id; ?>" class="btn btn-warning">Delete Picture</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>	
</create>
	
	
		
					
					<div>
						
						
						
						<p><b> Uploaded at <?php echo $created; ?></b> </p>
						<img  src="<?php echo "photos/".$photolink; ?>"  />
					</div>
			
			
	
	
	
	
	
	



</body>


</html>