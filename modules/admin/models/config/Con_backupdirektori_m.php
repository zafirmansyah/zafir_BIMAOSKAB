
<?php 


/**
 * 
 */
class Con_backupdirektori_m extends Bismillah_Model
{


    public function seekTahunBuku($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "TahunBuku <> ''" ;
        if($search !== "") $cWhere[]   = "(KodeTahunBuku LIKE '%{$search}%' OR TahunBuku LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("tahun_buku", "*", $cWhere, "", "", "TahunBuku ASC") ;
        return array("db"=>$dbd) ;
    }

}