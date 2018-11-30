<?php
class db
{
	protected $db;
	public $request;
	public $result;
	public function __construct(){
		try
		{
<<<<<<< HEAD
			$this->db = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8','root','');
=======
			$this->db = new PDO('mysql:host=127.0.0.1;dbname=common-database;charset=utf8','root','');
>>>>>>> d7ced2b7bf72bbf085b638264f35258bc7a41b99
			if(!isset($_SESSION)){
				session_start();
			}
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	}
}
class tweet extends db
{
	public function profil(){
		$this->request = $this->db->prepare("SELECT login, avatar FROM users WHERE id=".$_SESSION['id_user']);
		$this->request->execute();
		$this->result = $this->request->fetch();
		return $this->result;
	}
	public function tweeter(){

		$this->request = $this->db->prepare("SELECT follows FROM users WHERE id=".$_SESSION['id_user']);
		$this->request->execute();
		$this->follows = explode(";",$this->request->fetch()['follows']);
		$this->content = "";
		foreach($this->follows as $this->val){
			$this->request = $this->db->prepare("SELECT tweets.id as id,picture,content,member_id,date,login,avatar,reply_tweet_id,retweet_tweet_id FROM tweets LEFT JOIN users on member_id=users.id WHERE member_id='".$this->val."' || member_id='".$_SESSION['id_user']."' ORDER BY date DESC");
			$this->request->execute();
			while($this->result = $this->request->fetch()){
				if($this->result['reply_tweet_id'] == '' && $this->result['retweet_tweet_id'] == ''){
					if($this->result['picture'] == '')
					{
						$this->content = $this->content . '<div class="tweet"><h5>'.htmlspecialchars($this->result['login']).' a tweeté</h5><div id="content"><p>'.htmlspecialchars($this->result['content']).'</p></div></div><form class="reply" action="controler/controleracceuil.php" method="post" enctype="multipart/form-data"><input type="text" placeholder="Répondez-lui!" maxlength="140" name="replytweet" onKeyPress="if(event.keyCode == 13) validerForm();"><input type="hidden" name="id_tweet" value="'.$this->result['id'].'">
						<input type="file" name="tweetimg"></form>';
					}
					else
					{
						$this->content = $this->content . '<div class="tweet"><h5>'.htmlspecialchars($this->result['login']).' a tweeté</h5><div id="content"><p>'.htmlspecialchars($this->result['content']).'</p><img src="img/'.$this->result['login'].'/'.$this->result['picture'].'"> </div></div><form action="controler/controleracceuil.php" method="post" class="reply" enctype="multipart/form-data"><input type="text" maxlength="140" placeholder="Répondez-lui!" name="replytweet" onKeyPress="if(event.keyCode == 13) validerForm();"><input type="hidden" name="id_tweet" value="'.$this->result['id'].'">
						<input type="file" name="tweetimg"></form>';
					}
				}
				elseif($this->result['reply_tweet_id'] != '' && $this->result['retweet_tweet_id'] == ''){
					if($this->result['picture'] == '')
					{
						$this->content = $this->content . '<div class="retweet"><h5>'.htmlspecialchars($this->result['login']).' a repondu au tweet</h5>'.htmlspecialchars($this->result['content']).'</div><form action="controler/controleracceuil.php" method="post" enctype="multipart/form-data"><input type="text" maxlength="140" name="replytweet" onKeyPress="if(event.keyCode == 13) validerForm();"><input type="hidden" name="id_tweet" value="'.$this->result['id'].'">
						<input type="file" name="tweetimg"></form>';
					}
					else
					{
						$this->content = $this->content . '<div class="retweet"><h5>'.htmlspecialchars($this->result['login']).' a repondu au tweet</h5>'.htmlspecialchars($this->result['content']).'<img src="img/'.$this->result['login'].'/'.$this->result['picture'].'" </div><form action="controler/controleracceuil.php" method="post" enctype="multipart/form-data"><input type="text" maxlength="140" name="replytweet" onKeyPress="if(event.keyCode == 13) validerForm();"><input type="hidden" name="id_tweet" value="'.$this->result['id'].'">
						<input type="file" name="tweetimg"></form>';
					}
				}
				elseif($this->result['reply_tweet_id'] == '' && $this->result['retweet_tweet_id'] != ''){
					if($this->result['picture'] == '')
					{
						$this->content = $this->content . '<div class="retweet"><h5>'.htmlspecialchars($this->result['login']).' a retweet</h5>'.htmlspecialchars($this->result['content']).'</div><form action="controler/controleracceuil.php" method="post" enctype="multipart/form-data"><input type="text" maxlength="140" name="replytweet" onKeyPress="if(event.keyCode == 13) validerForm();"><input type="hidden" name="id_tweet" value="'.$this->result['id'].'">
						<input type="file" name="tweetimg"></form>';
					}
					else
					{
						$this->content = $this->content . '<div class="retweet"><h5>'.htmlspecialchars($this->result['login']).' a retweet</h5>'.htmlspecialchars($this->result['content']).'<img src="img/'.$this->result['login'].'/'.$this->result['picture'].'" </div><form action="controler/controleracceuil.php" method="post" enctype="multipart/form-data"><input type="text" maxlength="140" name="replytweet" onKeyPress="if(event.keyCode == 13) validerForm();"><input type="hidden" name="id_tweet" value="'.$this->result['id'].'">
						<input type="file" name="tweetimg"></form>';
					}
				}
			}
		}
		return $this->content;
	}
public function send(){
	$this->content = $_POST['tweet'];
	$this->explode = explode(' ',$this->content);
	$this->hashtags = '';
	$this->mentions = '';
	foreach ($this->explode as $value) {
		if($value[0] == '#'){
			$this->hashtags = $this->hashtags . $value;
		}
		elseif ($value[0] == '@'){
			$this->request = $this->db->prepare("SELECT follows FROM users WHERE id=".$_SESSION['id_user']);
			$this->request->execute();
			$this->follows = explode(';',$this->request->fetch()['follows']);
			foreach ($this->follows as $val) {
				$this->pseudo = explode('@',$value);
				$this->request = $this->db->prepare("SELECT id FROM users WHERE login='".$this->pseudo[1]."'");
				$this->request->execute();
				if($this->request->fetch()['id'] == $val)
				{
					$this->mentions = $this->mentions . $value;
				}
			}
		}
	}

	$this->id = $_SESSION['id_user'];
	if(preg_match('/image/', $_FILES['tweetimg']['type'])){

		$this->picture = $_FILES['tweetimg']['name'];
		$this->request = $this->db->prepare("INSERT INTO tweets(date,content,member_id,hashtags,mentions,picture) VALUES (NOW(),'$this->content','$this->id','$this->hashtags','$this->mentions','".$this->picture."')");
		$this->request->execute();
		if(!file_exists($_SESSION['pseudo'])){
			mkdir('../img/'.$_SESSION['pseudo']);
		}
		move_uploaded_file($_FILES['tweetimg']['tmp_name'], '../img/'.$_SESSION['pseudo']."/".$this->picture);
	}
	else{
		$this->request = $this->db->prepare("INSERT INTO tweets(date,content,member_id,hashtags,mentions) VALUES (NOW(),'$this->content','$this->id','$this->hashtags','$this->mentions')");
		$this->request->execute();
	}
}

}
?>