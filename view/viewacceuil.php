<?php
class tweeter{
	public function header($avatar){
		 $this->avatar = $avatar['avatar'];
			echo "<div id='header'>
				<a id='home' href='index.php'>Home</a>
				<input type='text' placeholder='Rechercher un tweet...'>
				<img src='img/logo.png' id='logo' alt='logo'>
			</div>";
		
	}
	public function formtweet(){
		return '<div id="tweet">
		<form action="controler/controleracceuil.php" method="post" enctype="multipart/form-data">
					<input type="text" placeholder="Que voulez-vous dire ?" id="tweetzone" maxlength="140" name="tweet" onKeyPress="if(event.keyCode == 13) validerForm();">
					<input type="file" name="tweetimg" id="tweetimg">
				</form>
				<script>function validerForm(){
    				document.getElementById("formulaire").submit();
				}</script>
				</div>';
	}
}

?>