<?php

class Model_admin extends CI_Model{

	function create_data($data,$table){
		$this->db->insert($table,$data);
	}

	function read_data($table){
		return $this->db->get($table);
	}

	function edit_data($where,$table){		
	return $this->db->get_where($table,$where);
	}

	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

	function del_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}	
	function manualQuery($q)
    {
        return $this->db->query($q);
    }

    function create_datas()
    {
    	$this->db->set('field', 'field+1', FALSE);
		$this->db->insert('mytable');
		// gives INSERT INTO mytable (field) VALUES (field+1)
    }
}