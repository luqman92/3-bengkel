<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmb_model extends CI_Model {

	var $table = 'pmb_sparepart';
	var $column_order = array('kode','diskripsi','qty','harga',null); //set column field database for datatable orderable
	var $column_search = array('kode','diskripsi','qty'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('a.tgl' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($id="")
	{
		
		/*if($id=='CBG-000001'){
			$this->db->select('*');
			$this->db->from($this->table);
		}else{
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('cabang_id', $id);
		}*/
		/*SELECT
	a.no_pmb,
	a.no_sj,
	a.SupplierId,
	a.supplier,
	a.tgl,
	a.tgl_tempo,
	a.cara,
	a.keterangan,
	a.ppn,
	a.diskon,
	a.post,
	a.ket_cara,
	a.tgl_lunas,
	a.cabang_id,
	b.nama 
FROM
	pmb_sparepart AS a
	INNER JOIN supplier AS b ON a.SupplierId = b.supplier_id*/
		if($id==''){
			$this->db->select('a.no_pmb,a.no_sj,a.SupplierId,a.supplier,a.tgl,a.tgl_tempo,a.cara,a.keterangan,a.ppn,a.diskon,a.post,a.ket_cara,a.tgl_lunas,a.cabang_id,b.nama,a.status');
			$this->db->from($this->table.' AS a');
			$this->db->join('supplier AS b', 'b.supplier_id=a.SupplierId');
        }else{
        	$this->db->select('a.no_pmb,a.no_sj,a.SupplierId,a.supplier,a.tgl,a.tgl_tempo,a.cara,a.keterangan,a.ppn,a.diskon,a.post,a.ket_cara,a.tgl_lunas,a.cabang_id,b.nama,a.status');
			$this->db->from($this->table.' AS a');
			$this->db->join('supplier AS b', 'b.supplier_id=a.SupplierId');
			$this->db->where('a.cabang_id', $id);
        }
		//$this->db->simple_query('SELECT * FROM '.$this->table);
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($id="")
	{
		$this->_get_datatables_query($id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id="")
	{
		$this->_get_datatables_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id="")
	{
		if($id==''){
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}else{
			$this->db->from($this->table.' AS a');
			$this->db->join('pmb_sparepart AS b', 'b.no_pmb=a.no_pmb');
			$this->db->where('b.cabang_id',$id);
			return $this->db->count_all_results();
		}

		/*if($id==''){
			$this->db->select('a.kode,a.diskripsi,a.qty,a.harga,a.key_id,a.total,b.supplier,b.tgl');
			$this->db->from($this->table.' AS a');
			$this->db->join('pmb_sparepart AS b', 'b.no_pmb=a.no_pmb');
        }else{
        	$this->db->select('a.kode,a.diskripsi,a.qty,a.harga,a.key_id,a.total,b.supplier,b.tgl');
			$this->db->from($this->table.' AS a');
			$this->db->join('pmb_sparepart AS b', 'b.no_pmb=a.no_pmb');
			$this->db->where('b.cabang_id', $id);
        }*/
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('no_pmb',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	function create_data($data,$table){
		$this->db->insert($table,$data);
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('no_pmb', $id);
		$this->db->delete($this->table);
	}

	// KODE BARANG
    function getKodeCabang(){
        $q = $this->db->query("select MAX(RIGHT(cabang_id,6)) as kd_max from cabang");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return "CBG-".$kd;
    }


}
