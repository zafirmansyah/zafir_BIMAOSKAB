<?php
	class Username_lv extends Bismillah_Controller{
      private $bdb ;
		public function __construct(){
			parent::__construct() ;
         $this->load->model('load_m') ;
         $this->bdb = $this->load_m;
		}

		public function index(){
			$this->load->view("config/con_userlevel.php") ;
		}

		public function loadgrid(){
			$va	 	= json_decode($this->input->post('request'), true) ;
			$vare 	= array() ;
			$limit	= $va['offset'].",".$va['limit'] ; //limit
			$dbdata = $this->bdb->select("sys_username_level", "code, name", "", "", "", "code DESC", $limit) ;
			while( $dbrow	= $this->bdb->getrow($dbdata) ){
				$vaset 		= $dbrow ;
				$vaset['recid']		= $dbrow['code'] ;

				$vaset['cmdedit'] 	= '<button type="button" onClick="bos.con_userlevel.cmdedit(\''.$dbrow['code'].'\')"
										class="btn btn-success btn-grid">Edit</button>' ;
				$vaset['cmddelete'] = '<button type="button" onClick="bos.con_userlevel.cmddelete(\''.$dbrow['code'].'\')"
										class="btn btn-danger btn-grid">Delete</button>' ;
				$vaset['cmdedit']	= html_entity_decode($vaset['cmdedit']) ;
				$vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

				$vare[]		= $vaset ;
			}

			$vare 	= array("total"=> $this->bdb->rows($dbdata), "records"=>$vare ) ;
			echo(json_encode($vare)) ;
		}

		public function loadmenu(){
			$q 		= $this->input->get('q') ;
			$vare 	= array() ;
			$arrmenu= json_decode(getsession($this, "bmenu", "{}"), true) ;
			$this->loadmenu_data($vare, $q, $arrmenu) ;
			echo json_encode($vare) ;
		}

		public function loadmenu_data(&$vare, $q, $arrmenu){
			foreach ($arrmenu as $key => $value) {
				if($value['loc'] !== ""){
					$lv 	= true;
					if($q) $lv = strpos( strtolower($value['name']), strtolower($q) ) ;
					if($lv){
						$arr 	= json_encode(array("md5"=>$value['md5'], "name"=>$value['name'])) ;
						$vare[]	= array("id"=>$arr, "text"=>$value['name']) ;
					}
				}
				if(isset($value['children'])) $this->loadmenu_data($vare, $q, $value['children']) ;
			}
		}

		public function saving(){
			$va 	= $this->input->post() ;
			$code = $va['code'] ;
         $w    = "code = " . $this->bdb->escape($code) ;
			$data = array("code"=>$code, "name"=>$va['name'],
							  "value"=>$va['value'], "dashboard"=> $va['dashboard']) ;

			$this->bdb->update("sys_username_level", $data, $w, "code") ;
			echo(' bos.con_userlevel.init() ; ') ;
		}

		public function deleting(){
			$va 	= $this->input->post() ;
         $w    = "code = " . $this->bdb->escape($va['code']) ;
			$this->bdb->delete("sys_username_level", $w) ;
			echo(' bos.con_userlevel.init() ; ') ;
		}

		public function editing(){
			$va 	= $this->input->post() ;
			$code = $va['code'] ;
         $w    = "code = " . $this->bdb->escape($code) ;
			$valmenu= "" ;
			if($data 	= $this->bdb->getval("*", $w, "sys_username_level")){
				$valmenu = $data['value'] ;
				$dash 	= json_decode($data['dashboard'], true) ;
				$sdash 	= array(array("id"=>$data['dashboard'], "text"=>$dash['name'])) ;
				echo('
					bos.con_userlevel.obj.find("#code").val("'.$code.'");
		        	bos.con_userlevel.obj.find("#name").val("'.$data['name'].'");
		        	bos.con_userlevel.obj.find("#dashboard").sval('.json_encode($sdash).');
				') ;
			}

			$arrmenu= json_decode(getsession($this, "bmenu", "{}"), true) ;
			$remenu	= array() ;
			$this->get_data_tree($remenu, $arrmenu, $valmenu) ;
			echo('

				bos.con_userlevel.tree 	= '.json_encode($remenu).' ;
				bos.con_userlevel.obj.find("#menu").dynatree("getRoot").removeChildren() ;
				bos.con_userlevel.obj.find("#menu").dynatree("getRoot").addChild(bos.con_userlevel.tree) ;

				bos.con_userlevel.tree_cell = bos.con_userlevel.obj.find("#menu").dynatree("getSelectedNodes") ;
				bos.con_userlevel.tree_cell = $.map(bos.con_userlevel.tree_cell,function(node){
					return 	node.data.key ;
				}) ;

		        bos.con_userlevel.obj.find("#value").val(bos.con_userlevel.tree_cell.join(", "));
			') ;
		}

		private function get_data_tree(&$re, $arrmenu, $val){
			$r 		= 0 ;
			foreach ($arrmenu as $key => $vav) {
				$title	= $vav['name'] ;
				$re[$r]	= array("title"=>$title,"key"=>$vav['md5']) ;
				if( strpos($val, $vav['md5']) > -1) $re[$r]["select"]	= true ;
				if(isset($vav['children'])){
					$re[$r]["isFolder"]	= true ;
					$re[$r]["expand"]		= true ;
					$re[$r]["children"]	= array() ;
					$this->get_data_tree($re[$r]["children"],$vav['children'],$val) ;
				}
				$r++ ;
			}
		}
	}
?>
