<?php
class Perhitungan_m extends Bismillah_Model{

    // Bismillahirohmanniraahmin...

    function GetRepaymentCapacity($cKodeFPK,$cKodeAnalisa){
      $nRC = 0 ;

      $vaData = $this->getval("*","KodeFPK = '$cKodeFPK' AND KodeAnalisa = '$cKodeAnalisa'","analisa_pekerjaan") ;

      $nPenghasilanGaji     = $vaData['PenghasilanGaji'];
      $nPenghasilanLainnya  = $vaData['PenghasilanLainnya'];
      $nTotalPenghasilan    = $nPenghasilanGaji + $nPenghasilanLainnya ;

      $nBiayaRumahTangga    = $vaData['BiayaRumahTangga'];
      $nBiayaTetapLainnya   = $vaData['BiayaTetapLainnya'];
      $nTotalBiaya          = $nBiayaRumahTangga + $nBiayaTetapLainnya ;

      $nPendapatanNett      = $nTotalPenghasilan - $nTotalBiaya ;

      $nKewajibanPerBulan   = $vaData['KewajibanPerBulan'];

      $nRC  = $nPendapatanNett / $nKewajibanPerBulan ;

      return $nRC ;

    }

    function GetDBR($cKodeFPK,$cKodeAnalisa){
      $vaData = $this->getval("*","KodeFPK = '$cKodeFPK' AND Kode = '$cKodeAnalisa'","analisa_usaha") ;
      
      $nfin_OmzetPenjualan	        = $vaData['fin_OmzetPenjualan'];
      $nfin_HPP	                    = $vaData['fin_HPP'];
      $nfin_BiayaUsahaLainnya	      = $vaData['fin_BiayaUsahaLainnya'];

      $nTotalPendapatanUsaha        = $nfin_OmzetPenjualan - $nfin_HPP - $nfin_BiayaUsahaLainnya ;

      $nfin_PendapatanUsahaLainnya	= $vaData['fin_PendapatanUsahaLainnya'];
      $nfin_PenghasilanGaji	        = $vaData['fin_PenghasilanGaji'];

      $nTotalPendapatanSelainUsaha  = $nfin_PendapatanUsahaLainnya + $nfin_PenghasilanGaji ;
      $nTotalPendapatanALL          = $nTotalPendapatanUsaha + $nTotalPendapatanSelainUsaha ;

      $nfin_BiayaRumahTangga	      = $vaData['fin_BiayaRumahTangga'];
      $nfin_BiayaTetapLainnya	      = $vaData['fin_BiayaTetapLainnya'];
      $nfin_AngsuranPinjamanExist	  = $vaData['fin_AngsuranPinjamanExist'];

      $nTotalBiaya                  = $nfin_BiayaRumahTangga + $nfin_BiayaTetapLainnya + $nfin_AngsuranPinjamanExist ;

      $nfin_AngsuranPinjamanNew	    = $vaData['fin_AngsuranPinjamanNew'];
      
      $nTotalAngsuran               = $nfin_AngsuranPinjamanExist + $nfin_AngsuranPinjamanNew ;

      $nDBR                         = $nTotalAngsuran / $nTotalPendapatanALL * 100 ;

      return $nDBR ;

    }

    function GetWINEED($cKodeFPK,$cKodeAnalisa){
      $va = array() ;

      $vaData = $this->getval("*","KodeFPK = '$cKodeFPK' AND Kode = '$cKodeAnalisa'","analisa_usaha") ;

      $nfin_HPP	               = $vaData['fin_HPP'];
      $nfin_OmzetPenjualan	   = $vaData['fin_OmzetPenjualan'];


      $nfinwi_Persediaan	     = $vaData['finwi_Persediaan'];
      $nfinwi_HutangDagang	   = $vaData['finwi_HutangDagang'];
      $nfinwi_PiutangDagang	   = $vaData['finwi_PiutangDagang'];
      
      $nDOHx                   = $nfinwi_Persediaan / $nfin_HPP * 30 ;
      $nDOHy                   = $nfinwi_PiutangDagang / $nfin_OmzetPenjualan * 30 ;
      $nDOHz                   = $nfinwi_HutangDagang / $nfin_HPP * 30 ;
      $nSUMDOH                 = $nDOHx + $nDOHy - $nDOHz ;

      $va['valWINEED1']        = $nfinwi_Persediaan + $nfinwi_PiutangDagang - $nfinwi_HutangDagang ;
      $va['valWINEED2']        = $nSUMDOH / 30 * $nfin_HPP ;
      return $va ;
    }

    public function GetIDIR($cKodeAnalisa)
    {
        $vaData = $this->getval("*","KodeAnalisa = '$cKodeAnalisa'","analisa_keuangan") ;

        $nPenjualanPerBulan         = $vaData['PenjualanPerBulan'];
        $nHPP                       = $vaData['HPP'];
        $nPenghasilanUsahaLainnya   = $vaData['PenghasilanUsahaLainnya'];

        $nBiayaSewaUsaha            = $vaData['BiayaSewaUsaha'];
        $nBiayaGajiPegawaiUsaha     = $vaData['BiayaGajiPegawaiUsaha'];
        $nBiayaListrikUsaha         = $vaData['BiayaListrikUsaha'];
        $nBiayaTransportasiUsaha    = $vaData['BiayaTransportasiUsaha'];
        $nBiayaLainnyaUsaha         = $vaData['BiayaLainnyaUsaha'];
        $nBelanjaRumahTangga        = $vaData['BelanjaRumahTangga'];
        $nBiayaSewaRumah            = $vaData['BiayaSewaRumah'];
        $nBiayaPendidikan           = $vaData['BiayaPendidikan'];
        $nBiayaListrikRumah         = $vaData['BiayaListrikRumah'];
        $nBiayaTransportasiRumah    = $vaData['BiayaTransportasiRumah'];
        $nBiayaLainnyaRumah         = $vaData['BiayaLainnyaRumah'];
        $nBiayaAngsuranPinjamanNow  = $vaData['BiayaAngsuranPinjamanNow'];

        $nTotalPendapatan           = $nPenjualanPerBulan - $nHPP + $nPenghasilanUsahaLainnya ;
        $nTotalBiaya                = $nBiayaSewaUsaha + $nBiayaGajiPegawaiUsaha + $nBiayaListrikUsaha + $nBiayaTransportasiUsaha + 
                                        $nBiayaLainnyaUsaha + $nBelanjaRumahTangga + $nBiayaSewaRumah + 
                                        $nBiayaPendidikan + $nBiayaListrikRumah + $nBiayaTransportasiRumah + $nBiayaLainnyaRumah + $nBiayaAngsuranPinjamanNow;
        
        $nRekomendasiAngsuran       = $vaData['RekomendasiAngsuran'];

        $nIDIR                      =  ($nTotalPendapatan - $nTotalBiaya) / $nRekomendasiAngsuran  ;
        return $nIDIR ;

    }

    function Terbilang($nNilai,$cRupiah=true){
        $nNilai1 = strval(intval($nNilai)); 
        $nNilai1 = str_pad($nNilai1,12,"0",STR_PAD_LEFT);  

        $cPecahan = $this->Konfersi(substr($nNilai,-2));
        if($cPecahan == ""){
            $cPecahan = "";
        }
        $cSatuan = $this->Konfersi(substr($nNilai1,9,3));
        if($cSatuan == ""){
            $cSatuan = "" ;  
        }  
        $cRibuan = $this->Konfersi(substr($nNilai1,6,3));
        if($cRibuan == ""){    
            $cRibuan = "" ;       
        }else{
            $cRibuan .= "RIBU ";
        }  
        $cJutaan = $this->Konfersi(substr($nNilai1,3,3));
        if($cJutaan == ""){
            $cJutaan = "" ;  
        }else{
            $cJutaan .= "JUTA ";
        }  
        $cMilyar = $this->Konfersi(substr($nNilai1,0,3));
        if($cMilyar == ""){
            $cMilyar = "" ;  
        }else{
            $cMilyar .= " MILYAR ";
        }  
      
        if($cRupiah){
            $cRetval = $cMilyar . $cJutaan . $cRibuan . $cSatuan . " RUPIAH"  ;
            if($cRetval == ""){
            $cRetval = "";
            }
        }else{
            $cRetval = $cMilyar . $cJutaan . $cRibuan . $cSatuan ;
            if($cPecahan !== ""){
                $cRetval = $cMilyar . $cJutaan . $cRibuan . $cSatuan . "KOMA " . $cPecahan;
                if($cMilyar == "" and $cRibuan == "" and $cSatuan == ""){
                    $cRetval = "NOL " . "KOMA " . $cPecahan;
                }
                if($nNilai = 11){
            
                }
            }      
        }  
        return $cRetval ;
    } 

    function Konfersi($nNilai){    
    $_1 = array("1"=>'SE',"2"=>'DUA ',"3"=>'TIGA ',"4"=>'EMPAT ',"5"=>'LIMA ',"6"=>'ENAM ',"7"=>'TUJUH ',"8"=>'DELAPAN ',"9"=>'SEMBILAN ');
    $_2 = array("1"=>'SE',"2"=>'DUA ',"3"=>'TIGA ',"4"=>'EMPAT ',"5"=>'LIMA ',"6"=>'ENAM ',"7"=>'TUJUH ',"8"=>'DELAPAN ',"9"=>'SEMBILAN ');
    $_3 = array("1"=>'SATU',"2"=>'DUA ',"3"=>'TIGA ',"4"=>'EMPAT ',"5"=>'LIMA ',"6"=>'ENAM ',"7"=>'TUJUH ',"8"=>'DELAPAN ',"9"=>'SEMBILAN ');   
    $nLen = strlen($nNilai); 
    $nNilai = str_pad($nNilai,3,"0",STR_PAD_LEFT);
    $cKonfersi = "" ;
    for($i=1;$i<4;$i++){ 
      $nBilangan = intval(substr($nNilai,$i - 1,1)); 
      $vaArray   = "_" . $i;
      $jenis = "" ;
      foreach($$vaArray as $key=>$value){
        if($key == $nBilangan){          
          if($nBilangan !== 0 and $i == 1){
            $jenis = "RATUS ";
          }else if($nBilangan !== 0 and $i == 2){
            if($nBilangan !== 1 and substr($nNilai,2,1) !== 1){
              $jenis = "PULUH ";
            }else{
              if(substr($nNilai,2,1) > 1){
                $jenis = "";
                $value = "" ;
              }else{
                if(substr($nNilai,2,1) == 0){
                  $jenis = "PULUH ";
                }else{                 
                  $jenis = "BELAS ";
                }                
              }            
            }           
         }else if($i == 3){           
            if(substr($nNilai,2,1) > 1 and substr($nNilai,1,1) == 1){
                $jenis = "BELAS " ;                
            }else{
                if(substr($nNilai,1,1) == 1){
                  $jenis = "" ;   
                  $value = " " ;     
                }else{
                  $jenis = "" ;   
                }
            } 
           
         }
          $cKonfersi .= " " . $value . $jenis   ; 
        }
      }
    }
    return $cKonfersi  ;
  }  
}
?>
