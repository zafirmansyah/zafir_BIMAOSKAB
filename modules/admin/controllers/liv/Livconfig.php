<?php


class Livconfig extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model("liv/livconfig_m") ;
        $this->bdb = $this->livconfig_m ;
        // $this->load->model("include/perhitungan_m") ;
    }

    public function index(){
        $this->load->view("liv/livconfig") ;
    }

    public function loadgrid(){
		$va		= json_decode($this->input->post('request'), true) ;
		$db 	= $this->bdb->loadgrid($va) ;
		$vare 	= array() ;
		$n		= 0 ;
		while( $dbrow	= $this->bdb->getrow($db['db']) ){
			$n++ ;
			$vaset 		        = $dbrow ;
			$vaset['recid']		= $dbrow['ID'] ;
			$vaset['Nomor'] 	= $n ;
			$vaset['TglAwal'] 	= date_2d($dbrow['TglAwal']);
			$vaset['TglAkhir'] 	= date_2d($dbrow['TglAkhir']);
			$vaset['cmdedit'] 	= '<button type="button" onClick="bos.livconfig.cmdedit(\''.$dbrow['ID'].'\')"
									class="btn btn-success btn-grid">Edit</button>' ;
			$vaset['cmddelete'] = '<button type="button" onClick="bos.livconfig.cmddelete(\''.$dbrow['ID'].'\')"
									class="btn btn-danger btn-grid">Delete</button>' ;
			$vaset['cmdedit']	= html_entity_decode($vaset['cmdedit']) ;
			$vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

			$vare[]		= $vaset ;
		}

		$vare 	= array("total"=> $db['rows'], "records"=>$vare ) ;
		echo(json_encode($vare)) ;
	}

    public function PickNomorKaryawan(){
		$search     = $this->input->get('q');
		$vdb    	= $this->bdb->PickNomorKaryawan($search) ;
		$dbd    	= $vdb['db'] ;
		$vare   	= array();
		while( $dbr = $this->bdb->getrow($dbd) ){
			$vare[] 	= array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] . " [ " . $dbr['Nama'] . " ]") ;
		}
		$Result = json_encode($vare);
		echo($Result) ;
	}

	public function saving()
	{
		$va 			 = $this->input->post();
		$chkAll 		 = $va['chkAll'];
		if(isset($chkAll)){
			$va['HakKepada'] = "ALL";
		}else{
			$va['HakKepada'] = $va['optNIK'] ;
		}
		$save = $this->bdb->savingProcess($va);
		echo('
			alert("Data Saved");
			bos.livconfig.init() ;
		');
	}
}

?>