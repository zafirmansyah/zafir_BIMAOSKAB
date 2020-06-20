<?php
class Utlchangepassword_m extends Bismillah_Model{

	public function checkOldPass($user, $pass){
		$pass 	= pass_crypt($pass) ;
		$where 	= "username = " . $this->escape($user) . " AND password LIKE '".$this->escape_like_str($pass)."%'" ;
		$cField = "username, fullname, data_var, lastchangepass, password, cabang, unit, KodeKaryawan, Jabatan";
		return $this->getval($cField, $where, "sys_username") ;
    }

    public function changePassword($va)
    {
        $cUsername 	= $va['cUsername'] ;
        $cOldPass   = $va['cOldPassword'] ;
        $cNewPass   = $va['cNewPassword'] ;
        $w    		= "username = '$cUsername' AND password LIKE '$cOldPass%'" ;
        $dbData     = $this->select("sys_username","*",$w) ;
        if($dbRow = $this->getrow($dbData)){
            
            $rOldPassword   = $dbRow['password'] ;
            $xx             = strlen($rOldPassword) - 4 ;
            $cRecentLevel   = substr($rOldPassword, $xx, 4) ;
            
            $cPassUpdate    = pass_crypt($cNewPass) . $cRecentLevel ;
            $vaUpdate       = array("password" => $cPassUpdate);
            $this->update("sys_username", $vaUpdate, "username = '$cUsername'") ;   
        }
    }
    
}
?>
