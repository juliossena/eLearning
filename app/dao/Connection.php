<?php

class Connection {
    private $usuario = "root";
	private $senha = "";
	private $host = "localhost";
	private $db = "site";
	
	/*
	private $usuario = "tinnitusperu";
    private $senha = "S1stem@M";
    private $host = "198.57.158.150";
    private $db = "tinnitus_web17db";
	*/

	private function connect(){
		$conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->usuario, $this->senha);
		return $conn;
	}
	
	public function runQuery($sql){
//	    echo $sql . "<br>";
		$stm = $this->connect()->prepare($sql);
		return $stm->execute();
	}
	
	public function runSelect($sql) {
 		echo $sql . "<br>";
		$stm = $this->connect()->prepare($sql);
		$stm->execute();
		return $stm->fetchAll(PDO::FETCH_ASSOC);
	}
}