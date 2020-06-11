<?php
   defined('BASEPATH') OR exit('No direct script access allowed') ;
    function s_2date($date, $ltime=false){
        $re     = $date ;
        if($ltime){
            $re = date("d-m-Y H:i:s",strtotime($re));
        }else{
            $re = date("d-m-Y",strtotime($re));
        }
        return $re ;
    }

    function date_2s($date){
        $retval = substr($date,0,10) ;
        $va = explode("-",$date) ;
        // Jika Array 1 Bukan Tahun maka akan berisi 2 Digit
        if(strlen($va [0]) == 2){
            $retval = $va [2] . "-" . $va [1] . "-" . $va[0] ;
        }
        return $retval ;
    }
  
    function date_2d($date){
        $retval = substr($date,0,10) ;
        $va = explode("-",$date) ;
        // Jika Array 1 Tahun maka akan berisi 4 Digit
        if(strlen($va [0]) == 4){
            $retval = $va [2] . "-" . $va [1] . "-" . $va[0] ;
        }
        return $retval ;
    }
  
    function date_2t($date){
        if(empty($date)){
            return 0 ;
        }
        $date = date_2d($date) ;  
        $va = explode("-",$date) ;
        return mktime(0,0,0,$va [1],$va[0],$va[2]) ;
    }
    function date_eom($dTgl){
        $day = date_2d($dTgl) ;
        $dBulan = substr($day,3,2) ;
        $dTahun = substr($day,6,4) ;
        $d = date('d-m-Y',mktime(0,0,0,$dBulan+1,0,$dTahun));
        return $d ;
    }
    
    function date_bom($dTgl){
        $day = date_2d($dTgl) ;
        $dBulan = substr($day,3,2) ;
        $dTahun = substr($day,6,4) ;
        $d = date('d-m-Y',mktime(0,0,0,$dBulan,1,$dTahun));
        return $d ;
    }
  
    function date_set($lt=false){
        $cf	= 'DD-MM-YYYY' ;
        if($lt)
            $cf .= ' HH:mm:ss' ;
        return 'data-date-format="'.$cf.'"' ;
    }
  
    function date_periodset($month=false){
        $cf	= 'YYYY' ;
        if($month)
            $cf = 'MM-YYYY' ;
        return 'data-date-format="'.$cf.'"' ;
    }
  
    function date_day($v){
        $va  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu") ;
        return strtoupper($va[$v]) ;
    }
  
    function date_month($v){
        $va  = array("Januari","Februari","Maret","April","Mei","Juni","Juli",
                    "Agustus","September","Oktober","November","Desember") ;
        return strtoupper($va[$v]) ;
    }
  
    function date_romawi($v){
        $va  = array("I","II","III","IV","V","VI","VII",
                    "VIII","IX","X","XI","XII") ;
        return strtoupper($va[$v]) ;
    }
  
    function date_2b($date=''){
        //date 2 bahasa
        $vad = getdate(strtotime($date)) ;
        $va  = array("d"=>$vad['mday'],"day"=> date_day($vad['wday']),
                    "m"=> date_month($vad['mon']-1),"y"=>$vad['year']) ;
        return $va ;
    }
  
    function date_now(){
        return date("Y-m-d H:i:s") ;
    }
  
    function sql_2sql($cChar){
        $cChar = str_replace("\\","\\\\",$cChar) ;
        $cChar = str_replace("'","\'",$cChar) ;
        $cChar = str_replace('"','\"',$cChar) ;
        return $cChar ;
    }

    function sql_2str($cChar){
        $cChar = str_replace("\\\\","\\",$cChar) ;
        $cChar = str_replace("\'","'",$cChar) ;
        $cChar = str_replace('\"','"',$cChar) ;
        return $cChar ;
    }
?>
