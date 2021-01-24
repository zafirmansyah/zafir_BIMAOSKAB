<?php
class Frame extends Bismillah_Controller{
	public function __construct(){
		parent::__construct() ;
		$this->load->helper('bmenu') ;
        $this->load->model('frame_m');

        // include functions
        $this->load->model('func/func_m') ;
        $this->load->model('func/perhitungan_m') ;
        $this->load->model('func/updtransaksi_m') ;

        $this->func 	        = $this->func_m ;
        $this->perhitungan_m 	    = $this->perhitungan_m ;
        $this->updtransaksi_m 	= $this->updtransaksi_m ;
	}

	public function index(){
		$arrmenu= menu_get($this, APPPATH . "../modules/admin/menu.php", "bmenu", "Administrator") ;
		$oinit 	= getsession($this, "dash") ;
		if($oinit == "") $oinit= md5("admin/dash/main") ;
		$oinit 	= menu_get_data($arrmenu, $oinit) ;

		$data 	= array("app_title"	=> getsession($this, "app_title"),
								"fullname"	=> getsession($this, "fullname"),
								"username"	=> getsession($this, "username"),
								"data_var"	=> getsession($this, "data_var"),
								"menu_html"	=> $this->menu_generate($arrmenu),
								"oinit"		=> $oinit ) ;
		$this->load->view("frame", $data) ;
	}

	//private function for menu adminlte
	private function menu_generate($arrmenu){
		$level_code 	= getsession($this, "level_code") ;
		$level_value 	= getsession($this, "level_value") ;

		$html 	= '' ;
		foreach ($arrmenu as $key => $value) {
			$v 	= true ;
			if($level_code !== "0000"){
				$v 	= false;
				if( strpos($level_value, $value['md5']) > -1) $v = true;
			}
			if($v){
				$onclick 	= '' ;
				if($value['loc'] !== ""){
					$onclick= 'onclick="form_mobile('.htmlspecialchars(json_encode($value)).');"' ;
				}

				$child 		= array('indi'=>'', 'data'=>'') ;
				if(isset($value['children'])){
					$child['indi'] 	= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>' ;
					$child['data']	= '<ul class="treeview-menu">' . $this->menu_generate($value['children']) . '</ul>' ;
				}

				$html .= '<li id="'.$value['md5'].'" '.$onclick.'>' ;
				$html .= '	<a href="#"><i class="'.$value['icon'].'"></i>&nbsp;';
				$html .= '		<span>'.$value['name'].'</span>' ;
				$html .= 		$child['indi'] ;
				$html .= '	</a>' ;
				$html .= 		$child['data'];
				$html .= '</li>' ;
			}
		}
		return $html;
	}

	public function logout(){
		$this->session->sess_destroy();
		echo('window.location.href = "'.base_url().'" ;') ;
	}

	function notifikasiSuratMasuk()
	{
		return $this->load->view('frame_notif_surat_masuk');
	}

	function notifikasiWorkOrder()
	{
		return $this->load->view('frame_notif_work_order');
	}
	
	function notifikasiM02Prinsip()
	{
		return $this->load->view('frame_notif_m02prinsip');
	}



	public function setSessionIDSurat()
	{
        $cKode      = $this->input->post('cKode');
        $cTerdisposisi = getsession($this,"KodeKaryawan");        
        $dbData     = $this->frame_m->getDetailSuratMasuk($cKode);
        $vaFileList = $this->getfilelist($cKode);
        $vaSess     = array() ;
        if($dbRow = $this->frame_m->getrow($dbData)){        
            $vaSess['ss_ID_SuratMasuk_']            = $cKode ;
            $vaSess['ss_PERIHAL_SuratMasuk_']       = $dbRow['Perihal'] ;
            $vaSess['ss_DARI_SuratMasuk_']          = $dbRow['Dari'] ;
            $vaSess['ss_DATETIME_SuratMasuk_']      = $dbRow['DateTime'] ;
            $vaSess['ss_NOSURAT_SuratMasuk_']       = $dbRow['NoSurat'] ;
            $vaSess['ss_TANGGAL_SuratMasuk_']       = $dbRow['Tgl'];
            $vaSess['ss_FILEITEM_SuratMasuk_']      = $vaFileList;
            $vaSess['ss_DESKRIPSI_SuratMasuk_']     = $this->frame_m->getDeskripsiDisposisiSurat($cKode,$cTerdisposisi);
            foreach ($vaSess as $key => $value) {
				savesession($this, $key, $value) ;
			}
        }
		// echo('alert("Hahahaha '. $cKode .' ");');
	}

	public function getfilelist($cKode){
        $dbData = $this->frame_m->getFileListSuratMasuk($cKode);
        $i = 0;
        $vaData = array();
        while($dbRow = $this->frame_m->getrow($dbData)){
            $vaData[$i]=$dbRow;
            $i++;
        }        
        return $vaData;
    }

	public function setSessionIDM02()
    {
		$cFaktur        = $this->input->post('cKode');
        $dbData         = $this->frame_m->getDetailM02($cFaktur);
        $vaFileList     = $this->getfilelistM02($cFaktur);
        $vaSess         = array() ;
        if($dbRow = $this->frame_m->getrow($dbData)){        
            $vaSess['ss_ID_M02PRINSIP_']            = $cFaktur ;
            $vaSess['ss_KODEDISPO_M02PRINSIP_']     = $dbRow['KodeDisposisi'];
            $vaSess['ss_PERIHAL_M02PRINSIP_']       = $dbRow['Perihal'] ;
            $vaSess['ss_DARI_M02PRINSIP_']          = $dbRow['UserName'] ;
            $vaSess['ss_NOSURAT_M02PRINSIP_']       = $dbRow['NoSurat'] ;
            $vaSess['ss_TANGGAL_M02PRINSIP_']       = $dbRow['Tgl'];
            $vaSess['ss_DETAIL_M02PRINSIP_']        = $dbRow['Deskripsi'];
            $vaSess['ss_FILEITEM_M02PRINSIP_']      = $vaFileList;
            $vaSess['ss_DATETIME_M02PRINSIP_']      = $dbRow['DateTime'] ;
            foreach ($vaSess as $key => $value) {
				savesession($this, $key, $value) ;
			}
        }
	}
	
	public function getfilelistM02($cKode){
        $dbData = $this->frame_m->getFileListM02($cKode);
        $i = 0;
        $vaData = array();
        while($dbRow = $this->frame_m->getrow($dbData)){
            $vaData[$i]=$dbRow;
            $i++;
        }        
        return $vaData;
	}
	
	public function setSessionIDWO()
    {
        $cKode      = $this->input->post('cKode');
        $this->setSessionDataWO($cKode);
        savesession($this,"ss_Kode_WO",$cKode);        
        $vaData     = array() ;
        $dbData     = $this->frame_m->getDetailFormWO($cKode);
        while($dbRow = $this->frame_m->getrow($dbData)){   
            $cFaktur        = $dbRow['Faktur'];
            $cDeskripsi     = $dbRow['Deskripsi'];
            $cStatus        = $dbRow['Status'];
            $dTgl           = $dbRow['Tgl'];
            $dStartDateTime = "";
            $dEndDateTime   = "";
            if(!empty($dbRow['StartDateTime'])){
                $cStartDateTime     = date_create($dbRow['StartDateTime']); 
                $dStartDateTime     = date_format($cStartDateTime,"d-m-Y H:i");
            }
            if(!empty($dbRow['EndDateTime'])){
                $cEndDateTime       = date_create($dbRow['EndDateTime']);
                $dEndDateTime       = date_format($cEndDateTime,"d-m-Y H:i");
            } 
            $cCaseClosed    = $this->frame_m->getStatusCaseClosed($cKode);
            $cUserName      = $dbRow['UserName'];
            $vaFileList     = $this->getFileFormWO($cFaktur);
            $vaDataForm[$dTgl][$cFaktur] = array("Faktur"       =>$cFaktur,
                                             "Deskripsi"    =>$cDeskripsi,
                                             "Status"       =>$cStatus,
                                             "Tgl"          =>$dTgl,
                                             "StartDateTime"=>$dStartDateTime,
                                             "EndDateTime"  =>$dEndDateTime,
                                             "UserName"     =>$cUserName,
                                             "CaseClosed"   =>$cCaseClosed,
                                             "File"         =>$vaFileList);
        }
        //print_r($vaDataForm);
        savesession($this,"ss_Data_FormWO",$vaDataForm);
    }

    public function setSessionDataWO($cKode)
    {
        $vaDataWO = array();
        $data = $this->frame_m->getDataWO($cKode);
        if(!empty($data)){
            $vaDataWO = $data;
            $vaDataWO['File'] = $this->getFileWO($cKode);
        }
        savesession($this,"ss_Data_WO",$vaDataWO);
    }

    public function getFileFormWO($cKode)
    {
        $dbData = $this->frame_m->getFileFormWO($cKode);
        $vaData = array();
        while($dbr = $this->frame_m->getrow($dbData)){
            $cPathWO     = $dbr['FilePath'];
            $cFileSize   = "0.00";
            $cNamaFileWO = "File Not Found";
            if(file_exists($cPathWO)){
                $nFileSize      = filesize($cPathWO);
                $vaPathWO       = explode("/",$cPathWO);
                $cNamaFileWO    = end($vaPathWO); 
                $cFileSize      = formatSizeUnits($nFileSize);
            }
            $dbr['FileSize'] = $cFileSize;
            $dbr['FileName'] = $cNamaFileWO;
            $vaData[] = $dbr;
        }        
        return $vaData;
    }

    public function getFileWO($cFaktur)
    {
        $dbData = $this->frame_m->getFileWO($cFaktur);
        $vaData = array();
        while($dbr = $this->frame_m->getrow($dbData)){
            $cPathWO     = $dbr['FilePath'];
            $cFileSize   = "0.00";
            $cNamaFileWO = "File Not Found";
            if(file_exists($cPathWO)){
                $nFileSize      = filesize($cPathWO);
                $vaPathWO       = explode("/",$cPathWO);
                $cNamaFileWO    = end($vaPathWO); 
                $cFileSize      = formatSizeUnits($nFileSize);
            }
            $dbr['FileSize'] = $cFileSize;
            $dbr['FileName'] = $cNamaFileWO;
            $vaData[] = $dbr;
        }        
        return $vaData;
    }

}
?>
