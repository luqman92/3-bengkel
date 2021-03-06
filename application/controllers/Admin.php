<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
        parent::__construct();
        if ($this->session->userdata('username')=="") {
			redirect('login');
		}

		/*if($this->session->userdata('USERNAME') != TRUE && $this->session->userdata('PASS') != TRUE){
            redirect('login');
        };*/
		$this->load->model('Model_admin');
		$this->load->helper('format');
		$this->load->model('Model_trxbengkel','trx');
		$this->load->model('Cabang_model','cbg');
		$this->load->model('Customer_model','cstm');
		$this->load->model('Kunjungan_model','kjg');
		$this->load->model('PMB_model','pmb');
		$this->load->model('Masterbarang_model','mb');
		$this->load->model('Transaksi_model','trxl');
		$this->load->model('Mutasibarang_model','mtb');
		$this->load->model('Stokbrg_model','stk');
		$this->load->model('Supplier_model','spp');
		$this->load->model('Hutang_model','htg');
		$this->load->model('Karyawan_model','kar');
		$this->load->model('Jabatan_model','jbt');
		$this->load->model('User_model','usr');
		$this->load->model('Bopersional_model','bo');
		
        //$this->load->library('My_PHPMailer');

		
    }
	
	public function index()
	{
		/*$article = $this->Model_admin->manualQuery("SELECT count(id_article) AS jml FROM article WHERE active='Y'")->result();
		$program = $this->Model_admin->manualQuery("SELECT count(id_album) AS jml FROM album_vod")->result();
		$label = $this->Model_admin->manualQuery("SELECT count(id_label) AS jml FROM label")->result();
		$kolumnis = $this->Model_admin->manualQuery("SELECT count(iduser) AS jml FROM user WHERE level='2'")->result();
		*/
		$currdate = date('Y-m-d');
		$trxbengkel = $this->Model_admin->manualQuery("SELECT count(id) AS jml FROM transaksi WHERE tgl=now()")->result();
		$customer = $this->Model_admin->manualQuery("SELECT count(customer_id) AS jml FROM customer WHERE status='normal'")->result();
		$karyawan = $this->Model_admin->manualQuery("SELECT count(karyawan_id) AS jml FROM karyawan")->result();
		$user = $this->Model_admin->manualQuery("SELECT count(iduser) AS jml FROM user")->result();

		$laba_servis = $this->Model_admin->manualQuery("SELECT
															a.tgl_lunas,
															SUM( b.total ) AS tlaba_servis 
														FROM
															transaksi AS a
															LEFT JOIN detil_transaksi AS b ON a.id = b.id 
														WHERE
															a.tgl_lunas = '".$currdate."'
														AND
															b.jenis='SERVIS'
														AND
															a.status='final'")->result();
		$laba_sparepart = $this->Model_admin->manualQuery("SELECT
																a.tgl_lunas,
																SUM( b.total ) AS tlaba_part 
															FROM
																transaksi AS a
																LEFT JOIN detil_transaksi AS b ON a.id = b.id 
															WHERE
																a.tgl_lunas = '".$currdate."'
															AND
																b.jenis='PART'
															AND
																a.status='final'")->result();
		$modal_part = $this->Model_admin->manualQuery("SELECT
															a.tgl_lunas,
															b.jenis,
															SUM( b.harga_beli ) AS TModalPart 
														FROM
															transaksi AS a
															LEFT JOIN detil_transaksi AS b ON a.id = b.id 
														WHERE
															a.tgl_lunas = '".$currdate."' 
														AND 
															b.jenis = 'PART'
														AND
															a.status='final'")->result();
		$omzet = $this->Model_admin->manualQuery("SELECT
													a.tgl_lunas,
													SUM( b.total ) AS TOmzet 
												FROM
													transaksi AS a
													LEFT JOIN detil_transaksi AS b ON a.id = b.id 
												WHERE
													a.tgl_lunas = '".$currdate."'
												AND
													a.status='final'")->result();
		$unit = $this->Model_admin->manualQuery("SELECT
													a.tgl_lunas,count( a.nopol ) AS Unit 
												FROM
													`transaksi` AS a 
												WHERE
													tgl_lunas = '".$currdate."'
												AND
													a.status='final'")->result();
		//$FormatAngka = $this->Model_admin->format_angka();
		$data = array(
			'trxbengkels' => $trxbengkel,
			'customers' => $customer,
			'karyawans' => $karyawan,
			'users' => $user,
			'laba_servis' => $laba_servis,
			'laba_sparepart' => $laba_sparepart,
			'modal_part' => $modal_part,
			'omzet' => $omzet,
			'unit' => $unit,
			//'FormatAngka' => $FormatAngka,
			);
		 $this->template_admin->load('template_admin','Moduls/home',$data);
	}
/*
----------------------------------------------------MASTER DATA----------------------------------------------------
*/
	public function merkmotor()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['merks'] = $this->Model_admin->manualQuery('SELECT * FROM merkmotor')->result();
		$this->template_admin->load('template_admin','Moduls/merkmotor/index',$data);
	}

	public function addmerk()
	{
		$this->template_admin->load('template_admin','Moduls/merkmotor/add');
	}
    function act_addmerk(){
    	$kode = $this->input->post('kode');
    	$merk_motor = $this->input->post('merk_motor');
    	$keterangan = $this->input->post('keterangan');
    	$date = date('Y-m-d H:i:s');

    	$data = array(
			'kode' => $kode,
			'merk_motor' => $merk_motor,
			'keterangan' => $keterangan,
			'created_at' => $date,
			);
		$this->Model_admin->create_data($data,'merkmotor');
		redirect('admin/merkmotor');
    }

    function editmerk($id){
    	$where = array('merk_id'=>$id);
    	$data['merks'] = $this->Model_admin->edit_data($where,'merkmotor')->result();

    	$this->template_admin->load('template_admin','Moduls/merkmotor/edit',$data);
    }
    function act_editmerk(){
    	/*echo "<pre>";
    		print_r($_POST);
    	echo "</pre>";*/

    	$date = date('Y-m-d H:i:s');

		$merk_id = $this->input->post('merk_id');
		$merk_motor = $this->input->post('merk_motor');
    	
    	$data = array(
    		'merk_id' => $merk_id,
			'merk_motor' => $merk_motor,
			'update_at' => $date,
			);

		$where = array(
			'merk_id' => $merk_id
		);

		$this->Model_admin->update_data($where,$data,'merkmotor');
		redirect('admin/merkmotor');
	}

    function delmerk($id){
    	$where = array('merk_id'=>$id);
    	
    	$this->Model_admin->del_data($where,'merkmotor');
		redirect('admin/merkmotor');
    }

		public function groupsparepart()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['gspareparts'] = $this->Model_admin->manualQuery('SELECT * FROM groupsparepart')->result();
		$this->template_admin->load('template_admin','Moduls/groupsparepart/index',$data);
	}

		public function suplier()
	{
		$data['kotas'] = $this->Model_admin->manualQuery('SELECT * FROM kota')->result();
		$this->template_admin->load('template_admin','Moduls/supplier/index',$data);
	}

	/*AJAX Supplier*/
	public function ajax_list_suplier()
    {
    	$cbg = $this->session->userdata('cabang');
    	$list = $this->spp->get_datatables($cbg);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $spp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $spp->nama;
            $row[] = $spp->alamat;
            $row[] = $spp->tlp;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_suplier('."'".$spp->supplier_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_suplier('."'".$spp->supplier_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 			
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->spp->count_all(),
                        "recordsFiltered" => $this->spp->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_suplier($id)
    {
        $data = $this->spp->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_suplier()
    {
    	$cbg = $this->session->userdata('cabang');
    	$currdate = date('Y-m-d');
    	$data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'kota_id' => $this->input->post('kota_id'),
                'tlp' => $this->input->post('tlp'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                );
        $insert = $this->spp->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_suplier()
    {
        $data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'kota_id' => $this->input->post('kota_id'),
                'tlp' => $this->input->post('tlp'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
            );
        $this->spp->update(array('supplier_id' => $this->input->post('supplier_id')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_suplier($id)
    {
    	//$this->Model_admin->update_data($where,$data,'supplier');
        $this->spp->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX Supplier*/

		public function customer()
	{
		$mtr = $this->Model_admin->manualQuery('SELECT
													a.mtr_id,
													a.kode,
													a.merk_id,
													a.tipe,
													a.jenis,
													a.cc,
													a.tahun,
													b.merk_motor 
												FROM
													motor AS a
													INNER JOIN merkmotor AS b ON a.merk_id = b.merk_id')->result();
		$data = array(
				'mtrs' => $mtr,
				); 
		$this->template_admin->load('template_admin','Moduls/customer/index',$data);
	}
	function unsetcust()
	{
		$this->session->unset_userdata('trx_id');
		redirect('admin/customer');
	}

	/*AJAX Customer*/
	public function ajax_list_customer()
    {
    	$cbg = $this->session->userdata('cabang');
    	$list = $this->cstm->get_datatables($cbg);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $cstm) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cstm->no_polisi;
            $row[] = $cstm->nama;
            $row[] = $cstm->alamat;
            $row[] = $cstm->hp;
            
            if($this->session->userdata('level')=='1'){
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_customer('."'".$cstm->customer_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a> <a class="btn btn-sm btn-primary" href="'.site_url('admin/trx_add/'.$cstm->customer_id).'" title="Transaksi"><i class="glyphicon glyphicon-shopping-cart"></i> Transaksi</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_customer('."'".$cstm->customer_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 			}else{
 				$row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('admin/trx_add/'.$cstm->customer_id).'" title="Transaksi"><i class="glyphicon glyphicon-shopping-cart"></i> Transaksi</a>';
 			}
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->cstm->count_all(),
                        "recordsFiltered" => $this->cstm->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_customer($id)
    {
        $data = $this->cstm->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_customer()
    {
    	$cbg = $this->session->userdata('cabang');
    	$currdate = date('Y-m-d');
    	$data = array(
                'no_polisi' => $this->input->post('no_polisi'),
                'nama' => $this->input->post('nama'),
                'mtr_id' => $this->input->post('tipe'),
                'alamat' => $this->input->post('alamat'),
                'hp' => $this->input->post('hp'),
                'cabang_id' => $cbg,
                'tanggal' => $currdate,
            );
        $insert = $this->cstm->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_customer()
    {
        $data = array(
                'no_polisi' => $this->input->post('no_polisi'),
                'nama' => $this->input->post('nama'),
                'mtr_id' => $this->input->post('tipe'),
                'alamat' => $this->input->post('alamat'),
                'hp' => $this->input->post('hp'),
            );
        $this->cstm->update(array('customer_id' => $this->input->post('customer_id')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_customer($id)
    {
    	$where = array(
    		'customer_id'=>$id,);
    	$data = array(
    		'status'=>'nullified',
    		);
    	$this->Model_admin->update_data($where,$data,'customer');
        //$this->cstm->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX Customer*/

		public function cabang()
	{
		$kota = $this->Model_admin->manualQuery('SELECT * FROM kota')->result();
		$data = array(
			'kdcabang' =>$this->cbg->getKodeCabang(),
			'kota'=>$kota
			);
		//$data['cabangs'] = $this->Model_admin->manualQuery('SELECT * FROM cabang')->result();
		$this->template_admin->load('template_admin','Moduls/cabang/index',$data);
	}

    /*AJAX Cabang*/
	public function ajax_list_cabang()
    {
    	$list = $this->cbg->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $cbg) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cbg->cabang_id;
            $row[] = $cbg->nama;
            $row[] = $cbg->alamat;
            $row[] = $cbg->kota;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_cabang('."'".$cbg->cabang_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_cabang('."'".$cbg->cabang_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->cbg->count_all(),
                        "recordsFiltered" => $this->cbg->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_cabang($id)
    {
        $data = $this->cbg->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_cabang()
    {
    	$data = array(
                'cabang_id' => $this->input->post('cabang_id'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'kota' => $this->input->post('kota'),
                'kodepos' => $this->input->post('kodepos'),
                'fax' => $this->input->post('fax'),
                'tlp' => $this->input->post('tlp'),
                'email' => $this->input->post('email')
            );
        
        $insert = $this->cbg->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_cabang()
    {
        $data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'kota' => $this->input->post('kota'),
                'kodepos' => $this->input->post('kodepos'),
                'fax' => $this->input->post('fax'),
                'tlp' => $this->input->post('tlp'),
                'email' => $this->input->post('email')
            );
        $this->cbg->update(array('cabang_id' => $this->input->post('cabang_id')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_cabang($id)
    {
        $this->cbg->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX Cabang*/

	public function karyawan()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$jabatan = $this->Model_admin->manualQuery('SELECT * FROM jabatan')->result();
		$data = array(
			'jabatan'=>$jabatan,
			);
		$this->template_admin->load('template_admin','Moduls/karyawan/index',$data);
	}

	/*AJAX Karyawan*/
	public function ajax_list_karyawan()
    {
    	$list = $this->kar->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kar) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $kar->noktp;
            $row[] = $kar->nama;
            $row[] = "Tlp. ".$kar->tlp." / Hp. ".$kar->hp;
            $row[] = $kar->jabatan;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_karyawan('."'".$kar->karyawan_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_karyawan('."'".$kar->karyawan_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->kar->count_all(),
                        "recordsFiltered" => $this->kar->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_karyawan($id)
    {
        $data = $this->kar->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_karyawan()
    {
    	$data = array(
                'noktp' => $this->input->post('noktp'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tlp' => $this->input->post('tlp'),
                'hp' => $this->input->post('hp'),
                'email' => $this->input->post('email'),
                'jabatan' => $this->input->post('jabatan')
            );
        
        $insert = $this->kar->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_karyawan()
    {
        $data = array(
                'noktp' => $this->input->post('noktp'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tlp' => $this->input->post('tlp'),
                'hp' => $this->input->post('hp'),
                'email' => $this->input->post('email'),
                'jabatan' => $this->input->post('jabatan')
            );
        $this->kar->update(array('karyawan_id' => $this->input->post('karyawan_id')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_karyawan($id)
    {
        $this->kar->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX Karyawan*/

	public function jabatan()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['jabatans'] = $this->Model_admin->manualQuery('SELECT * FROM jabatan')->result();
		$this->template_admin->load('template_admin','Moduls/jabatan/index',$data);
	}

	/*AJAX Jabatan*/
	public function ajax_list_jabatan()
    {
    	$list = $this->jbt->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jbt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $jbt->kode;
            $row[] = $jbt->diskripsi;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_jabatan('."'".$jbt->jabatan_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_jabatan('."'".$jbt->jabatan_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->jbt->count_all(),
                        "recordsFiltered" => $this->jbt->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_jabatan($id)
    {
        $data = $this->jbt->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_jabatan()
    {
    	$data = array(
                'kode' => $this->input->post('kode'),
                'diskripsi' => $this->input->post('diskripsi')
            );
        
        $insert = $this->jbt->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_jabatan()
    {
        $data = array(
                'kode' => $this->input->post('kode'),
                'diskripsi' => $this->input->post('diskripsi')
            );
        $this->jbt->update(array('jabatan_id' => $this->input->post('jabatan_id')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_jabatan($id)
    {
        $this->jbt->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX Jabatan*/

	public function jenispengeluaran()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['jenispengeluarans'] = $this->Model_admin->manualQuery('SELECT * FROM jenis_pengeluaran')->result();
		$this->template_admin->load('template_admin','Moduls/jenispengeluaran/index',$data);
	}


	public function jenispemasukan()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['jenispemasukans'] = $this->Model_admin->manualQuery('SELECT * FROM jenis_pemasukan')->result();
		$this->template_admin->load('template_admin','Moduls/jenispemasukan/index',$data);
	}

	public function motor()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['motors'] = $this->Model_admin->manualQuery('SELECT * FROM motor')->result();
		$this->template_admin->load('template_admin','Moduls/motor/index',$data);
	}

	public function masterbarang()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		
		$data = array(
			'KdBrg' =>$this->mb->getKodeBrg(),
		);
		$this->template_admin->load('template_admin','Moduls/masterbarang/index',$data);
	}

	/*AJAX MasterBarang*/
	public function ajax_list_mb()
    {
    	//$cbg = $this->session->userdata('cabang');
    	//$list = $this->mb->get_datatables($cbg);
    	$list = $this->mb->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $mb) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mb->KodeBarang;
            $row[] = $mb->NamaBarang;
            $row[] = $mb->Satuan;
            $row[] = $mb->HPP;
            if(empty($mb->HargaJual)){
            	$row[] = '<span class="label label-danger">Harga belum di set</span>';
            }else{
            	$row[] = $mb->HargaJual;/*<span class="label label-danger">Danger</span>*/
            }
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_masterbrg('."'".$mb->KodeBarang."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_masterbrg('."'".$mb->KodeBarang."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->mb->count_all(),
                        "recordsFiltered" => $this->mb->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_mb($id)
    {
        $data = $this->mb->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_mb()
    {
    	$KodeCabang = $this->session->userdata('cabang');
        $KodeBrg = $this->mb->getKodeBrg();
        $data = array(
                'KodeBarang' => $KodeBrg,
                'NamaBarang' => $this->input->post('NamaBarang'),
                'Satuan' => $this->input->post('Satuan'),
                'HPP' => $this->input->post('HPP'),
                'HargaJual' => $this->input->post('HargaJual'),
                'KodeCabang' => $KodeCabang,
            );
        $datast = array(
            'KodeBarang' => $KodeBrg,
        	'StokAkhir' => '0',
		);
        $insert = $this->mb->save($data);
        $insertstok = $this->Model_admin->create_data($datast,'stokbarang');
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_mb()
    {
        $data = array(
                'NamaBarang' => $this->input->post('NamaBarang'),
                'Satuan' => $this->input->post('Satuan'),
                'HPP' => $this->input->post('HPP'),
                'HargaJual' => $this->input->post('HargaJual'),
            );
        $this->mb->update(array('KodeBarang' => $this->input->post('KodeBarang')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_mb($id)
    {
        $this->mb->delete_by_id($id);
        $where = array('KodeBarang'=> $id);
        $this->Model_admin->del_data($where,'stokbarang');
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX MasterBarang*/

	public function stokbarang()
	{
		$this->template_admin->load('template_admin','Moduls/stokbarang/index');
	}

/*AJAX MasterBarang*/
	public function ajax_list_st()
    {
    	//$cbg = $this->session->userdata('cabang');
    	//$list = $this->mb->get_datatables($cbg);
    	$list = $this->stk->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $stk) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $stk->KodeBarang;
            $row[] = $stk->NamaBarang;
            $row[] = $stk->HargaJual;
            $row[] = $stk->StokAkhir;
            
            //add html for action
            /*$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_masterbrg('."'".$mb->KodeBarang."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_masterbrg('."'".$mb->KodeBarang."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';*/
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->stk->count_all(),
                        "recordsFiltered" => $this->stk->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_st($id)
    {
        $data = $this->stk->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_st()
    {
    	$KodeCabang = $this->session->userdata('cabang');
        $data = array(
                'KodeBarang' => $this->input->post('KodeBarang'),
                'NamaBarang' => $this->input->post('NamaBarang'),
                'Satuan' => $this->input->post('Satuan'),
                'HPP' => $this->input->post('HPP'),
                'HargaJual' => $this->input->post('HargaJual'),
                'KodeCabang' => $KodeCabang,
            );
        $datast = array(
        	'KodeBarang' => $this->input->post('KodeBarang'),
        	'StokAkhir' => '0',
		);
        $insert = $this->stk->save($data);
        $insertstok = $this->Model_admin->create_data($datast,'stokbarang');
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_st()
    {
        $data = array(
                'NamaBarang' => $this->input->post('NamaBarang'),
                'Satuan' => $this->input->post('Satuan'),
                'HPP' => $this->input->post('HPP'),
                'HargaJual' => $this->input->post('HargaJual'),
            );
        $this->stk->update(array('KodeBarang' => $this->input->post('KodeBarang')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_st($id)
    {
        $this->stk->delete_by_id($id);
        $where = array('KodeBarang'=> $id);
        $this->Model_admin->del_data($where,'stokbarang');
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX MasterBarang*/

	public function kota()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['kotas'] = $this->Model_admin->manualQuery('SELECT * FROM kota')->result();
		$this->template_admin->load('template_admin','Moduls/kota/index',$data);
	}

		public function user()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		//$data['users'] = $this->Model_admin->manualQuery('SELECT * FROM user')->result();
		$user_level = $this->Model_admin->manualQuery('SELECT * FROM user_level')->result();
		$data = array(
			'user_level'=> $user_level,
			);
		$this->template_admin->load('template_admin','Moduls/user/index',$data);
	}

		/*AJAX User*/
	public function ajax_list_user()
    {
    	$list = $this->usr->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $usr) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $usr->username;
            $row[] = $usr->nama_lengkap;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_user('."'".$usr->iduser."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_user('."'".$usr->iduser."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->usr->count_all(),
                        "recordsFiltered" => $this->usr->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_user($id)
    {
        $data = $this->usr->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_user()
    {
    	$data = array(
                'username' => $this->input->post('username'),
                'pass' => $this->input->post('pass'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $this->input->post('email'),
                'notelp' => $this->input->post('notelp'),
                'level' => $this->input->post('level'),
            );
        
        $insert = $this->usr->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_user()
    {
        $data = array(
                'pass' => $this->input->post('pass'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $this->input->post('email'),
                'notelp' => $this->input->post('notelp'),
                'level' => $this->input->post('level'),
            );
        $this->usr->update(array('iduser' => $this->input->post('iduser')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_user($id)
    {
        $this->usr->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX User*/

/*
------------------------------------------------END MASTER DATA-----------------------------------------------------
*/


/*
------------------------------------------------KEUANGAN-------------------------------------------------------------
*/


	public function trx_add($id)
	{
		$cust_id = $id;
        $trx = $this->trxl->getKodeTRX();
		//$trx = "TRX".date('ymd').rand(100000,999999);
		$datenow = date('Y-m-d H:i:s');

    	$sess_data['trx_id'] = $trx;
		$this->session->set_userdata($sess_data);
        $query = $this->Model_admin->manualQuery('SELECT a.no_polisi,a.nama,b.tipe FROM customer AS a LEFT JOIN motor AS b ON b.mtr_id=a.mtr_id');
        $row = $query->row_array();
        $nopol = $row['no_polisi'];
        $tipe = $row['tipe'];
        $nama_cust = $row['nama'];
        $waktu1 = date('H:i:s');
        $waktu2 = date('H:i:s');
		$data = array(
			'customer_id' => $cust_id,
			'id' => $trx,
            'nopol' => $nopol,
            'waktu1' => $waktu1,
            'waktu2' => $waktu2,
            'nama_cust' => $nama_cust,
            'tipe_motor' => $tipe,
            //'merek_motor' => $merek_motor,
            'tgl' => $datenow,
            'tgl_tempo' => $datenow,
			'tgl_lunas' => $datenow,
			);

		$cbg = $this->session->userdata('cabang');
    	$this->Model_admin->create_data($data,'transaksi');

    	redirect('admin/trxbengkel/'.$trx);
	}

	public function trx_bkl($id)
	{
		$trx = $id;
		
    	$sess_data['trx_id'] = $trx;
		$this->session->set_userdata($sess_data);

		redirect('admin/trxbengkel/'.$trx);
	}

	public function trxlist()
	{
		$this->template_admin->load('template_admin','Moduls/trxlist/index');
	}

/*AJAX MasterBarang*/
	public function ajax_list_trxl()
    {
    	//$cbg = $this->session->userdata('cabang');
    	//$list = $this->mb->get_datatables($cbg);
    	$list = $this->trxl->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trxl) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $trxl->id;
            $row[] = $trxl->cust;
            $row[] = $trxl->no_polisi;
            $row[] = $trxl->tipe_motor;
            $row[] = $trxl->mekanik;
            
            //add html for action
            if($trxl->status=='final'){
            $row[] = '<a class="btn btn-sm btn-success" href="'.site_url('admin/cetaktrx/'.$trxl->id).'" title="Transaksi"><i class="glyphicon glyphicon-print"></i> Cetak</a> <a class="btn btn-sm btn-primary" href="#" title="Lunas"><i class="glyphicon glyphicon-check"></i> LUNAS</a>';
            }else{
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('admin/trx_bkl/'.$trxl->id).'" title="Transaksi"><i class="glyphicon glyphicon-shopping-cart"></i> Transaksi</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_trxl('."'".$trxl->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 			}
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->trxl->count_all(),
                        "recordsFiltered" => $this->trxl->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_trxl($id)
    {
        $data = $this->trxl->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_trxl()
    {
        $data = array(
                'KodeBarang' => $this->input->post('KodeBarang'),
                'NamaBarang' => $this->input->post('NamaBarang'),
                'Satuan' => $this->input->post('Satuan'),
                'HPP' => $this->input->post('HPP'),
                'HargaJual' => $this->input->post('HargaJual'),
            );
        $insert = $this->trxl->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_trxl()
    {
        $data = array(
                'NamaBarang' => $this->input->post('NamaBarang'),
                'Satuan' => $this->input->post('Satuan'),
                'HPP' => $this->input->post('HPP'),
                'HargaJual' => $this->input->post('HargaJual'),
            );
        $this->trxl->update(array('KodeBarang' => $this->input->post('KodeBarang')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_trxl($id)
    {
        //$this->trxl->delete_by_id($id);
        $data = array(
                'status' => 'nullified',
            );
        $this->trxl->update(array('id' => $id), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX MasterBarang*/

	public function trxbengkelup($id)
	{
		$id = $this->input->post('id');
		$data =  array(
			'cara' => $this->input->post('cara'),
			'tgl' => $this->input->post('tgl'),
			'tgl_tempo' => $this->input->post('tgl_tempo'),
			'tgl_lunas' => $this->input->post('tgl_lunas'),
			'km' => $this->input->post('km'),
			'keluhan' => $this->input->post('keluhan'),
			'keterangan' => $this->input->post('keterangan'),
			'id_mekanik'=>$this->input->post('id_mekanik')
			);
		$where = array('id' => $id);
		$this->Model_admin->update_data($where,$data,'transaksi');
		redirect('admin/trxbengkel/'.$id);
	}
	function act_trxbengkelup()
	{
		$NomorTransaksi = $this->input->post('NomorTransaksi');
		$Jenis = $this->input->post('Jenis');
		
		if($Jenis == 'SERVIS'){
			$UpdateJenis = $this->Model_admin->manualQuery('UPDATE transaksi SET status="final" WHERE id="'.$NomorTransaksi.'"');
		}else{
			$UpdateJenis = $this->Model_admin->manualQuery('UPDATE transaksi SET status="final" WHERE id="'.$NomorTransaksi.'"');
			$detil_transaksi = $this->Model_admin->manualQuery('SELECT * FROM detil_transaksi WHERE id="'.$NomorTransaksi.'" AND jenis="PART"')->result();
		foreach ($detil_transaksi as $data) {
			$NomorTransaksi = $data->NomorTransaksi;
			$KodeBarang = $data->kode;
			$Keluar = $data->qty;
			$stokbarangup = $this->Model_admin->manualQuery('UPDATE stokbarang SET StokAkhir=StokAkhir-"'.$Keluar.'" WHERE KodeBarang="'.$KodeBarang.'"');
		}
	}
	$this->session->unset_userdata('trx_id');
	redirect('admin/trxlist');
	
}
	public function trxbengkel($id="")
	{
		$trx_id = $this->session->userdata('trx_id');
		if(!empty($trx_id)){
			$dtrx = $this->Model_admin->manualQuery('SELECT
													a.id,
													a.nopol,
													a.customer_id,
													a.km,
													a.keluhan,
													a.keluhan,
													a.keluhan1,
													a.id_mekanik,
													a.mekanik,
													a.waktu1,
													a.waktu2,
													a.keterangan,
													a.nama_cust,
													a.tipe_motor,
													a.merek_motor,
													a.pot_persen,
													a.pot_nominal,
													a.post,
													a.tgl,
													a.cara,
													a.ket_cara,
													a.cust,
													a.tgl_tempo,
													a.tgl_lunas,
													b.no_polisi, 
													c.jenis 
												FROM
													transaksi AS a
													LEFT JOIN customer AS b ON a.customer_id = b.customer_id
													LEFT JOIN detil_transaksi AS c ON a.id=c.id
												WHERE a.id="'.$trx_id.'"')->result();
			$mekanik = $this->Model_admin->manualQuery('SELECT * FROM karyawan')->result();
			$dtmb = $this->Model_admin->manualQuery('SELECT
												a.KodeBarang,
												a.KodeCabang,
												a.NamaBarang,
                                                a.HPP,
												a.Satuan,
												a.HargaJual,
												b.StokAkhir 
											FROM
												masterbarang AS a
												LEFT JOIN stokbarang AS b ON a.KodeBarang = b.KodeBarang
                                                WHERE b.StokAkhir >1
                                                ')->result();
			$data = array(
				'KdTrx' => $trx_id,
				'dtrxs' => $dtrx,
				'mekaniks' => $mekanik,
				'dtmbs' => $dtmb,
				);
			$this->template_admin->load('template_admin','Moduls/trxbengkel/index',$data);
			
		}else{
			redirect('admin/customer');
		}
	}

	/*AJAX TRX BENGKEL*/
	public function ajax_list_trxbengkel()
    {
    	$trx_id = $this->session->userdata('trx_id');
    	$list = $this->trx->get_datatables($trx_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trx) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $trx->jenis;
            $row[] = $trx->keterangan;
            $row[] = $trx->harga;
            $row[] = $trx->qty;
            $row[] = $trx->total;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_trxbengkel('."'".$trx->key."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->trx->count_all(),
                        "recordsFiltered" => $this->trx->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_trxbengkel($id)
    {
        $data = $this->trx->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_trxbengkel()
    {
    	$NomorTransaksi = $this->input->post('NomorTransaksi');
    	$JenisTrx = $this->input->post('jenis');
    	$keterangan = $this->input->post('Keterangan');
    	$harga = $this->input->post('harga');
    	$CustomerId = $this->input->post('CustomerId');
    	$KodeBarang = $this->input->post('KodeBarang');
    	$Keluar = $this->input->post('Keluar');
    	$user = $this->session->userdata('iduser');
    	$currdate = date('Y-m-d');

    	if($JenisTrx=='PART'){
    		$query = $this->Model_admin->manualQuery('SELECT b.no_pmb,a.KodeBarang,a.KodeCabang,a.NamaBarang,a.Satuan,a.HPP,a.HargaJual,a.Status FROM masterbarang AS a LEFT JOIN sparepart_pmb AS b ON a.KodeBarang = b.kode WHERE KodeBarang="'.$KodeBarang.'"'); //,b.harga AS HPP
    		$row = $query->row_array();
    		$NamaBarang = $row['NamaBarang'];
    		$HJ = $harga;
    		$HPP = $row['HPP'];
    		$no_pmb = $row['no_pmb'];
    		$total = $HJ * $Keluar;
    		
    		$data = array(
                'id' => $NomorTransaksi,
        		'jenis' => $JenisTrx,
                'keterangan' => $NamaBarang,
        		'kode' => $KodeBarang,
                'harga' => $HJ,
                'qty' => $Keluar,
                'total' => $total,
                'harga_beli' => $HPP,
                'harga_pokok' => $HPP,
                'nopmb' => $no_pmb,
                'tgl' => $currdate,
                'harga_jual' => $HJ,
            );
        	$insert = $this->trx->save($data);
    		
    	}else{
    		$data = array(
                'id' => $NomorTransaksi,
        		'jenis' => $JenisTrx,
        		'kode' => $JenisTrx,
                'keterangan' => $keterangan,
                'harga' => $harga,
                'qty' => $Keluar,
                'total' => $harga,
                'harga_beli' => '0',
                'harga_pokok' => '0',
                'tgl' => $currdate,
                'harga_jual' => $harga,
            );
        $insert = $this->trx->save($data);
    	}
    	
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_trxbengkel()
    {
        $data = array(
                'KodeBarang' => $this->input->post('KodeBarang'),
                'Keluar' => $this->input->post('Keluar'),
            );
        $this->trx->update(array('KeyId' => $this->input->post('KeyId')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_trxbengkel($id)
    {
        $this->trx->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX TRX BENGKEL*/

	public function pemasukanbengkel()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['pemasukans'] = $this->Model_admin->manualQuery('SELECT * FROM pemasukan ORDER BY tgl DESC')->result();
		$this->template_admin->load('template_admin','Moduls/pemasukanbengkel/index',$data);
	}

	public function pembeliansparepart()
	{
		$spp = $this->Model_admin->manualQuery('SELECT * FROM supplier')->result();
		/*PB979501611-180216*/
		//$no_pmb = "PB".date('ymd')."-".rand(100000,999999);
    	$cbg = $this->session->userdata('cabang');
    	$NoPMB = $this->pmb->getKodePMB();
		$data = array(
			'spps'=>$spp,
			'NoPMB'=>$NoPMB,
			'cbg'=>$cbg,
			);
		$this->template_admin->load('template_admin','Moduls/pembeliansparepart/index',$data);
	}

	/*AJAX PEMASUKAN BENGKEL*/
	public function ajax_list_pmb()
    {
    	$cbg = $this->session->userdata('cabang');
		$list = $this->pmb->get_datatables($cbg);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pmb) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = tgl_eng_to_ind($pmb->tgl);
            $row[] = $pmb->no_pmb;
            $row[] = $pmb->supplier;
            
            //add html for action
                if($pmb->status == 'final'){
                	$row[] = '<a class="btn btn-sm btn-success" href="#" title="Transaksi"><i class="glyphicon glyphicon-print"></i> Cetak</a>';
                }else{
                	$row[] = '<a class="btn btn-sm btn-success" href="'.site_url('admin/pmb_add/'.$pmb->no_pmb).'" title="Transaksi"><i class="glyphicon glyphicon-shopping-cart"></i> Transaksi</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_pmb_sparepart('."'".$pmb->no_pmb."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                }
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->pmb->count_all($cbg),
                        "recordsFiltered" => $this->pmb->count_filtered($cbg),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_pmb($id)
    {
        $data = $this->pmb->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_pmb()
    {
        $NoPMB = $this->pmb->getKodePMB();
        $cbg = $this->session->userdata('cabang');
    	$currdate = date('Y-m-d');
        
        $data = array(
                'no_pmb' => $NoPMB,
                'supplier' => $this->input->post('nama'),
                'cabang_id' => $cbg,
                'tgl' => $currdate,
                'tgl_tempo' => $currdate,
                'tgl_lunas' => $currdate,
                );
        $this->Model_admin->create_data($data,'pmb_sparepart');
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_pmb()
    {
    	$data = array(
                'no_pmb' => $this->input->post('no_pmb'),
                'SupplierId' => $this->input->post('SupplierId'),
                );
        $this->Model_admin->create_data($data,'pmb_sparepart');
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_pmb($id)
    {
        $this->pmb->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX PEMASUKAN BENGKEL*/

	public function pmb_add($id)
	{
		$NoTrx = $id;
		$sess_data['NoPMB'] = $NoTrx;
		$this->session->set_userdata($sess_data);

		$cara = $this->Model_admin->manualQuery('SELECT * FROM carabayar')->result();
		$pmb_sp = $this->Model_admin->manualQuery('SELECT
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
										a.cabang_id
									FROM
										pmb_sparepart AS a
										WHERE a.no_pmb="'.$NoTrx.'"')->result();
		$mstrbrg = $this->Model_admin->manualQuery('SELECT
										a.KodeBarang,
										a.KodeCabang,
										a.NamaBarang,
										a.Satuan,
										a.HPP,
										a.HargaJual,
										b.StokAkhir
										FROM
										masterbarang AS a
										INNER JOIN stokbarang AS b ON a.KodeBarang = b.KodeBarang
										')->result();
		$data = array(
			'NoTrxs' => $NoTrx,
			'pmb_sps' => $pmb_sp,
			'mstrbrgs' => $mstrbrg,
			'caras' => $cara,
			);
		$this->template_admin->load('template_admin','Moduls/pmb_add/index',$data);
	}

	/*AJAX PEMASUKAN BENGKEL*/
	public function ajax_list_pmba()
    {
    	$NoPMB = $this->session->userdata('NoPMB');
		$list = $this->mtb->get_datatables($NoPMB);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $mtb) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mtb->diskripsi;
            $row[] = $mtb->harga;
            $row[] = $mtb->qty;
            //$row[] = '';
            $row[] = $mtb->total;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_barang('."'".$mtb->key_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_barang('."'".$mtb->key_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                 /* $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$pmb->no_pmb."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$pmb->no_pmb."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';*/
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->mtb->count_all(),
                        "recordsFiltered" => $this->mtb->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_pmba($id)
    {
        $data = $this->mtb->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_pmba()
    {
    	$iduser = $this->session->userdata('iduser');
    	$cbg = $this->session->userdata('cabang');
    	$currdate = date('Y-m-d');

    	$KodeBarang = $this->input->post('KodeBarang');
    	$NomorTransaksi = $this->input->post('NomorTransaksi');
    	$supplier = $this->input->post('supplier');
    	$Masuk = $this->input->post('Masuk');
    	$harga = $this->input->post('harga');
    	$Total = $this->input->post('harga')*$this->input->post('Masuk');

        
        $data = array(
                'KodeBarang' => $this->input->post('KodeBarang'),
                'NomorTransaksi' => $this->input->post('NomorTransaksi'),
                'SupplierId' => $this->input->post('supplier'),
                'Masuk' => $this->input->post('Masuk'),
                'UserId' => $iduser,
                'TanggalTransaksi' => $currdate,
                'Status' => 'new',
                'JenisTransaksi' => '1',
                );
        /*$max = SELECT MAX( customer_id ) FROM customers;*/
        /*INSERT INTO customers( customer_id, firstname, surname )
VALUES ($max+1 , 'jim', 'sock')*/
//$max = $this->Model_admin->manualQuery('SELECT MAX(item) FROM sparepart_pmb WHERE no_pmb="'.$NomorTransaksi.'"');
		$dtmb = $this->Model_admin->manualQuery('SELECT * FROM masterbarang WHERE KodeBarang="'.$KodeBarang.'"')->result();
		foreach ($dtmb as $dt) {
		$NamaBarang=$dt->NamaBarang;	
		$dataspmb = array(
                'kode' => $this->input->post('KodeBarang'),
                'no_pmb' => $this->input->post('NomorTransaksi'),
                'qty' => $this->input->post('Masuk'),
                'harga' => $this->input->post('harga'),
                'diskripsi' => $NamaBarang,
                'total' => $this->input->post('harga')*$this->input->post('Masuk'),
                'UserId' => $iduser,
                'kondisi' => 'new'
                );
		$this->Model_admin->create_data($dataspmb,'sparepart_pmb');
        }
        
        $this->Model_admin->create_data($data,'mutasibarang');
        /*StokAkhir=StokAkhir+"'.$Masuk.'"*/
       // $max = $this->Model_admin->manualQuery('SELECT MAX(item) FROM sparepart_pmb WHERE no_pmb="'.$NomorTransaksi.'"');
       // $this->Model_admin->manualQuery('INSERT INTO sparepart_pmb SET no_pmb=$NomorTransaksi,kode=$KodeBarang,qty=$Masuk,harga=$harga,total=$total,UserId=$iduser,kondisi="new",item=$max+1');
        //$this->Model_admin->manualQuery("INSERT INTO sparepart_pmb SET no_pmb='".$NomorTransaksi."',item='".$max+'1'."'");
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_pmba()
    {
    	$data = array(
                'kode' => $this->input->post('KodeBarang'),
                'qty' => $this->input->post('Masuk'),
                'harga' => $this->input->post('harga'),
                'total' => $this->input->post('harga')*$this->input->post('Masuk'),
                );
		$this->mtb->update(array('key_id' => $this->input->post('key_id')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_pmba($id)
    {
        $this->mtb->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX PEMASUKAN BENGKEL*/

	function pmb_addup()
	{
		/*echo "<pre>";
			print_r($_POST);
		echo "</pre>";*/
		$id = $this->input->post('id');
		$where = array('no_pmb'=> $id);
		$data = array(
			'cara'=>$this->input->post('cara'),
			'tgl'=>$this->input->post('tgl'),
			'no_sj'=>$this->input->post('no_sj'),
			'tgl_tempo'=>$this->input->post('tgl_tempo'),
			'tgl_lunas'=>$this->input->post('tgl_lunas'),
			'keterangan'=>$this->input->post('keterangan'),
			);
		$this->Model_admin->update_data($where,$data,'pmb_sparepart');
		redirect('admin/pmb_add/'.$id);
	}

	public function pmb_del($id)
	{
		$where = array('key_id'=>$id);
    	
    	$this->Model_admin->del_data($where,'mutasibarang');
		redirect('admin/pmb_add');
	}

	public function pmb_add_act()
	{
		$kode = $this->input->post('kode');
		$qty = $this->input->post('qty');
		/*PB<?=rand(100000000,999999999)?>-<?=date('dmy')?>*/
		$rn = "PB".rand(100000000,999999999)-date('dmy');

		$query = $this->Model_admin->manualQuery('SELECT * FROM sparepart WHERE kode="'.$kode.'"');
		$row = $query->row_array();
		$hargax = $row['harga'];
		$total = $hargax*$qty;
		$data = array(
			'kode'=>$kode,
			'qty'=>$qty,
			'harga'=>$hargax,
			'total'=>$total,
			'kondisi'=>'new',
			);

		$this->Model_admin->create_data($data,'sparepart_pmb');
		redirect('admin/pmb_add');
	}
	public function add_pmba_act()
	{
		/*echo "<pre>";
			print_r($_POST);
		echo "</pre>";*/
		$no_pmb = $this->input->post('NomorTransaksi');
		$mutasibarang = $this->Model_admin->manualQuery('SELECT * FROM sparepart_pmb WHERE no_pmb="'.$no_pmb.'"')->result();
		foreach ($mutasibarang as $data) {
			$no_pmb = $data->no_pmb;
			$key_id = $data->key_id;
			$KodeBarang = $data->kode;
			$qty = $data->qty;
			$stokbarangup = $this->Model_admin->manualQuery('UPDATE stokbarang SET StokAkhir=StokAkhir+"'.$qty.'" WHERE KodeBarang="'.$KodeBarang.'"');

			$data = array(
				'key_id'=>$key_id,
				);
			//$update = $this->Model_admin->manualQuery('UPDATE mutasibarang SET status="normal" WHERE NomorTransaksi="'.$NomorTransaksi.'"');
			$update = $this->Model_admin->manualQuery('UPDATE pmb_sparepart SET status="final" WHERE no_pmb="'.$no_pmb.'"');
		}
		
	redirect('admin/pembeliansparepart');
	}

    public function penjualanpart()
    {
        $this->template_admin->load('template_admin','Moduls/penjualanpart/index');
    }

    

	public function biayaoperasional()
	{
		$this->template_admin->load('template_admin','Moduls/biayaoperasional/index');
	}

			/*AJAX BO*/
	public function ajax_list_bo()
    {
    	$list = $this->bo->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bo) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = tgl_eng_to_ind($bo->tgl);
            $row[] = $bo->kode;
            $row[] = $bo->diskripsi;
            $row[] = $bo->keterangan;
            $row[] = format_angka($bo->total);
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_bo('."'".$bo->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_bo('."'".$bo->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->bo->count_all(),
                        "recordsFiltered" => $this->bo->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_bo($id)
    {
        $data = $this->bo->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_bo()
    {
    	/*$('[name="id"]').val(data.id);
            $('[name="tgl"]').val(data.tgl);
            $('[name="kode"]').val(data.kode);
            $('[name="keterangan"]').val(data.keterangan);
            $('[name="diskripsi"]').val(data.diskripsi);
            $('[name="total"]').val(data.total);*/
    	$data = array(
                'tgl' => $this->input->post('tgl'),
                'kode' => $this->input->post('kode'),
                'keterangan' => $this->input->post('keterangan'),
                'diskripsi' => $this->input->post('diskripsi'),
                'total' => $this->input->post('total'),
            );
        
        $insert = $this->bo->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_bo()
    {
        $data = array(
                'tgl' => $this->input->post('tgl'),
                'kode' => $this->input->post('kode'),
                'keterangan' => $this->input->post('keterangan'),
                'diskripsi' => $this->input->post('diskripsi'),
                'total' => $this->input->post('total'),
            );
        $this->bo->update(array('id' => $this->input->post('id')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_bo($id)
    {
        $this->bo->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX BO*/

	public function hutang()
	{
		$this->template_admin->load('template_admin','Moduls/hutang/index');
	}

		/*AJAX MasterBarang*/
	public function ajax_list_hutang()
    {
    	//$cbg = $this->session->userdata('cabang');
    	//$list = $this->mb->get_datatables($cbg);
    	$list = $this->htg->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $htg) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $htg->no_pmb;
            $row[] = $htg->supplier;
            $row[] = $htg->tgl;
            $row[] = $htg->tgl_tempo;
            $row[] = $htg->Total;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Hapus" onclick="update_lunas('."'".$htg->no_pmb."'".')"><i class="glyphicon glyphicon-check"></i> Lunasi</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->htg->count_all(),
                        "recordsFiltered" => $this->htg->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_hutang($id)
    {
        $data = $this->htg->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_hutang()
    {
    	$KodeCabang = $this->session->userdata('cabang');
        $data = array(
                'KodeBarang' => $this->input->post('KodeBarang'),
                'NamaBarang' => $this->input->post('NamaBarang'),
                'Satuan' => $this->input->post('Satuan'),
                'HPP' => $this->input->post('HPP'),
                'HargaJual' => $this->input->post('HargaJual'),
                'KodeCabang' => $KodeCabang,
            );
        $datast = array(
        	'KodeBarang' => $this->input->post('KodeBarang'),
        	'StokAkhir' => '0',
		);
        $insert = $this->htg->save($data);
        $insertstok = $this->Model_admin->create_data($datast,'stokbarang');
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_hutang($id)
    {
        $data = array(
                'ket_cara' => 'LUNAS',
            );
        $this->htg->update(array('no_pmb' => $id), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
	/*AJAX MasterBarang*/

	public function retursparepart()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['returs'] = $this->Model_admin->manualQuery('SELECT a.key_id,a.kode,a.diskripsi,a.qty,a.total,b.keterangan,b.status FROM retur AS a LEFT JOIN notaretur AS b ON b.id = a.id ORDER BY b.tgl DESC')->result();
		$this->template_admin->load('template_admin','Moduls/retursparepart/index',$data);
	}

    public function lapomzet()
    {
        $btn_cetakPDF = $this->input->post('btn_cetakPDF');
        $btn_tampil = $this->input->post('btn_tampil');
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $sess_data['tgl_awal'] = $tgl_awal;
        $sess_data['tgl_akhir'] = $tgl_akhir;
        $this->session->set_userdata($sess_data);

        if(isset($btn_cetakPDF)){
            $selLaba = $this->Model_admin->manualQuery("SELECT
                                                        b.tgl_lunas,
                                                        SUM( IF ( a.jenis = 'SERVIS', a.total, 0 ) ) AS TLabaServis,
                                                        SUM( IF ( a.jenis = 'PART', a.total, 0 ) ) AS TLabaPart,
                                                        SUM( a.harga_beli ) AS TModalPart,
                                                        SUM( a.total ) AS Omzet,
                                                        b.Unit 
                                                    FROM
                                                        detil_transaksi AS a
                                                        LEFT JOIN ( SELECT trx.tgl_lunas,trx.id,COUNT( trx.id ) AS Unit FROM transaksi AS trx GROUP BY
                                                        trx.tgl_lunas) AS b ON b.id = a.id 
                                                    WHERE
                                                        b.tgl_lunas BETWEEN '".$tgl_awal."' 
                                                        AND '".$tgl_akhir."'
                                                        GROUP BY
                                                        b.tgl_lunas")->result();
            $selLabar = $this->Model_admin->manualQuery("SELECT
                                                        b.tgl_lunas,
                                                        SUM( IF ( a.jenis = 'SERVIS', a.total, 0 ) ) AS TLabaServis,
                                                        SUM( IF ( a.jenis = 'PART', a.total, 0 ) ) AS TLabaPart,
                                                        SUM( a.harga_beli ) AS TModalPart,
                                                        SUM( a.total ) AS Omzet,
                                                        b.Unit 
                                                    FROM
                                                        detil_transaksi AS a 
                                                        LEFT JOIN ( SELECT trx.tgl_lunas,trx.id,COUNT( trx.id ) AS Unit FROM transaksi AS trx GROUP BY
                                                        trx.tgl_lunas) AS b ON b.id = a.id 
                                                    WHERE
                                                        b.tgl_lunas BETWEEN '".$tgl_awal."' 
                                                        AND '".$tgl_akhir."'
                                                        GROUP BY
                                                        b.tgl_lunas");
            $row = $selLabar->row();

        $pdf = new FPDF('l','mm','Letter');//A4,Letter,Legal
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(275,7,'Laporan Omzet Pro Matic 002',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(275,7,'PERIODE '.tgl_eng_to_ind($tgl_awal).' S/D '.tgl_eng_to_ind($tgl_akhir),0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(30,7,'',0,1);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(20,6,'No',1,0);
        $pdf->Cell(40,6,'TANGGAL',1,0);
        $pdf->Cell(40,6,'LABA SERVIS',1,0);
        $pdf->Cell(40,6,'LABA PART',1,0);
        $pdf->Cell(40,6,'MODAL PART',1,0);
        $pdf->Cell(40,6,'OMZET',1,0);
        $pdf->Cell(40,6,'UNIT',1,1);
        $pdf->SetFont('Arial','',12);
        $no = 1;
        $TLabaServis="";
        $TLabaPart="";
        $TModalPart="";
        $Omzet="";
        $Unit="";
        if(isset($row)){
        foreach ($selLaba as $row){
            $TLabaServis = $TLabaServis+$row->TLabaServis;
            $TLabaPart = $TLabaPart+$row->TLabaPart;
            $TModalPart = $TModalPart+$row->TModalPart;
            $Omzet = $Omzet+$row->Omzet;
            $Unit = $Unit+$row->Unit;
            $pdf->Cell(20,6,$no,1,0);
            $pdf->Cell(40,6,$row->tgl_lunas,1,0);
            $pdf->Cell(40,6,format_angka($row->TLabaServis),1,0);
            $pdf->Cell(40,6,format_angka($row->TLabaPart),1,0);
            $pdf->Cell(40,6,format_angka($row->TModalPart),1,0); 
            $pdf->Cell(40,6,format_angka($row->Omzet),1,0); 
            $pdf->Cell(40,6,format_angka($row->Unit),1,1); 
        $no++;
        }

        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(60,7,'TOTAL',1,0,'C');
        $pdf->Cell(40,7,'Rp. '.format_angka($TLabaServis),1,0);
        $pdf->Cell(40,7,'Rp. '.format_angka($TLabaPart),1,0);
        $pdf->Cell(40,7,'Rp. '.format_angka($TModalPart),1,0);
        $pdf->Cell(40,7,'Rp. '.format_angka($Omzet),1,0);
        $pdf->Cell(40,7,$Unit,1,1);
        }
        $pdf->Output();
        }else{
            $selLaba = $this->Model_admin->manualQuery("SELECT
                                                        b.tgl_lunas,
                                                        SUM( IF ( a.jenis = 'SERVIS', a.total, 0 ) ) AS TLabaServis,
                                                        SUM( IF ( a.jenis = 'PART', a.total, 0 ) ) AS TLabaPart,
                                                        SUM( a.harga_beli ) AS TModalPart,
                                                        SUM( a.total ) AS Omzet,
                                                        b.Unit 
                                                    FROM
                                                        detil_transaksi AS a 
                                                        LEFT JOIN ( SELECT trx.tgl_lunas,trx.id,COUNT( trx.id ) AS Unit FROM transaksi AS trx GROUP BY
                                                        trx.tgl_lunas) AS b ON b.id = a.id 
                                                    WHERE
                                                        b.tgl_lunas BETWEEN '".$tgl_awal."' 
                                                        AND '".$tgl_akhir."'
                                                        GROUP BY
                                                        b.tgl_lunas")->result();
            $data = array(
                'selLabas'=> $selLaba,
                'btn_tampil'=> $btn_tampil,
                );
            $this->template_admin->load('template_admin','Moduls/lapomzet/index',$data);
            }
    }

    public function cetaktrx($id)
    {

        $query = $this->Model_admin->manualQuery("SELECT
                                                    id,
                                                    jenis,
                                                    keterangan,
                                                    harga,
                                                    qty,
                                                    total 
                                                FROM
                                                    detil_transaksi 
                                                WHERE
                                                    id = '".$id."'")->result();
        $query2 = $this->Model_admin->manualQuery("SELECT
                                                        a.nopol,
                                                        a.customer_id,
                                                        a.km,
                                                        a.keluhan,
                                                        a.mekanik,
                                                        a.waktu1,
                                                        a.waktu2,
                                                        a.keterangan,
                                                        a.nama_cust,
                                                        a.tipe_motor,
                                                        a.tgl_lunas,
                                                        b.nama AS mekanik
                                                    FROM
                                                        transaksi AS a
                                                    LEFT JOIN karyawan AS b ON b.karyawan_id=a.id_mekanik
                                                     WHERE a.id='".$id."'");
        $row = $query2->row_array();
        $nopol = $row['nopol'];
        $km = $row['km'];
        $keluhan = $row['keluhan'];
        $mekanik = $row['mekanik'];
        $waktu1 = $row['waktu1'];
        $waktu2 = $row['waktu2'];
        $keterangan = $row['keterangan'];
        $nama_cust = $row['nama_cust'];
        $tipe_motor = $row['tipe_motor'];
        $tgl_lunas = $row['tgl_lunas'];

        $currdate = date('d-m-Y');
        $pdf = new FPDF('l','mm','Letter');//A4,Letter,Legal
        // membuat halaman baru
        $pdf->AddPage('L');
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(275,7,'KWITANSI ProMatic 002',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(275,7,'Tanggal : '. $tgl_lunas,0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(30,7,'',0,1);
        $pdf->Cell(30,7,'',0,1);

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(20,6,'Nama Pelanggan  : '.$nama_cust,0,1);
        $pdf->Cell(20,6,'No Polisi  : '.$nopol,0,1);
        $pdf->Cell(20,6,'Tipe Motor : '.$tipe_motor,0,1);
        $pdf->Cell(20,6,'Keluhan : '.$keluhan,0,1);
        $pdf->Cell(20,6,'Mekanik : '.$mekanik,0,1);

        $pdf->Cell(30,7,'',0,1);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'No',1,0);
        $pdf->Cell(40,6,'Jenis',1,0);
        $pdf->Cell(40,6,'KETERANGAN',1,0);
        $pdf->Cell(40,6,'HARGA',1,0);
        $pdf->Cell(40,6,'QTY',1,0);
        $pdf->Cell(40,6,'TOTAL',1,1);
        $pdf->SetFont('Arial','',12);
        
        $no = 1;
        $TOTAL ="";
        foreach ($query as $row){
            /*$TLabaServis = $TLabaServis+$row->TLabaServis;
            $TLabaPart = $TLabaPart+$row->TLabaPart;
            $TModalPart = $TModalPart+$row->TModalPart;
            $Omzet = $Omzet+$row->Omzet;*/
            $TOTAL = $TOTAL+$row->total;
            $pdf->Cell(20,6,$no,1,0);
            $pdf->Cell(40,6,$row->jenis,1,0);
            $pdf->Cell(40,6,$row->keterangan,1,0);
            $pdf->Cell(40,6,format_angka($row->harga),1,0);
            $pdf->Cell(40,6,$row->qty,1,0); 
            $pdf->Cell(40,6,format_angka($row->total),1,1); 
        $no++;
        }

        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(180,7,'TOTAL',1,0,'C');
        $pdf->Cell(40,7,'Rp. '.format_angka($TOTAL),1,0);
        $pdf->Output();
    }



}