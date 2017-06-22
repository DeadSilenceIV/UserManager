<?php
require 'Mysql.php';
class UserManager extends Mysql
{
	
	function __construct($host_name,$db_name,$user,$contraseña)
	{
		parent::__construct($host_name,$db_name,$user,$contraseña);
	}

	public function createUser($username,$password){
		$this->execStatementSetter("INSERT INTO users (id,user,pass) VALUES(null,:usuario,:pass)",array(':usuario'=>$username,':pass'=>$password));
	}
	public function validateUser($username,$password){
		$resultados = $this->execStatementGetter('SELECT * FROM users WHERE user = :usuario AND pass = :password',array(':usuario' => $username,':password' => $password),false);
		if ($resultados !== false) {
			return true;
		}else{
			return false;
		}
	}
	public function existsUser($username){
		$resultados = $this->execStatementGetter("SELECT * FROM users WHERE user = :usuario LIMIT 1",array(':usuario' => $username),false);
		if($resultados != false){
			return true;
		}else{
			return false;
		}
	}
}

?>