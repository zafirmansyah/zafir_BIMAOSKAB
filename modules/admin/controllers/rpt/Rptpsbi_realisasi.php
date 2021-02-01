<?php 

/**
 * 
 */
class Rptpsbi_realisasi extends Bismillah_Controller
{
    
    protected $ss ;
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptpsbi_realisasi_m') ;
        $this->load->model("func/updtransaksi_m") ;
        $this->load->model("func/perhitungan_m") ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptpsbi_realisasi_m ;
    }

    public function index(){
        $this->load->view('rpt/rptpsbi_realisasi') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;

        $file   = setfile($this, "rpt", __FILE__ , $va) ;
        savesession($this, $this->ss . "file", $file ) ;
        savesession($this, $this->ss . "va", json_encode($va) ) ;
        file_put_contents($file, json_encode(array())) ;

        $vare   = array() ;
        $nNilaiAnggaranReguler  = $this->perhitungan_m->getSaldoAnggaran("001",date_2s($va['dTglAkhir'])) ;
        $nNilaiAnggaranTematik  = $this->perhitungan_m->getSaldoAnggaran("002",date_2s($va['dTglAkhir'])) ;
        $nNilaiAnggaranBeasiswa = $this->perhitungan_m->getSaldoAnggaran("003",date_2s($va['dTglAkhir'])) ;
        $vare[] = array("Kode"=>"","WaktuKegiatan"=>"","NamaKegiatan"=>"","PenerimaManfaat"=>"","TujuanManfaat"=>"",
                        "RuangLingkup"=>"","NilaiPengajuan"=>"","LokasiKegiatan"=>"","DetailLokasi"=>"","PesertaPartisipan"=>"",
                        "Permasalahan"=>"","TanggalProposal"=>"","NomorSuratProposal"=>"","JenisBantuan"=>"","DetailBantuan"=>"",
                        "KodeM02Persetujuan"=>"","TanggalPersetujuan"=>"","TanggalRealisasi"=>"","Vendor"=>"","UserName"=>"",
                        "GolonganPSBI"=>"","NilaiRealisasi"=>"",
                        "SaldoReguler"=>$nNilaiAnggaranReguler,"SaldoTematik"=>$nNilaiAnggaranTematik,"SaldoBeasiswa"=>$nNilaiAnggaranBeasiswa ) ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $dbr['SaldoReguler']        = 0 ;
            $dbr['SaldoTematik']        = 0 ;
            $dbr['SaldoBeasiswa']       = 0 ;
            $vaset                      = $dbr ;
            $cGolonganPSBI              = $this->bdb->getval("Keterangan","Kode = '{$dbr['GolonganPSBI']}'","psbi_golongan") ;
            $cLokasiPSBI                = $this->bdb->getval("Keterangan","Kode = '{$dbr['LokasiKegiatan']}'","psbi_lokasi") ;
            $vaset['GolonganPSBI']      = $cGolonganPSBI ;
            $vaset['LokasiKegiatan']    = $cLokasiPSBI ;
            $vaset['Tgl']               = date_2d($dbr['TanggalRealisasi']) ;
            if($dbr['GolonganPSBI'] == "001"){
                $vaset['SaldoReguler'] =  $nNilaiAnggaranReguler -= $dbr['NilaiRealisasi'] ;
            }else if($dbr['GolonganPSBI'] == "002"){
                $vaset['SaldoTematik'] = $nNilaiAnggaranTematik -= $dbr['NilaiRealisasi'] ;
            }else if($dbr['GolonganPSBI'] == "003"){
                $vaset['SaldoBeasiswa'] = $nNilaiAnggaranBeasiswa -= $dbr['NilaiRealisasi'] ;
            }
            $vare[]		            = $vaset ;
            file_put_contents($file, json_encode($vare) ) ;
        }

        $vare 	= array("total"=>$vdb['rows']+1, "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function SeekGolonganPSBI($value='')
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->SeekGolonganPSBI($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
    }

    public function SeekLokasiPSBI($value='')
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->SeekLokasiPSBI($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
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
            $font = 8 ;
            $o    = array('paper'=>'legal', 'orientation'=>'landscape', 'export'=>$cExport,
                            'opt'=>array('export_name'=>'Rptpsbi_realisasi_' . getsession($this, "username") ) ) ;
            $this->load->library('bospdf', $o) ;
            $this->bospdf->ezTable($data,"","",array("fontSize"=>$font,
                                "cols"=> array(
                                                "Kode"=>array("width"=>15,"wrap"=>1,"caption"=>"Kode"),
                                                "WaktuKegiatan"=>array("width"=>15,"wrap"=>1,"caption"=>"WaktuKegiatan"),
                                                "NamaKegiatan"=>array("width"=>15,"wrap"=>1,"caption"=>"NamaKegiatan"),
                                                "PenerimaManfaat"=>array("width"=>15,"wrap"=>1,"caption"=>"PenerimaManfaat"),
                                                "TujuanManfaat"=>array("width"=>15,"wrap"=>1,"caption"=>"TujuanManfaat"),
                                                "RuangLingkup"=>array("width"=>15,"wrap"=>1,"caption"=>"RuangLingkup"),
                                                "NilaiPengajuan"=>array("width"=>15,"wrap"=>1,"caption"=>"NilaiPengajuan"),
                                                "LokasiKegiatan"=>array("width"=>15,"wrap"=>1,"caption"=>"LokasiKegiatan"),
                                                "DetailLokasi"=>array("width"=>15,"wrap"=>1,"caption"=>"DetailLokasi"),
                                                "PesertaPartisipan"=>array("width"=>15,"wrap"=>1,"caption"=>"PesertaPartisipan"),
                                                "Permasalahan"=>array("width"=>15,"wrap"=>1,"caption"=>"Permasalahan"),
                                                "TanggalProposal"=>array("width"=>15,"wrap"=>1,"caption"=>"TanggalProposal"),
                                                "NomorSuratProposal"=>array("width"=>15,"wrap"=>1,"caption"=>"NomorSuratProposal"),
                                                "JenisBantuan"=>array("width"=>15,"wrap"=>1,"caption"=>"JenisBantuan"),
                                                "DetailBantuan"=>array("width"=>15,"wrap"=>1,"caption"=>"DetailBantuan"),
                                                "KodeM02Persetujuan"=>array("width"=>15,"wrap"=>1,"caption"=>"KodeM02Persetujuan"),
                                                "TanggalPersetujuan"=>array("width"=>15,"wrap"=>1,"caption"=>"TanggalPersetujuan"),
                                                "TanggalRealisasi"=>array("width"=>15,"wrap"=>1,"caption"=>"TanggalRealisasi"),
                                                "Vendor"=>array("width"=>15,"wrap"=>1,"caption"=>"Vendor"),
                                                "UserName"=>array("width"=>15,"wrap"=>1,"caption"=>"UserName"),
                                                "GolonganPSBI"=>array("width"=>15,"wrap"=>1,"caption"=>"GolonganPSBI"),
                                                "NilaiRealisasi"=>array("width"=>15,"wrap"=>1,"caption"=>"NilaiRealisasia"),
                                                "SaldoReguler"=>array("width"=>15,"wrap"=>1,"caption"=>"SaldoReguler"),
                                                "SaldoTematik"=>array("width"=>15,"wrap"=>1,"caption"=>"SaldoTematik"),
                                                "SaldoBeasiswa"=>array("width"=>15,"wrap"=>1,"caption"=>"SaldoBeasiswa")
                                            ))) ;
            $this->bospdf->ezStream() ;
        }else{
            echo('Sorry No Data Can Be Fetched!') ;
        }
    }
}


?>