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

	$dbhost = 'localhost';
	$dbname = 'update-tracker1';
	$user = 'root';
	$pass = '';
	try {
	    $database = new PDO("mysql:host=$dbhost;dbname=$dbname", $user, $pass);
	    $database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$User_ID = $_SESSION['id'];
		echo $sql = "UPDATE users SET Paying= 1 WHERE ID=".$User_ID;
		$stmt = $database->prepare($sql);

		$stmt->execute();

		echo $stmt->rowCount() . " records UPDATED successfully";
    }
	catch(PDOException $e)
    {
    	echo $sql . "<br>" . $e->getMessage();
    }

	$conn = null;
	header('Location:index.php');
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
	<li><a href="index.php"><i class="material-icons">home</i></a></li>
	<li><a href="profile.php?edit_id=<?php echo $id ?>"><i class="material-icons">person</i></a></li>
	<li><a href="Add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
	<div class="row">
	<form class="col s12" id="add-edit" action="" method="post">
		<div class="row">
			<div class="input-field col s12" id="Softwarename">
				<input type="text" name="Rekening nummer" >
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