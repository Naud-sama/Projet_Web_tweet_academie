<?php
if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION['id_user'])){
	if(isset($_POST['tweet'])){
		include '../view/viewacceuil.php';
		include '../model/modelacceuil.php';
		$tweeter = new tweet();
		$tweeter->send();
		header("Location: ../index.php");
	}
	else{
		include 'view/viewacceuil.php';
		include 'model/modelacceuil.php';
		$tweet = new tweeter();
		$tweeter = new tweet();
		$tweet->header($tweeter->profil());
		echo $tweet->formtweet();		
		echo $tweeter->tweeter();
	}
}
else{
	echo '<div class="error">Vous n\'avez pas acces a cette page</div>';
}
?>