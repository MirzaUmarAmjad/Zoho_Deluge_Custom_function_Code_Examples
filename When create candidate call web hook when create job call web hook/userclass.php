<?php

include 'dbconn.php';

class user extends db
{
	private $candidateID;
	private $email;
	private $skillSet;
	
	function register($t_candidateID,$t_email,$t_skillSet){
		$this->candidateID = $t_candidateID;
		$this->email = $t_email;
		$this->skillSet = $t_skillSet;

		$query= "select * from candidate where email='$t_email'";
		$user_obj = $this->conn->query($query);

		if($user_obj->rowCount()==0){

				$_q ="insert into candidate (candidateID, email , skillSte) values ('$this->candidateID', '$this->email', '$this->skillSet')";
				$this->conn->exec($_q) ;
	    }
	    else 
	    {}
}



function getData(){

		$_q ="select * from candidate";
		$stmt = $this->conn->prepare($_q);
		$stmt->execute();

		return $stmt;
}

	    	

	
}



?>