<?php
class Main extends Bismillah_Controller{
    private $bdb;
    public function __construct(){
        parent::__construct() ;
        $this->load->model("dash/main_m") ;
        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;
        $this->bdb = $this->main_m ;
        // $this->load->model("include/perhitungan_m") ;
    }

    public function index(){
        $nJmlSuratMasuk = $this->bdb->getJumlahSuratMasukPerUser();
        $nJmlM02        = $this->bdb->getJumlahM02();
        $nJmlIKU        = $this->bdb->getJumlahIKU();
        $nJmlWO         = $this->bdb->getJumlahWO();
        $vaDataWO       = $this->getDataWOPerUnit();
        $vaDataIKU      = $this->bdb->getDataIKUPerUnit();

        $var = array();
        $var['Jumlah'] = array( 'JmlSuratMasuk'=>$nJmlSuratMasuk,
                                'JmlM02'       =>$nJmlM02,
                                'JmlIKU'       =>$nJmlIKU,
                                'JmlWO'        =>$nJmlWO
                                );
        $var['DataWO']  = $vaDataWO;
        $var['DataIKU'] = $vaDataIKU;
        $var['unit']    = getsession($this,"unit");
        $var['keteranganUnit'] = $this->bdb->getKeteranganUnit($var['unit']);
        $this->load->view("dash/main",$var) ;
    }

    
    public function getDataWOPerUnit()
    {
        $vaDataWO = $this->bdb->getDataWOPerUnit();
        foreach($vaDataWO as $key=>$value){
            $cStatus                = $value['Status'];
            $cCaseClosed            = $this->bdb->getStatusCaseClosed($value['Kode']);
            $cTextStatus                = "<span class='text-default'>New</span>";
            if($cStatus == "1"){ //proses
                $cTextStatus  = "<span class='text-info'>Proses</span>";
            }else if($cStatus == "2"){ //pending
                $cTextStatus  = "<span class='text-warning'>Pending</span>";
            }else if($cStatus == "3"){ // reject
                $cTextStatus  = "<span class='text-danger'>Reject</span>";
            }else if($cStatus == "F"){ // finish
                $cTextStatus  = "<span class='text-success'>Finish</span>";
                if($cCaseClosed == "1"){
                    $cTextStatus  = "<span class='text-success'><i class='fa fa-check'></i>&nbsp;Case Closed</span>";
                }
            }
            $vaDataWO[$key]['TextStatus'] = $cTextStatus;
        }
        return $vaDataWO;
    }

    /*
    public function getDataWOPerUser()
    {
        $vaDataWO = $this->bdb->getDataWOPerUser();
        foreach($vaDataWO as $key=>$value){
            $cStatus                = $value['Status'];
            $cCaseClosed            = $this->bdb->getStatusCaseClosed($value['Kode']);
            $cTextStatus                = "<span class='text-default'>New</span>";
            if($cStatus == "1"){ //proses
                $cTextStatus  = "<span class='text-info'>Proses</span>";
            }else if($cStatus == "2"){ //pending
                $cTextStatus  = "<span class='text-warning'>Pending</span>";
            }else if($cStatus == "3"){ // reject
                $cTextStatus  = "<span class='text-danger'>Reject</span>";
            }else if($cStatus == "F"){ // finish
                $cTextStatus  = "<span class='text-success'>Finish</span>";
                if($cCaseClosed == "1"){
                    $cTextStatus  = "<span class='text-success'><i class='fa fa-check'></i>&nbsp;Case Closed</span>";
                }
            }
            $vaDataWO[$key]['TextStatus'] = $cTextStatus;
        }
        return $vaDataWO;
    }
    */
        // public function loaddata(){
        //     $stockjml = $this->main_m->getcountstock();
        //     echo(' $("#boxstock").html("'.$stockjml.'");') ;

        //     $totpenj = $this->main_m->getpenjualantot();
        //     echo(' $("#boxomset").html("Rp '.number_format($totpenj['jmlpenj'],2).'");') ;
        //     echo(' $("#boxpngunjung").html("'.$totpenj['jmlfkt'].'");') ;

        //     $labels = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        //     $labels = json_encode($labels);

        //     $data = array();

        //     //minggu ini
        //     $tglnow = date("Y-m-d");
        //     $dnow = date("w",strtotime($tglnow));
        //     $tglawalweek = date("Y-m-d",strtotime($tglnow) - ($dnow*60*60*24));
        //     $omsetmingini = array(0,0,0,0,0,0,0);
        //     for($i=0;$i<=$dnow;$i++){
        //         $tgl = date("Y-m-d",strtotime($tglawalweek) + ($i*60*60*24));
        //         $analisapm = $this->perhitungan_m->GetAnalisaProfitMargin($tgl,$tgl);
        //         $omsetmingini[$i] = $analisapm['total'];
        //     }
            
        //     //minggu kemarin
        //     $dnow = $dnow + 7;
        //     $tglawalweek1 = date("Y-m-d",strtotime($tglnow) - ($dnow*60*60*24));
        //     $omsetmingkemarin = array(0,0,0,0,0,0,0);
        //     for($i=0;$i<=7;$i++){
        //         $tgl = date("Y-m-d",strtotime($tglawalweek1) + ($i*60*60*24));
        //         $analisapm = $this->perhitungan_m->GetAnalisaProfitMargin($tgl,$tgl);
        //         $omsetmingkemarin[$i] = $analisapm['total'];
        //     }

        //     $data[] = array("label"=>"Minggu Ini","data"=>$omsetmingini,"backgroundColor"=>array("rgba(255, 99, 132, 0.2)"),
        //                    "borderColor"=>array("rgba(255,99,132,1)"),"borderWidth"=>1);
        //     $data[] = array("label"=>"Minggu Kemarin","data"=>$omsetmingkemarin,"backgroundColor"=>array("rgba(54, 162, 235, 0.2)"),
        //                    "borderColor"=>array("rgba(54, 162, 235, 1)"),"borderWidth"=>1);
        //     $data = json_encode($data);    
        //     echo('
        //     var labels = '.$labels.';
        //     var ctx = document.getElementById("chartomsetmingguan").getContext("2d");
        //     var myChart = new Chart(ctx, {
        //         type: "line",
        //         data: {
        //             labels: labels,
        //             datasets: '.$data.'
        //         },
        //         options: {
        //             scales: {
        //                 yAxes: [{
        //                     ticks: {
        //                         beginAtZero:true
        //                     }
        //                 }]
        //             }
        //         }
        //     });

        //    ');
        // }
}
?>