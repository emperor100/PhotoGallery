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
	$imageid = (int)($_GET["imageid"]);
	
	
	
	$sql = "INSERT into likedphotos (imageid, username) VALUES ( ?, ? )";

	
	
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_imageid, $param_username);
		$param_imageid = $imageid;
		$param_username = $username;
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					mysqli_stmt_bind_result($stmt, $id, $imagename, $albumname, $username, $created, $photolink);
					
					(mysqli_stmt_fetch($stmt));

					
				}
				else {
			
			$url = "location: opensharedpic.php?imageid=".$imageid;

				header($url);
				exit;
		}
				
		}
		
		
		
	}
		
	$url = "location: opensharedpic.php?imageid=".$imageid;

				header($url);
				exit;


?>
