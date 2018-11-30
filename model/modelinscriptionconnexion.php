<?php
class db
{
	protected $db;
	public $request;
	public $result;
	public function __construct(){
		try
	{

	    $this->db = new PDO('mysql:host=127.0.0.1;dbname=common-database;charset=utf8','root','');
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
		shell_exec("chmod 777 img");
		$this->request = $this->db->prepare("
        ALTER TABLE users 
        ADD birthdate VARCHAR(10) NOT NULL,
        ADD token VARCHAR(255) NOT NULL,
        ADD confirm int(11) NOT NULL DEFAULT 0;
        ");
        $this->request->execute();
	}
}
class register extends db{
	public $lastname;
	public $firstname;
	public $pseudo;
	private $passwd;
	private $confirmpasswd;
	public $birthdate;
	public $location;
	public $email;
	public $token;
	public $age;
	public $form;
	public $i;
	public function registers(){
		$this->lastname = $_POST['lastname'];
		$this->firstname = $_POST['firstname'];
		$this->pseudo = $_POST['pseudo'];
		$this->passwd = hash_hmac("ripemd160",$_POST['passwd'], "si tu aimes la wac tape dans tes mains");
		$this->confirmpasswd = hash_hmac("ripemd160",$_POST['confirmpasswd'], "si tu aimes la wac tape dans tes mains");
		$this->birthdate = $_POST['birthdatem'] . '/' . $_POST['birthdated'] . '/' .$_POST['birthdatey'];
		$this->age = floor((time() - strtotime($_POST['birthdatem'] . '/' . $_POST['birthdated'] . '/' .$_POST['birthdatey'])) / 3600 / 24 / 365);
		$this->email = $_POST['email'];	
		if($this->age > 12)
		{
			if($this->passwd == $this->confirmpasswd)
			{

				$this->token = str_shuffle('qwertyuiopasdfghjklzxcvbnm0123654789');
				$this->request = $this->db->prepare("SELECT id FROM users WHERE login=:pseudo OR email=:email");
				$this->request->execute(array('pseudo' => $this->pseudo,'email' => $this->email));
				if ($this->request->fetch() == array()) {
					$this->request = $this->db->prepare("INSERT INTO users(lastname,firstname,login,password,email,birthdate,avatar,token,register_date) VALUES ('$this->lastname','$this->firstname','$this->pseudo',:passwd,'$this->email', '$this->birthdate','avatar".rand(1, 10).".png','$this->token',NOW())");
					$this->request->execute(array('passwd' => $this->passwd));
					require_once 'vendor/autoload.php';
					$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465	 , 'ssl'))
					->setUsername('mymeeticadmi@gmail.com')
					->setPassword('Dark56489');
					$mailer = new Swift_Mailer($transport);

					$message = (new Swift_Message('activate account'))
					->setFrom(['michel.girard@epitech.eu' => 'my meetic activate'])
					->setTo([$this->email])
					->setBody('<a href="localhost/index.php?token='.$this->token.'">activer</a>' ,'text/html');
					$result = $mailer->send($message);
					return '<div class=""> Un mail de confirmation a ete envoye a l\'adresse suivante :' . $this->email . '</div>';
				}
				else{
					return 'email ou pseudo deja utilisé.';
				}
			}
			else{
				return 'Les mots de passe ne sont pas identiques.';
			}
		}
		else{
			return 'Vous devez avoir 13ans pour vous inscrire.';
		}
	}
}
class connect extends db
{
	public $pseudo;
	private $passwd;
	public function connection(){
		$this->pseudo = $_POST['login'];
		$this->passwd = hash_hmac("ripemd160",$_POST['passwd'], "si tu aimes la wac tape dans tes mains");
		$this->request = $this->db->prepare("SELECT login,id,confirm FROM users WHERE (login=:pseudo AND password=:passwd)");
		$this->request->execute(array('pseudo' => $this->pseudo,'passwd' => $this->passwd));
		if ($this->result = $this->request->fetch()) {
			if($this->result['confirm'] != 1){
				if($this->result['confirm'] == 0){
					return 'Veuillez confirmer votre compte.';
				}
				else{
					return 'Votre compte a été supprimer.';
				}
			}
			else{
				$_SESSION['pseudo'] = $this->result['login'];
				$_SESSION['id_user'] = $this->result['id'];
				header("Location: index.php");
				return 'connecter';
			}
		}
		else{
			return 'couple login/mot de passe incorrecte.';
		}
	}
}
class mail extends db{
	function confirmmail(){
		$this->request = $this->db->prepare("SELECT confirm FROM users WHERE token='". $_GET['token'] ."'");
		$this->request->execute();
		if($this->request->fetch()['confirm'] != 1){
			$this->request = $this->db->prepare("UPDATE users SET confirm=1 WHERE token='". $_GET['token'] ."'");
			$this->request->execute();
			return 'Confirmation réussite!';
		}
		else{
			return 'Votre compte a déjà été activé!';
		}
	}
}