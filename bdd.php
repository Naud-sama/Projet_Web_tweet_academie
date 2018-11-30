<?php
class db
{
	protected $db;
	public $request;
	public function __construct(){
		shell_exec("chmod 777 img");
		$this->db = new PDO('mysql:host=localhost;dbname=tweet_academy;charset=utf8','root','');
		$this->request = $this->db->prepare("
        ALTER TABLE users 
        ADD birthday VARCHAR(10) NOT NULL,
        ADD gender VARCHAR(10) NOT NULL,
        ADD country VARCHAR(255) NOT NULL,
        ADD token VARCHAR(32) NOT NULL,
        ADD confirm int(11) NOT NULL DEFAULT 0;
        ");
        $this->request->execute();
	}
}
session_start();
?>