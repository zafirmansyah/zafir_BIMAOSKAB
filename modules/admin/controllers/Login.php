<?php
class Login extends CI_Controller{
	public function __construct(){
		parent::__construct() ;
		$this->load->model('loginm') ;
        $this->loginm->CheckDatabase();
	}

	public function index(){
		$data 	= array('app_title'=> $this->loginm->getconfig('app_title'),
						'app_logo'=>base_url($this->loginm->getconfig('app_logo')),
						'app_login_image'=>base_url($this->loginm->getconfig('app_login_image')) ) ;
		$this->load->view("login", $data) ;
	}

	public function checklogin(){
		$va	= $this->input->post() ;
		$data = $this->loginm->getdata_login($va['cusername'], $va['cpassword']) ;
		if(!empty($data)){
			$lStatus = true ;
			//saving data username
			$data['app_title']	= $this->loginm->getconfig('app_title') ;
			$data['app_logo']		= $this->loginm->getconfig('app_logo') ;
 			
			//get photo
			$data['data_var']		= $data['data_var'] !== "" ? json_decode($data['data_var'], true) : array("ava"=>"") ;
			if($data['data_var']['ava'] == "") $data['data_var']['ava'] = "./uploads/mdt.png" ;
			
			//get level menu
			$level 					= substr($data['password'], -4) ;
			$data['level_code']	= $level ;
			$data['level_value'] = "" ;
			if($dbl = $this->loginm->getval("value, dashboard", "code = '$level'", "sys_username_level")){
				$data['level_value'] = $dbl['value'] ;
				$data['dash']			= json_decode($dbl['dashboard'], true) ;
				$data['dash']			= $data['dash']['md5'] ;
			}

			foreach ($data as $key => $value) {
				savesession($this, $key, $value) ;
			}

			if($data['Terminate']){
				$lStatus  = false ;
				$lComment = "Username " . $data['username'] . " tidak bisa login, silahkan laporkan pada Super Admin / PIC untuk informasi lebih lanjut" ;
			}
		}else{
			$lStatus = false ;
			$lComment = "User atau Password Tidak Ditemukan!" ;
		}

		if(!$lStatus){
			echo(" 
				Swal.fire(
					'Perhatian',
					'". $lComment ."',
					'warning'
				)
				$('#cusername').val('') ;
				$('#cusername').focus(); 
				$('#cpassword').val('') ; 
				
			") ;
		}else{
			echo('window.location.href = "'.base_url().'" ;') ;
		}
	}
}
?>
