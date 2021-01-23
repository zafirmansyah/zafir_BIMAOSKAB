<?php

class DPSBI_m extends Bismillah_Model 
{
    public function getTotalRealisasibyLokasi($cKodeLokasi,$dTglAwal,$dTglAkhir) 
    {
        $nSaldo = $this->func->getTotalRealisasibyLokasi($cKodeLokasi,$dTglAwal,$dTglAkhir);
        return $nSaldo ;
    }
}


?>