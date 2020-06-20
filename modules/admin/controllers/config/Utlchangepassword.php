<?php


class Utlchangepassword extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('config/utlchangepassword_m') ;
        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;

        $this->bdb = $this->utlchangepassword_m ;
    }

    public function index(){
        $va['cUsername'] = getsession($this,'username') ;
        $this->load->view('config/utlchangepassword',$va) ;
    }

    public function validSaving()
    {
        $va     = $this->input->post() ;
        $lValid = true ;
        $cError = "" ;

        $checkOldPass = $this->bdb->checkOldPass($va['cUsername'],$va['cOldPassword']) ;
        if(empty($checkOldPass)){
            $lValid = false ;
            $cError .= "Password Lama anda Salah! \\n" ;
        }

        if(empty(trim($va['cNewPassword']))){
            $lValid = false ;
            $cError .= "Harap Isi Password Baru Pada Kolom yang Tersedia! \\n" ;
        }

        if($va['cNewPassword'] !== $va['cReNewPassword']){
            $lValid = false ;
            $cError .= "Kolom Konfirmasi Password Baru Tidak Cocok! \\n" ;
        }

        if($lValid){
            $this->changePassword($va) ;
        }else{
            echo('alert("'.$cError.'")');
        }

    }

    public function changePassword($va)
    { 
        $this->bdb->changePassword($va) ;
        echo('
            bos.utlchangepassword.finalAct();    
        ');
    }

    public function logOut()
    {
        $this->session->sess_destroy();
		echo('window.location.href = "'.base_url().'" ;') ;
    }
}