<?php

class Utlconf extends Bismillah_Controller{

    private $bdb;
    public function __construct(){
        parent::__construct() ;
        // $this->load->model('include/func_m') ;
        // $this->load->model("config/config_m") ;
        // $this->bdb = $this->config_m;
    }

    public function index(){
        $this->load->view("config/utlconf") ;
    }

}