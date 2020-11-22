<?php

include 'databaseconnect.php';

//signup table content input
   $Sstatus = "";
	if(isset($_POST['save'])) {
	  $first_name = $_POST['first_name'];
	  $last_name = $_POST['last_name'];
	  $email = $_POST['email'];
	  $username = $_POST['username'];
	  $password = $_POST['password'];
	  $re_password = $_POST['re_password'];
	  $account_type = "nonadmin";

	  if(empty($first_name) || empty($email) || empty($last_name) || empty($username) || empty($password) ||empty($re_password) ) {
	    $Sstatus = "All fields are compulsory.";
	  } 
	  else {
	    if(strlen($first_name) >= 255 || !preg_match("/^[a-zA-Z-'\s]+$/", $first_name)) {
	      $Sstatus = "Please enter a valid name";
	    }

	     else if(strlen($last_name) >= 255 || !preg_match("/^[a-zA-Z-'\s]+$/", $last_name)) {
	      $Sstatus = "Please enter a valid name";
	    } 

	    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	      $Sstatus = "Please enter a valid email";
	    } 

	    else 
	    {  
	      $chck = "SELECT * from signup_table WHERE username='$username'";
	      $result = $pdo->query($chck);
	      if($result->rowCount()>0){
	      	$Sstatus = "username already exists";
	      }

	      else{

	      $sql = "INSERT INTO signup_table (first_name, last_name, email, username, password, re_password, account_type ) VALUES (:first_name, :last_name, :email, :username, :password, :re_password, :account_type)";
	      $stmt = $pdo->prepare($sql);
	      
	      $stmt->execute(['first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'username'=>$username ,'password'=>$password, 're_password'=>$re_password, 'account_type'=>$account_type]);
	      
	      $Sstatus = "Signup Successful !!";

	  
	      $first_name = "";
	      $last_name = "";
	      $email = "";
	      $username = "";
	      $password = "";
	      $re_password = "";
    	}

    	}
  }
}

// login table content input

$Lstatus = "";

	if(isset($_POST['getin'])){
		$Lusername = $_POST['Lusername'];
		$Lpassword = $_POST['Lpassword'];

		if(empty($Lusername) || empty($Lpassword)){
			$Lstatus = "Enter credentials";
		}

		else{

			$statement = "SELECT * from signup_table where username='$Lusername'";
			$result = $pdo->query($statement);
			if($result->rowCount()>0){

				$row = $result->fetch();
				if(strval($Lpassword)!= strval($row['password']))
				{
					$Lstatus = "Incorrect Password";

				}

				else{

					$Lstatus = "Success";
					

					$_SESSION['username'] = $row['username'];
					$_SESSION['name'] = $row['first_name'];
					if($row['account_type'] == "admin")
					{

						$_SESSION['acc'] = "admin";
					}					
					
					else {

						$_SESSION['acc'] = "nonadmin";

					}

				}
			}

			else{

				$Lstatus = "User doesn't exit";
			}


			}
	}
	

	$stmt = "SELECT * from home_table WHERE 1";
	$final = $pdo->prepare($stmt);
	$final->execute();

	$home_array = array();

	while($rowout = $final->fetch())	
	{

		$home_array[] = $rowout;

	}


   
?>

<!DOCTYPE html>
<html>
<head>
	<title>Nagashekar Ananda Portfolio</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta http-equi="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript" src="js/login.js"></script>
	<script type="text/javascript" src="js/validation.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Rajdhani|Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<!--Header Showcase -->
	<div id="wrapper">
		<div class="header">
			</div>	
		<div class="main-block">	
				<nav class="main-nav">
								
						
					<ul>
					
						<li><a href="index.php"><img src="images/logo.png" class="logo" alt="logo"></a></li> 	
						
						<li><p id="myname">Nagashekar Ananda</p></li> 
					
							
					
						<li><a class="current" href="index.php">HOME</a></li>
							
						<li><a href="libmanage.php">MANAGE LIBRARY</a></li>
							
						<li><a href="notificationtrigger.php">NOTIFICATION</a></li>

					</ul>
				

				</nav>
				
				<div class="main-block-home" style="background-image:url('images/lib_background.jpg');">

					<div class="hello">
						<h1>Hi </h1>
					</div>
					<div class=nags>
						<h1>Welcome to the Library!! </h1>
					</div>
					<div class="dummy"></div>
					<div class="tothetop">

						<a href="#"><img src="images/arrow_white.png" class="arrowhead" alt="arrow"></a> 
					</div>					
				</div>
		</div>		
			

			<footer>
				<p>Copyright &copy; Registered &reg; Nagashekar Ananda</p>
			</footer>


		</div>


<!-- </div> -->
</body> 
</html>