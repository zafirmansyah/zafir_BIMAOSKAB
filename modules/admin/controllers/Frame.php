<?php
class Frame extends Bismillah_Controller{
	public function __construct(){
		parent::__construct() ;
		$this->load->helper('bmenu') ;
		$this->load->model('func/func_m') ;
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
}
?>
