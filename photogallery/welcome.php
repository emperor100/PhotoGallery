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
    <title>Welcome</title>
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
				width: 250px;
				height: 200px;
				margin: 0 0 20 25px;
				padding: 0;
			}
			.column div:first-child {
				margin-left: 0;
			}
			.column div span {
				position: absolute;
				bottom: -20px;
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
				width: 250px;
				height: 200px;
				margin: 0;
				padding: 0;
				background: #fff;
				overflow: hidden;
			}
			figure:hover+span {
				bottom: -96px;
				opacity: 1;
			}
			
			
					.gallery img {
				width: 20%;
				height: auto;
				border-radius: 5px;
				cursor: pointer;
				transition: 0.3s;
			}
			.hover01 figure img {
				width: 80%;
				height: 80%;	
				-webkit-transform: scale(1);
				transform: scale(1);
				-webkit-transition: .3s ease-in-out;
				transition: .3s ease-in-out;
			}
			.hover01 figure:hover img {
				-webkit-transform: scale(1.3);
				transform: scale(1.3);
			}
			.hover08 figure img {
				width: 80%;
				height: 80%;	
				border-radius: 10px;
				-webkit-filter: grayscale(70%);
				filter: grayscale(70%);
				-webkit-transition: .3s ease-in-out;
				transition: .3s ease-in-out;
			}
			.hover08 figure:hover img {
				-webkit-filter: grayscale(0);
				filter: grayscale(0);
			}
			
			.hover14 figure img{
				width: 100%;
				height: 80%;	
				position: relative;
			}
			.hover14 figure::before {
				position: absolute;
				top: 0;
				left: -75%;
				z-index: 2;
				display: block;
				content: '';
				width: 100%;
				height: 80%;
				background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,.3) 100%);
				background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,.3) 100%);
				-webkit-transform: skewX(-25deg);
				transform: skewX(-25deg);
			}
			.hover14 figure:hover::before {
					
				-webkit-animation: shine .75s;
				animation: shine .75s;
			}
			@-webkit-keyframes shine {
				100% {
					left: 125%;
				}
			}
			@keyframes shine {
				100% {
					left: 125%;
				}
			}

		create {font: 14px sans-serif; text-align: right;}
		
		
		
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Photo Gallery.</h1>
    </div>
    <p>
		<a href="albums.php" class="btn btn-success">Open Album</a>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
	<div class="page-header">
        <p><h4> These are photos which are shared by users on PhotoGallery. Like their photos to make them feel special. :D </h4></p>
    </div>
	
	
<script>



function myFun(id) {

	window.location = "opensharedpic.php?imageid="+id;
	
}
</script>
<div class="hover08 column">
	<?php

	
	require_once "config.php";
	$username = $_SESSION["username"];
	$albumname = $_SESSION["albumname"];
	
	$sql = "SELECT S.imageid, S.shared_at , R.imagename, R.username, R.photo_link from sharedphotos S,  photos R where imageid=id order by S.shared_at desc";
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					mysqli_stmt_bind_result($stmt, $imageid, $shared_at,$imagename, $username, $photolink);
					
					while(mysqli_stmt_fetch($stmt)){?>
						
						<div>
							<figure>
							
							
						<a href="#" id="imag" onclick="return myFun('<?php echo $imageid; ?>')" >
							<img  src="<?php echo "photos/".$photolink; ?>"  />
						</a>
							</figure>
							<span><p align="center">Image Title: <?PHP echo $imagename; ?> </p>
								  <p align="center">Shared by User: <?PHP echo $username; ?> </p>
							      <p align="center">Shared at: <?PHP echo $shared_at; ?></p> </span>
							
							
							
						</div>
							<p>.</p>
							
							
						
						<?php 
						/* <img  src="<?php echo "photos/".$photolink; ?>"  value="<?php echo $name; ?>" onclick="myFunction('<?php reDirect($name) ?>')" /> */
						/* <p id="imagid" onclick="return myFunction('<?php echo $name; ?>')">Click</p> */
						
					}
						
					
					
                } 
				
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
  
	
	
	?>
	
	
	
	
	
	
	
	
</div>
	
</body>
</html>