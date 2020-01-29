<?php
session_start();
// $connect = mysqli_connect('localhost', 'root', '', 'update-tracker1') or die("Opps some thing went wrong");
$connect = mysqli_connect('rdbms.strato.de', 'U4001610', 'XYymJZVP8i!LC52', 'DB4001610') or die("Opps some thing went wrong");
	 if (isset($_POST['login_user'])) {
		 extract($_POST);
		// Get Old Password from Database which is having unique userName
		$sqlQuery = mysqli_query($connect, "select * from users where Username='$username'");
		$res = mysqli_fetch_array($sqlQuery);
		$current_password = $res['Password'];
		$id = $res['ID'];
		$Level = $res['Admin'];
		$enteredPassword = $_POST["password"];
		if (password_verify($enteredPassword, $current_password)) {
			 	/* If Password is valid!! */
			 	$_SESSION['username'] = $username;
			 	$_SESSION['id'] = $id;
			 	$_SESSION['level'] = $Level;
		 		$_SESSION['success'] = "You are now logged in";
		 		if($Level == 0){
		 			header('location: Software/index.php');
		 		}else{
		 			header('location: admin/index.php');
		 		}
		}
		else {
			 /* If Invalid password Entered */
			 $alt = "Login Failed! Please try again";
			 ?>
			 <div class="alert1">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
				<strong>Let op!</strong> <?php echo $alt ?>
			</div>
			<?php
		}
 }
?>
<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link rel="icon" href="img/favicon.ico">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
  <link rel="stylesheet" href="css/style.css">

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
  <meta content="utf-8" http-equiv="encoding">
</head>
<body class="login_body">
	<div class="row">
	<form class="col s12" id="form" action="" method="post">
		<h1 class="update">Update<div class="tracker">Tracker</h1>
		<div class="row">
			<div class="input-field col s12" id="username">
				<input type="text" name="username" >
				<label for="Username">Username</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="password">
				<input type="password" name="password">
          		<label for="Password">Password</label>
			</div>
		</div>
		<div class="row">
			<h2 class="not-a-user">not a user? <a href="sign-up.php" class="Sign-up">Sign up</a></h2>
		</div>
			<div class="input-group">
				<button id="login" class="btn waves-effect waves-light" type="submit" name="login_user">Login
		  	 	</button>
			</div>
	</form>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
</html>