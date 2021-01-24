<?php
class Perhitungan_m extends Bismillah_Model{

    // Bismillahirohmanniraahmin...

    function getTotalRealisasibyLokasi($cKodeLokasi,$dTglAwal='0000-00-00',$dTglAkhir='2099-12-31')
    {
      $nSaldo = 0; 
      $cTable = "psbi_realisasi" ;
      $cWhere = "LokasiKegiatan" ;
      $cField = "SUM('NilaiRealisasi') AS Saldo" ;
      $dbData = $this->select($cTable,$cField,$cWhere) ;
      if($dbR = $this->getrow($dbData)){
        $nSaldo = $dbR['Saldo'] ;
      }
      return $nSaldo ;
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
