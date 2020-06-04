<?php
class Perhitungan_m extends Bismillah_Model{

    public function GetKeterangan($cKode,$cFieldKeterangan,$cTable){
        if(empty($cFieldKeterangan)){
            $cFieldKeterangan = "keterangan" ;
        }
        $dbData = $this->select($cTable,$cFieldKeterangan,"Kode = '$cKode'");
        return $this->getrow($dbData) ;
    }

    public function devide($a,$b){
        $return = 0;
        if($a > 0 and $b > 0){
            $return = $a / $b;
        }
        return $return ;
    }

    public function GetJumlahHariCuti($dTglAwal='1988-01-01',$dTglAkhir='1988-01-01')
    {
        $dDateNow               = "2020-03-12" ; //date('Y-m-d') ;
        $dTglAwal               = date_2s($dTglAwal);
        $dTglAkhir              = date_2s($dTglAkhir);
        $nSelisihHari           = $this->GetSelisihHari($dTglAwal,$dTglAkhir);
        $nSelisihHariPengajuan  = $this->GetSelisihHari($dDateNow,$dTglAwal);
        $lReturn                = true ;
        $vaReturn               = array() ;
        if($nSelisihHariPengajuan < 7){
            $vaReturn               = array("nHariCuti"=>"0","cMessages"=>"Pengajuan Cuti Sekurang-kurangnya 7 Hari Sebelum Tanggal Yang Diajukan");
        }else{
            $vaHolidayConfig    = explode(';',$this->getconfig('cfgHariLibur')) ;
            $nCountHoliday      = count($vaHolidayConfig) ;
            $lTglMerah          = false ;
            $nHariCuti          = 0 ;
            $nHariLibur         = 0 ;
            
            for($i=0;$i<=$nSelisihHari;$i++){
                $dDateOnLoop    = date( 'Y-m-d',strtotime($dTglAwal .' + '.$i.' days')) ;
                $cWhereLiburNasional  = "tgl_libur = '$dDateOnLoop'" ;
                $dbCheckLiburNasional = $this->select("liburnasional","tgl_libur",$cWhereLiburNasional);
                if($dbRowLiburNasional = $this->getrow($dbCheckLiburNasional)){
                    $nHariLibur++ ;
                }

                $cDayNameOnLoop = date('D',strtotime($dTglAwal .' + '.$i.' days') ) ;
                for($a=0;$a<$nCountHoliday;$a++){
                    if ($cDayNameOnLoop == $vaHolidayConfig[$a]){
                        $nHariLibur++;
                    }
                }

            }
            $nHariCuti = $nSelisihHari + 1 - $nHariLibur ;
            $vaReturn['nHariCuti'] = $nHariCuti ;
            $vaReturn['cMessages'] = "Cuti Sedang Dalam Proses" ;
        }
        
        return $vaReturn ;    
        
    }

    public function GetSelisihHari($dTglAwal,$dTglAkhir,$differenceFormat = '%a')
    {
        $dTglAwal   = date_create($dTglAwal);
        $dTglAkhir  = date_create($dTglAkhir);
        $n          = date_diff($dTglAwal,$dTglAkhir);
        return $n->format($differenceFormat); ;
    }
}
?>