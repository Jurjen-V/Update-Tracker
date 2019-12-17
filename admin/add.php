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
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_users = $db->prepare("SELECT * FROM users");
$result_users->execute();
for($i=0; $row = $result_users->fetch(); $i++){
  $id = $row['ID'];
} 
  $username = "";
  $email = "";
  if(isset($_POST['Sign-up'])) {
    $dbhost = 'localhost';
    $dbname = 'update-tracker1';
    $user = 'root';
    $pass = '';
    $error = 0;

    try {
          $database = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
          $database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
          echo $e->getMessage();
    }
    $username = $_POST['username'];
    $email = $_POST['email'];
    $query = "SELECT * FROM users WHERE username= :username OR email= :email LIMIT 1";
    $stmt = $database->prepare($query);
    $results = $stmt->execute(array(":username" => $username, ":email" => $email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) { // if user exists
      if ($user['username'] === $username) {
        $error++;
      }
      if ($user['email'] === $email) {
        $error++;
      }
    }
    if (isset($_POST['username'])){
        $username = htmlspecialchars($_POST['username']);

    }else{
        $error++;
    }

    if (isset($_POST['email'])){
        $email = htmlspecialchars($_POST['email']);

    }else{
        $error++;
    }
    if (isset($_POST['password_1'])){
        $password_1 = htmlspecialchars($_POST['password_1']);

    }else{
        $error++;
    }
    if (isset($_POST['password_2'])){
        $password_2 = htmlspecialchars($_POST['password_2']);

    }else{
        $error++;
    }
    if($password_1 == $password_2){
      $password_3 = $password_3 = password_hash($password_1, PASSWORD_DEFAULT);
    }else{
      $error++;
    }
      
      if ($error == 0) {
        $query = "INSERT INTO users (Username, Email, password) VALUES (?, ?, ?)";
        $insert = $database->prepare($query);

        $data = array("$username", "$email", "$password_3");
        try {
            $insert->execute($data);
        }
        catch (PDOException $e) {
            throw $e;
        }
        header('Location:index.php');
      }else{
        echo "Er is iets misgegaan";
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="../css/add.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
  <meta charset="UTF-8">
  <title>Home</title>
</head>
<ul>
  <li><a href="index.php"><i class="material-icons">home</i></a></li>
  <li><a href="Add.php"><i class="material-icons">add_circle_outline</i></a></li>
  <li class="right"><a href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
<body>
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
			<div class="input-field col s12" id="e-mail">
				<input type="email" name="email">
          		<label for="E-mail">E-mail address</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="password">
				<input type="password" name="password_1">
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
			<button id="Sign-up" class="btn waves-effect waves-light" type="submit" name="Sign-up">Sign-up</button>
		</div>
	</form>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</html>