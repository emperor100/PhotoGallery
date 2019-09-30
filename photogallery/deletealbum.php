<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

$albumname = $_SESSION["albumname"];
$username = $_SESSION["username"];

$sql = "DELETE from albums where name = ? and username = ?";
	
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_username);
		$param_name = $albumname;
		$param_username = $username;
		
		
		mysqli_stmt_execute($stmt);
		
	}
		else{
                echo "Oops! Something went wrong. Please try again later.";
            }



header("location: albums.php");
exit;

?>