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
// $dbhost = 'localhost';
// $dbname = 'update-tracker1';
// $user = 'root';
// $pass = ''; 
$dbhost = "rdbms.strato.de";
$dbname = "DB4001610";
$user = "U4001610";
$pass = "XYymJZVP8i!LC52";
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_users = $db->prepare("SELECT * FROM users");
$result_users->execute();
for($i=0; $row = $result_users->fetch(); $i++){
	$id = $row['ID'];
}	
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_software = $db->prepare("SELECT * FROM usersoftware INNER JOIN software on usersoftware.Software_ID = software.ID WHERE usersoftware.usersoftwareID = " . $_GET['ID']);
$result_software->execute();
for($i=0; $row = $result_software->fetch(); $i++){
	$ID = $row['usersoftwareID'];
	$Software = $row['Software'];
	$Versie = $row['Version'];
}	

if(isset($_POST['Save'])) {

	// $dbhost = 'localhost';
 //    $dbname = 'update-tracker1';
 //    $user = 'root';
 //    $pass = '';
	$dbhost = "rdbms.strato.de";
$dbname = "DB4001610";
$user = "U4001610";
$pass = "XYymJZVP8i!LC52";
	$error = 0;


	if (isset($_POST['Software_ID'])){
	    $Software_ID = htmlspecialchars($_POST['Software_ID']);

	}else{
	    $error++;
	    $errorMessage = "Software naam is leeg";
	}

	if (isset($_POST['Versie'])){
	    $Current_Version = htmlspecialchars($_POST['Versie']);

	}else{
	    $error++;
	    $errorMessage = "Software versie is leeg";
	}
    try {
        $database = new PDO("mysql:host=$dbhost;dbname=$dbname", $user, $pass);
        $database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
    if ($error == 0) {
    $query = "UPDATE usersoftware SET Software_ID=:Software_ID, Current_Version=:Current_Version WHERE usersoftwareID= :ID";
    $stmt = $db->prepare($query);

    $stmt->bindValue(":ID", $ID, PDO::PARAM_STR);
	$stmt->bindValue(":Software_ID", $Software_ID, PDO::PARAM_STR);
	$stmt->bindValue(":Current_Version", $Current_Version, PDO::PARAM_STR);

    try {
        $stmt->execute();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
    header('Location:index.php');	
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
	<title>Edit software</title>
</head>
<ul>
	<li><a href="index.php"><i class="material-icons">home</i></a></li>
	<li><a href="profile.php?edit_id=<?php echo $id ?>"><i class="material-icons">person</i></a></li>
	<li><a href="Add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
	<div class="row">
	<h1 class="update">Update<div class="tracker">Tracker</h1>
	<form class="col s12" id="add-edit" action="" method="post">
		<div class='row'>
	        <div class='input-field col s12' id='Softwarename'>
	          <select name='Software_ID' >
	            <option value="" disabled selected>Kies software uit</option>
	            <?php 
	              $result_users = $db->prepare("SELECT * FROM software");
	              $result_users->execute();
	              for ($i=0; $row = $result_users->fetch(); $i++) {
	                echo "<option value=". $row['ID']. ">" . $row['Software'] . "</option>";
	              }?>
	            </select>
	            <label>Software naam</label>
	         </div>
        </div>
		<div class='row'>
	        <div class='input-field col s12' id='Versie'>
	          <select name='Versie' >
	            <option value="" disabled selected>Wat is uw huidige versie?</option>
	            <?php 
	              $result_users = $db->prepare("SELECT * FROM software");
	              $result_users->execute();
	              for ($i=0; $row = $result_users->fetch(); $i++) {
	                echo "<option value=". $row['Version']. ">" . $row['Version'] . "</option>";
	              }?>
	            </select>
	            <label>Veriets</label>
	         </div>
        </div>
		<div class="input-group">
			<button id="Button" class="btn waves-effect waves-light" type="submit" name="Save">Save</button>
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