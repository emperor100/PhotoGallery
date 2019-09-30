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
	$imageid = (int)($_GET["imageid"]);
	
	
	
	$sql = "INSERT into sharedphotos (imageid) VALUES ( ? )";

	
	
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_imageid);
		$param_imageid = $imageid;
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					mysqli_stmt_bind_result($stmt, $id, $imagename, $albumname, $username, $created, $photolink);
					
					(mysqli_stmt_fetch($stmt));

					
				}
				else {
			
			$url = "location: openpic.php?imageid=".$imageid;

				header($url);
				exit;
		}
				
		}
		
		
		
	}
		
	$url = "location: openpic.php?imageid=".$imageid;

				header($url);
				exit;


?>
