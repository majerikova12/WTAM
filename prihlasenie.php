<?php
session_start();
if (isset($_SESSION["user"])){
	echo json_encode(array("state"=>"error", "message"=>"Už si prihlásený."));
} else if (isset($_POST["user_name"]) && isset($_POST["password"]) && $conn=new mysqli("localhost", "root", "usbw", "wtam")){
	if ($result=$conn->query("SELECT * FROM users WHERE user_name='".mysqli_real_escape_string($conn, $_POST["user_name"])."' AND password='".mysqli_real_escape_string($conn, md5($_POST["password"]))."'")){
		if ($result->num_rows>0){
			$row = result->fetch_assoc();
			$_SESSION["user"]=array("user_name"=>$row["user_name"], "first_name"=>$row["first_name"], "last_name"=>$row["last_name"], "id_user"=>$row["id_user"]);
			echo json_encode(array("state"=>"ok", "user_data"=>$_SESSION["user"]));
		} else{
			echo json_encode(array("state"=>"error", "message"=>"Zlé prihlasovacie meno alebo heslo."));
		}
	} else{
		echo json_encode(array("state"=>"error", "message"=>"SQL query error."));
	}
} else{
	echo json_encode(array("state"=>"error", "message"=>"Nepodarilo sa pripojiť k databáze alebo chýbajú prihlasovacie údaje."));
}
?>