<?php
$dbhost = 'localhost';
$dbname = 'update-tracker1';
$user = 'root';
$pass = ''; 
// $dbhost = "rdbms.strato.de";
// $dbname = "DB4001610";
// $user = "U4001610";
// $pass = "XYymJZVP8i!LC52";
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $user, $pass);

if(isset($_GET['usersoftwareID'])){
	$usersoftwareID =$_GET['usersoftwareID'];
	$result_usersoftware = $db->prepare("SELECT * FROM usersoftware INNER JOIN software on usersoftware.Software_ID = software.ID WHERE usersoftwareID =".$usersoftwareID);
	$result_usersoftware->execute();
	for($i=0; $row = $result_usersoftware->fetch(); $i++){
		$Software_ID = $row['Software_ID'];
		$Version = $row['Version'];
	}
    $query = "UPDATE usersoftware SET NeedUpdate=:NeedUpdate, Current_Version=:Version WHERE usersoftwareID = ".$usersoftwareID;
	$stmt = $db->prepare($query);
	$NeedUpdate = 0;
    $stmt = $db->prepare($query);

	$stmt->bindValue(":NeedUpdate", $NeedUpdate, PDO::PARAM_STR);
	$stmt->bindValue(":Version", $Version, PDO::PARAM_STR);

	try{
    	$stmt->execute();
	}
	catch (PDOException $e) {
			echo $e->getMessage();
	}
    header('location: ../index.php');
}

$result_usersoftware = $db->prepare("SELECT * FROM usersoftware INNER JOIN software on usersoftware.Software_ID = software.ID");
$result_usersoftware->execute();
for($i=0; $row = $result_usersoftware->fetch(); $i++){
	// echo "Current_Version: " .$Current_Version = $row['Current_Version'] . $software= $row['Software'] ."<br>";
	// echo "Software version: " . $version = $row['Version']. "<br>";
	$Current_Version = $row['Current_Version'];
	$version = $row['Version'];
	$usersoftwareID = $row['usersoftwareID'];
	if($Current_Version !==  $version){
		$query = "UPDATE usersoftware SET NeedUpdate=1 WHERE usersoftwareID=:usersoftwareID";
		$stmt = $db->prepare($query);

		$stmt->bindValue(":usersoftwareID", $usersoftwareID, PDO::PARAM_STR);
		try {
			$stmt->execute();
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}else{
	}
}
$result_needupdate = $db->prepare("SELECT * FROM users INNER JOIN usersoftware on users.ID = usersoftware.User_ID INNER JOIN software on usersoftware.Software_ID = software.ID WHERE NeedUpdate = 1");
$result_needupdate->execute();
for($i=0; $row = $result_needupdate->fetch(); $i++){
	$id = $row['ID'];
	print_r($row);
	$Email = $row['Email'];
	$Username = $row['Username'];
	$software = $row['Software'];
	$usersoftwareID = $row['usersoftwareID'];
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$to = $Email;
	$subject = "Er zijn software updates";

	$message = "
		<h1 class='update'>Update<div class='tracker'>Tracker</h1>
		<br>	
		<p class='beste'> Beste <div class='jurjen'>".$Username."</div></p>
		<p class='beste'>Er is software dat guepdate moet worden.</p>
		<table class='Software' id='project_table'>
			<tr id='head'>
				<th>Software</th>
				<th>Versie</th>
				<th></th>
			</tr>
			<tr>
			<td>".$software . "</td>
			<td>" . $Current_Version . "</td>
		   	<td><a class='link' href=http://updatetracker.itmediasneek.nl/Software/update-checker.php?usersoftwareID=". $usersoftwareID.">Update</td></table>";
	$message .="
	<style>
		html{
				line-height: 1.5;
				font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;
				font-weight: normal;
				color:rgba(0,0,0,0.87);
				font-size: 15px;
		}
		table{
				border-collapse: collapse;
				border-spacing: 0;
		}
		tr{
				border-bottom: 1px solid rgba(0,0,0,0.12);
		}
		.Software{
				width: 100%;
				// margin-left: 5%;
				top: 40%;
		}
		tr:nth-child(even){
				background-color: #DCDCDC;
		}
		.update{
			  margin-top:5%;	
			  color: #707070;
			  display: inline;
			  // margin-left: 5%;
			  font-size: 30px;
		}
		.tracker{
			  color: #1A9988;
			  display: inline;
		}	
		.beste{
			  margin-top:5%;	
			  color: #707070;
			  display: inline;
			  // margin-left: 5%;
			  font-size: 24px;
		}
		.jurjen{
			  font-size: 24px;
			  color: #1A9988;
			  display: inline;
		}
		h1{
			font-size: 4.2rem;
			line-height: 110%;
			margin: 2.8rem 0 1.68rem 0;
			font-weight: 400;
		}
		td, th{
		    padding: 15px 5px;
		    display: table-cell;
		    text-align: left;
		    vertical-align: middle;
		    border-radius: 2px;
		}
		.link{
	  		color: #1a9988;
		}
		.link:hover{
		  	color:  #0f7567;
		}";
	if(@mail($to,$subject,$message,$headers)){
	// header("location: admin.php");
		echo "Mail send";
	}else{
		echo $title= "Error";
		echo $message= "Oops! Er is iets fout gegaan. Probeer de website te vernieuwen.";		
	}	
}
?>