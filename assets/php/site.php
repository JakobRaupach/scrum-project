<?php
session_start();

$controller = $_GET["controller"];

include_once("inc.php");


switch ($controller) {
	case "balance":
		BalanceController();
		break;
	case "user":
		UserController();
		break;
	case "authorization":
		AuthorizationController();
		break;
}

// controller

function BalanceController(){
	global $conn;
	$userId = $_SESSION["user-id"];

	$sql = "SELECT Kontostand FROM User WHERE UserID = $userId";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		$balance = $row["Kontostand"];

		$sql = "SELECT Datum, Betrag, Typ FROM PaymentHistory WHERE UserID = $userId ORDER BY Datum DESC LIMIT 3";
		$result = mysqli_query($conn, $sql);

		$history = [];
		
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$payment = ["date"=>$row["Datum"], "amount"=>$row["Betrag"], "type"=>$row["Typ"]];
				$history[] = $payment; 
			}
			$data = ["balance"=>$balance, "history"=>$history];
			echo json_encode($data);
		}
		else{
			$data = ["balance"=>$balance];
			echo json_encode($data);
		}
	}
}

function UserController(){
	global $conn;
	$userId = $_SESSION["user-id"];

	$sql = "SELECT Username, Profilbild FROM User WHERE UserID=$userId";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		$username = $row["Username"];
		$imagedb = $row["Profilbild"];
		if ($imagedb == null){
			$image = null;
		}
		else{
			$image = base64_encode($imagedb);
		}

		$array = ["username"=>$username, "img"=>$image];

		echo json_encode($array);
	}

	// Falls Profilbilder eingebaut werden sollen müssen sie in dieser Funktion noch ergänzt werden 
}

function AuthorizationController(){
	$userId = $_SESSION['user-id'];

	if ($userId == 0 || $userId == null){
		echo false;
	}
	else{
		echo true;
	}
}