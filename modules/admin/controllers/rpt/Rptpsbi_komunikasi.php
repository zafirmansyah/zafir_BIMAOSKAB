<?php 

/**
 * 
 */
class Rptpsbi_komunikasi extends Bismillah_Controller
{
    protected $ss ;
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptpsbi_komunikasi_m') ;
        $this->load->model("func/updtransaksi_m") ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptpsbi_komunikasi_m ;
    }

    public function index(){
        $this->load->view('rpt/rptpsbi_komunikasi') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;

        $file   = setfile($this, "rpt", __FILE__ , $va) ;
        savesession($this, $this->ss . "file", $file ) ;
        savesession($this, $this->ss . "va", json_encode($va) ) ;
        file_put_contents($file, json_encode(array())) ;
        $nSUMPengAnggaran = 0 ;
        $vare   = array() ;
        $vaSum = array("recid"=>"zzzz1",
                        "Kode"=>"<b>JUMLAH</b>",
                        "NamaProgram"=>"",
                        "UnitKerja"=>"",
                        "LatarBelakangKegiatan"=>"",
                        "Tujuan"=>"",
                        "WaktuPelaksanaan"=>"",
                        "Narasumber"=>"",
                        "Saluran"=>"",
                        "Peserta"=>"",
                        "PersepsiStakeHolder"=>"",
                        "PenggunaanAnggaran"=>"0",
                        "DampakOutput"=>"",
                        "w2ui"=>array("summary"=>true));

        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset                  = $dbr ;
            $vaset['Tgl']                   = date_2d($dbr['Tgl']) ;
            $vaset['WaktuPelaksanaan']      = date_2d($dbr['WaktuPelaksanaan']) ;
            $nSUMPengAnggaran               += $vaset['PenggunaanAnggaran'] ;
            $vare[]		                    = $vaset ;
            unset($vare['UserName']);
            unset($vare['DateTime']);
            file_put_contents($file, json_encode($vare) ) ;
        }
        $vaSum['PenggunaanAnggaran'] = $nSUMPengAnggaran;
        $vare[] = $vaSum;
        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function initReport()
    {
        $va         = json_decode(getsession($this, $this->ss . "va", "{}"), true) ;
        $this->showReport($va) ;
    }

    public function showReport($va){
        $va         = json_decode(getsession($this, $this->ss . "va", "{}"), true) ;
        $cExport    =  $va['cExportRpt'] ;
        
        $file = getsession($this, $this->ss . "file") ;
        $data = @file_get_contents($file) ;
        $data = json_decode($data,true) ;
        if(!empty($data)){
            unset($data['DateTime']);
            unset($data['UserName']);
            $font = 8 ;
            $o    = array('paper'=>'A3', 'orientation'=>'landscape', 'export'=>$cExport,
                            'opt'=>array('export_name'=>'Rptpsbi_komunikasi_' . getsession($this, "username") . date('ymdhis') ) ) ;
            $this->load->library('bospdf', $o) ;
            $this->bospdf->ezTable($data,"","",array("fontSize"=>$font,
                                "cols"=> array(
                                                "Kode"=>array("width"=>8,"wrap"=>1,"caption"=>"Kode"),
                                                "Tgl"=>array("width"=>8,"wrap"=>1,"caption"=>"Tgl"),
                                                "NamaProgram"=>array("width"=>8,"wrap"=>1,"caption"=>"Nama Program"),
                                                "UnitKerja"=>array("width"=>8,"wrap"=>1,"caption"=>"Unit Kerja"),
                                                "LatarBelakangKegiatan"=>array("width"=>8,"wrap"=>1,"caption"=>"Latar Belakang Kegiatan"),
                                                "Tujuan"=>array("width"=>8,"wrap"=>1,"caption"=>"Tujuan"),
                                                "WaktuPelaksanaan"=>array("width"=>8,"wrap"=>1,"caption"=>"Progress Pelaksanaan;Waktu Pelaksanaan"),
                                                "Narasumber"=>array("width"=>8,"wrap"=>1,"caption"=>"Progress Pelaksanaan;Narasumber"),
                                                "Saluran"=>array("width"=>8,"wrap"=>1,"caption"=>"Progress Pelaksanaan;Saluran"),
                                                "Peserta"=>array("width"=>8,"wrap"=>1,"caption"=>"Progress Pelaksanaan;Peserta"),
                                                "PersepsiStakeHolder"=>array("width"=>8,"wrap"=>1,"caption"=>"Persepsi StakeHolder"),
                                                "PenggunaanAnggaran"=>array("width"=>8,"wrap"=>1,"caption"=>"Penggunaan Anggaran"),
                                                "DampakOutput"=>array("width"=>8,"wrap"=>1,"caption"=>"Dampak Output")
                                            ))) ;
            $this->bospdf->ezStream() ;
        }else{
            echo('Sorry No Data Can Be Fetched!') ;
        }
    }
}


?>