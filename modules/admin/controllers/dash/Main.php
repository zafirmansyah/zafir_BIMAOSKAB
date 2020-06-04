<?php
class Main extends Bismillah_Controller{
    private $bdb;
    public function __construct(){
        parent::__construct() ;
        // $this->load->model("dash/main_m") ;
        // $this->load->model("include/perhitungan_m") ;
    }

    public function index(){
        $this->load->view("dash/main") ;
    }

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