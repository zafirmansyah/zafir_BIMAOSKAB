<?php
class Updtransaksi_m extends Bismillah_Model{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('func/perhitungan_m') ;
    }
    public function updjurnal($faktur,$cabang,$tgl='0000-00-00',$rekening,$keterangan,$debet=0,$kredit=0,$datetime='0000-00-00 00:00:00',$username=''){
        $tgl = date_2s($tgl);
        $arr  = array("faktur"=>$faktur,"cabang"=>$cabang,"tgl"=>$tgl,"rekening"=>$rekening,
                      "keterangan"=>sql_2sql($keterangan),"debet"=>string_2n($debet),"kredit"=>string_2n($kredit),
                       "datetime"=>$datetime,"username"=>$username);
        $this->insert("keuangan_jurnal",$arr);
    }
    
    public function updbukubesar($faktur,$cabang,$tgl='0000-00-00',$rekening,$keterangan,$debet=0,$kredit=0,$datetime='0000-00-00 00:00:00',$username=''){
        if($debet >0 or $kredit > 0){
            $tgl = date_2s($tgl);
            $arr  = array("faktur"=>$faktur,"cabang"=>$cabang,"tgl"=>$tgl,"rekening"=>$rekening,
                          "keterangan"=>sql_2sql($keterangan),"debet"=>string_2n($debet),"kredit"=>string_2n($kredit),
                          "datetime"=>$datetime,"username"=>$username);
            $this->insert("keuangan_bukubesar",$arr);
        }
    }

    public function updrekjurnal($faktur){
        $this->delete("keuangan_bukubesar", "faktur = '$faktur'" ) ;
        $where    = "faktur = '$faktur'";
        $join     = "";
        $field    = "faktur,cabang,tgl,rekening,keterangan,debet,kredit,datetime,username";
        $dbd      = $this->select("keuangan_jurnal", $field, $where, $join, "", "debet desc") ;
        while( $dbr = $this->getrow($dbd) ){
            $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$dbr['rekening'],$dbr['keterangan'],$dbr['debet'],$dbr['kredit'],$dbr['datetime'],$dbr['username']);
        }
    }
    public function updkartustock($faktur,$stock,$tgl='0000-00-00',$gudang,$cabang,$keterangan,$debet=0,$kredit=0,$hp=0,$username=''){
        if($debet >0 or $kredit > 0){
            if($username == '')$username = getsession($this, "username");
            $vainsert = array("faktur"=>$faktur,"stock"=>$stock,"tgl"=>$tgl,"keterangan"=>$keterangan,"debet"=>$debet,"kredit"=>$kredit,
                              "gudang"=>$gudang,"cabang"=>$cabang,"hp"=>$hp,"username"=>$username);
            $this->insert("stock_kartu",$vainsert);
        }
    }
    /********************pembelian*******************************/
    public function updkartustockreturpembelian($faktur){
        $this->delete("stock_kartu", "faktur = '$faktur'" ) ;
        $field      = "d.faktur,d.stock,d.harga,d.qty,d.totalitem,t.username,t.tgl,t.gudang,t.cabang,s.nama";
        $where      = "d.faktur = '$faktur'";
        $join       = "left join pembelian_retur_total t on t.faktur = d.faktur left join supplier s on s.kode = t.supplier";

        $dbd        = $this->select("pembelian_retur_detail d", $field, $where, $join, "") ;
        while($dbr  = $this->getrow($dbd)){
            $hp = 0;
            $keterangan = "pembelian stock ".$dbr['nama'];
            if($dbr['totalitem'] > 0 and $dbr['qty'] > 0) $hp = $dbr['totalitem'] / $dbr['qty'];
            $this->updkartustock($faktur,$dbr['stock'],$dbr['tgl'],$dbr['gudang'],$dbr['cabang'],$keterangan,0,$dbr['qty'],
                                 $hp,$dbr['username']);
        }
    }

    public function updkartustockpembelian($faktur){
        $this->delete("stock_kartu", "faktur = '$faktur'" ) ;
        $field = "d.faktur,d.stock,d.harga,d.qty,d.totalitem,d.username,t.tgl,t.gudang,t.cabang";
        $where = "d.faktur = '$faktur'";
        $join = "left join pembelian_total t on t.faktur = d.faktur";
        $keterangan = "pembelian stock fkt[".$faktur."]";
        $dbd      = $this->select("pembelian_detail d", $field, $where, $join, "") ;
        while($dbr = $this->getrow($dbd)){
            $hp = 0;
            if($dbr['totalitem'] > 0 and $dbr['qty'] > 0) $hp = $dbr['totalitem'] / $dbr['qty'];
            $this->updkartustock($faktur,$dbr['stock'],$dbr['tgl'],$dbr['gudang'],$dbr['cabang'],$keterangan,$dbr['qty'],
                                 0,$hp,$dbr['username']);
            $this->hitunghpp($dbr['stock'],$dbr['tgl']);
        }
    }
    
    public function updrekpembelian($faktur){
        $rekkas = getsession($this, "rekkas") ;
        $this->delete("keuangan_bukubesar", "faktur = '$faktur'" ) ;
        $field = "t.faktur,t.tgl,t.cabang,s.nama,t.subtotal,t.diskon,t.ppn,t.total,t.hutang,t.kas,t.username,t.datetime_insert datetime";
        $where = "t.faktur = '$faktur'";
        $join = "left join supplier s on s.kode = t.supplier";
        $dbd      = $this->select("pembelian_total t", $field, $where, $join, "") ;
        while($dbr = $this->getrow($dbd)){
            $vapersd = array();
            $f = "d.stock,d.harga,d.qty,d.jumlah,d.totalitem,g.keterangan,g.rekpersd,s.stock_group";
            $w = "d.faktur = '$faktur'";
            $j = "left join stock s on s.kode = d.stock left join stock_group g on g.kode = s.stock_group";
            $dbd2      = $this->select("pembelian_detail d", $f, $w, $j, "") ;
            while($dbr2 = $this->getrow($dbd2)){
                if(!isset($vapersd[$dbr2['stock_group']]))$vapersd[$dbr2['stock_group']] = array("jml"=>0,"rekpersd"=>$dbr2['rekpersd'],"keterangan"=>$dbr2['keterangan']);
                $vapersd[$dbr2['stock_group']]['jml'] += $dbr2['totalitem'];
            }

            foreach($vapersd as $key => $val){
                $ket= "Persd. Pembelian ".$val['keterangan'];
                $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$val['rekpersd'],$ket,$val['jml'],0,$dbr['datetime'],$dbr['username']);
            }

            $ket= "Kas Pembelian ".$dbr['nama'];
            $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$rekkas,$ket,0,$dbr['kas'],$dbr['datetime'],$dbr['username']);

            $ket= "Disc. Pembelian ".$dbr['nama'];
            $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$this->getconfig("rekpbdisc"),$ket,0,$dbr['diskon'],$dbr['datetime'],$dbr['username']);

            $ket= "PPn Pembelian ".$dbr['nama'];
            $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$this->getconfig("rekpbppn"),$ket,$dbr['ppn'],0,$dbr['datetime'],$dbr['username']);
        }
    }
    
    public function updrekreturpembelian($faktur){
        $rekkas = getsession($this, "rekkas") ;
        $this->delete("keuangan_bukubesar", "faktur = '$faktur'" ) ;
        $field = "t.faktur,t.tgl,t.cabang,s.nama,t.subtotal,t.total,t.kas,t.username,t.datetime";
        $where = "t.faktur = '$faktur'";
        $join = "left join supplier s on s.kode = t.supplier";
        $dbd      = $this->select("pembelian_retur_total t", $field, $where, $join, "") ;
        while($dbr = $this->getrow($dbd)){
            $vapersd = array();
            $f = "d.stock,d.harga,d.qty,d.jumlah,d.totalitem,g.keterangan,g.rekpersd,s.stock_group";
            $w = "d.faktur = '$faktur'";
            $j = "left join stock s on s.kode = d.stock left join stock_group g on g.kode = s.stock_group";
            $dbd2      = $this->select("pembelian_retur_detail d", $f, $w, $j, "") ;
            while($dbr2 = $this->getrow($dbd2)){
                if(!isset($vapersd[$dbr2['stock_group']]))$vapersd[$dbr2['stock_group']] = array("jml"=>0,"rekpersd"=>$dbr2['rekpersd'],"keterangan"=>$dbr2['keterangan']);
                $vapersd[$dbr2['stock_group']]['jml'] += $dbr2['totalitem'];
            }

            foreach($vapersd as $key => $val){
                $ket= "Persd. Retur Pembelian ".$val['keterangan'];
                $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$val['rekpersd'],$ket,0,$val['jml'],$dbr['datetime'],$dbr['username']);
            }

            $ket= "Kas Pembelian ".$dbr['nama'];
            $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$rekkas,$ket,$dbr['kas'],0,$dbr['datetime'],$dbr['username']);


        }
    }

    public function hitunghpp($kode,$tgl){
        $tglkemarin = date("Y-m-d",strtotime($tgl)-(60*60*24));
        $stock = $this->perhitungan_m->GetSaldoAkhirStock($kode,$tglkemarin);
        $hpp = $this->perhitungan_m->GetHPPStock($kode,$tglkemarin);
        $nilaipers = $hpp * $stock;
        $field = "sum(d.hp * d.debet) as jml,sum(d.debet) as qty,d.cabang";
        $where = "d.stock = '$kode' and d.tgl = '$tgl' and d.faktur like 'PB%'";
        $join = "";
        $dbd      = $this->select("stock_kartu d", $field, $where, $join, "") ;
        if($dbr = $this->getrow($dbd)){
            $nilaipers += $dbr['jml'] ;
            $stock += $dbr['qty'] ;
            $hppskrg = 0;
            if($dbr['qty'] > 0 and $dbr['jml']> 0) $hppdkrg = $nilaipers / $stock;
            if($hppdkrg <> $hpp){
                $arr = array("tgl"=>$tgl,"kode"=>$kode,"hp"=>$hppdkrg,"cabang"=>$dbr['cabang']);
                $where = "tgl = '$tgl' and kode = '$kode'";
                $this->update('stock_hp',$arr,$where,"");
            }


        }
    }
    /***************************************************/

    /********************penjualan*******************************/
    public function updkartustockpenjualan($faktur){
        $field = "d.id,d.faktur,d.stock,d.harga,d.qty,d.totalitem,d.username,t.tgl,t.gudang,t.cabang";
        $where = "d.faktur = '$faktur'";
        $join = "left join penjualan_total t on t.faktur = d.faktur";
        $keterangan = "Penjualan kasir fkt[".$faktur."]";
        $dbd      = $this->select("penjualan_detail d", $field, $where, $join, "") ;
        while($dbr = $this->getrow($dbd)){
            $hp = 0;
            $this->updkartustock($faktur,$dbr['stock'],$dbr['tgl'],$dbr['gudang'],$dbr['cabang'],$keterangan,0,$dbr['qty'],$hp,$dbr['username']);

            //HITUNG HPP
            $hp = $this->perhitungan_m->GetHPPStock($dbr['stock'],$dbr['tgl']);
            $vaArray = array("hp"=>$hp);
            $this->edit('penjualan_detail',$vaArray,"id = {$dbr['id']}");
        }
    }
    
    public function updrekpenjualan($faktur){
        $rekkas = getsession($this, "rekkas") ;
        $this->delete("keuangan_bukubesar", "faktur = '$faktur'" ) ;
        $field = "t.faktur,t.tgl,t.cabang,s.nama,t.subtotal,t.total,t.kas,t.username,t.datetime_update datetime";
        $where = "t.faktur = '$faktur'";
        $join = "left join customer s on s.kode = t.customer";
        $dbd      = $this->select("penjualan_total t", $field, $where, $join, "") ;
        while($dbr = $this->getrow($dbd)){
            $vapersd = array();
            $f = "d.stock,d.harga,d.qty,d.jumlah,d.totalitem,g.keterangan,g.rekpersd,s.stock_group,g.rekhpp,g.rekpj,d.hp";
            $w = "d.faktur = '$faktur'";
            $j = "left join stock s on s.kode = d.stock left join stock_group g on g.kode = s.stock_group";
            $dbd2      = $this->select("penjualan_detail d", $f, $w, $j, "") ;
            while($dbr2 = $this->getrow($dbd2)){
                if(!isset($vapersd[$dbr2['stock_group']]))$vapersd[$dbr2['stock_group']] = array("jml"=>0,"hpp"=>0,"rekpersd"=>$dbr2['rekpersd'],"rekhpp"=>$dbr2['rekhpp'],"rekpj"=>$dbr2['rekpj'],"keterangan"=>$dbr2['keterangan']);
                $vapersd[$dbr2['stock_group']]['jml'] += $dbr2['totalitem'];
                $vapersd[$dbr2['stock_group']]['hpp'] += $dbr2['hp'];
            }
            
            $ket= "Kas Penjualan ".$dbr['nama'];
            $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$rekkas,$ket,$dbr['total'],0,$dbr['datetime'],$dbr['username']);

            foreach($vapersd as $key => $val){
                $ket= "Penjualan ".$val['keterangan']." - ".$dbr['nama'];
                $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$val['rekpj'],$ket,0,$val['jml'],$dbr['datetime'],$dbr['username']);
                
                $ket= "HPP ".$val['keterangan'];
                $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$val['rekhpp'],$ket,$val['hpp'],0,$dbr['datetime'],$dbr['username']);
                $this->updbukubesar($dbr['faktur'],$dbr['cabang'],$dbr['tgl'],$val['rekpersd'],$ket,0,$val['hpp'],$dbr['datetime'],$dbr['username']);
            }

        }
    }
    /***************************************************/

    /********************opname*******************************/
    public function updkartustockopname($faktur){
        $this->delete("stock_kartu", "faktur = '$faktur'" ) ;
        $field = "d.faktur,d.kode,d.saldo,d.qty,d.debet,d.kredit,t.tgl,t.gudang,t.cabang,t.username,t.datetime";
        $where = "d.faktur = '$faktur'";
        $join = "left join opnamestock_total t on t.faktur = d.faktur";
        $dbd      = $this->select("opnamestock_detail d", $field, $where, $join, "") ;
        while($dbr = $this->getrow($dbd)){
            $hp = 0;
            $keterangan = "opnamestock stock SA.".$dbr['saldo']." -> SO ".$dbr['qty'];
            $this->updkartustock($faktur,$dbr['kode'],$dbr['tgl'],$dbr['gudang'],$dbr['cabang'],$keterangan,$dbr['debet'],
                                 $dbr['kredit'],$hp,$dbr['username']);
        }
    }
    /***************************************************/
    /********************mutasi stock*******************************/
    public function updkartustockmutasi($faktur){
        $this->delete("stock_kartu", "faktur = '$faktur'" ) ;
        $field = "d.faktur,d.kode,d.qty,d.debet,d.kredit,t.tgl,t.gudang,t.cabang,t.username,t.datetime";
        $where = "d.faktur = '$faktur'";
        $join = "left join stock_mutasi_total t on t.faktur = d.faktur";
        $dbd      = $this->select("stock_mutasi_detail d", $field, $where, $join, "") ;
        while($dbr = $this->getrow($dbd)){
            $hp = 0;
            $keterangan = "Mutasi stock";
            $this->updkartustock($faktur,$dbr['kode'],$dbr['tgl'],$dbr['gudang'],$dbr['cabang'],$keterangan,$dbr['debet'],
                                 $dbr['kredit'],$hp,$dbr['username']);
        }
    }
    /***************************************************/
    /**********Posting*****************************************/
    public function postingharian($tglawal,$tglakhir){
        $this->delete("stock_kartu", "tgl >= '$tglawal' and tgl <= '$tglakhir'" ) ;
        $this->delete("stock_hp", "tgl >= '$tglawal' and tgl <= '$tglakhir'" ) ;

        //PEMBELIAN
        $where = "tgl >= '$tglawal' and tgl <= '$tglakhir' and status = '1'";
        $dbd      = $this->select("pembelian_total","faktur", $where, "", "") ;
        while($dbr = $this->getrow($dbd)){
            $this->updkartustockpembelian($dbr['faktur']);
        }

        //PENJUALAN KASIR
        $where = "tgl >= '$tglawal' and tgl <= '$tglakhir' and status = '1'";
        $dbd      = $this->select("penjualankasir_total","faktur", $where, "", "") ;
        while($dbr = $this->getrow($dbd)){
            $this->updkartustockpenjualankasir($dbr['faktur']);
        }

        //OPNAME STOCK
        $where = "tgl >= '$tglawal' and tgl <= '$tglakhir' and status = '1'";
        $dbd      = $this->select("opnamestock_total","faktur", $where, "", "") ;
        while($dbr = $this->getrow($dbd)){
            $this->updkartustockopname($dbr['faktur']);
        }

        //MUTASI STOCK
        $where = "tgl >= '$tglawal' and tgl <= '$tglakhir' and status = '1'";
        $dbd      = $this->select("stock_mutasi_total","faktur", $where, "", "") ;
        while($dbr = $this->getrow($dbd)){
            $this->updkartustockmutasi($dbr['faktur']);
        }
    }
    /***************************************************/
}
?>
