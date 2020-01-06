<?php
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
// $email = $_GET['email'];
// $decoded_mail = str_rot13($email);
$to = 'jurjen.veenstra@hotmail.nl';
$subject = "Er zijn software updates";
$message = "
<h1 class='update'>Update<div class='tracker'>Tracker</h1>
<br>	
<p class='beste'> Beste <div class='jurjen'>Jurjen</div></p>
<p class='beste'>Er is software dat guepdate moet worden.</p>
<table class='Software' id='project_table'>
	<tr id='head'>
		<th>Software</th>
		<th>Versie</th>
		<th></th>
	</tr>
	<tr>
		<td>Office 365</td>
		<td>V 1.263</td>
		<td><a class='link' href='#''>Geupdate</a></td>
	</tr>
	<tr>
		<td>Office 365</td>
		<td>V 1.263</td>
		<td><a class='link' href='#''>Geupdate</a></td>
	</tr>
	<tr>
		<td>Office 365</td>
		<td>V 1.263</td>
		<td><a class='link' href='#''>Geupdate</a></td>
	</tr>

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
			width: 80%;
			right: 10%;
			top: 20%;
			position: absolute;
	}
	tr:nth-child(even){
			background-color: #DCDCDC;
	}
	.update{
		  margin-top:5%;	
		  color: #707070;
		  display: inline;
		  margin-left: 5%;
	}
	.tracker{
		  color: #1A9988;
		  display: inline;
	}	
	.beste{
		  margin-top:5%;	
		  color: #707070;
		  display: inline;
		  margin-left: 5%;
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
	header("location: admin.php");
}else{
	echo $title= "Error";
	echo $message= "Oops! Er is iets fout gegaan. Probeer de website te vernieuwen.";
}