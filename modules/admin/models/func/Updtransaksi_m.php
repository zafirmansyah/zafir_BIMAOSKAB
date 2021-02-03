<?php
class Updtransaksi_m extends Bismillah_Model{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('func/perhitungan_m') ;
    }

    public function updAnggaranPSBIX()
    {
        echo('alert("kasjdh");');
    }

    public function updAnggaranPSBI($cFaktur,$dTgl,$cGolongan,$cKeterangan,$nNominal,$cUsername='',$lUpdMutasiAnggaran=true){
        $dTgl       = date_2s($dTgl);
        $cDateTime  = date("Y-m-d H:i:s") ;
        if($cUsername == "") $cUsername  = getsession($this, "username") ;
        $vaArray        = array("Faktur"=>$cFaktur,
                                "GolonganPSBI"=>$cGolongan,
                                "Tgl"=>$dTgl,
                                "Status"=>'1',
                                "Keterangan"=>sql_2sql($cKeterangan),
                                "Debet"=>string_2n($nNominal),
                                "DateTime"=>$cDateTime,
                                "UserName"=>$cUsername);
        $this->insert("psbi_mutasi_anggaran",$vaArray);

        if($lUpdMutasiAnggaran) $this->updMutasiPSBI($cFaktur,'psbi_mutasi_anggaran');
    }
    public function updRealisasiPSBI($cKode,$dTgl,$optGolonganPSBI,$dTglKegiatan,$cNamaKegiatan,$cPenerimaManfaat,$cTujuanManfaat,$cRuangLingkup,
                                    $nPengajuan,$optLokasiPSBI,$cDetailLokasi,$cPesertaPartisipan,$cPermasalahan,$dTglProposal,$cNoSuratProposal,
                                    $cJenisBantuan,$cDetailBantuan,$cKodeM02,$dTglM02,$cVendor,$dTglRealisasi,$nRealisasi,$cUsername='',$lUpdMutasiRealisasi=true)
                                    
    {
        $cDateTime  = date("Y-m-d H:i:s") ;
        if($cUsername == "") $cUsername  = getsession($this, "username") ;
        $vaArray = array("Kode"=>$cKode,
                            "NomorRekap"=>"",
                            "WaktuKegiatan"=>date_2s($dTglKegiatan),
                            "NamaKegiatan"=>$cNamaKegiatan,
                            "PenerimaManfaat"=>$cPenerimaManfaat,
                            "TujuanManfaat"=>$cTujuanManfaat,
                            "RuangLingkup"=>$cRuangLingkup,
                            "NilaiPengajuan"=>$nPengajuan,
                            "LokasiKegiatan"=>$optLokasiPSBI,
                            "DetailLokasi"=>$cDetailLokasi,
                            "PesertaPartisipan"=>$cPesertaPartisipan,
                            "Permasalahan"=>$cPermasalahan,
                            "TanggalProposal"=>date_2s($dTglProposal),
                            "NomorSuratProposal"=>$cNoSuratProposal,
                            "JenisBantuan"=>$cJenisBantuan,
                            "DetailBantuan"=>$cDetailBantuan,
                            "KodeM02Persetujuan"=>$cKodeM02,
                            "TanggalPersetujuan"=>date_2s($dTglM02),
                            "TanggalRealisasi"=>date_2s($dTglRealisasi),
                            "Vendor"=>$cVendor,
                            "PIC"=>$cUsername,
                            "GolonganPSBI"=>$optGolonganPSBI,
                            "NilaiRealisasi"=>$nRealisasi,
                            "Tgl"=>date_2s($dTgl)) ;
        $this->update("psbi_realisasi",$vaArray,"Kode = '{$cKode}'");

        if($lUpdMutasiRealisasi){
            $this->updMutasiPSBI($cKode,'psbi_realisasi');
        }
    }

    public function updMutasiPSBI($cFaktur,$cSegmen){

        $this->delete("psbi_mutasi","Faktur = '{$cFaktur}'") ;

        $cField     = "*";
        $cWhereField = "Faktur" ;
        if($cSegmen == "psbi_realisasi") $cWhereField = "Kode" ;
        $cWhere     = "$cWhereField = '$cFaktur'" ;
        $dbData     = $this->select($cSegmen, $cField, $cWhere) ;
        while($dbr = $this->getrow($dbData)){

            if($cSegmen == "psbi_realisasi"){
                $dbr['Faktur']      = $dbr['Kode'];
                $dbr['Rekening']    = "";
                $dbr['Tgl']         = $dbr['TanggalRealisasi'] ;
                $dbr['Status']      = "1" ;
                $dbr['Keterangan']  = $dbr['NamaKegiatan'] ;
                $dbr['Debet']       = 0 ;
                $dbr['Kredit']      = $dbr['NilaiRealisasi'];
                $dbr['DateTime']    = "";
                $dbr['UserName']    = "";
            }

            $vaArray    = array("Faktur"=>$dbr['Faktur'],
                                "GolonganPSBI"=>$dbr['GolonganPSBI'],
                                "Rekening"=>$dbr['Rekening'],
                                "Tgl"=>$dbr['Tgl'],
                                "Status"=>$dbr['Status'],
                                "Keterangan"=>$dbr['Keterangan'],
                                "Debet"=>$dbr['Debet'],
                                "Kredit"=>$dbr['Kredit'],
                                "DateTime"=>$dbr['DateTime'],
                                "UserName"=>$dbr['UserName']);
            $this->update("psbi_mutasi",$vaArray,"Faktur = '{$dbr['Faktur']}'");
        }
    }

    public function deleteRealisasiPSBI($cKode){
        $this->delete('psbi_realisasi',"Kode = '{$cKode}'") ;
        $this->delete('psbi_mutasi',"Faktur = '{$cKode}'") ;
    }
    
}
?>
