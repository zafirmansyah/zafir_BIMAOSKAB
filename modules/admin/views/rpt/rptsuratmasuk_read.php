<section class="content">
    <div class="row">
        <div class="col-md-3">
            <?php $this->load->view('rptlistfolder_suratmasuk');?>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                <?php
                    $cIDSurat        = getsession($this,"ss_ID_SuratMasuk_") ;
                    $cPERIHALSurat   = getsession($this,"ss_PERIHAL_SuratMasuk_") ;
                    $cDARISurat      = getsession($this,"ss_DARI_SuratMasuk_") ;
                    $cDATETIMESurat  = getsession($this,"ss_DATETIME_SuratMasuk_") ;
                    $cNOSURATSurat   = getsession($this,"ss_NOSURAT_SuratMasuk_") ;
                    $vaFileListSurat = getsession($this,"ss_FILEITEM_SuratMasuk_");
                ?>
                <h3 class="box-title">Read Mail : ID. <?=$cIDSurat?></h3>
                </div>
                <div class="box-body no-padding">
                <div class="mailbox-read-info">
                    <h3><?=$cPERIHALSurat?></h3>
                    <h5>From: <?=$cDARISurat?>
                    <span class="mailbox-read-time pull-right"><?=$cDATETIMESurat?></span></h5>
                </div>
                <div class="mailbox-read-message">
                    <!-- Detail Surat -->
                </div>
                </div>
                <div class="box-footer">
                <ul class="mailbox-attachments clearfix">
                    <?php
                        foreach($vaFileListSurat as $key => $value){
                            $cPATHSurat     = $value['FilePath'];
                            $cFileSize      = "0.00";
                            $cNAMAFILESurat = "File Not Found";
                            if(file_exists($cPATHSurat)){
                                $nFileSize      = filesize($cPATHSurat);
                                $vaPATHSurat    = explode("/",$cPATHSurat);
                                $cNAMAFILESurat = end($vaPATHSurat); 
                                $cFileSize      = formatSizeUnits($nFileSize);
                            }
                    ?>
                        <li>
                            <span class="mailbox-attachment-icon"><i class="fa fa-cubes"></i></span>

                            <div class="mailbox-attachment-info">
                                <a href="<?=$cPATHSurat?>" class="mailbox-attachment-name" title="<?=$cNAMAFILESurat?>" target="_blank"><i class="fa fa-paperclip"></i>&nbsp;<?=substr($cNAMAFILESurat,0,22).".."?></a>
                                <span class="mailbox-attachment-size">
                                <?=$cFileSize?>
                                <a href="<?=$cPATHSurat?>" class="btn btn-default btn-xs pull-right" download><i class="fa fa-cloud-download"></i></a>
                                </span>
                            </div>
                        </li>
                    <?php
                        }
                    ?>
                </ul>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                        <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                    </div>
                    <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
                    <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</section>