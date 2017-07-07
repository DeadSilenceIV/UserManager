<?php
		
	class Mysql 
	{
		protected $conexion;
		private $usuario;
		private $password;
		private $dbname;
		private $hostname;
		function __construct($host_name,$db_name,$user,$contraseña){
			$this->hostname = $host_name;
			$this->dbname = $db_name;
			$this->usuario = $user;
			$this->password = $contraseña;
			try{
				$this->conexion = new PDO('mysql:hostname='.$this->hostname,$this->usuario,$this->password);
			}catch(PDOException $e){
				echo $e->getMessage();
				die();
			}
			$this->setupDatabase();
		}
		public function execStatementSetter($stm,$placeholders){
			$statement = $this->conexion->prepare($stm);
			if($placeholders != false){
				$statement->execute($placeholders);
			}else{
    			$statement->execute();
    		}
		}
		public function execStatementGetter($stm,$placeholders,$fetchall){
			$statement = $this->conexion->prepare($stm);
			if($placeholders != false){
				$statement->execute($placeholders);
			}else{
    			$statement->execute();
    		}
    		if($fetchall == true){
    			$resultado = $statement->fetchAll();
    		}else{
    			$resultado = $statement->fetch();
    		}
    		return $resultado;
		}
		private function setupDatabase(){
			$stm = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$this->dbname'";
			$statement = $this->conexion->prepare($stm);
    		$statement->execute();
			if(((bool) $statement->fetchColumn()) == false){
				$this->execStatementSetter("CREATE DATABASE IF NOT EXISTS $this->dbname",false);
			}
			try{
				$this->conexion = new PDO('mysql:hostname='.$this->hostname.';dbname='.$this->dbname,$this->usuario,$this->password);
			}catch(PDOException $e){
				echo $e->getMessage();
				die();
			}
			$this->execStatementSetter("CREATE TABLE IF NOT EXISTS users(id INT AUTO_INCREMENT,user varchar(50),pass varchar(250),PRIMARY KEY (id))",false);
		}
	}

?>
