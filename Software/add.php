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
$User= $_SESSION['id'];
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_users = $db->prepare("SELECT * FROM users where ID=".$User);
$result_users->execute();
for($i=0; $row = $result_users->fetch(); $i++){
	$id = $row['ID'];
	$betaald= $row['Paying'];
}	
$result_software = $db->prepare("SELECT * FROM usersoftware INNER JOIN software on usersoftware.Software_ID = Software.ID WHERE User_ID = ". $User);
$result_software->execute();
$count = $result_software->rowCount();
if($betaald == 0 && $count >= 2){
	echo "Je hebt je max aantal bereikt";
}else{
	if(isset($_POST['Save'])) {

	$dbhost = 'localhost';
    $dbname = 'update-tracker1';
    $user = 'root';
    $pass = '';
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
	    $User_ID = $_SESSION['id'];
	    $query = "INSERT INTO usersoftware (User_ID, Software_ID, Current_Version) VALUES (?, ?, ?)";
	    $insert = $database->prepare($query);

	    $data = array("$User_ID", "$Software_ID", "$Current_Version");
	    try {
	        $insert->execute($data);
	    }
	    catch (PDOException $e) {
	        throw $e;
	    }
	    header('Location:index.php');
	    }else{
	    	echo $error;
	    	echo $errorMessage;
    	}
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
	<li><a href="profile.php?edit_id=<?php echo $id ?>"><i class="material-icons">person</i></a></li>
	<li><a href="Add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
	<div class="row">
	<form class="col s12" id="form" action="" method="post">
		<h1 class="update">Update<div class="tracker">Tracker</h1>
		<div class='row'>
	        <div class='input-field col s12' id='Softwarenaam'>
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
			<button id="Buy" class="btn waves-effect waves-light" type="submit" name="Save">Save</button>
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