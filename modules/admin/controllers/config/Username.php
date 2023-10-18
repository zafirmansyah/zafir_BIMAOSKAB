<?php
class Username extends Bismillah_Controller{
   private $bdb;
	public function __construct(){
		parent::__construct() ;
      	$this->load->model("config/username_m") ;
      	$this->bdb = $this->username_m;
	}

	public function index(){
		$this->load->view("config/con_user") ;
	}

	public function loadgrid(){
		$va   = json_decode($this->input->post('request'), true) ;
		$db   = $this->bdb->loadgrid($va) ;
		$vare = array() ;

		while( $dbrow	= $this->bdb->getrow($db['db']) ){
			$vaset 		= $dbrow ;
			$vaset['recid']		= $dbrow['username'] ;

			$vaset['cmdedit'] 			= '<button type="button" onClick="bos.con_user.cmdedit(\''.$dbrow['username'].'\')"
																	class="btn btn-success btn-grid">Edit</button>' ;
			$vaset['cmdTerminate'] 	= '<button type="button" onClick="bos.con_user.cmdTerminate(\''.$dbrow['username'].'\')"
																	class="btn btn-danger btn-grid">Terminate</button>' ;
			$vaset['cmdedit']				= html_entity_decode($vaset['cmdedit']) ;
			$vaset['cmdTerminate']	= html_entity_decode($vaset['cmdTerminate']) ;
		
			$vare[]		= $vaset ;
		}

		$vare 	= array("total"=>$db['rows'],"records"=>$vare ) ;
		echo(json_encode($vare)) ;
	}

	public function init(){
      savesession($this, "ssusername_image", "") ;
	}

	public function seekusername(){
		$va 	= $this->input->post() ;
      	$w    = "username = ".$this->bdb->escape($va['username']) ;
		if($data= $this->bdb->getval("username",$w , "sys_username")){
			echo('bos.con_user.obj.find("#username").val("").focus() ;  ') ;
		}
	}

	public function saving(){
		$va       = $this->input->post() ;
		$username = $va['username'] ;
		$w        = "username = ".$this->bdb->escape($va['username']) ;
		  
		if( $dblast = $this->bdb->getval("*", $w, "sys_username") ){
			$dblast['data_var']	= ($dblast['data_var'] !== "") ? json_decode($dblast['data_var'], true) : array() ;
		}
		
		if(empty($dblast)){
			$dblast = array("password"=>"", "data_var"=>array('ava'=>"")) ;
		}

		$cKodeKaryawan 		= $va['chKodeKaryawan'] ; 
		if($cKodeKaryawan == "" || empty($cKodeKaryawan)){
			$cKodeKaryawan = $this->bdb->GetKodeKaryawan() ;
		}
		
		$data 				= array("username"     => $va['username'],
													"fullname"     => $va['fullname'],
													"Unit"         => $va['optUnit'],
													"Email"        => $va['cEmail'],
													"KodeKaryawan" => $cKodeKaryawan,
													"Jabatan"      => $va['optJabatan'],
													"superior"     => $va['optAtasan']
													) ;
		$data['data_var']	= array("ava"=>$dblast['data_var']['ava']) ;

		if($va['password'] !== ""){
			$data['password']	= pass_crypt($va['password']) . $va['level'] ;
		}else{
			$data['password']	= substr($dblast['password'], 0, strlen($dblast['password'])-4) . $va['level'];
		}

		$vimage = json_decode(getsession($this, "ssusername_image", "{}"), true) ;
		if(!empty($vimage)){
			$adir 	= $this->config->item('bcore_uploads') . "users_pict/";
			if(!is_dir($adir)){
				mkdir($adir,0777,true);
			}

			foreach ($vimage as $key => $img) {
				$vi		= pathinfo($img) ;
				$dir 	= $adir ;
				$dir 	.=  $key . "_".date("dmy_Hi") . "." . $vi['extension'] ;
				if(is_file($dir)) @unlink($dir) ;
				if(@copy($img,$dir)){
					@unlink($img) ;
					@unlink($dblast['data_var']['ava']) ;
					$data['data_var']['ava']	= $dir;
				}
			}
		}
		$data['data_var']	= json_encode($data['data_var']) ;

		$this->bdb->update("sys_username", $data, $w, "username") ;
		echo(' bos.con_user.init() ; ') ;
	}

	public function saving_image(){
		$fcfg	= array("upload_path"=>"./tmp/", "allowed_types"=>"jpg|jpeg|png", "overwrite"=>true) ;

		savesession($this, "ssusername_image", "") ;
		$this->load->library('upload', $fcfg) ;
		if ( ! $this->upload->do_upload(0) ){
			echo('
				alert("'. $this->upload->display_errors('','') .'") ;
				bos.mstparty.obj.find("#idlimage").html("") ;
			') ;
		}else{
			$data 	= $this->upload->data() ;
			$tname 	= str_replace($data['file_ext'], "", $data['client_name']) ;
			$vimage	= array( $tname => $data['full_path']) ;
			savesession($this, "ssusername_image", json_encode($vimage) ) ;

			echo('
				bos.con_user.obj.find("#idlimage").html("") ;
				bos.con_user.obj.find("#idimage").html("<img src=\"'.base_url("./tmp/" . $data['client_name'] . "?time=". time()).'\" class=\"img-responsive\" />") ;
			') ;
		}
	}

	public function editing(){
		$va 	= $this->input->post() ;
		$w    	= "username = ".$this->bdb->escape($va['username']) ;
		$data 	= $this->bdb->getval("*", $w, "sys_username") ;
		if(!empty($data)){
			$jsonUnit[] 		= array("id"=>$data['Unit'],"text"=>$data['Unit'] . " - " . $this->bdb->getval("Keterangan", "Kode = '{$data['Unit']}'", "golongan_unit"));
			$jsonJabatan[] 	= array("id"=>$data['Jabatan'],"text"=>$data['Jabatan'] . " - " . $this->bdb->getval("Keterangan", "Kode = '{$data['Jabatan']}'", "golongan_jabatan"));
			$jsonAtasan[] 	= array("id"=>$data['superior'],"text"=>$data['superior'] . " - " . $this->bdb->getval("fullname", "KodeKaryawan = '{$data['superior']}'", "sys_username"));
			$image 					= "" ;
			$slevel 				= array() ;
			$data_var				= ($data['data_var'] !== "") ? json_decode($data['data_var'], true) : array() ;
			if(isset($data_var['ava'])){
				$image 	= '<img src=\"'.base_url($data_var['ava']).'\" class=\"img-responsive\"/>' ;
			}
			$level 		= substr($data['password'], -4) ;
			$slevel[] 	= array("id"=>$level, "text"=> $level . " - " . $this->bdb->getval("name", "code = '{$level}'", "sys_username_level")) ;

			echo('
				with(bos.con_user.obj){
					find("#username").val("'.$data['username'].'").attr("readonly", true) ;
					find("#fullname").val("'.$data['fullname'].'").focus() ;
					find("#level").sval('.json_encode($slevel).') ;
					find("#optUnit").sval('.json_encode($jsonUnit).') ;
					find("#optJabatan").sval('.json_encode($jsonJabatan).') ;
					find("#optAtasan").sval('.json_encode($jsonAtasan).') ;
					find("#chKodeKaryawan").val("'.$data['KodeKaryawan'].'") ;
					find("#cEmail").val("'.$data['Email'].'") ;
					find("#idimage").html("'.$image.'") ;
				}
			') ;
		}
	}

	public function deleting(){
		$va	= $this->input->post() ;
		$w  = "username = ".$this->bdb->escape($va['username']) ;
		$this->bdb->delete("sys_username", $w ) ;
		echo(' bos.con_user.init() ; ') ;
	}

	public function terminateUser()
	{
		$va		= $this->input->post() ; 
		$this->bdb->terminateUser($va['cUsername']) ;
		echo(' 
			bos.con_user.init() ; 
		') ;
	} 
    
    public function seekcabang(){
      $search = $this->input->get('q');
      $vdb    = $this->bdb->seekcabang($search) ;
      $dbd    = $vdb['db'] ;
      $vare   = array();
      while($dbr = $this->bdb->getrow($dbd)){
        $vare[] = array("id"=>$dbr['kode'], "text"=>$dbr['keterangan']) ;
      }
      $Result = json_encode($vare);
      echo($Result) ;
	}
	   
	public function PickNomorKaryawan(){
		$search = $this->input->get('q');
		$vdb    = $this->bdb->PickNomorKaryawan($search) ;
		$dbd    = $vdb['db'] ;
		$vare   = array();
		while( $dbr = $this->bdb->getrow($dbd) ){
			$vare[] 	= array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] . " [ " . $dbr['Nama'] . " ]") ;
		}
		$Result = json_encode($vare);
		echo($Result) ;
	}

	public function SeekNIK()
	{
		$va 		= $this->input->post() ;
		$cKode 	= $va['Kode']; 
		if(isset($cKode)){
			$cWhere = "Kode = " .$this->bdb->escape($cKode) ;
			$dbData = $this->bdb->getval("*", $cWhere, "karyawan") ;
			if($dbData){
				$jsonCabang[] = array("id"=>$dbData['KodeCabang'],"text"=>$dbData['KodeCabang']. "-" . $this->bdb->getval("Keterangan","Kode = '{$dbData['KodeCabang']}'","cabang")) ;
				echo('

					with(bos.con_user.obj){
						$("#fullname").val("'.$dbData['Nama'].'");				
						$("#cabang").sval('.json_encode($jsonCabang).');
					}

				');
			}
		}
	}

	public function SeekUnit()
	{
		$search     = $this->input->get('q');
		$vdb        = $this->bdb->SeekUnit($search) ;
		$dbd        = $vdb['db'] ;
		$vare       = array();
		while($dbr = $this->bdb->getrow($dbd)){
			$vare[] = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
		}
		$Result = json_encode($vare);
		echo($Result) ;
	}

	public function SeekJabatan()
	{
		$search     = $this->input->get('q');
		$vdb        = $this->bdb->SeekJabatan($search) ;
		$dbd        = $vdb['db'] ;
		$vare       = array();
		while($dbr = $this->bdb->getrow($dbd)){
			$vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
		}
		$Result = json_encode($vare);
		echo($Result) ;
	}

	public function seekAtasan() {
		$search     = $this->input->get('q');
		$vdb        = $this->bdb->SeekAtasan($search) ;
		$dbd        = $vdb['db'] ;
		$vare       = array();
		while($dbr = $this->bdb->getrow($dbd)){
			$vare[]	= array("id"=>$dbr['username'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
		}
		$Result = json_encode($vare);
		echo($Result) ;
	}
}
?>
