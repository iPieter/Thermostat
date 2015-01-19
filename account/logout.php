<?php 

    // First we execute our common code to connection to the database and start the session 
    require("../scripts/common.php"); 
     
    // We remove the user's data from the session 
    unset($_SESSION['user']); 
    
    if (isset($_COOKIE['autoLogin'])) {
      	
  		$token = $_COOKIE['autoLogin'];
  		
  		$time = time();
		$sql = "UPDATE `autologin` SET `expires`=NOW() WHERE `token`='$token'";
 	    mysqli_query($con, $sql);

	    unset($_COOKIE['autoLogin']);
	    setcookie('autoLogin', null, time()-3600, "/");
	    
    }
    // We redirect them to the login page 
    header("Location: login.php"); 
    die("Redirecting to: login.php");