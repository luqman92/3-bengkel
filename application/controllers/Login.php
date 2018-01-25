<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		if ($this->session->userdata('username')==TRUE) {
			echo "<script>history.go(-1)</script>";
		}
		$this->load->model('Model_auth');
	}
	public function index()
	{
		$this->load->view('frmlogin');
	}

	public function act_login()
	{
		/*echo "<pre>";
			print_r($_POST);
		echo "</pre>";*/
		if(isset($_POST['submit'])){
			//Proses Login
			$data = array('username' => $this->input->post('username', TRUE),
						'pass' => $this->input->post('pass', TRUE)
			);
			
			$hasil = $this->Model_auth->cek_user($data);
			if($hasil->num_rows() == 1){
				foreach ($hasil->result() as $sess) {
				$sess_data['logged_in'] = 'Sudah Login';
				$sess_data['iduser'] = $sess->iduser;
				$sess_data['username'] = $sess->username;
				$sess_data['picture'] = $sess->picture;
				$sess_data['level'] = $sess->level;
				$sess_data['cabang'] = $sess->cabang_id;
				$this->session->set_userdata($sess_data);
			}
			
				redirect('admin');
			}else{
				echo "<script>alert('Gagal login: Cek username, password!');history.go(-1);</script>";
			}
		}
	}
		


	function logout(){
		$this->session->sess_destroy();
		redirect('login/index');
	}
}
