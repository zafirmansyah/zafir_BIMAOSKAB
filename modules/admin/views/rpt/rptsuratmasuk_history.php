<div class="section" style="margin-top:20px;">
    <?php
        
        $cIDSurat        = getsession($this,"ss_ID_SuratMasuk_") ;
        $cPERIHALSurat   = getsession($this,"ss_PERIHAL_SuratMasuk_") ;
        $cDARISurat      = getsession($this,"ss_DARI_SuratMasuk_") ;
        $cDATETIMESurat  = getsession($this,"ss_DATETIME_SuratMasuk_") ;
        $cNOSURATSurat   = getsession($this,"ss_NOSURAT_SuratMasuk_") ;
        $dTANGGALSurat   = getsession($this,"ss_TANGGAL_SuratMasuk_") ;
        $vaFileListSurat = getsession($this,"ss_FILEITEM_SuratMasuk_") ;
        
        $vaHistory = getsession($this,"ss_HISTORY_SuratMasuk_");
        //print_r($vaHistory);
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="timeline">
                <?php
                foreach($vaHistory as $key=>$value){
                
                ?>
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-envelope bg-blue" title="Diteruskan"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=$value['DateTime']?></span>

                        <h3 class="timeline-header bg-default">
                            <a href="#">
                                <?=$value['Pendisposisi']?>
                                <i class="fa fa-arrow-right"></i>
                                <?=$value['Terdisposisi']?>
                            </a> 
                        </h3>

                        <div class="timeline-body">
                            <?=$value['Deskripsi']?>
                        </div>
                        
                    </div>
                </li>
                
                <?php
                }
                ?>
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-history bg-gray"></i>
                    
                </li>     
            </div>
        </div>
    </div>
</div>