<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH ."third_party/excel/PHPExcel.php";
require APPPATH ."third_party/pdf/class.ezpdf.php";

class bospdf extends Cezpdf{
   public function __construct($o=array()){
      $od    = array('paper'=>'LETTER', 'orientation'=>'portrait','export'=>0 ,'opt'=>array(), 'lpagenumber'=>FALSE) ;
      $op    = array_merge($od, $o) ;

      parent::__construct($op['paper'],$op['orientation'],$op['export'],$op['opt'],$op['lpagenumber']) ;
   }
}
?>
