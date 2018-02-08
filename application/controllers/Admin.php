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
		$this->load->model('Model_trxbengkel','trx');
		$this->load->model('Cabang_model','cbg');
		$this->load->model('Customer_model','cstm');
		$this->load->model('Kunjungan_model','kjg');
		$this->load->model('PMB_model','pmb');
		$this->load->model('Masterbarang_model','mb');
		$this->load->model('Transaksi_model','trxl');
		$this->load->model('Mutasibarang_model','mtb');
		
        //$this->load->library('My_PHPMailer');

		
    }
	
	public function index()
	{
		/*$article = $this->Model_admin->manualQuery("SELECT count(id_article) AS jml FROM article WHERE active='Y'")->result();
		$program = $this->Model_admin->manualQuery("SELECT count(id_album) AS jml FROM album_vod")->result();
		$label = $this->Model_admin->manualQuery("SELECT count(id_label) AS jml FROM label")->result();
		$kolumnis = $this->Model_admin->manualQuery("SELECT count(iduser) AS jml FROM user WHERE level='2'")->result();
		$data = array(
			'articles' => $article,
			'programs' => $program,
			'labels' => $label,
			'kolumniss' => $kolumnis,
			);*/
		 $this->template_admin->load('template_admin','Moduls/home');
	}
/*
-------------------------------------------------------------MASTER DATA----------------------------------------------------
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
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['suppliers'] = $this->Model_admin->manualQuery('SELECT * FROM supplier')->result();
		$this->template_admin->load('template_admin','Moduls/supplier/index',$data);
	}

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
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data = array(
			'cabangs' =>$this->Model_admin->manualQuery('SELECT * FROM cabang')->result(),
			'kdcabang' =>$this->cbg->getKodeCabang(),
			);
		//$data['cabangs'] = $this->Model_admin->manualQuery('SELECT * FROM cabang')->result();
		$this->template_admin->load('template_admin','Moduls/cabang/index',$data);
	}

	function act_addcabang(){
    	$cabang_id = $this->input->post('cabang_id');
    	$nama = $this->input->post('nama');
    	$alamat = $this->input->post('alamat');
    	$kota = $this->input->post('kota');
    	$kodepos = $this->input->post('kodepos');
    	$fax = $this->input->post('fax');
    	$tlp = $this->input->post('tlp');
    	$email = $this->input->post('email');
    	
    	$data = array(
			'cabang_id' => $cabang_id,
			'alamat' => $alamat,
			'kota' => $kota,
			'kodepos' => $kodepos,
			'fax' => $fax,
			'tlp' => $tlp,
			'email' => $email,
			);
		$this->Model_admin->create_data($data,'cabang');
		redirect('admin/cabang');
    }

    function editcabang($id){
    	$where = array('merk_id'=>$id);
    	$data['merks'] = $this->Model_admin->edit_data($where,'merkmotor')->result();

    	$this->template_admin->load('template_admin','Moduls/merkmotor/edit',$data);
    }
    function act_editcabang(){
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
		redirect('admin/cabang');
	}

    function delcabang($id){
    	$where = array('merk_id'=>$id);
    	
    	$this->Model_admin->del_data($where,'merkmotor');
		redirect('admin/cabang');
    }

	public function karyawan()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['karyawans'] = $this->Model_admin->manualQuery('SELECT * FROM karyawan')->result();
		$this->template_admin->load('template_admin','Moduls/karyawan/index',$data);
	}

	public function jabatan()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['jabatans'] = $this->Model_admin->manualQuery('SELECT * FROM jabatan')->result();
		$this->template_admin->load('template_admin','Moduls/jabatan/index',$data);
	}

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
            $row[] = $mb->HargaJual;
            
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

	public function kota()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['kotas'] = $this->Model_admin->manualQuery('SELECT * FROM kota')->result();
		$this->template_admin->load('template_admin','Moduls/kota/index',$data);
	}

		public function user()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['users'] = $this->Model_admin->manualQuery('SELECT * FROM user')->result();
		$this->template_admin->load('template_admin','Moduls/user/index',$data);
	}

	public function adduser()
	{
		$this->template_admin->load('template_admin','Moduls/user/add');
	}
    function act_adduser(){
    	$merk_motor = $this->input->post('merk_motor');
    	$date = date('Y-m-d H:i:s');

    	$data = array(
			'merk_motor' => $merk_motor,
			'created_at' => $date,
			);
		$this->Model_admin->create_data($data,'user');
		redirect('admin/user');
    }

    function edituser($id){
    	$where = array('iduser'=>$id);
    	$data['merks'] = $this->Model_admin->edit_data($where,'user')->result();

    	$this->template_admin->load('template_admin','Moduls/user/edit',$data);
    }
    function act_edituser(){
    	/*echo "<pre>";
    		print_r($_POST);
    	echo "</pre>";*/

    	$date = date('Y-m-d H:i:s');

		$iduser = $this->input->post('iduser');
		$merk_motor = $this->input->post('merk_motor');
    	
    	$data = array(
    		'iduser' => $iduser,
			'merk_motor' => $merk_motor,
			'update_at' => $date,
			);

		$where = array(
			'iduser' => $iduser
		);

		$this->Model_admin->update_data($where,$data,'user');
		redirect('admin/user');
	}

    function deluser($id){
    	$where = array('iduser'=>$id);
    	
    	$this->Model_admin->del_data($where,'user');
		redirect('admin/user');
    }

/*
-----------------------------------------------------END MASTER DATA-----------------------------------------------------
*/


/*
-----------------------------------------------------KEUANGAN-------------------------------------------------------------
*/


	public function trx_add($id)
	{
		$cust_id = $id;
		$trx = "TRX".date('ymd').rand(100000,999999);
		$datenow = date('Y-m-d H:i:s');

    	$sess_data['trx_id'] = $trx;
		$this->session->set_userdata($sess_data);

		$data = array(
			'customer_id' => $cust_id,
			'id' => $trx,
			'tgl' => $datenow,
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
            $row[] = $trxl->mekanik;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('admin/trx_bkl/'.$trxl->id).'" title="Transaksi"><i class="glyphicon glyphicon-shopping-cart"></i> Transaksi</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_trxl('."'".$trxl->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
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
			'keterangan' => $this->input->post('keterangan')
			);
		$where = array('id' => $id);
		//$this->trx->update(array('id' => $this->input->post('id')), $data);
		/*update_data($where,$data,$table)*/
		$this->Model_admin->update_data($where,$data,'transaksi');
		redirect('admin/trxbengkel/'.$id);
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
													b.no_polisi 
												FROM
													transaksi AS a
													LEFT JOIN customer AS b ON a.customer_id = b.customer_id
												WHERE id="'.$trx_id.'"')->result();
			$mekanik = $this->Model_admin->manualQuery('SELECT * FROM karyawan WHERE id_jabatan="MK"')->result();
			$data = array(
				'KdTrx' => $trx_id,
				'dtrxs' => $dtrx,
				'mekaniks' => $mekanik,
				);
			$this->template_admin->load('template_admin','Moduls/trxbengkel/index',$data);
			
		}else{
			redirect('admin/customer');
		}
	}

	/*AJAX TRX BENGKEL*/
	public function ajax_list_trxbengkel()
    {
    	$list = $this->trx->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trx) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $trx->kode;
            $row[] = $trx->jenis;
            $row[] = $trx->keterangan;
            $row[] = $trx->harga;
            $row[] = $trx->qty;
            $row[] = $trx->pot;
            $row[] = $trx->total;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_trxl('."'".$trx->key."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
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
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $insert = $this->trx->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_trxbengkel()
    {
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $this->trx->update(array('id' => $this->input->post('id')), $data);
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
		$no_pmb = "TRX".date('ymd').rand(100000,999999);
    	$cbg = $this->session->userdata('cabang');

		$data = array(
			'spps'=>$spp,
			'no_pmb'=>$no_pmb,
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
            $row[] = $pmb->tgl;
            $row[] = $pmb->no_pmb;
            $row[] = $pmb->nama;
            
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
    	$cbg = $this->session->userdata('cabang');
    	$currdate = date('Y-m-d');
        
        $data = array(
                'no_pmb' => $this->input->post('no_pmb'),
                'SupplierId' => $this->input->post('SupplierId'),
                'cabang_id' => $cbg,
                'tgl' => $currdate,
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
										a.cabang_id,
										b.nama 
									FROM
										pmb_sparepart AS a
										INNER JOIN supplier AS b ON a.SupplierId = b.supplier_id
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
			);
		$this->template_admin->load('template_admin','Moduls/pmb_add/index',$data);
	}

	/*AJAX PEMASUKAN BENGKEL*/
	public function ajax_list_pmba()
    {
    	$cbg = $this->session->userdata('cabang');
		$list = $this->mtb->get_datatables($cbg);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $mtb) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mtb->KodeBarang;
            //$row[] = '';
            $row[] = $mtb->NamaBarang;
            $row[] = $mtb->HargaJual;
            $row[] = $mtb->Masuk;
            //$row[] = '';
            $row[] = $mtb->HargaJual*$mtb->Masuk;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_barang('."'".$mtb->KeyId."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                 /* $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$pmb->no_pmb."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$pmb->no_pmb."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';*/
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->mtb->count_all($cbg),
                        "recordsFiltered" => $this->mtb->count_filtered($cbg),
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
        
        $data = array(
                'KodeBarang' => $this->input->post('KodeBarang'),
                'NomorTransaksi' => $this->input->post('NomorTransaksi'),
                'SupplierId' => $this->input->post('SupplierId'),
                'Masuk' => $this->input->post('Masuk'),
                'UserId' => $iduser,
                'TanggalTransaksi' => $currdate,
                'Status' => 'new',
                'JenisTransaksi' => '1',
                );
        $this->Model_admin->create_data($data,'mutasibarang');
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_pmba()
    {
    	$data = array(
                'no_pmb' => $this->input->post('no_pmb'),
                'SupplierId' => $this->input->post('SupplierId'),
                );
        $this->Model_admin->create_data($data,'pmb_sparepart');
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
		$NomorTransaksi = $this->input->post('NomorTransaksi');
		$mutasibarang = $this->Model_admin->manualQuery('SELECT * FROM mutasibarang WHERE NomorTransaksi="'.$NomorTransaksi.'"')->result();
		foreach ($mutasibarang as $data) {
			$NomorTransaksi = $data->NomorTransaksi;
			$KeyId = $data->KeyId;
			$KodeBarang = $data->KodeBarang;
			$Masuk = $data->Masuk;
			$stokbarangup = $this->Model_admin->manualQuery('UPDATE stokbarang SET StokAkhir=StokAkhir+"'.$Masuk.'" WHERE KodeBarang="'.$KodeBarang.'"');

			$data = array(
				'KeyId'=>$KeyId,
				);
			$update = $this->Model_admin->manualQuery('UPDATE mutasibarang SET status="normal" WHERE NomorTransaksi="'.$NomorTransaksi.'"');
			$update2 = $this->Model_admin->manualQuery('UPDATE pmb_sparepart SET status="final" WHERE no_pmb="'.$NomorTransaksi.'"');
		}
		
	redirect('admin/pembeliansparepart');
	}

	public function biayaoperasional()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['pengeluarans'] = $this->Model_admin->manualQuery('SELECT * FROM pengeluaran ORDER BY tgl DESC')->result();
		$this->template_admin->load('template_admin','Moduls/biayaoperasional/index',$data);
	}

	public function retursparepart()
	{
		//$data['kat'] = $this->Model_admin->manualQuery('SELECT a.id_category,b.title FROM category AS a LEFT JOIN category_description AS b ON b.id_category = a.id_category')->result();
		$data['returs'] = $this->Model_admin->manualQuery('SELECT a.key_id,a.kode,a.diskripsi,a.qty,a.total,b.keterangan,b.status FROM retur AS a LEFT JOIN notaretur AS b ON b.id = a.id ORDER BY b.tgl DESC')->result();
		$this->template_admin->load('template_admin','Moduls/retursparepart/index',$data);
	}

	/*==================================================Administrasi===================================================*/

	public function registrasi()
	{	
		$cbg = $this->session->userdata('cabang');
		$data['regs'] = $this->Model_admin->manualQuery('SELECT customer_id,cabang_id,no_polisi,nama,alamat,hp FROM customer WHERE status="normal" AND cabang_id="'.$cbg.'" ORDER BY tanggal DESC')->result();
		$this->template_admin->load('template_admin','Moduls/registrasi/index',$data);
	}

	public function act_rkunjungan()
	{
		/*echo "<pre>";
			print_r($_POST);
		echo "</pre>";*/

		$cusid = $this->input->post('customer_id');
		$sess_data['cstmid'] = $cusid;
		$this->session->set_userdata($sess_data);
		redirect('admin/kunjungan/'.$cusid);
	}

	public function kunjungan($id="")
	{
		if(!empty($id)){
			$kdcs = $this->session->userdata('cstmid');
			$cstm = $this->Model_admin->manualQuery('SELECT * FROM customer WHERE customer_id="'.$id.'"')->result();
			$kjg = $this->Model_admin->manualQuery('SELECT a.kunjungan_id,a.kunjungan_date,a.cara_bayar,a.km,b.no_polisi,b.nama FROM kunjungan AS a LEFT JOIN customer AS b ON b.customer_id = a.customer_id WHERE a.status="normal" AND b.customer_id="'.$id.'"')->result();
			$data = array(
				'kdcss'=> $kdcs,
				'cstms'=> $cstm,
				'kjgs'=> $kjg,
				);
			$this->template_admin->load('template_admin','Moduls/kunjungan/index',$data);
		}else{
			$cusid = $this->session->userdata('cstmid');
			if(!empty($cusid)){
				redirect('admin/kunjungan/'.$cusid);
			}else{
			echo "REGISTRASI";
			}
		}
	}
	public function unsetcust()
	{
		$this->session->unset_userdata('trx_id');
		redirect('admin/customer/');
	}

		/*AJAX TRX BENGKEL*/
	public function ajax_list_kunjungan($id)
    {
    	$list = $this->kjg->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kjg) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $kjg->kunjungan_date;
            $row[] = $kjg->cara_bayar;
            $row[] = $kjg->km;
            $row[] = $kjg->kunjungan_status;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$kjg->kunjungan_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$kjg->kunjungan_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->kjg->count_all(),
                        "recordsFiltered" => $this->kjg->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        header('Content-Type: application/json');
        echo json_encode($output);
    }
 
    public function ajax_edit_kunjungan($id)
    {
        $data = $this->kjg->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
 
    public function ajax_add_kunjungan()
    {
        $data = array(
                'customer_id' => $this->input->post('customer_id'),
                'kunjungan_id' => $this->input->post('kunjungan_id'),
                'kunjungan_date' => $this->input->post('kunjungan_date'),
                'cara_bayar' => $this->input->post('cara_bayar'),
                'km' => $this->input->post('km'),
                'cabang_id' => $this->input->post('cabang_id'),
                'created_by' => $this->input->post('created_by'),
            );
        $insert = $this->kjg->save($data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update_kunjungan()
    {
        $data = array(
                'customer_id' => $this->input->post('customer_id'),
                'kunjungan_id' => $this->input->post('kunjungan_id'),
                'kunjungan_date' => $this->input->post('kunjungan_date'),
                'cara_bayar' => $this->input->post('cara_bayar'),
                'km' => $this->input->post('km'),
                'cabang_id' => $this->input->post('cabang_id'),
                'created_by' => $this->input->post('created_by'),
            );
        $this->kjg->update(array('id' => $this->input->post('id')), $data);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_kunjungan($id)
    {
        $this->kjg->delete_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(array("status" => TRUE));
    }
	/*AJAX TRX BENGKEL*/

	public function pelayanan($id=""){
		if(!empty($id)){
			echo $id;
		}else{
			echo "REGISTRASI";
		}
	}

	/*==================================================Administrasi===================================================*/

}