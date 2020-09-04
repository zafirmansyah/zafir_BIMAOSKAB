<?php

class Rptsuratmasuk_read_m extends Bismillah_Model
{
    
    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "surat_masuk")){
        $data = $d;
        }
        return $data ;
    }
    
    public function loadGridDataUserDisposisi($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(KodeKaryawan LIKE '{$search}%' OR fullname LIKE '%{$search}%')" ;
        $where[]    = "Jabatan > '002' AND Jabatan <> ''";
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("sys_username", "*", $where, "", "", "KodeKaryawan ASC", $limit) ;
        $dba        = $this->select("sys_username", "KodeKaryawan", $where) ;
        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function getDataTargetDisposisi($cKode){
        $data = array() ;
		if($d = $this->getval("*", "KodeKaryawan = " . $this->escape($cKode), "sys_username")){
            $data = $d;
		}
		return $data ;
    }
    public function SeekJenisSurat($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("jenis_surat", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function saving($va){

        $cKode = $va['cKode'] ;

        $cUserName                 = getsession($this,'username') ;
        $cKodeKaryawanPendisposisi = $this->getval("KodeKaryawan", "username = '$cUserName'","sys_username") ;

        //insert detail po
        $vaGrid = json_decode($va['dataDisposisi']);
        //$this->delete("surat_masuk_disposisi", "Kode = '{$cKode}'" ) ;
        foreach($vaGrid as $key => $val){
            
            $cReceiverKode   = $val->kode ;
            $cReceiverEmail  = $this->getval("Email", "KodeKaryawan = '{$cReceiverKode}'", "sys_username") ; 
            $cReceiverName   = $this->getval("fullname", "KodeKaryawan = '{$cReceiverKode}'", "sys_username") ; 
            $cSenderName     = $this->getval("fullname", "KodeKaryawan = '{$cKodeKaryawanPendisposisi}'", "sys_username") ; 

            $cJenisSurat     = $this->getval("JenisSurat", "Kode='{$cKode}'", "surat_masuk");
            $cKetJenisSurat  = $this->getval("Keterangan", "Kode='{$cJenisSurat}'", "jenis_surat");
           
            $cSuratDari      = $this->getval("Dari", "Kode='{$cKode}'", "surat_masuk");
            $cPerihal        = $this->getval("Perihal", "Kode='{$cKode}'", "surat_masuk");            
            $cLevelDispoAwal = getsession($this,'ss_LEVELDISPOSISI_SuratMasuk_') ;
            $cLevelDisposisi = $cLevelDispoAwal + 1 ;
            if($cLevelDisposisi >= 3){
                $cLevelDisposisi = 3 ;
            }

            $cJabatanSender  = $this->getval("Jabatan", "KodeKaryawan = '{$cKodeKaryawanPendisposisi}'", "sys_username") ; 
            $cLevelDispoSender  = $this->getval("LevelDisposisi", "Kode = '{$cJabatanSender}'", "golongan_jabatan") ; 

            $where          = "Kode = " . $this->escape($cKode) ;
            $vadetail = array("Kode"=>$cKode,
                              "Tgl"=>date_2s($va['dTgl']),
                              "Pendisposisi"=>$cKodeKaryawanPendisposisi,
                              "Terdisposisi"=>$val->kode,
                              "Level"=>$val->level,
                              "Status"=>"1",
                              "UserName"=>$cUserName,
                              "DateTime"=>date('Y-m-d H:i:s'),
                              "Deskripsi"=>$va['cDeskripsi'],
                              "LevelDisposisi"=>$cLevelDispoSender
                            );
            $this->insert("surat_masuk_disposisi",$vadetail);
            
            // Send Email Notification to All Reciever
            $subjectMail    = "NOTIFIKASI BIMA OSKAB - ".$cSenderName." mendisposisi kepada Anda dokumen ".$cKetJenisSurat." dari ".$cSuratDari." perihal ".$cPerihal."" ;
            $headers        = "MIME-Version: 1.0" . "\r\n";
            $headers        .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers        .= 'From: <bimaoskab@gmail.com>' . "\r\n";
            $message = "
                <html>
                    <body>
                    
                    <p>Hallo ".$cReceiverName.",</p>
                    <p>".$cSenderName." mendisposisi kepada Anda dokumen ".$cKetJenisSurat." dari ".$cSuratDari." perihal ".$cPerihal."</p>
                    
                    <p>
                        <a href='bimaoskab.com'>
                            <b>Klik Link Ini Untuk Menuju Aplikasi BIMA OSKAB</b>
                        </a>
                    </p>

                    <p>Terima Kasih</p>
                    <p><b>BIMA OSKAB</b></p>

                    </body>
                </html>
            ";
            
            //mail($cReceiverEmail,$subjectMail,$message,$headers);
        }        

        // Trigger Notifikasi Ke Masing2 Terdisposisi

        require APPPATH . '../vendor/autoload.php';

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '1d87ad16eb0bd12a181f',
            '059b5835bf2f02c082d3',
            '1010070',
            $options
        );

        $data['message'] = 'hello world';
        $pusher->trigger('my-channel', 'my-event', $data);

        return $vaGrid ;
    }
}


?>