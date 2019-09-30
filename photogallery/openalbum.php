<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$_SESSION["albumname"] = $_GET["albumname"];


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
	width: 190px;
	height: 200px;
	margin: 0 0 0 25px;
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
	width: 190px;
	height: 200px;
	margin: 0;
	padding: 0;
	background: #fff;
	overflow: hidden;
}
figure:hover+span {
	bottom: -36px;
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
	width: 100%;
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
	width: 100%;
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
        <h1>Album : <b> <?php echo htmlspecialchars($_SESSION["albumname"]); ?></b></h1>
    </div>
    
	<create>
	<p>
		<a href="welcome.php" class="btn btn-primary">Home</a>
		<a href="addpic.php" class="btn btn-default"> + Add Photo</a>
		<a href="albums.php" class="btn btn-success">Go to Albums</a>
		<a href="deletealbum.php" class="btn btn-warning">Delete Album</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>	
</create>



	<?php

	
	require_once "config.php";
	$username = $_SESSION["username"];
	$albumname = $_SESSION["albumname"];
	
	$sql = "SELECT * from albums where username = ? and name = ?";
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_albumname);
		$param_username = $username;
		$param_albumname = $albumname;
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					mysqli_stmt_bind_result($stmt, $id, $name, $username,$desc,  $created, $photolink);
					
					(mysqli_stmt_fetch($stmt))

					?>
					<p><b> Album's cover </b></p>
					<div class="gallery column">
						
						<img  src="<?php echo "photos/".$photolink; ?>"  />
						<p><b> Descrition:  <?php echo $desc; ?></b> </p>
						<p><b> Created:  <?php echo $created; ?></b></p>
						<p><b> Album's Photos </b></p>
					</div>
	
				<?php 
				}
				
		}
		mysqli_stmt_close($stmt);
	}
	
    
    // Close connection
   
		
		?>
		
					
			
			
					
					


<div class="page-header"></div>





<div class="hover08 column">

<script>

function myFun(id) {
	
	
	
	window.location = "openpic.php?imageid="+id;
	
	
	

	
}
</script>
	<?php

	
	require_once "config.php";
	$username = $_SESSION["username"];
	$albumname = $_SESSION["albumname"];
	
	$sql = "SELECT * from photos where username = ? and albumname = ?";
	if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_albumname);
		$param_username = $username;
		$param_albumname = $albumname;
		
		if(mysqli_stmt_execute($stmt)){
                /* store result */
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    
					mysqli_stmt_bind_result($stmt, $id, $imagename,$albumname, $username, $created, $photolink);
					
					while(mysqli_stmt_fetch($stmt)){?>
						
						<div>
							<figure>
							
							
						<a href="#" id="imag" onclick="return myFun('<?php echo $id; ?>')" >
							<img  src="<?php echo "photos/".$photolink; ?>"  />
						</a>
							</figure>
							
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