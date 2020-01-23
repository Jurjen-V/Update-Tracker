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
$User_id= $_SESSION['id'];
$error = 0;
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_users = $db->prepare("SELECT * FROM users where ID=".$User_id);
$result_users->execute();
for($i=0; $row = $result_users->fetch(); $i++){
	$id = $row['ID'];
	$betaald= $row['Paying'];
}	
$result_software = $db->prepare("SELECT * FROM usersoftware INNER JOIN software on usersoftware.Software_ID = software.ID WHERE User_ID = ". $User_id);
$result_software->execute();
$count = $result_software->rowCount();
if($betaald == 0 && $count >= 2){
	$error++;
	$errorMessage= "Je hebt je max aantal software bereikt";
	?>
	<div class="alert">
		<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
		<strong>Let op!</strong> <?php echo $errorMessage ?>
	</div>
	<?php
}else{
	if(isset($_POST['Save'])) {

	$dbhost = 'localhost';
    $dbname = 'update-tracker1';
    $user = 'root';
    $pass = '';
// $dbhost = "rdbms.strato.de";
// $dbname = "DB4001610";
// $user = "U4001610";
// $pass = "XYymJZVP8i!LC52";

	if (!empty($_POST['Software_ID'])){
	    $Software_ID = htmlspecialchars($_POST['Software_ID']);
	}else{
	    $error++;
	    $errorMessage = "Software naam is leeg";
	}
	if (!empty($_POST['Versie'])){
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
	    	?>
	    	<div class="alert">
			  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
			  <strong>Let op!</strong> <?php echo $errorMessage ?>
			</div>
			<?php
    	}
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
	<title>Add software</title>
</head>
<ul>
	<li><a href="index.php"><i class="material-icons">home</i></a></li>
	<li><a href="profile.php?edit_id=<?php echo $id ?>"><i class="material-icons">person</i></a></li>
	<li><a class="active" href="add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
	<div class="row">
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
	            <label>Verie</label>
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