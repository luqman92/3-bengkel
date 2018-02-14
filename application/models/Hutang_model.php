<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hutang_model extends CI_Model {

	var $table = 'pmb_sparepart';
	var $column_order = array('no_pmb','supplier','tgl','tgl_tempo','Total',null); //set column field database for datatable orderable
	var $column_search = array('no_pmb','supplier','tgl','tgl_tempo','Total'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('a.no_pmb' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		/*SELECT
a.no_pmb,
a.no_sj,
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
SUM(b.total)
FROM
pmb_sparepart AS a
LEFT JOIN sparepart_pmb AS b ON b.no_pmb = a.no_pmb
WHERE a.cara ='HUTANG'
GROUP BY a.no_pmb*/
			$this->db->select('a.no_pmb,a.no_sj,a.supplier,a.tgl,a.tgl_tempo,a.cara,a.keterangan,a.ppn,a.diskon,a.post,a.ket_cara,a.tgl_lunas,SUM(b.total)AS Total');
			$this->db->from($this->table.' AS a');
			$this->db->join('sparepart_pmb AS b', 'a.no_pmb=b.no_pmb','left');
			$this->db->where('ket_cara','HUTANG');
			$this->db->group_by('a.no_pmb');
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

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
			$this->db->from($this->table);
			return $this->db->count_all_results();
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
    function getKodeBrg(){
        $q = $this->db->query("select MAX(RIGHT(KodeBarang,6)) as kd_max from masterbarang WHERE KodeBarang != 'JST'
	AND KodeBarang != 'JSV'");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%07s", $tmp);
            }
        }else{
            $kd = "00000001";
        }
        return "BRG".$kd;
    }


}
