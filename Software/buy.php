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
if(isset($_POST['Buy'])) {

	// $dbhost = 'localhost';
	// $dbname = 'update-tracker1';
	// $user = 'root';
	// $pass = '';
	$error = 0;
	$dbhost = "rdbms.strato.de";
	$dbname = "DB4001610";
	$user = "U4001610";
	$pass = "XYymJZVP8i!LC52";
	if (!empty($_POST['Rekeningnummer'])) {
	   	$Rekeningnummer = htmlspecialchars($_POST['Rekeningnummer']);
	}else{
	    $error++;
	    $errorMSG= "Rekeningnummer empty";
    }
    if (!empty($_POST['Passnummer'])) {
	   	$Passnummer = htmlspecialchars($_POST['Passnummer']);
	}else{
	    $error++;
	    $errorMSG= "Passnummer empty";
    }
    if (!empty($_POST['Bank'])) {
	   	$Bank = htmlspecialchars($_POST['Bank']);
	}else{
	    $error++;
	    $errorMSG= "Bank empty";
    }
    if ($error === 0) {
    	try {
			$database = new PDO("mysql:host=$dbhost;dbname=$dbname", $user, $pass);
			$database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$User_ID = $_SESSION['id'];
			$sql = "UPDATE users SET Paying= 1 WHERE ID=".$User_ID;
			$stmt = $database->prepare($sql);

			$stmt->execute();
   		}
		catch(PDOException $e)
		{
		    echo $sql . "<br>" . $e->getMessage();
		}
		$conn = null;
		header('Location:index.php');
	}else{
        ?>
        <div class="alert">
          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
          <strong>Let op!</strong> <?php echo $errorMSG ?>
        </div><?php
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Buy</title>
</head>
<ul>
	<li><a title="Home" href="index.php"><i class="material-icons">home</i></a></li>
	<li><a title="Profile" href="profile.php?edit_id=<?php echo $id ?>"><i class="material-icons">person</i></a></li>
	<li><a title="Add software" href="Add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a title="Sign off" href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
	<div class="row">
	<form class="col s12" id="add-edit" action="" method="post">
		<div class="row">
			<div class="input-field col s12" id="Softwarename">
				<input type="text" name="Rekeningnummer" >
				<label for="Rekening nummer">Rekening nummer</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="Versie">
				<input type="text" name="Passnummer">
          		<label for="Passnummer">Passnummer</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12" id="Versie">
		    <select name="Bank">
		      <option value="" disabled selected>Choose your option</option>
		      <option value="Rabobank">Rabobank</option>
		      <option value="ING">ING</option>
		      <option value="ABN ambro">ABN ambro</option>
		    </select>
		    <label>Bank</label>
		  </div>
		</div>
		<div class="input-group">
			<button id="Button" class="btn waves-effect waves-light" type="submit" name="Buy">Buy</button>
		</div>
	</form>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
<script>
$(document).ready(function(){
	$('select').formSelect();
});
</script>
</html>