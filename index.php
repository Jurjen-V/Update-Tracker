<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link rel="icon" href="img/favicon.ico">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
  <link rel="stylesheet" href="css/Login.css">

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