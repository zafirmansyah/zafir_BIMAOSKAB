<?php

class Utlchangepp extends Bismillah_Controller
{
 
    public function __construct(){
        parent::__construct() ;
        $this->load->model('config/utlchangepp_m') ;
        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;

        $this->bdb = $this->utlchangepp_m ;
    }

    public function index(){
        $va['cUsername'] = getsession($this,'username') ;
        $this->load->view('config/utlchangepp',$va) ;
    }

    public function initComp(){
        $cUsername  = getsession($this,"username") ;
		$w    	    = "username = ".$this->bdb->escape($cUsername) ;
		$data 	    = $this->bdb->getval("*", $w, "sys_username") ;
		if(!empty($data)){
            $image 			= "" ;
			$data_var		= ($data['data_var'] !== "") ? json_decode($data['data_var'], true) : array() ;
			if(isset($data_var['ava'])){
				$image 	= '<img src=\"'.base_url($data_var['ava']).'\" class=\"img-responsive\"/>' ;
			}
			
			echo('
				with(bos.utlchangepp.obj){
					find("#idimage").html("'.$image.'") ;
				}
			') ;
		}
    }
    
    public function saving_image(){
		$fcfg	= array("upload_path"=>"./tmp/", "allowed_types"=>"jpg|jpeg|png", "overwrite"=>true) ;

		savesession($this, "ssusername_image", "") ;
		$this->load->library('upload', $fcfg) ;
		if ( ! $this->upload->do_upload(0) ){
			echo('
				alert("'. $this->upload->display_errors('','') .'") ;
				bos.utlchangepp.obj.find("#idlimage").html("") ;
			') ;
		}else{
			$data 	= $this->upload->data() ;
			$tname 	= str_replace($data['file_ext'], "", $data['client_name']) ;
			$vimage	= array( $tname => $data['full_path']) ;
			savesession($this, "ssusername_image", json_encode($vimage) ) ;

			echo('
				bos.utlchangepp.obj.find("#idlimage").html("") ;
				bos.utlchangepp.obj.find("#idimage").html("<img src=\"'.base_url("./tmp/" . $data['client_name'] . "?time=". time()).'\" class=\"img-responsive\" />") ;
			') ;
		}
    }
    
    public function saving(){
		$va 		= $this->input->post() ;
		$cUsername 	= getsession($this,"username") ;
		$w    		= "username = ".$this->bdb->escape($cUsername) ;
		  
		if( $dblast = $this->bdb->getval("*", $w, "sys_username") ){
			$dblast['data_var']	= ($dblast['data_var'] !== "") ? json_decode($dblast['data_var'], true) : array() ;
		}
		
		if(empty($dblast)){
			$dblast = array("data_var"=>array('ava'=>"")) ;
		}

		$data['data_var']	= array("ava"=>$dblast['data_var']['ava']) ;

		$vimage = json_decode(getsession($this, "ssusername_image", "{}"), true) ;
		if(!empty($vimage)){
			$adir 	= $this->config->item('bcore_uploads') . "users_pict/";
			if(!is_dir($adir)){
				mkdir($adir,0777,true);
			}

			foreach ($vimage as $key => $img) {
				$vi		= pathinfo($img) ;
				$dir 	= $adir ;
				$dir 	.=  $key . "_".date("dmy_Hi") . "." . $vi['extension'] ;
				if(is_file($dir)) @unlink($dir) ;
				if(@copy($img,$dir)){
					@unlink($img) ;
					@unlink($dblast['data_var']['ava']) ;
					$data['data_var']['ava']	= $dir;
				}
			}
		}
		$data['data_var']	= json_encode($data['data_var']) ;

		$this->bdb->update("sys_username", $data, $w, "username") ;
		echo(' bos.utlchangepp.finalAct() ; ') ;
    }
    
    public function logOut()
    {
        $this->session->sess_destroy();
		echo('window.location.href = "'.base_url().'" ;') ;
    }
    
}


?>