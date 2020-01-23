<?php
session_start();
if (!isset($_SESSION['username'])) {
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
// $dbhost = "rdbms.strato.de";
// $dbname = "DB4001610";
// $user = "U4001610";
// $pass = "XYymJZVP8i!LC52";
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result = $db->prepare("SELECT * FROM users WHERE id =" . $_GET['edit_id']);
   	$result->execute();
    for ($i=0; $row = $result->fetch(); $i++) {
    	$id = $row['ID'];
    	$Username = $row['Username'];
    	$Email = $row['Email'];
    	$password = $row['Password'];
	}
 if (isset($_POST['Save'])) {
    $dbhost = 'localhost';
    $dbname = 'update-tracker1';
    $user = 'root';
    $pass = '';
	// $dbhost = "rdbms.strato.de";
	// $dbname = "DB4001610";
	// $user = "U4001610";
	// $pass = "XYymJZVP8i!LC52";
    $error = 0;

	if (!empty($_POST['username'])) {
	    $username = htmlspecialchars($_POST['username']);
	}else{
	    $error++;
	    $errorMessage = "Er ging iets mis bij de username";
	}

	if (!empty($_POST['email'])) {
		$email = htmlspecialchars($_POST['email']);
	}else{
		$error++;
		$errorMessage = "Er ging iets mis bij de email";
	}

	if (!empty($_POST['password_1'])) {
		$password_1 = htmlspecialchars($_POST['password_1']);
	}else{
		$error++;
		$errorMessage = "Er ging iets mis bij het wachtwoord";
	}
	if (!empty($_POST['password_2'])) {
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
		$stmt->bindValue(":ID", $_GET['edit_id'], PDO::PARAM_STR);

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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Profile</title>
</head>
<ul>
	<li><a href="index.php"><i class="material-icons">home</i></a></li>
	<li><a class="active" href="profile.php?edit_id=<?php echo $id ?>"><i class="material-icons">person</i></a></li>
	<li><a href="add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
<body>
	<div class="row">
	<form class="col s12" id="add-edit" action="" method="post">
		<div class="row">
			<div class="input-field col s12" id="Softwarename">
				<input type="text" name="username" value="<?= $Username; ?>" >
				<label for="Username">Username</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="Versie">
				<input type="email" name="email" value="<?= $Email; ?>">
          		<label for="E-mail">E-mail address</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="Versie">
				<input type="password" name="password_1" value="<?= $Password; ?>">
          		<label for="Password">Password</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="Versie">
				<input type="password" name="password_2">
          		<label for="Password">Password</label>
			</div>
		</div>
		<div class="input-group">
			<button id="Button" class="btn waves-effect waves-light" type="submit" name="Save">Save</button>
		</div>
	</form>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</html>