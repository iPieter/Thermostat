<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
</head>
<body>

<?php 

    // First we execute our common code to connection to the database and start the session 
    include "../scripts/common.php";
    include "../scripts/datalogin.php";
     
    // This variable will be used to re-display the user's username to them in the 
    // login form if they fail to enter the correct password.  It is initialized here 
    // to an empty value, which will be shown if the user has not submitted the form. 
    $submitted_username = ''; 
    
    //get the original page the user came from 
    if (isset($_GET['r'])) {
    	$original_page = $_GET['r'];	    
    } else {
    	$original_page = '';	    
    }
    
    if(isset($_COOKIE['autoLogin'])) {
  		$token = $_COOKIE['autoLogin'];
		$sql = "SELECT * FROM `autologin` WHERE `token`='$token' AND `expires` > NOW();";
		
		$user = mysqli_query($con, $sql);
		
		if(mysqli_num_rows($user)) {
			$row_user = mysqli_fetch_array($user);
        	$_SESSION['user'] = $row_user;
        
        	header("Location: ../" . $original_page); 
        	die("Redirecting to: ../". $original_page);  		
		}
    }
    
    
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST)) 
    { 
        // This query retreives the user's information from the database using 
        // their username. 
        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt, 
                email 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            //die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This variable tells us whether the user has successfully logged in or not. 
        // We initialize it to false, assuming they have not. 
        // If we determine that they have entered the right details, then we switch it to true. 
        $login_ok = false; 
         
        // Retrieve the user data from the database.  If $row is false, then the username 
        // they entered is not registered. 
        $row = $stmt->fetch(); 
        if($row) 
        { 
            // Using the password submitted by the user and the salt stored in the database, 
            // we now check to see whether the passwords match by hashing the submitted password 
            // and comparing it to the hashed version already stored in the database. 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
            } 
        } 
         
        // If the user logged in successfully, then we send them to the private members-only page 
        // Otherwise, we display a login failed message and show the login form again 
        if($login_ok) 
        { 
        	//set a cookie for autologin if the user check it
        	if (isset($_POST["remember-me"])){
        		//generate a random value to link the user to this computer

        		$size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
				$iv = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);

				$token =  bin2hex($iv);
				$time = date('Y-m-d H:i:s',time()+ 1209600); //2 weeks
	        	setcookie("autoLogin", $token, time()+ 1209600, "/");
	        	
	        	//get the ip
	        	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	        	    $ip = $_SERVER['HTTP_CLIENT_IP'];
	        	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	        	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	        	} else {
	        	    $ip = $_SERVER['REMOTE_ADDR'];
	        	}
	        	
	        	//save this in the database
	        	$username= $row['username'];
	        	
	        	$sql = "INSERT INTO `autologin`(`token`, `ip`, `expires`, `username`) VALUES ('$token','$ip','$time','$username')";

	        	mysqli_query($con, $sql);


        	} 
        	
        	
            // Here I am preparing to store the $row array into the $_SESSION by 
            // removing the salt and password values from it.  Although $_SESSION is 
            // stored on the server-side, there is no reason to store sensitive values 
            // in it unless you have to.  Thus, it is best practice to remove these 
            // sensitive values first. 
            unset($row['salt']); 
            unset($row['password']); 
             
            // This stores the user's data into the session at the index 'user'. 
            // We will check this index on the private members-only page to determine whether 
            // or not the user is logged in.  We can also use it to retrieve 
            // the user's details. 
            $_SESSION['user'] = $row; 
             
            // Redirect the user to the private members-only page. 
            header("Location: ../" . $original_page); 
            die("Redirecting to: ../". $original_page); 
        } 
        else 
        { 
            // Tell the user they failed 
            print("Login Failed."); 
             
            // Show them their username again so all they have to do is enter a new 
            // password.  The use of htmlentities prevents XSS attacks.  You should 
            // always use htmlentities on user submitted values before displaying them 
            // to any users (including the user that submitted them).  For more information: 
            // http://en.wikipedia.org/wiki/XSS_attack 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        } 
    } 
     
?>
<div class="container">
	<form class="form-signin" role="form" action="login.php<?php echo "?r=" .$original_page; ?>"  method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="username" class="form-control" placeholder="Email address or username" required="" autofocus="">
        <input type="password" name="password" class="form-control" placeholder="Password" required="">
        <label class="checkbox">
        	<input type="checkbox" value="remember-me" name="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div>
</body>