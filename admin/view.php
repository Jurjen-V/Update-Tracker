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
$dbname = 'update-tracker';
$user = 'root';
$pass = ''; 
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_users = $db->prepare("SELECT * FROM users");
$result_users->execute();
for($i=0; $row = $result_users->fetch(); $i++){
	$id = $row['ID'];
}	
$result_user = $db->prepare("SELECT * FROM users WHERE ID ={$_GET['User_ID']}");
$result_user->execute();
for($i=0; $row = $result_user->fetch(); $i++){
	$username = $row['Username'];
	$betaald = $row['Paying'];
	if($betaald == 0){
		$betaald = "Nee";
	}else{
		$betaald = "Ja";
	}
	$id = $row['ID'];
}	
if(isset($_GET['users_id'])){
    $query = "
    alter table usersoftware nocheck constraint all
	DELETE FROM users WHERE ID={$_GET['users_id']}";
    $insert = $db->prepare($query);
    $insert->execute();
    ?><script>window.location.href = "index.php";</script><?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="../css/view.css">
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
	<h1 class="update">Update<div class="tracker">Tracker</h1>
	<p class="userinfo">User: <?php echo $username?></p>
	<p class="userinfo1">Betaald: <?php echo $betaald?></p>
	<?php
	echo "
	      <table class='Software' id='project_table'>
	        <tr id='head'>
	          <th>Software</th>
	          <th>Version</th>
	          <th>Actions</th>
	        </tr>";
	  $result_projects = $db->prepare("SELECT * FROM usersoftware INNER JOIN software on usersoftware.Software_ID = Software.ID WHERE User_ID ={$_GET['User_ID']}");

	  $result_projects->execute();
	  for($i=0; $row = $result_projects->fetch(); $i++){
	    $id = $row['ID'];
	    echo "<tr>";
	    echo "<td>" . $row['Software'] . "</td>";
	   	echo "<td>" . $row['Version'] . "</td>";
	    echo "
   			<td><a class='link' href=edit.php?User_ID=". $id."><i class='material-icons'>edit</i></a><a class='link'href='?users_id=". $id ."'><i class='material-icons'>delete</i></a></td>";
	    ?>
	<?php } ?>
	</tbody>
</body>
</html>