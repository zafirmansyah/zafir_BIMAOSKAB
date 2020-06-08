<?php
class Loginm extends Bismillah_Model{
	public function getdata_login($user, $pass){
		$pass 	= pass_crypt($pass) ;
		$where 	= "username = " . $this->escape($user) . " AND password LIKE '".$this->escape_like_str($pass)."%'" ;
		$cField = "username, fullname, data_var, lastchangepass, password, cabang, unit, KodeKaryawan, Jabatan";
		return $this->getval($cField, $where, "sys_username") ;
	}
}
?>
