<div class="section">
    <?php
        $cIDSurat         = getsession($this,"ss_ID_M02PRINSIP_") ;
        $cKODEDISPO       = getsession($this,"ss_KODEDISPO_M02PRINSIP_") ;
        $cPERIHALSurat    = getsession($this,"ss_PERIHAL_M02PRINSIP_") ;        
        $cDARISurat       = getsession($this,"ss_DARI_M02PRINSIP_") ;
        $cDATETIMESurat   = getsession($this,"ss_DATETIME_M02PRINSIP_") ;
        $cNOSURATSurat    = getsession($this,"ss_NOSURAT_M02PRINSIP_") ;
        $cDETAILM02       = getsession($this,"ss_DETAIL_M02PRINSIP_") ;
        $dTANGGALSurat    = getsession($this,"ss_TANGGAL_M02PRINSIP_") ;
        $vaFileListSurat  = getsession($this,"ss_FILEITEM_M02PRINSIP_") ;
        
        $cDateTimePrinsip = date_create($cDATETIMESurat); 
        $dDateTimePrinsip = date_format($cDateTimePrinsip,"d-m-Y H:i");
        $dTgl             = date_create($dTANGGALSurat);
        $cTgl             = date_format($dTgl,"d M Y");
        
        $cUserNameOL      = getsession($this,"username") ;
        $cKodeKaryawanOL  = getsession($this,"KodeKaryawan") ;
        $vaTimeLineM02    = getsession($this,"ss_TIMELINE_M02PRINSIP");
        //($vaTimeLineM02);
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="timeline">
                <li class="time-label">
                    <span class="bg-light-blue">
                        <?=$cTgl ?>
                    </span>
                </li>
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-pencil" title="New"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=$dDateTimePrinsip?></span>

                        <h3 class="timeline-header bg-default"><a href="#"><?=$cDARISurat?></a> </h3>

                        <div class="timeline-body">
                            <?=$cDETAILM02?>
                        </div>
                        <div class="timeline-footer">
                            <?php if(!empty($vaFileListSurat)){?>
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
                                        <span class="mailbox-attachment-icon" style="padding:0;"><i class="fa fa-file-text-o"></i></span>

                                        <div class="mailbox-attachment-info">
                                            <a href="<?=$cPATHSurat?>" class="mailbox-attachment-name" title="<?=$cNAMAFILESurat?>" target="_blank">
                                                <i class="fa fa-paperclip"></i>&nbsp;<?=substr($cNAMAFILESurat,0,20).".."?>
                                            </a>
                                            <span class="mailbox-attachment-size">
                                                <?=$cFileSize?>
                                                <a href="<?=$cPATHSurat?>" class="btn btn-default btn-xs pull-right" title="Download" download>
                                                    <i class="fa fa-cloud-download"></i
                                                ></a>
                                            </span>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            <?php
                                }
                            ?>
                        </div>
                        
                    </div>
                </li>
                <!-- END timeline item -->
                <?php
                if(!empty($vaTimeLineM02)){
                    foreach($vaTimeLineM02 as $ckey=>$val){
                        $dTglTimeLine = date_create($ckey);
                        $cTglTimeLine = date_format($dTglTimeLine,"d M Y");
                ?>
                <li class="time-label">
                    <span class="bg-blue">
                        <?=$cTglTimeLine ?>
                    </span>
                </li>
                <?php
                    foreach($val as $key=>$value){
                        $cStatus = $value['Status'];
                        if($cStatus == "1"){
                            $iconTimeline  = "fa-check bg-green";
                            $titleTimeline = "Acc"; 
                        }else if($cStatus == "3"){
                            $iconTimeline  = "fa-times bg-red";
                            $titleTimeline = "Ditolak"; 
                        }
                ?>
                <li>
                    <!-- timeline icon -->
                    <i class="fa <?=$iconTimeline?>" title="<?=$titleTimeline?>"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=$value['DateTime']?></span>

                        <h3 class="timeline-header bg-default"><a href="#"><?=$value['UserName']?></a> </h3>

                        <div class="timeline-body">
                            <?=$value['Keterangan']?>
                        </div>
                        
                    </div>
                </li>
                <?php
                }
                ?>
                <!-- END timeline item -->
                <?php
                    }
                }
                ?>
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>     
            </div>
        </div>
    </div>
</div>