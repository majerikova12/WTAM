<?php
session_start();
if (isset($_SESSION["user"])){
	echo json_encode(array("state"=>"error", "message"=>"Si prihlásený. Nemôžeš sa registrovať."));
} else if (isset($_POST["last_name"]) && isset($_POST["first_name"]) && isset($_POST["user_name"]) && isset($_POST["password"]) && $conn=new mysqli("localhost", "root", "usbw", "wtam")){
	if ($result=$conn->query("SELECT count(*) as pocet FROM users WHERE user_name='".mysqli_real_escape_string($conn, $_POST["user_name"])."'")){
		if ($result->fetch_assoc()["pocet"]>0){
			echo json_encode(array("state"=>"error", "message"=>"Používateľské meno sa už používa."));
		} else if($result=$conn->query("INSERT INTO users (user_name,password,first_name,last_name) VALUES ('".mysqli_real_escape_string($_POST["user_name"])."', '".mysqli_real_escape_string(md5($_POST["password"]))."', '".mysqli_real_escape_string($_POST["first_name"])."', '".mysqli_real_escape_string($_POST["last_name"])."')")){
			echo json_encode(array("state"=>"ok"));
		} else{
			echo json_encode(array("state"=>"error", "message"=>"SQL query error."));
		}
	} else{
		echo json_encode(array("state"=>"error", "message"=>"SQL query error."));
	}
} else{
	echo json_encode(array("state"=>"error", "message"=>"Nepodarilo sa pripojiť k databáze alebo chýbajú údaje."));
}
?>