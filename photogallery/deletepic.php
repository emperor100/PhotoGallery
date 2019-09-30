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
$imageid = $_GET["imageid"];

$sql = "DELETE from photos where id = ? and username = ? and albumname = ?";
	
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_id, $param_username, $param_albumname);
		$param_id = (int)($imageid);
		$param_username = $username;
		$param_albumname = $albumname;
		
		mysqli_stmt_execute($stmt);
		
	}
		else{
                echo "Oops! Something went wrong. Please try again later.";
            }


$url = "location: openalbum.php?albumname=".$albumname;

header($url);
exit;

?>