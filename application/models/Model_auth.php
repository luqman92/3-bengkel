<?php

class Model_auth extends CI_Model{

	function login($username,$pass){
		$check = $this->db->get_where('user',array('username'=>$username,'pass'=>$pass));
		if($check->num_rows()>0){
			return 1;
		}else{
			return 0;
		}
	}

	public function cek_user($data) {
			$query = $this->db->get_where('user', $data);
			return $query;
	}
}