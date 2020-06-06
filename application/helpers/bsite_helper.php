<?php
    defined('BASEPATH') OR exit('No direct script access allowed') ;
    date_default_timezone_set('Asia/Jakarta') ;

    if (!function_exists('listNotifSuratMasuk')){
        function listNotifSuratMasuk(){
            $ci             = get_instance();
            $cKodeKaryawan  = getsession($ci, "KodeKaryawan") ; 
            return $ci->db->select('s.*,u.*,i.*,s.DateTime as DTDisposisi')
                          ->from('surat_masuk_disposisi s')
                          ->join('sys_username u','u.KodeKaryawan = s.Terdisposisi','left')
                          ->join('surat_masuk i','i.Kode = s.Kode','left')
                          ->where(['s.Terdisposisi' => $cKodeKaryawan, 's.Status' => '1'])
                          ->get()
                          ->result_array();
        }
    }

    if(!function_exists('formatSizeUnits')){
        function formatSizeUnits($bytes){
            if ($bytes >= 1073741824){
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }else if ($bytes >= 1048576){
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }else if ($bytes >= 1024){
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }else if ($bytes > 1){
                $bytes = $bytes . ' bytes';
            }else if ($bytes == 1){
                $bytes = $bytes . ' byte';
            }else{
                $bytes = '0 bytes';
            }
            return $bytes;  
        }
    }