<?php
class Toko_m extends Bismillah_Model{

    public function getkas($d){
        $kas  = 0 ;
        $w    = "tgl = '".$d."' AND jenis = 1 AND kredit > 0 AND username = " . $this->escape(getsession($this, "username")) ;
        $db   = $this->select("brg_stok_kartu", "SUM(total) kas", $w) ;
        if($r = $this->getrow($db)){
            $kas = $r['kas'] ;
        }
        //kurangi retur
        $w    = "tgl = '".$d."' AND jenis = 1 AND debet > 0 AND username = " . $this->escape(getsession($this, "username")) ;
        $db   = $this->select("brg_stok_kartu", "SUM(total) retur", $w) ;
        if($r = $this->getrow($db)){
            $kas -= $r['retur'] ;
        }
        return $kas ;
   }

    public function getstok($id){
        $stok  = 0;
        $s  = $this->datastok($id, "stok") ;
        if($s !== "") $stok = $s ;
        return $stok;
    }

    public function datastok($id, $field="*"){
        $w     = "id = " . $this->escape($id) ;
        return $this->getval($field, $w, "v_brg") ;
    }

    public function savehp($tgl, $faktur, $tbl, $id, $qty, $hp){
        //$this->edit("brg_stok", array("hp"=>$hp), "id_brg = " . $this->escape($id)) ;
        $f    = array("id_brg"=>$id, "tgl"=>$tgl, "faktur"=>$faktur, "tbl"=>$tbl,
                     "qty"=>$qty, "nilai"=>$hp, "username"=>getsession($this, "username")) ;
        $this->insert("brg_hp", $f) ;
    }

    public function saveharga($tgl, $id, $qty, $harga){
        $f    = array("id_brg"=>$id, "tgl"=>$tgl, "faktur"=>"manual", "tbl"=>"manual" ,
                     "jenis"=>0,"qty"=>$qty, "nilai"=>$harga, "username"=>getsession($this, "username")) ;
        $this->insert("brg_hp", $f) ;
    }

    public function rumushp($id, $qty, $harga){
        /*
            (Jumlah Stok * Harga Pokok Lama) + (QTY Pembelian * Harga Pembelian) / Jumlah Stok keseluruhan
        */
        $stok    = $this->datastok($id, "stok, hp") ;

        $tot_brg = $stok['stok'] + $qty ;
        $hp      = (($stok['stok'] * $stok['hp']) + ($qty * $harga)) / $tot_brg ;
        return round($hp, 0, PHP_ROUND_HALF_UP) ;
    }

    public function updstok_konversi($va){
        /*
            update stok
            id_brg                K
            id_brg_tujuan    D
            save hp
        */
        //Kredit
        $user = getsession($this, "username") ;
        $harga= $this->datastok($va['id_brg'], "harga") ;
        $t    = $va['qty'] * $harga ;
        $vaf  = array("faktur"=>$va['faktur'], "id_brg"=>$va['id_brg'], "tgl"=>$va['tgl'],
                     "qty"=>$va['qty'], "kredit"=>$va['qty'], "harga"=>$harga,
                     "total_sub"=>$t, "total"=>$t, "hp"=>$va['harga'], "jenis"=>2, "username"=>$user) ;
        $this->insert("brg_stok_kartu", $vaf) ;

        //Debet
        $hp   = $this->rumushp($va['id_brg_tujuan'], $va['qty_tujuan'], $va['harga']) ;
        $t    = $va['qty_tujuan'] * $va['harga'] ;
        $vaf  = array("faktur"=>$va['faktur'], "id_brg"=>$va['id_brg_tujuan'], "tgl"=>$va['tgl'],
                        "qty"=>$va['qty_tujuan'], "debet"=>$va['qty_tujuan'], "harga"=>$va['harga'],
                        "total_sub"=>$t, "total"=>$t, "hp"=>$hp, "jenis"=>2, "username"=>$user) ;
        $this->insert("brg_stok_kartu", $vaf) ;

        //ambil qty
        $id   = $va['id_brg_tujuan'] ;
        $qty  = $this->getstok($id, "stok") ;
        $this->savehp($va['tgl'], $va['faktur'], "brg_konversi", $id, $qty, $hp) ;
    }

    public function updstok_beli($f){
        //update stok di posisi debet
        $username= getsession($this, "username") ;
        $d       = date("Y-m-d") ;
        $db      = $this->select("brg_beli","*", "faktur = " . $this->escape($f)) ;
        while($r = $this->getrow($db)){
            $t    = $r['qty'] * $r['harga'];
            $va   = array("faktur"=>$f, "id_brg"=>$r['id_brg'], "jenis"=>0, "tgl"=>$d,
                            "qty"=>$r['qty'], "debet"=>$r['qty'], "harga"=>$r['harga'],
                            "total_sub"=>$t, "total"=>$t, "username"=>$username) ;
            $w    = "faktur = " . $this->escape($f) . " AND id_brg = " . $this->escape($r['id_brg']) ;
            $id   = $this->getval("id", $w, "brg_stok_kartu") ;
            if($id == ""){
                $hp         = $this->rumushp($r['id_brg'], $r['qty'], $r['harga']) ;
                $va['hp']   = $hp ;
                $this->insert("brg_stok_kartu", $va) ;

                $id   = $r['id_brg'] ;
                $qty  = $this->getstok($id, "stok") ;
                $this->savehp($r['tgl'], $f, "brg_beli", $id, $qty, $hp) ;
            }else{
                $this->edit("brg_stok_kartu", $va, "id = " . $this->escape($id)) ;
            }
        }
    }

    public function updstok_retur_beli_kon($f, $fr){
        //update stok di posisi KREDIT
        $username= getsession($this, "username") ;
        $d       = date("Y-m-d") ;
        $db      = $this->select("brg_beli","*", "faktur = " . $this->escape($f)) ;
        while($r = $this->getrow($db)){
            $stok    = $this->toko_m->getstok($r['id_brg']) ;
            $r['qty']= $stok ;
            $t 	   = $stok * $r['harga'] ;

            $va   = array("faktur"=>$fr, "id_brg"=>$r['id_brg'], "jenis"=>0, "tgl"=>$d,
                            "qty"=>$r['qty'], "kredit"=>$r['qty'], "harga"=>$r['harga'],
                            "total_sub"=>$t, "total"=>$t, "username"=>$username) ;
            $this->insert("brg_stok_kartu", $va) ;
        }
    }

    public function updstok_retur_beli($f, $fr){
        //update stok di posisi KREDIT
        $username= getsession($this, "username") ;
        $d       = date("Y-m-d") ;
        $db      = $this->select("brg_beli","*", "faktur = " . $this->escape($f)) ;
        while($r = $this->getrow($db)){
            $t    = $r['total'];
            $va   = array("faktur"=>$fr, "id_brg"=>$r['id_brg'], "jenis"=>0, "tgl"=>$d,
                            "qty"=>$r['qty'], "kredit"=>$r['qty'], "harga"=>$r['harga'],
                            "total_sub"=>$t, "total"=>$t, "username"=>$username) ;
            $this->insert("brg_stok_kartu", $va) ;

            //harus kembalikan hp
        }
    }

    public function updstok_jual($f){
        $d       = date("Y-m-d") ;
        $username= getsession($this, "username") ;
        $db      = $this->select("brg_jual","*", "faktur = " . $this->escape($f)) ;
        while($r = $this->getrow($db)){
            $hp   = $this->rumushp($r['id_brg'], $r['qty'], $r['harga']) ;
            $t    = $r['qty'] * $r['harga'];
            $va   = array("faktur"=>$f, "id_brg"=>$r['id_brg'], "jenis"=>1, "tgl"=>$d,
                            "qty"=>$r['qty'], "kredit"=>$r['qty'], "harga"=>$r['harga'],
                            "total_sub"=>$t, "total"=>$t, "username"=>$username, "hp"=>$hp) ;
            $this->insert("brg_stok_kartu", $va) ;
        }
    }

    public function updstok_retur_jual($f, $fr){
        //update stok di posisi KREDIT
        $username= getsession($this, "username") ;
        $d       = date("Y-m-d") ;
        $db      = $this->select("brg_jual","*", "faktur = " . $this->escape($f)) ;
        while($r = $this->getrow($db)){
            $t    = $r['total'];
            $va   = array("faktur"=>$fr, "id_brg"=>$r['id_brg'], "jenis"=>1, "tgl"=>$d,
                            "qty"=>$r['qty'], "debet"=>$r['qty'], "harga"=>$r['harga'],
                            "total_sub"=>$t, "total"=>$t, "username"=>$username) ;
            $this->insert("brg_stok_kartu", $va) ;
        }
    }

    public function updstok_opname($f){
        //update stok jika + posisi debet jika - posisi kredit
        $username= getsession($this, "username") ;
        $d       = date("Y-m-d") ;
        $db      = $this->select("brg_opname","*", "faktur = " . $this->escape($f)) ;
        while($r = $this->getrow($db)){
            $t    = abs($r['total']) ;
            $q    = abs($r['qty']) ;
            $va   = array("faktur"=>$f, "id_brg"=>$r['id_brg'], "jenis"=>3, "tgl"=>$d,
                        "qty"=>$q, "harga"=>$r['harga'],
                        "total_sub"=>$t, "total"=>$t, "username"=>$username) ;
            if($r['qty'] > 0){
                $va['debet'] = $q ;
            }else{
                $va['kredit']= $q ;
            }

            $this->insert("brg_stok_kartu", $va) ;
        }
    }

    public function getjadwalbayar($id){
        $d = "" ;
        $db      = $this->select("pelanggan","*", "kode = " . $this->escape($id)) ;
        if($r = $this->getrow($db)){
            $d = $r['tgl'] ;
        }
        return $d ;
    }
    
}
?>
