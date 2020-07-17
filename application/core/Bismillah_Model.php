<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Bismillah_Model extends CI_Model{
	public function __construct(){
		$this->load->database() ;
	}

	public function escape($str){
		return $this->db->escape($str) ;
	}

	public function escape_like_str($str){
		return $this->db->escape_like_str($str) ;
	}

	public function sql_exec($query, $save_log=TRUE, $simple=TRUE){
		if($this->db->save_log === TRUE && $save_log === TRUE){//save to log

		}

		if($simple){
			if(!$this->db->simple_query($query)){
				if(ENVIRONMENT <> 'live'){
					print_r($this->db->error()) ;
					print_r($query) ;
				}
			}
		}else{
			if($return = $this->db->query($query)){
				return $return ;
			}else{
				if(ENVIRONMENT <> 'live'){
					print_r($this->db->error()) ;
				}
			}
		}
	}

	public function select($table, $field, $where='', $join='', $group='', $order='', $limit=''){
		if(trim($where) !== "") $where = 'WHERE ' . $where ;
		if(trim($group) !== "") $group = 'GROUP BY ' . $group ;
		if(trim($order) !== "") $order = 'ORDER BY ' . $order ;
		if(trim($limit) !== "") $limit = 'LIMIT ' . $limit ;

		$query = "SELECT {$field} FROM {$table} {$join} {$where} {$group} {$order} {$limit}" ;
		return $this->sql_exec($query, FALSE, FALSE) ;
	}

	public function getrow($o){
		return (array) $o->unbuffered_row() ;
	}

	public function getrow_for($o){
        return $o->result_array() ; 
    }

	public function rows($o){
		return $o->num_rows() ;
	}

	public function fields($o){
		return $o->num_fields() ;
	}

	public function insert($table, $data, $save_log=TRUE){
		$field 	= array() ;
		$val 		= array() ;
		foreach ($data as $key => $value) {
			$field[] 	= $key ;
			$val[]		= $this->escape($value) ;
		}
		$field	= "(" . implode(",", $field) . ")" ;
		$val 		= "(" . implode(",", $val) . ")" ;
		$query	= "INSERT INTO {$table} {$field} VALUES {$val}" ;
		$this->sql_exec($query, $save_log) ;
	}

	public function edit($table, $data, $where='',$save_log=TRUE){
		if(trim($where) !== "") $where = 'WHERE ' . $where ;

		$udata 			= array() ;
		foreach ($data as $key => $value) {
			$udata[] 	= " {$key} = ".$this->escape($value)." " ;
		}
		$udata 	= implode(", ", $udata) ;
		$query	= "UPDATE {$table} SET {$udata} {$where}" ;
		$this->sql_exec($query, $save_log) ;
	}

	public function update($table, $data, $where='', $field_id='', $save_log=TRUE){
		if($field_id == '') $field_id = 'id';
		$dbdata = $this->select($table, $field_id, $where) ;
		if($this->rows($dbdata) > 0){
			$this->edit($table, $data, $where, $save_log) ;
		}else{
			$this->insert($table, $data, $save_log) ;
		}
	}

	public function delete($table, $where, $save_log=TRUE){
		if(trim($where) !== "") $where = 'WHERE ' . $where ;
		$query 	= "DELETE FROM {$table} {$where}" ;
		$this->sql_exec($query, $save_log) ;
	}

	public function delete_all($table){
		$query 	= "TRUNCATE TABLE {$table}" ;
		$this->sql_regcase($query, FALSE) ;
	}

	public function getsql(){
		return $this->db->last_query() ;
	}

	public function getval($field, $where, $table){
		$rerow 		= '' ;
		$dbdata 	= $this->select($table, $field, $where, "", "", "", "0,1") ;
		$row 		= $this->getrow($dbdata) ;
		if(strpos($field, ",") === FALSE && trim($field) !== "*" ){
			if(!empty($row)){
				$rerow 	= $row[$field] ;
			}
		}else{
			$rerow 	= $row ;
		}
		return $rerow ;
	}

	public function saveconfig($key, $val=''){
		$this->update("sys_config", array("title"=>$key, "val"=>$val), "title = " . $this->escape($key), "id") ;
	}

	public function getconfig($key){
		return $this->getval('val', "title = ". $this->escape($key), "sys_config") ;
	}

	public function getincrement($k,$l=true,$n=0 ){
		/*
			$k = Key about increment
			$l = Update increment?
			$n = Length (pad)
		*/
		$inc 	= 1 ;
		$k 		= "inc_" . $k ;
		$val 	= intval($this->getconfig($k)) ;
		$inc 	= ($val > 0) ? $val+1 : $inc ;
		if($l){
			$this->saveconfig($k, $inc) ;
		}
		return str_pad($inc, $n, "0", STR_PAD_LEFT) ;
	}

 // func DB
    public function AddTable($cTableName,$cSQL,$cDatabase=''){
        if(!empty($cDatabase)){
            $cDatabase = " From " . $cDatabase ;
        }

        //$cTableName = strtolower(trim($cTableName)) ;
        $dbData = $this->db->query("Show Tables $cDatabase") ;
        $lAdd = true ;
        foreach($dbData->result_array() as $dbRow){
           foreach($dbRow as $key){
              if($key == $cTableName){
                $lAdd = false ; 
              }
           }
        }
        //if($this->rows($dbData) > 0)$lAdd = false ; 
        if($lAdd){
            $this->db->query($cSQL) ;
        }
    }

    function AddField($cTableName,$cFieldName,$cFieldType,$cDefault='',$cFieldAfter=''){
        $dbData =  $this->db->query("Show Fields From $cTableName") ;
        $lModif = true ;
        foreach($dbData->result_array() as $dbRow){
           foreach($dbRow as $key){
              if($key == $cFieldName){
                $lModif = false ; 
              }
           }
        }
        if($lModif){
            if(!empty($cFieldAfter)){
                $cFieldAfter = " AFTER " . $cFieldAfter ;
            }
           $this->db->query("ALTER TABLE $cTableName ADD $cFieldName $cFieldType DEFAULT '$cDefault' $cFieldAfter") ;
        }
	}
	
	

    public function CheckDatabase(){
		
		$this->AddField("sys_username","Unit","varchar(5)","","");
		$this->AddField("sys_username","Email","text");
		$this->AddField("iku_master","Status","varchar(1)","0","");

		$cSQL = "CREATE TABLE `surat_masuk`(
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`NoSurat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Dari` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Disposisi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
					`Tgl` date NULL DEFAULT NULL,
					`TglSurat` date NULL DEFAULT NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("surat_masuk",$cSQL);
		$this->AddField("surat_masuk","Perihal","varchar(255)","","");
		$this->AddField("surat_masuk","Path","text");
		

		$cSQL = "CREATE TABLE `surat_masuk_disposisi`  (
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Tgl` date NULL DEFAULT NULL,
					`Disposisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Level` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Status` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					`Pendisposisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '',
					`Terdisposisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '',
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 84 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("surat_masuk_disposisi",$cSQL);
		$this->AddField("surat_masuk_disposisi","Pendisposisi","varchar(255)","","");
		$this->AddField("surat_masuk_disposisi","Terdisposisi","varchar(255)","","");
		$this->AddField("surat_masuk_disposisi","Deskripsi","text","","");
		
		$this->AddField("golongan_unit","KodeRubrik","varchar(255)","","");
		$this->AddField("jenis_surat","KodeRubrik","varchar(255)","","");
		$this->AddField("jenis_surat","Status","varchar(1)","1","");

		$cSQL = "CREATE TABLE `golongan_jabatan`  (
					`ID` int(3) NOT NULL AUTO_INCREMENT,
					`Kode` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
					`Keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("golongan_jabatan",$cSQL);
		
		$this->AddField("sys_username","Jabatan","varchar(255)","","");

		$cSQL = "CREATE TABLE `jenis_sifat_surat`  (
					`ID` int(3) NOT NULL AUTO_INCREMENT,
					`Kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`KodeRubrik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;" ;
		$this->AddTable("jenis_sifat_surat",$cSQL);

		$cSQL = "CREATE TABLE `m02_anggaran`  (
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Faktur` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Kepada` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Perihal` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
					`Metode` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Tgl` date NULL DEFAULT NULL,
					`StatusPersetujuan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Sifat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					`UserName_Delete` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime_Delete` datetime(0) NULL DEFAULT NULL,
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("m02_anggaran",$cSQL);
		$this->AddField("m02_anggaran","NoSurat","varchar(255)","","Tgl");

			
		$cSQL = "CREATE TABLE `m02_anggaran_detail`  (
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Faktur` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Tgl` date NULL DEFAULT NULL,
					`No` int(3) NULL DEFAULT NULL,
					`Keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Nominal` double(16, 2) NULL DEFAULT NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("m02_anggaran_detail",$cSQL);

		$cSQL = "CREATE TABLE `m02_prinsip`  (
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Faktur` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Kepada` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Perihal` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
					`NoSurat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Sifat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL,
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("m02_prinsip",$cSQL);
		$this->AddField("m02_prinsip","Tgl","date","0000-00-00","");
		$this->AddField("m02_prinsip","KodeDisposisi","varchar(255)","","");
		$this->AddField("m02_prinsip","MetodeDisposisi","varchar(255)","M","");
		$this->AddField("m02_prinsip","StatusPersetujuan","varchar(255)","0","");
		$this->AddField("m02_prinsip","Status","varchar(255)","1","");
		

		$cSQL = "CREATE TABLE `m02_prinsip_status`  (
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Faktur` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Tgl` date NULL DEFAULT NULL,
					`Status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("m02_prinsip_status",$cSQL);
		$this->AddField("m02_prinsip_status","Terdisposisi","varchar(255)","","Tgl");
		$this->AddField("m02_prinsip_status","FakturDisposisi","varchar(255)","","Faktur");
		$this->AddField("m02_prinsip_status","Alasan","varchar(255)","","Status");


		$cSQL = "CREATE TABLE `m02_prinsip_disposisi` (
			`ID` int(9) NOT NULL AUTO_INCREMENT,
			`Kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
			`Tgl` date NULL DEFAULT NULL,
			`Disposisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
			`Level` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
			`Status` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
			`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
			`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
			`Pendisposisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '',
			`Terdisposisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '',
			PRIMARY KEY (`ID`) USING BTREE
		  ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;" ;
		$this->AddTable("m02_prinsip_disposisi",$cSQL) ;
		$this->AddField("m02_prinsip_disposisi","FakturDokumen","varchar(255)","","ID");
		
		$cSQL = "CREATE TABLE `surat_keluar`  (
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Kepada` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Perihal` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Tgl` date NULL DEFAULT NULL,
					`NoSurat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
					`JenisSurat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Unit` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;" ;
		$this->AddTable("surat_keluar",$cSQL) ;
		$this->AddField("surat_keluar","Status","varchar(1)","1","Unit");


		$cSQL = "CREATE TABLE `work_order_master` ( 
					`ID` INT(11) NOT NULL AUTO_INCREMENT , 
					`Kode` VARCHAR(255) DEFAULT NULL , 
					`TujuanUserName` VARCHAR(255) DEFAULT NULL ,
					`Subject` VARCHAR(255) DEFAULT NULL , 
					`Deskripsi` TEXT DEFAULT NULL , 
					`Tgl` DATE DEFAULT NULL , 
					`UserName` VARCHAR(255) DEFAULT NULL , 
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0), 
					`StartDateTime` datetime(0) NULL DEFAULT NULL , 
					`FinishDateTime` datetime(0) NULL DEFAULT NULL , 
					`Status` VARCHAR(1) DEFAULT NULL , 
					PRIMARY KEY (`ID`)  USING BTREE
				) ENGINE = InnoDB;";
		$this->AddTable("work_order_master",$cSQL) ;

		$cSQL = "CREATE TABLE `work_order_master_file` ( 
					`ID` INT(11) NOT NULL AUTO_INCREMENT , 
					`Kode` VARCHAR(255) DEFAULT NULL , 
					`Tgl` DATE DEFAULT NULL , 
					`FilePath` TEXT DEFAULT NULL , 
					`UserName` VARCHAR(255) DEFAULT NULL , 
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0), 
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB;";
		$this->AddTable("work_order_master_file",$cSQL);
		
		$cSQL = "CREATE TABLE `work_order_form` ( 
					`ID` INT(11) NOT NULL AUTO_INCREMENT , 
					`Kode` VARCHAR(255) NULL DEFAULT NULL , 
					`Deskripsi` TEXT NULL DEFAULT NULL , 
					`Tgl` DATE NULL DEFAULT NULL , 
					`StartDateTime` DATETIME NULL DEFAULT NULL , 
					`EndDateTime` DATETIME NULL DEFAULT NULL , 
					`UserName` VARCHAR(255) NULL DEFAULT NULL ,
					`Status` VARCHAR(1) DEFAULT NULL ,
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB;";
		$this->AddTable("work_order_form",$cSQL);
		$this->AddField("work_order_form","Faktur","varchar(255)","","ID");
		$this->AddField("work_order_master","CaseClosed","varchar(1)","0","Status");

		$cSQL = "CREATE TABLE `work_order_form_file` (
			 		`ID` INT(11) NOT NULL AUTO_INCREMENT , 
					`Kode` VARCHAR(255) NULL DEFAULT NULL , 
					`Tgl` DATE NULL DEFAULT NULL , 
					`FilePath` TEXT NULL DEFAULT NULL , 
					`UserName` VARCHAR(255) NULL DEFAULT NULL , 
					`DateTime` DATETIME NULL DEFAULT CURRENT_TIMESTAMP , 
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB;" ;
		$this->AddTable("work_order_form_file",$cSQL);
		$this->AddField("work_order_form_file","Faktur","varchar(255)","","ID");
		
		
		$cSQL = "CREATE TABLE `tahun_buku`  (
					`ID` int(3) NOT NULL AUTO_INCREMENT,
					`TahunBuku` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`KodeTahunBuku` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("tahun_buku",$cSQL);

		$cSQL = "CREATE TABLE `m02_prinsip_file`  (
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Tgl` date NULL DEFAULT NULL,
					`FilePath` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("m02_prinsip_file",$cSQL);
		
		$cSQL = "CREATE TABLE `template_dokumen`  (
					`ID` int(4) NOT NULL AUTO_INCREMENT,
					`Subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
					`FilePath` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("template_dokumen",$cSQL);
		$this->AddField("template_dokumen","Kode","varchar(255)","","ID");
		$this->AddField("template_dokumen","Tgl","date","0000-00-00","");
		$this->AddField("template_dokumen","Status","char(1)","","");
		
		$cSQL = "CREATE TABLE `template_dokumen_file`  (
					`ID` int(9) NOT NULL AUTO_INCREMENT,
					`Kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`Tgl` date NULL DEFAULT NULL,
					`FilePath` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
					`UserName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
					`DateTime` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
					PRIMARY KEY (`ID`) USING BTREE
				) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;";
		$this->AddTable("template_dokumen_file",$cSQL);

    }
}
?>
