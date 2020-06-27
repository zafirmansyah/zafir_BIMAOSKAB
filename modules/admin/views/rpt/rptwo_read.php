<section class="content">
    <?php
        $cKode  = getsession($this,"ss_Kode_WO");
        $vaData = getsession($this,"ss_Data_FormWO");
        //print_r($vaData);
    ?>
    <div class="row">
       <div class="col-md-12">
           <ul class="timeline">
                <?php
                    foreach($vaData as $ckey=>$val){
                ?>
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-blue">
                                <?= $ckey?>
                            </span>
                        </li>
                        <!-- /.timeline-label -->
                        <?php
                            foreach($val as $key=>$value){
                                $cStatus      = $value['Status'];
                                if($cStatus == "1"){
                                    $iconWO = "fa-play bg-blue";
                                }else if($cStatus == "2"){
                                    $iconWO = "fa-envelope bg-yellow";
                                }else if($cStatus == "F"){
                                    $iconWO = "fa-check bg-green";
                                }
                                $cDeskripsi     = ($cStatus == "1") ? "On Proccess" : $value['Deskripsi'];
                                $dStartDateTime = $value['StartDateTime'];
                                $dEndDateTime   = ($cStatus == "1") ? "On Proccess" : $value['EndDateTime'];
                                $cUserName      = $value['UserName'];
                                $vaFileFormWO   = $value['File'];

                        ?>
                                <!-- timeline item -->
                                <li>
                                    <!-- timeline icon -->
                                    <i class="fa <?=$iconWO?>"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> <?=$dStartDateTime?> - <?=$dEndDateTime?></span>

                                        <h3 class="timeline-header bg-default"><a href="#"><?=$cUserName?></a> </h3>

                                        <div class="timeline-body">
                                            <?=$cDeskripsi?>
                                        </div>
                                        <div class="timeline-footer">
                                            <?php if(!empty($vaFileFormWO)){?>
                                                <ul class="mailbox-attachments clearfix">
                                                    <?php
                                                        foreach($vaFileFormWO as $key => $value){
                                                            $cPATH     = $value['FilePath'];
                                                            $cFileSize      = "0.00";
                                                            $cNAMAFILESurat = "File Not Found";
                                                            if(file_exists($cPATH)){
                                                                $nFileSize      = filesize($cPATH);
                                                                $vaPATHSurat    = explode("/",$cPATH);
                                                                $cNAMAFILESurat = end($vaPATHSurat); 
                                                                $cFileSize      = formatSizeUnits($nFileSize);
                                                            }
                                                    ?>
                                                        <li>
                                                            <span class="mailbox-attachment-icon" style="padding:0;"><i class="fa fa-cubes"></i></span>

                                                            <div class="mailbox-attachment-info">
                                                                <a href="<?=$cPATH?>" class="mailbox-attachment-name" title="<?=$cNAMAFILESurat?>" target="_blank">
                                                                    <i class="fa fa-paperclip"></i>&nbsp;<?=substr($cNAMAFILESurat,0,20).".."?>
                                                                </a>
                                                                <span class="mailbox-attachment-size">
                                                                    <?=$cFileSize?>
                                                                    <a href="<?=$cPATH?>" class="btn btn-default btn-xs pull-right" title="Download" download>
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
                                                if($cStatus == "F"){
                                                    echo('<div class="timeline-footer">
                                                            <a class="btn btn-danger btn-xs">Reject</a>
                                                        </div>');
                                                }
                                            ?>
                                        </div>
                                        
                                    </div>
                                </li>
                                <!-- END timeline item -->

                        <?php
                            }
                        ?>
                <?php
                    }
                ?>
            </ul>
       </div>
    </div>   
</section>
<script>
    <?=cekbosjs();?>
    var id = "<?=$cKode?>";
</script>