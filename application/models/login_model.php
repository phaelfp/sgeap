<?php

class login_model extends CI_Model{
	function verfica_login($username,$password){
		$sql = "SELECT p.nome, p.login 
			FROM Pessoa p
			WHERE p.login='".$this->db->escape_str($username)."' AND 
				p.pass = '".$this->db->escape_str(sha1($password))."'";
        
		$query = $this->db->query($sql);
		return $query->row();
	}

	
}
