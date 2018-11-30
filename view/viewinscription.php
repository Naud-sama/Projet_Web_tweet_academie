<?php
class form {
public function formregister() {
			$this->i = 0;
		$this->form = '
		<img id="logo" src="img/logo.png" alt="logo">
		<div id="regi">
			<div class="inscri">
				<h1> Inscrivez-vous! </h1>
			</div>
			<a href="#connect">Déjà inscrit ? connectez-vous!</a>
			<form class="form" method="post" action="index.php">
				<div class="form-row">
					<div class="clod-sm-6">
						<p>Nom</p>
						<input type="text" name="lastname" required>
					</div>
					<div class="clod-sm-6">
						<p>Prenom</p>
							<input type="text" name="firstname" required>
					</div>
				</div>
				<div class="form-row">
					<div class="clod-sm-6">
						<p>Pseudo</p>
						<input type="text" name="pseudo" maxlength="10" required>
					</div>
				</div>
				<div class="form-row">
					<div class="clod-sm-6">
						<p>Mot de Passe</p>
						<input type="password" name="passwd" minlength="8" maxlength="16" required>
					</div>
					<div class="clod-sm-6">
						<p>Confirmer mot de passe</p>
						<input type="password" name="confirmpasswd" required>
					</div>
				</div>
			<div class="form-row">
				<div class="clod-sm-6">
					<p>Email</p>
					<input type="email" name="email" class="form-control" required>
				</div>
			</div>
			<div class="form-row">
				<p>Date de naissance</p>
					<select name="birthdated" id="day" class="form-control-sm">
					</select><select name="birthdatem" id="month" class="form-control-sm">';
		while($this->i < 12){
			$this->form = $this->form . '<option>' . ++$this->i .'</option>';
		}
		 $this->form = $this->form .'</select><select name="birthdatey" id="year" class="form-control-sm">
		 </select>
		</div><div class="form-row">
		<br>
		<div class="clod-sm-6">
		<label><input type="radio" name="gender" value="1" checked>Homme</label>
		<label><input type="radio" name="gender" value="0">Femme</label>
		</div>
		<button class="button" id="connect">S\'inscrire</button>
		</form>
		</div>
				</div>
		<div class="inscri">
		<h1>Se connecter</h1>
		</div>
		<script src="script.js"></script>
		</div>
		</form>
		</div>
		<script src="public/script.js"></script>
		';
		return $this->form;
	}
}
$form = new form();
echo $form->formregister();
?>