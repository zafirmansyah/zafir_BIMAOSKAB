<?php

class Livapply extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        // $this->load->model("liv/livapply_m") ;
        // $this->bdb = $this->livapply_m ;
    }

    public function index(){
        $this->load->view("liv/livapply") ;
    }

}

?>