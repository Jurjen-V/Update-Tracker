<?php 
  if(isset($_POST['Sign-up'])) {
    $dbhost = "rdbms.strato.de";
    $dbname = "DB4001610";
    $user = "U4001610";
    $pass = "XYymJZVP8i!LC52";
    // $dbhost = 'localhost';
    // $dbname = 'update-tracker1';
    // $user = 'root';
    // $pass = '';
    $error = 0;
    try {
          $database = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
          $database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
          echo $e->getMessage();
    }
    $username = $_POST['Username'];
    $email = $_POST['email'];
    $query = "SELECT * FROM users WHERE Username= :username OR Email= :email LIMIT 1";
    $stmt = $database->prepare($query);
    $results = $stmt->execute(array(":username" => $username, ":email" => $email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) { // if user exists
      if ($user['Username'] == $username) {
        $error++;
        $errorMSG= "Username already excist";
      }
      if ($user['Email'] == $email) {
        $error++;
        $errorMSG= "Email already excist";
      }
    }
    if (!empty($_POST['Username'])){
        $username = htmlspecialchars($_POST['Username']);

    }else{
        $error++;
        $errorMSG= "Username empty";
    }

    if (!empty($_POST['email'])){
        $email = htmlspecialchars($_POST['email']);

    }else{
        $error++;
        $errorMSG= "Email empty";
    }
    if (!empty($_POST['password_1'])){
        $password_1 = htmlspecialchars($_POST['password_1']);

    }else{
        $error++;
        $errorMSG= "Password empty";
    }
    if (!empty($_POST['password_2'])){
        $password_2 = htmlspecialchars($_POST['password_2']);

    }else{
        $error++;
        $errorMSG= "Password empty";
    }
    if(strlen($password_1) < 10 || strlen($password_2) < 10){
      $error++;
      $errorMSG= "Password needs to me longer than 10 characters.";
    }
    if($password_1 == $password_2){
      $password_3 = $password_3 = password_hash($password_1, PASSWORD_DEFAULT);
    }else{
      $error++;
      $errorMSG= "Password needs to be the same";
    }

      if ($error === 0) {
        $query = "INSERT INTO users (Username, Email, Password) VALUES (?, ?, ?)";
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
        ?>
        <div class="alert1">
          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
          <strong>Let op!</strong> <?php echo $errorMSG ?>
        </div><?php
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="./css/materialize.min.css"  media="screen,projection"/>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign-up</title>
</head>
<body class="login_body">
	<div class="row">
	<form class="col s12" id="form" action="" method="post">
		<h1 class="update">Update<div class="tracker">Tracker</h1>
		<div class="row">
			<div class="input-field col s12" id="username">
				<input type="text" name="Username" >
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
				<input minlength="10" type="password" name="password_1">
          		<label for="Password">Password</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="password">
				<input minlength="10" type="password" name="password_2">
          		<label for="Password">Password</label>
			</div>
		</div>
		<div class="input-group">
			<button id="login" class="btn waves-effect waves-light" type="submit" name="Sign-up">Sign-up</button>
		</div>
    <div class="row">
      <h2 class="not-a-user"><a href="index.php" class="Sign-up">Cancel</a></h2>
    </div>
	</form>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
</html>