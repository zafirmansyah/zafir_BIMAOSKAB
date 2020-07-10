<?php 

/**
 * 
 */
class Con_backupdirektori extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->library('zip');
        $this->load->model('config/con_backupdirektori_m') ;

        $this->bdb = $this->con_backupdirektori_m ;
    }

    public function index(){
        $this->load->view('config/con_backupdirektori') ;
    }

    public function backup()
    {
        $va             = $this->input->post();
        $nTahunBuku     = $va['optTahunBuku'];
        $pathToZip      = APPPATH.'../uploads/SuratSurat/'.$nTahunBuku."/";
        $zipName        = "BackUp_Dokumen_".$nTahunBuku."_".time().".zip" ;
        $fileToDownload = "./tmp/".$zipName;
        $this->zip->read_dir($pathToZip,false);
        $this->zip->archive($fileToDownload);
        echo('
            bos.con_backupdirektori.finalAct("'.$fileToDownload.'","'.$zipName.'");    
        ');
    }

    public function seekTahunBuku()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->seekTahunBuku($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['TahunBuku'], "text"=>$dbr['TahunBuku']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
    }

}

?>