<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] == 0) {
	$_SESSION['msg'] = "You must log in first";
    header('location: ../index.php');
}
if (isset($_GET['logout'])) {
	session_destroy();
    unset($_SESSION['username']);
    header("location: ../index.php");
}
$dbhost = 'localhost';
$dbname = 'update-tracker1';
$user = 'root';
$pass = ''; 
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_users = $db->prepare("SELECT * FROM users");
$result_users->execute();
for($i=0; $row = $result_users->fetch(); $i++){
	$id = $row['ID'];
}	
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_software = $db->prepare("SELECT * FROM users WHERE ID = " . $_GET['User_ID']);
$result_software->execute();
for($i=0; $row = $result_software->fetch(); $i++){
	$Username = $row['Username'];
	$Email = $row['Email'];
	$Password = $row['Password'];
}	

if (isset($_POST['Save'])) {
    $dbhost = 'localhost';
    $dbname = 'update-tracker1';
    $user = 'root';
    $pass = '';
    $error = 0;

	if (isset($_POST['username'])) {
	    $username = htmlspecialchars($_POST['username']);
	}else{
	    $error++;
	    $errorMessage = "Er ging iets mis bij de username";
	}

	if (isset($_POST['email'])) {
		$email = htmlspecialchars($_POST['email']);
	}else{
		$error++;
		$errorMessage = "Er ging iets mis bij de email";
	}

	if (isset($_POST['password_1'])) {
		$password_1 = htmlspecialchars($_POST['password_1']);
	}else{
		$error++;
		$errorMessage = "Er ging iets mis bij het wachtwoord";
	}
	if (isset($_POST['password_2'])) {
		$password_2 = htmlspecialchars($_POST['password_2']);
	}else{
		$error++;
		$errorMessage = "Er ging iets mis bij het wachtwoord";
	}
	if($password_1 == $password_2){
      $password_3 = $password_3 = password_hash($password_1, PASSWORD_DEFAULT);
    }else{
      $error++;
      $errorMessage = "De wachtwoorden moeten gelijk zijn";
    }

	try {
		$db = new PDO("mysql:host=$dbhost;dbname=$dbname", $user, $pass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
	if ($error == 0) {
		$query = "UPDATE users SET Username=:Username, Email=:Email, Password=:Password WHERE ID=:ID";
		$stmt = $db->prepare($query);

		$stmt->bindValue(":Username", $username, PDO::PARAM_STR);
		$stmt->bindValue(":Email", $email, PDO::PARAM_STR);
		$stmt->bindValue(":Password", $password_3, PDO::PARAM_STR);
		$stmt->bindValue(":ID", $_GET['User_ID'], PDO::PARAM_STR);

		try {
			$stmt->execute();

		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		header('location:index.php');

	}else{
		echo $errorMessage;	
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../css/profile.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
	<meta charset="UTF-8">
	<title>Edit user</title>
</head>
<ul>
	<li><a href="index.php"><i class="material-icons">home</i></a></li>
	<li><a href="Add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
<body>
	<h1 class="update">Update<div class="tracker">Tracker</h1>
	<div class="row">
	<form class="col s12" id="form" action="" method="post">
		<div class="row">
			<div class="input-field col s12" id="username">
				<input type="text" name="username" value="<?= $Username; ?>" >
				<label for="Username">Username</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="e-mail">
				<input type="email" name="email" value="<?= $Email; ?>">
          		<label for="E-mail">E-mail address</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="password">
				<input type="password" name="password_1" value="<?= $Password; ?>">
          		<label for="Password">Password</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="password">
				<input type="password" name="password_2">
          		<label for="Password">Password</label>
			</div>
		</div>
		<div class="input-group">
			<button id="Sign-up" class="btn waves-effect waves-light" type="submit" name="Save">Save</button>
		</div>
	</form>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</html>