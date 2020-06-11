<?php
class Load extends Bismillah_Controller{
   private $bdb ;
   public function __construct(){
      parent::__construct() ;
      $this->load->model('load_m') ;
      $this->bdb    = $this->load_m ;
   }

   public function load_pemilik(){
      $q    = $this->input->get('q') ;
		$vare = array() ;
      $w    = "nik LIKE '". $this->bdb->escape_like_str($q) ."%' OR nama LIKE '". $this->bdb->escape_like_str($q) ."%'" ;
		$dbd 	= $this->bdb->select("v_pemilik", "id, nik, nama, alamat", $w, "", "", "nama ASC", "0,5") ;
		while($dbr    = $this->bdb->getrow($dbd)){
			$vare[]    = array("id"=>$dbr['id'], "text"=>$dbr['nama'] . ' ('. $dbr['nik'] .') ' . ' - ' . $dbr['alamat']) ;
		}
		echo(json_encode($vare)) ;
   }

   public function load_reklame_perpanjangan(){
      $q    = $this->input->get('q') ;
		$vare = array() ;
      $w    = "(code LIKE '%". $this->bdb->escape_like_str($q) ."%' OR teks LIKE '%". $this->bdb->escape_like_str($q) ."%') AND jenis <> '2'" ;
		$dbd 	= $this->bdb->select("v_reklame", "id, code, teks, nama", $w, "", "", "tgl_akhir ASC", "0,5") ;
		while($dbr    = $this->bdb->getrow($dbd)){
			$vare[]    = array("id"=>$dbr['id'], "text"=>$dbr['code'] . ' (' . $dbr['nama'] . ') - ' . $dbr['teks']) ;
		}
		echo(json_encode($vare)) ; 
   }

   public function load_bentuk(){
      $q    = $this->input->get('q') ;
		$vare = array() ;
      $w    = "val LIKE '". $this->bdb->escape_like_str($q) ."%'" ;
		$dbd 	= $this->bdb->select("v_bentuk", "id, val", $w, "", "", "id ASC", "0,5") ;
		while($dbr    = $this->bdb->getrow($dbd)){
			$vare[]    = array("id"=>$dbr['id'], "text"=>$dbr['val']) ;
		}
		echo(json_encode($vare)) ;
   }

   public function load_level(){
      $q      = $this->input->get('q') ;
		$vare   = array() ;
      $vare[] = array("id"=>"0000","text"=>"0000 - Administrator") ;
      $w      = "code LIKE '". $this->bdb->escape_like_str($q) ."%' OR name LIKE '". $this->bdb->escape_like_str($q) ."%'" ;
		$dbd  = $this->bdb->select("sys_username_level", "code, name", $w, "", "", "code ASC", "0,5") ;
		while($dbr    = $this->bdb->getrow($dbd)){
			$vare[]    = array("id"=>$dbr['code'], "text"=>$dbr['code'] . ' - ' . $dbr['name'] ) ;
		}
		echo(json_encode($vare)) ;
   }
}
?>
