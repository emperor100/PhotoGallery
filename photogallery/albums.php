<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;

}


?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Albums</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
		h1,
h1+p {
	margin: 30px 15px 0;
	font-weight: 300;
}
h1+p a {
	color: #333;
}
h1+p a:hover {
	text-decoration: none;
}
h2 {
	margin: 60px 15px 0;
	padding: 0;
	font-weight: 300;
}
h2 span {
	margin-left: 1em;
	color: #aaa;
	font-size: 85%;
}
.column {
	margin: 15px 15px 0;
	padding: 0;
}
.column:last-child {
	padding-bottom: 60px;
}
.column::after {
	content: '';
	clear: both;
	display: block;
}
.column div {
	position: relative;
	float: left;
	width: 300px;
	height: 200px;
	margin: 0 0 27px 25px;
	padding: 0;
}
.column div:first-child {
	margin-left: 0;
}
.column div span {
	position: absolute;
	bottom: -10px;
	left: 0;
	z-index: -1;
	display: block;
	width: 300px;
	margin: 0;
	padding: 0;
	color: #444;
	font-size: 18px;
	text-decoration: none;
	text-align: center;
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
	opacity: 0;
}
figure {
	width: 300px;
	height: 200px;
	margin: 0;
	padding: 0;
	background: #fff;
	overflow: hidden;
}
figure:hover+span {
	bottom: -26px;
	opacity: 1;
}


		.gallery img {
    width: 20%;
    height: auto;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}
		.hover07 figure img {
	 width: 70%;
    height: 80%;		
	border-radius: 5px;
	-webkit-filter: blur(5px);
	filter: blur(5px);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
.hover07 figure:hover img {
	-webkit-filter: blur(0);
	filter: blur(0);
}

		create {font: 14px sans-serif; text-align: right;}
		
    </style>
</head>

<body>



	<div class="page-header">
        <h1>Wecome to <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>'s Album.</h1>
    </div>

	



<create>

	<div class="page-header">
	<p>
		<a href="welcome.php" class="btn btn-warning"> Home</a>
		<a href="createalbum.php" class="btn btn-success"> + Create New Album</a>
		<a href="logout.php" class="btn btn-danger">Sign Out</a>
	<p>
	</div>
</create>

<div class="hover07 column">
<script>
function myFunction(name) {
	


	
	window.location = "openalbum.php?albumname="+name;
	
	
	

}
</script>
	<?php

	
	require_once "config.php";
	$username = $_SESSION["username"];
	$sql = "SELECT * from albums where username = ?";
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
		$param_username = $username;
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					mysqli_stmt_bind_result($stmt, $id, $name, $username, $desc, $created, $photolink);
					$ind=0;
					while(mysqli_stmt_fetch($stmt)){?>
						
						<div>
							<figure>
						<a href="#" id="images" onclick="return myFunction('<?php echo $name; ?>')" >
							<img  src="<?php echo "photos/".$photolink; ?>"  />
						</a>
							</figure>
							<span> <?PHP echo $name; ?> </span>
						</div>
						
						<?php 
						
						/* <img  src="<?php echo "photos/".$photolink; ?>"  value="<?php echo $name; ?>" onclick="myFunction('<?php reDirect($name) ?>')" /> */
						/* <p id="imagid" onclick="return myFunction('<?php echo $name; ?>')">Click</p> */
						
						
						
						
						
					}
						
					
					
                } 
				
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
		
	
	?>
</div>

</body>


</html>