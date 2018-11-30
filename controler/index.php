<?php
session_start();
include '../view/templateheader.php';
class affichage{
	public function __construct(){
		if(!isset($_SESSION['id_user'])){
			include '../model/modelinscriptionconnexion.php';
			$regi = new register();
			$connect = new connect();
			$mail = new mail();
			if(isset($_POST['confirmpasswd'])){
				echo $regi->registers();
			}
			if(isset($_POST['login'])){
				echo $connect->connection();
			}
			if(isset($_GET['token']))
			{
				echo $mail->confirmmail();
			}
			include '../view/viewinscription.php';
			include '../view/viewconnect.php';
		}
		else{
			if(isset($_GET['p'])){
				switch ($_GET['p']) {
					case 'acceuil':
					include '../controler/controleracceuil.php';
					break;
					case 1:
					echo "i égal 1";
					break;
					case 2:
					echo "i égal 2";
					break;
					default:
					header("Location: index.php");
				}
			}
			else{
				include '../controler/controleracceuil.php';
			}
		}
	}
}
$affich = new affichage();
?>