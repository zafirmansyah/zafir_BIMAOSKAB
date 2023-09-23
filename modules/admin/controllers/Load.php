<?php
class Load extends Bismillah_Controller{
	private $bdb ;
	public function __construct(){
		parent::__construct() ;
		$this->load->model('load_m') ;
		$this->bdb    = $this->load_m ;
	}

	public function load_level(){
		$q      = $this->input->get('q') ;
		$vare   = array() ;
		$vare[] = array("id"=>"0000","text"=>"0000 - Administrator") ;
		$w      = "code LIKE '". $this->bdb->escape_like_str($q) ."%' OR name LIKE '". $this->bdb->escape_like_str($q) ."%'" ;
		$dbd  	= $this->bdb->select("sys_username_level", "code, name", $w, "", "", "code ASC", "0,5") ;
		while($dbr    = $this->bdb->getrow($dbd)){
			$vare[]    = array("id"=>$dbr['code'], "text"=>$dbr['code'] . ' - ' . $dbr['name'] ) ;
		}
		echo(json_encode($vare)) ;
	}
	   
	public function load_export(){
		$vare = array() ;  
		$vare[]    = array("id"=>'0', "text"=>"PDF") ;
		$vare[]    = array("id"=>'1', "text"=>"CSV") ;
		$vare[]    = array("id"=>'2', "text"=>"XLSX") ;
		echo(json_encode($vare)) ; 
	}

	function load_PeriodeTriwulan(){
		$vare 		 = array() ;  
		$vare[]    = array("id"=>'0', "text"=>"Triwulan 1") ;
		$vare[]    = array("id"=>'1', "text"=>"Triwulan 2") ;
		$vare[]    = array("id"=>'2', "text"=>"Triwulan 3") ;
		$vare[]    = array("id"=>'3', "text"=>"XLSX") ;
		echo(json_encode($vare)) ; 
	}
}
?>
