<?php 
class formc{
public function formconnect(){
		return '
		<div id="connect">
		<form method="post" action="index.php" class="form">
		<p>Pseudo</p>
		<input type="text" name="login">
		<p>Mot de passe</p>
		<input type="password" name="passwd">
		<input type="submit" name="values" id="button" value="Se connecter">
		</form>
		</div>';
	}
}
$formc = new formc();
echo $formc->formconnect();
?>