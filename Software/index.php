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
$User_ID= $_SESSION['id'];
$dbhost = 'localhost';
$dbname = 'update-tracker1';
$user = 'root';
$pass = ''; 
// $dbhost = "rdbms.strato.de";
// $dbname = "DB4001610";
// $user = "U4001610";
// $pass = "XYymJZVP8i!LC52";

$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);
$result_users = $db->prepare("SELECT * FROM users");
$result_users->execute();
for($i=0; $row = $result_users->fetch(); $i++){
	$id = $row['ID'];
}	

if(isset($_GET['ID'])){
    $query = "DELETE FROM usersoftware WHERE usersoftwareID={$_GET['ID']}";
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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
</head>
<ul>
	<li><a title="Home" class="active" href="index.php"><i class="material-icons">home</i></a></li>
	<li><a title="Profile" href="profile.php?edit_id=<?php echo $User_ID ?>"><i class="material-icons">person</i></a></li>
	<li><a title="Add software" href="add.php"><i class="material-icons">add_circle_outline</i></a></li>
	<li class="right"><a title="Sign off" href="?logout=1"><i class="material-icons">power_settings_new</i></a></li>
</ul>
<body>
	<h1 class="update">Update<div class="tracker">Tracker</h1>
	<?php
	echo "
	      <table class='Software' id='project_table'>
	        <tr id='head'>
	          <th>Software name</th>
	          <th>Software version</th>
	          <th>Actions</th>
	        </tr>";
	  $result_projects = $db->prepare("SELECT * FROM usersoftware INNER JOIN software on usersoftware.Software_ID = software.ID WHERE User_ID = ". $User_ID);

	  $result_projects->execute();
	  for($i=0; $row = $result_projects->fetch(); $i++){
	    $id = $row['usersoftwareID'];
	    echo "<tr>";
	    echo "<td>" . $row['Software'] . "</td>";
	    echo "<td>" . $row['Current_Version'] . "</td>";
	    echo "
   			<td><a title='Edit' class='link' href=edit.php?ID=". $id."><i class='material-icons'>edit</i></a>
   			<a title='Delete' onclick=\"return confirm('Delete This item?')\" class='link'href='?ID=". $id ."'><i class='material-icons'>delete</i></a></td>";
	    ?>
	<?php } ?>
	</tbody>
	<?php
	$result_user = $db->prepare("SELECT * FROM users WHERE ID =".$User_ID);
	$result_user->execute();
	for($i=0; $row = $result_user->fetch(); $i++){
		$betaald = $row['Paying'];
		if($betaald == 0){
			?><div class='buy_div'>
				<h2 class='buy'>Meer software toevoegen? <button onclick="window.location.href = 'buy.php';" id='buy' class='btn waves-effect waves-light' type='submit' name='buy'>Buy</button></h2>
			</div>
			<?php
		}else{
			$betaald = "Ja";
		}
		$id = $row['ID'];
	}	
	?>
</body>
</html>