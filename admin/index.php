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
if(isset($_GET['users_id'])){
    $query = "DELETE FROM users WHERE ID={$_GET['users_id']};";
    $insert = $db->prepare($query);
    $insert->execute();
    ?>	
    <script>window.location.href = "index.php";</script>
    <?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Home</title>
</head>
<ul>
	<li><a title="Home" class="active" href="index.php"><i class="material-icons">home</i></a></li>
	<li><a title="Add user" href="add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a title="Sign off" href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
<body>
	<h1 class="update">Update<div class="tracker">Tracker</h1>
	<?php
	echo "
	      <table class='Software' id='user_table'>
	        <tr id='head'>
	          <th>ID</th>
	          <th>Username</th>
	          <th class='th'>E-mail</th>
	          <th>Paying?</th>
	          <th>Actions</th>
	        </tr>";
	  $result_projects = $db->prepare("SELECT * FROM users");

	  $result_projects->execute();
	  for($i=0; $row = $result_projects->fetch(); $i++){
	  	if($row['Paying'] == 1){
	  		$Paying = "Ja";
	  	}else{
	  		$Paying = "Nee";
	  	}
	    $id = $row['ID'];
	    echo "<tr>";
	  	echo "<td>" . $id . "</td>";
	    echo "<td>" . $row['Username'] . "</td>";
	   	echo "<td class='th'>" . $row['Email'] . "</td>";
	   	echo "<td>". $Paying. "</td>";
	    echo "
   			<td>
   			<a title='View' class='link' href=view.php?User_ID=". $id."><i class='material-icons'>remove_red_eye</i></a>
   			<a title='Edit' class='link' href=edit.php?User_ID=". $id."><i class='material-icons'>edit</i></a>
   			<a title='Delete' onclick=\"return confirm('Delete This item?')\" class='link'href='?users_id=". $id ."'><i class='material-icons'>delete</i></a></td>";
	    ?>
	<?php } ?>
	</tbody>
</body>
</html>
