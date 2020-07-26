<?php 


/**
 * 
 */
class Tcwo_master_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $limit    = $va['offset'].",".$va['limit'] ;
        $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search   = $this->escape_like_str($search) ;
        $where 	 = array() ; 
        $where[]    = "Status <> 'D'";
        if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	 = implode(" AND ", $where) ;
        $dbd      = $this->select("work_order_master", "*", $where, "", "", "Kode DESC", $limit) ;
        $dba      = $this->select("work_order_master", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function loadGridDataUserDisposisi($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(KodeKaryawan LIKE '{$search}%' OR fullname LIKE '%{$search}%')" ;
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("sys_username", "*", $where, "", "", "KodeKaryawan ASC", $limit) ;
        $dba        = $this->select("sys_username", "KodeKaryawan", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }
    
    public function getKodeWO()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "WO" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function saving($va){

        //var_dump($va);    
        $cKode = $va['cKode'] ;
        $cUserName      = getsession($this,'username') ;
        
        $this->delete("work_order_master", "Kode = '{$cKode}'" ) ;
        $vaData         = array("Kode"=>$cKode, 
                                "Tgl"=>date_2s($va['dTgl']),
                                "Subject"=>$va['cSubject'],
                                "Deskripsi"=>$va['cDeskripsi'],
                                "TujuanUserName"=>$va['optUserName'],
                                "UserName"=>$cUserName ,
                                "DateTime"=>date('Y-m-d H:i:s'),
                                "Status"=>$va['cStatus']
                                ) ;
        $this->insert("work_order_master",$vaData);
        
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
        $pusher->trigger('my-channel-wo', 'my-event-wo', $data);

        $cReceiverKode   = $va['optUserName'] ;
        $cReceiverEmail  = $this->getval("Email", "KodeKaryawan = '{$cReceiverKode}'", "sys_username") ; 
        $cReceiverName   = $this->getval("fullname", "KodeKaryawan = '{$cReceiverKode}'", "sys_username") ; 
        $cSenderName     = $this->getval("fullname", "username = '{$cUserName}'", "sys_username") ; 

        $subjectMail    = "NOTIFIKASI BIMA OSKAB - Work Order Baru Untuk Anda" ;
        $headers        = "MIME-Version: 1.0" . "\r\n";
        $headers        .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers        .= 'From: <bimaoskab@gmail.com>' . "\r\n";
        $message = "
            <html>
                <body>
                <p>
                    Anda telah mendapat work order <b><i>" . $va['cSubject'] . "</i></b>, 
                    Silahkan dicek dan lakukan pengerjaan pada aplikasi BIMA OSKAB.
                </p>
                
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
        
        mail($cReceiverEmail,$subjectMail,$message,$headers);

        return $vaData ;
    }

    public function saveFile($va)
    {
        $cKode          = $va['cKode'] ;
        $cUserName      = getsession($this,'username') ;
        $vaData = array("Kode"=>$cKode, 
                        "Tgl"=>date_2s($va['dTgl']),
                        "FilePath"=>$va['FilePath'],
                        "UserName"=>$cUserName ,
                        "DateTime"=>date('Y-m-d H:i:s')
        ) ;
        $where      = "Kode = " . $this->escape($cKode) ;
        $this->insert("work_order_master_file", $vaData, $where, "") ;
    }

    public function deleteFile($va)
    {
        $cKode  = $va['cKode'] ;
        $cWhere = "Kode = '$cKode'" ;
        $this->delete('work_order_master_file',$cWhere);
    }

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "work_order_master")){
        $data = $d;
        }
        return $data ;
    }

    public function deleting($id){
        //$this->delete("work_order_master", "Kode = " . $this->escape($id)) ;
        $vaUpd = array('Status'=>"D");
        $where = "Kode= " . $this->escape($id);
        $this->update("work_order_master", $vaUpd, $where, "");
    }

    public function seekGolonganUnit($search)
    {
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("golongan_unit", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function seekUserName($search)
    {
        $cWhere     = array() ; 
        $cWhere[]   = "username <> ''" ;
        if($search !== "") $cWhere[]   = "(username LIKE '%{$search}%' OR fullname LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("sys_username", "username,fullname", $cWhere, "", "", "username ASC") ;
        return array("db"=>$dbd) ;
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


    public function getDataTargetDisposisi($cKode)
    {
        $data = array() ;
		if($d = $this->getval("*", "KodeKaryawan = " . $this->escape($cKode), "sys_username")){
            $data = $d;
		}
		return $data ;
    }

    /*
    Kode Status WO
    0 = new
    1 = start
    2 = pending
    3 = reject
    F = finish
    D = delete
    */
}

 ?>