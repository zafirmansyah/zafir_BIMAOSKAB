<?php
   function getcons_jenis($i=0){
      $r   = "Baru Tetap" ;
      switch ($i) {
         case '1':
            $r   = "Perpanjangan" ;
            break;
         case '2':
            $r   = "Insidental" ;
            break;
      }
      return $r;
   }

   function getcons_status($i=0){
      $r   = "Belum terpasang" ;
      switch ($i) {
         case '1':
            $r   = "Terpasang" ;
            break;
         case '2':
            $r   = "Dilepas" ;
            break;
      }
      return $r;
   }
?>
