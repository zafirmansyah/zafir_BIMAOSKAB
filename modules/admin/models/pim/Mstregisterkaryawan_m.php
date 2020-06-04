<?php 

	/**
	 * 
	 */
	class mstregisterkaryawan_m extends Bismillah_Model
	{
		// create CIF Code
		public function getCIFCode()
		{
	        $cBranch 	= getsession($this, "cabang") ; 
	        $cKey  		= "EMPLOYEE_HRD_" . $cBranch . "_";
	        $n    		= $this->getincrement($cKey,true,6);
	        $cCIF    	= $cBranch . "." . $n ;
	        return $cCIF ;
		}
		
		public function loadgrid($va){
			$limit    = $va['offset'].",".$va['limit'] ;
			$search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
			$search   = $this->escape_like_str($search) ;
			$where 	 = array() ; 
			if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Nama LIKE '%{$search}%')" ;
			$where 	 = implode(" AND ", $where) ;
			$dbd      = $this->select("karyawan", "*", $where, "", "", "Kode ASC", $limit) ;
			$dba      = $this->select("karyawan", "id", $where) ;
	  
			return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
		 }

		public function CheckStatusSLIK($cCIF)
		{
			$vaRetval 			= array() ;
			$vaRetval['Status'] = '0' ;
			$cField 	= "StatusSLIK AS Status" ;
	    	$cTable		= "status_acc" ; 
	    	$cWhere 	= "KodeRegister = '$cCIF'" ;
	    	$dbData 	= $this->select($cTable,$cField,$cWhere); 
	    	if($dbRow = $this->getrow($dbData)){
	    		$vaRetval = $dbRow ;
	    	}
	    	return $vaRetval ;
		}

	    public function SeekDataDetail($cCIF)
	    {	
	    	$vaRetval 	= array() ;
	    	$cField 	= "*" ;
	    	$cTable		= "karyawan" ; 
	    	$cWhere 	= "Kode = '$cCIF'" ;
	    	$dbData 	= $this->select($cTable,$cField,$cWhere); 
	    	if($dbRow = $this->getrow($dbData)){
	    		$vaRetval = $dbRow ; //array('Nama' => $dbRow['Nama']);
	    	}
	    	return $vaRetval ;
	    }

	    public function saving($va)
	    {
			if(empty($va['cKode'])){
				$va['cKode'] = $this->getCIFCode() ;
			}else{
				$va['cKode'] = $va['cKode'] ;
			}
			$data    = array() ;
	    	// data stored here!!

			// $w    		= "Kode = ".$this->escape($va['cKode']) ;
			// if($dblast = $this->getval("*", $w, "customer") ){
			// 	$dblast['img_map_rumah']	= ($dblast['img_map_rumah'] !== "") ? json_decode($dblast['img_map_rumah'], true) : array() ;
			// 	$dblast['img_map_usaha']	= ($dblast['img_map_usaha'] !== "") ? json_decode($dblast['img_map_usaha'], true) : array() ;
			// }

			// if(empty($dblast)){
			// 	$dblast = array("img_map_rumah"=>array('maps_rumah'=>""),
			// 					"img_map_usaha"=>array('maps_usaha'=>"")) ;
			// }

	    	$data    = array("Kode" => $va['cKode'] ,
								"Nama" => $va['cNama'] ,
								"AlamatKTP" => $va['cAlamatKTP'] ,
								"AlamatTinggal" => $va['cAlamat'] ,
								"KotaTinggal" => $va['optKota'] ,
								"KecamatanTinggal" => $va['optKecamatan'] ,
								"KelurahanTinggal" => $va['optKelurahan'] ,
								"Kota" => $va['optKotaKTP'] ,
								"Kecamatan" => $va['optKecamatanKTP'] ,
								"Kelurahan" => $va['optKelurahanKTP'] ,
								"NoKTP" => $va['cIDCard'] ,
								"NoNPWP" => $va['cNPWP'] ,
								"TglLahir" => date_2s($va['dTglLahir']) ,
								"TempatLahir" => $va['cTempatLahir'] ,
								"JenisKelamin" => $va['optGender'] ,
								"NoTelepon" => $va['cNoTelepon'] ,
								"NoHandphone" => $va['cNoHandphone'] ,
								"PendidikanTerakhir" => $va['optPendidikan'] ,
								"GolonganDarah" => $va['optGolonganDarah'] ,
								"Kewarganegaraan" => $va['optKewarganegaraan'] ,
								"TglCanvasing" => date("Y-m-d"),
								"UserNameCanvasing"=> getsession($this, "username"),
								"KodeCabang" => getsession($this, "cabang"),
	    					) ;
			
			// $data['img_map_rumah']	= array("maps_rumah"=>$dblast['img_map_rumah']['maps_rumah']) ;
			// $data['img_map_usaha']	= array("maps_usaha"=>$dblast['img_map_usaha']['maps_usaha']) ;

			// Saving Img Maps Rumah
			/*$vimage 					= json_decode(getsession($this, "ssmstregisternasabah_image", "{}"), true) ;
			$vaData['img_map_rumah']   	= array() ;
			if(!empty($vimage)){
			$adir 	= $this->config->item('bcore_uploads') . "imgcustreg/";
	        @mkdir($adir, 0777, true) ;
				foreach ($vimage as $key => $img) {
					$vi	= pathinfo($img) ;
					$dir 	= $adir ;
					$dir .=  "MAPS_".$va['cKode'] . "." . $vi['extension'] ;
					if(is_file($dir)) @unlink($dir) ;
					if(@copy($img,$dir)){
						@unlink($img) ;
						// @unlink($dblast['img_map_rumah']['maps_rumah']) ;
						$data['img_map_rumah']['maps_rumah']	= $dir;
					}
				}
			}

			// Saving Img Maps Rumah
			$vimageMapsUsaha			= json_decode(getsession($this, "ssmstregisternasabah_imageMapsUsaha", "{}"), true) ;
			$vaData['img_map_usaha']   	= array() ;
			if(!empty($vimageMapsUsaha)){
			$adir 	= $this->config->item('bcore_uploads') . "imgcustreg/";
	        @mkdir($adir, 0777, true) ;
				foreach ($vimageMapsUsaha as $key => $imgMapUsaha) {
					$vi	= pathinfo($imgMapUsaha) ;
					$dir 	= $adir ;
					$dir .=  "MAPS_USAHA".$va['cKode'] . "." . $vi['extension'] ;
					if(is_file($dir)) @unlink($dir) ;
					if(@copy($imgMapUsaha,$dir)){
						@unlink($imgMapUsaha) ;
						// @unlink($dblast['img_map_usaha']['maps_usaha']) ;
						$data['img_map_usaha']['maps_usaha']	= $dir;
					}
				}
			}

			$data['img_map_rumah']	= json_encode($data['img_map_rumah']) ;	
			$data['img_map_usaha']	= json_encode($data['img_map_usaha']) ;	
			*/ 

			$where   = "Kode = " . $this->escape($va['cKode']) ;
	      	$this->update("karyawan", $data, $where,"") ;
	   	}

	   	public function SeekPendidikan($search)
	    {
	        $where      = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
	        $dbd        = $this->select("pendidikan", "Kode,Keterangan", $where, "", "", "Kode ASC") ;
	        return array("db"=>$dbd) ;
	    }

	    public function SeekKota($search)
	    {   
	        $cWhere     = array() ; 
	        $cWhere[]   = "Kode <> ''" ;
	        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
	        $cWhere     = implode(" AND ", $cWhere) ;
	        $dbd        = $this->select("kota", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
	        return array("db"=>$dbd) ;
	    }

	    public function SeekKecamatan($search='',$cKota='')
	    {   
	        $cWhere     = array() ; 
	        $cWhere[]   = "Kode LIKE '$cKota.%'" ;
	        if($search !== "") $cWhere[]   = "(Keterangan LIKE '%{$search}%')" ;
	        $cWhere     = implode(" AND ", $cWhere) ;
	        $dbd        = $this->select("kecamatan", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
	        return array("db"=>$dbd) ;
	    }

	    public function SeekKelurahan($search='',$cKecamatan='')
	    {   
	        $cWhere     = array() ; 
	        $cWhere[]   = "Kode LIKE '$cKecamatan.%'" ;
	        if($search !== "") $cWhere[]   = "(Keterangan LIKE '%{$search}%')" ;
	        $cWhere     = implode(" AND ", $cWhere) ;
	        $dbd        = $this->select("kelurahan", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
	        return array("db"=>$dbd) ;
	    }

	}

 ?>