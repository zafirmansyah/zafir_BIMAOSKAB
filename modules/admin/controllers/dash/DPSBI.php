<?php
class dPSBI extends Bismillah_Controller{
    private $bdb;
    public function __construct(){
        parent::__construct() ;
        $this->load->model("dash/DPSBI_m") ;
        $this->load->model("func/perhitungan_m") ;
        // $this->load->model("func/updtransaksi_m") ;

        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;

        $this->bdb    = $this->DPSBI_m ;
        // $this->func   = $this->perhitungan_m ;
        
    }

    public function index(){
        $this->load->view("dash/dpsbi") ;
    }

    public function loadc(){
        // $nSaldo = 0 ;
		$va 	= $this->input->post() ;
		//load penjualan
		$d  	= array("labels"=>array(),
							"datasets"=>array(
                                array("label"           => "Realisasi", 
                                      "barPercentage"   => "0.5",
                                      "barThickness"    => "6",
                                      "maxBarThickness" => "8",
                                      "minBarLength"    => "2",
                                      "fill"            => "start",
                                      "backgroundColor" => "rgba(69, 198, 255, .4)", 
                                      "borderColor"     => "#45C6FF",
                                      "data"            => array()),
                                )
							) ;
		$year       = date("Y") ;
		$dTglAwal 	= $year . "-01-01" ;
		$dTglAkhir 	= $year . "-12-31" ;
		$dbData 	= $this->bdb->select("psbi_lokasi", "*") ;
		while($dbRow = $this->bdb->getrow($dbData)){
            $cKodeLokasi    = $dbRow['Kode']; 
            $cLabelLokasi   = $this->bdb->getval("Keterangan", "Kode = '$cKodeLokasi'", "psbi_lokasi") ;

            $cTable     = "psbi_realisasi" ;
            $cWhere     = array() ;
            $cWhere[]   = "LokasiKegiatan = '$cKodeLokasi'" ;
            $cWhere[]   = "TanggalRealisasi >= '$dTglAwal'";
            $cWhere[]   = "TanggalRealisasi <= '$dTglAkhir'";
            $cWhere     = implode(" AND ", $cWhere) ;
            
            $cField     = "SUM(NilaiRealisasi) AS Saldo" ;
            $dbD        = $this->bdb->select($cTable,$cField,$cWhere) ;
            $nSaldo     = 0 ;
            if($dbR = $this->bdb->getrow($dbD)){
                $nSaldo         = $dbR['Saldo'] ;
                $nDataRecords   = $nSaldo;
            }
            
            $d["labels"][]  = $cLabelLokasi ;
            $d["datasets"][0]["data"][] =  $nDataRecords ; //5000 ;
            
		}

		echo(' bos.dpsbi.setc('.json_encode($d).') ; ') ;
    }
    
    public function load_chart_realByGolongan(){
        // $nSaldo = 0 ;
		$va 	= $this->input->post() ;
		//load penjualan
		$d  	= array("labels"=>array(),
							"datasets"=>array(
                                array("label"           => "Realisasi", 
                                    //   "barPercentage"   => "0.5",
                                    //   "barThickness"    => "6",
                                    //   "maxBarThickness" => "8",
                                    //   "minBarLength"    => "2",
                                      "fill"            => "start",
                                      "backgroundColor" => "rgba(90,197,148, .4)", 
                                      "borderColor"     => "#45C6FF",
                                      "data"            => array()),
                                array("label"           => "Plafond", 
                                    //   "barPercentage"   => "0.5",
                                    //   "barThickness"    => "6",
                                    //   "maxBarThickness" => "8",
                                    //   "minBarLength"    => "2",
                                      "fill"            => "start",
                                      "backgroundColor" => "rgba(239,81,54, .4)", 
                                      "borderColor"     => "#45C6FF",
                                      "data"            => array())
                                )
							) ;
		$year       = date("Y") ;
		$dTglAwal 	= $year . "-01-01" ;
		$dTglAkhir 	= $year . "-12-31" ;
        $dbData 	= $this->bdb->select("psbi_golongan", "*") ;
        $n          = 0 ;
		while($dbRow = $this->bdb->getrow($dbData)){
            $n++ ;
            $cKodeLokasi    = $dbRow['Kode']; 
            $cLabelGolongan   = $this->bdb->getval("Keterangan", "Kode = '$cKodeLokasi'", "psbi_golongan") ;

            $cTable     = "psbi_realisasi" ;
            $cWhere     = array() ;
            $cWhere[]   = "GolonganPSBI = '$cKodeLokasi'" ;
            $cWhere[]   = "TanggalRealisasi >= '$dTglAwal'";
            $cWhere[]   = "TanggalRealisasi <= '$dTglAkhir'";
            $cWhere     = implode(" AND ", $cWhere) ;
            $cField     = "SUM(NilaiRealisasi) AS Saldo" ;
            $dbD        = $this->bdb->select($cTable,$cField,$cWhere) ;
            $nSaldo     = 0 ;
            if($dbR = $this->bdb->getrow($dbD)){
                $nSaldo         = $dbR['Saldo'] ;
                $nDataRecords   = $nSaldo;
            }
            
            $cTable     = "psbi_mutasi_anggaran" ;
            $cWhere     = array() ;
            $cWhere[]   = "GolonganPSBI = '$cKodeLokasi'" ;
            $cWhere[]   = "Tgl >= '$dTglAwal'";
            $cWhere[]   = "Tgl <= '$dTglAkhir'";
            $cWhere     = implode(" AND ", $cWhere) ;
            $cField     = "SUM(Debet) AS Saldo" ;
            $dbD        = $this->bdb->select($cTable,$cField,$cWhere) ;
            $nSaldo     = 0 ;
            if($dbR = $this->bdb->getrow($dbD)){
                $nSaldo                 = $dbR['Saldo'] ;
                $nDataRecordsPlafond    = $nSaldo;
            }

            $d["labels"][]              = $cLabelGolongan ;
            $d["datasets"][0]["data"][] =  $nDataRecords ;
            $d["datasets"][1]["data"][] =  $nDataRecordsPlafond ;
            
		}

		echo(' bos.dpsbi.setChartByGolongan('.json_encode($d).') ; ') ;
    }
}

?>