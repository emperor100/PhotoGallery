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
	$imagename = $_GET["imageid"];
	
	$sql = "SELECT * from photos where id = ?";
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_imagename);
		$param_imagename = $imagename;
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					mysqli_stmt_bind_result($stmt, $id, $imagename, $albumname, $username, $created, $photolink);
					
					(mysqli_stmt_fetch($stmt));

					
				}
				else {
			
			$url = "location: welcome.php";

				header($url);
				exit;
		}
				
		}
		
		
		
	}
		
		
	//Here we are cheking if it is shared or not
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
					mysqli_stmt_bind_result($stmt, $imageid, $uploaded_at);
					
					(mysqli_stmt_fetch($stmt));
					
				}
				
				
		}
		
		
		
	}
	
	$likecount=0;
	$isLiked=(int)(0);
	//if($isPublic)
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
			
			$sql = "SELECT * from likedphotos where  imageid = ? and username = ?";
			if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ss", $param_imagename,$param_username);
			
			$param_imagename == (int)($_GET["imageid"]);
			$param_username = $_SESSION["username"];
			
			
			
				if(mysqli_stmt_execute($stmt)){
						/* store result */
						
						mysqli_stmt_store_result($stmt);
						
						if(mysqli_stmt_num_rows($stmt) > 0){
                    
							$isLiked =(int)(1);
						
						}
						
				}
			
		
		
			}
			
			
			
			
		
	}

		
		
	if($isPublic){ echo ""; }
	else 
	{
		header("location: welcome.php");
	exit;}


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
		<h3><b>User Name :  <?php echo htmlspecialchars($username); ?> </b></h3>
		
		<h3><b> Uploaded at: <?php echo htmlspecialchars($uploaded_at); ?> </b></h3>
		<h3><b> This pic got  <?php echo htmlspecialchars($likecount); ?>  like(s).</b></h3>
		
    </div>

	
	
<create>
	<p>
		
		<a href="welcome.php" class="btn btn-default"> HOME</a> 
		<?php if ($isLiked) { ?>
		<a href="markunlike.php?imageid=<?php echo $id; ?>" class="btn btn-primary"> Unlike </a>
		<?php } else { ?>
		<a href="marklike.php?imageid=<?php echo $id; ?>" class="btn btn-success"> Like </a>
		<?php } ?>
		<a href="albums.php" class="btn btn-info">Go to Albums</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>	
</create>
	
	
		
					
					<div>
						
						
						<?php if ($isPublic) { ?>
						<img  src="<?php echo "photos/".$photolink; ?>"  />
						<?php } else {
							header("location: welcome.php");
						exit; } ?>
					</div>
			
			
	
	
	
	
	
	



</body>


</html>