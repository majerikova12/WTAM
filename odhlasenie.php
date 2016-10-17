<?php
session_start();
if (!isset($_SESSION["user"])){
	echo json_encode(array("state"=>"error", "message"=>"Nebol si prihlásený."));
} else{
	unset($_SESSION["user"]);
	echo json_encode(array("state"=>"ok"));
}
?>

<!-- komentar pre mata a zuzkis -->

