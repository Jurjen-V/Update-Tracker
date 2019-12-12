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
if(isset($_GET['software_id'])){
    $query = "DELETE FROM usersoftware WHERE KoppelID={$_GET['software_id']}";
    $insert = $db->prepare($query);
    $insert->execute();
    ?><script>window.location.href = "index.php";</script><?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="../css/home.css">
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
	  $result_projects = $db->prepare("SELECT * FROM usersoftware INNER JOIN software on usersoftware.Software_ID = Software.ID WHERE User_ID = ". $id);

	  $result_projects->execute();
	  for($i=0; $row = $result_projects->fetch(); $i++){
	    $id = $row['KoppelID'];
	    echo "<tr>";
	    echo "<td>" . $row['Software'] . "</td>";
	    echo "<td>" . $row['Version'] . "</td>";
	    echo "
   			<td><a class='link' href=edit.php?KoppelID=". $id."><i class='material-icons'>edit</i></a><a class='link'href='?software_id=". $id ."'><i class='material-icons'>delete</i></a></td>";
	    ?>
	<?php } ?>
	</tbody>
	<div class="buy_div">
		<h2 class="buy">Meer software toevoegen? <button onclick="window.location.href = 'buy.php';" id="buy" class="btn waves-effect waves-light" type="submit" name="buy">Buy</button></h2>

	</div>
</body>
</html>