<?php

    class Dshaboutme extends Bismillah_Controller
    {
        public function __construct(){
            parent::__construct() ;
            // $this->load->model("dash/main_m") ;
            // $this->load->model("include/perhitungan_m") ;
        }
    
        public function index(){
            $this->load->view("dash/dshaboutme") ;
        }
    }
    

?>