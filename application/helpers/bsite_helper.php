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