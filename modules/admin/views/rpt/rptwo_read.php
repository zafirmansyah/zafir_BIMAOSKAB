<section class="content">
    <?php
        $cKode            = getsession($this,"ss_Kode_WO");
        $vaDataWO         = getsession($this,"ss_Data_WO"); 
        $vaDataForm       = getsession($this,"ss_Data_FormWO");
        //print_r($vaDataWO);
        //print_r($vaDataForm);
        $dTgl             = date_create($vaDataWO['DateTime']);
        $cTgl             = date_format($dTgl,"d M Y");
        $cDeskripsi       = $vaDataWO['Deskripsi'];
        $dStartDateTimeWO = $vaDataWO['StartDateTime'];
        $cUserNameWO      = $vaDataWO['UserName'];
        $vaFileWO         = $vaDataWO['File'];
        $lUserAcc         = ($vaDataWO['UserName'] == getsession($this,"username")) ? true : false; // filter supaya hanya user yg input WO yg bisa ACC 
    ?>
    <div class="row">
       <div class="col-md-12">
           <ul class="timeline">
                <li class="time-label">
                    <span class="bg-blue">
                        <?=$cTgl ?>
                    </span>
                </li>
                <!-- timeline item -->
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-pencil" title="New"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=$dStartDateTimeWO?></span>

                        <h3 class="timeline-header bg-default"><a href="#"><?=$cUserNameWO?></a> </h3>

                        <div class="timeline-body">
                            <?=$cDeskripsi?>
                        </div>
                        <div class="timeline-footer">
                            <?php if(!empty($vaFileWO)){?>
                                <ul class="mailbox-attachments clearfix">
                                    <?php
                                        foreach($vaFileWO as $key => $value){
                                            $cPATH     = $value['FilePath'];
                                            $cFileSize = $value['FileSize'];
                                            $cNAMAFILE = $value['FileName'];
                                    ?>
                                        <li>
                                            <span class="mailbox-attachment-icon" style="padding:0;"><i class="fa fa-file-text-o"></i></span>

                                            <div class="mailbox-attachment-info">
                                                <a href="<?=$cPATH?>" class="mailbox-attachment-name" title="<?=$cNAMAFILE?>" target="_blank">
                                                    <i class="fa fa-paperclip"></i>&nbsp;<?=substr($cNAMAFILE,0,20).".."?>
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
                            ?>
                        </div>
                        
                    </div>
                </li>
                <!-- END timeline item -->

                <?php
                if(!empty($vaDataForm)){
                foreach($vaDataForm as $ckey=>$val){
                    $dTglForm = date_create($ckey);
                    $cTglForm = date_format($dTglForm,"d M Y");
                ?>
                    <!-- timeline time label -->
                    <li class="time-label">
                        <span class="bg-blue">
                            <?=$cTglForm ?>
                        </span>
                    </li>
                    <!-- /.timeline-label -->
                    <?php
                    foreach($val as $key=>$value){
                        $cFaktur = $value['Faktur']; 
                        $cStatus = $value['Status'];
                        $cCaseClosed = $value['CaseClosed'];
                        if($cStatus == "1"){
                            $iconFormWO  = "fa-play bg-blue";
                            $titleFormWO = "Proses"; 
                        }else if($cStatus == "2"){
                            $iconFormWO  = "fa-pause bg-yellow";
                            $titleFormWO = "Pending";
                        }else if($cStatus == "F"){
                            $iconFormWO  = "fa-check bg-green";
                            $titleFormWO = "Finish";
                        }else if($cStatus == "3"){
                            $iconFormWO  = "fa-times bg-red";
                            $titleFormWO = "Reject";
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
                            <i class="fa <?=$iconFormWO?>" title="<?= $titleFormWO?>"></i>
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
                                                    $cFileSize = $value['FileSize'];
                                                    $cNAMAFILE = $value['FileName'];
                                            ?>
                                                <li>
                                                    <span class="mailbox-attachment-icon" style="padding:0;"><i class="fa fa-file-text-o"></i></span>

                                                    <div class="mailbox-attachment-info">
                                                        <a href="<?=$cPATH?>" class="mailbox-attachment-name" title="<?=$cNAMAFILE?>" target="_blank">
                                                            <i class="fa fa-paperclip"></i>&nbsp;<?=substr($cNAMAFILE,0,20).".."?>
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
                                        if($cStatus == "F" && $cCaseClosed == "0" & $lUserAcc){
                                        ?>
                                            <div class="timeline-footer">
                                                <button class="btn btn-danger btn-xs" onclick="bos.rptwo_read.cmdOpenRejectForm('<?=$cFaktur?>');">Reject</button>
                                                <button class="btn btn-success btn-xs" onclick="bos.rptwo_read.cmdFinish('<?=$cFaktur?>');"> Finish</button>       
                                                
                                            </div>
                                        <?php
                                        }else if($cStatus == "F" && $cCaseClosed == "1"){
                                            echo("<div class='alert alert-success'>Work Order Case Closed!</div>");
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
                }
                ?>
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>                
            </ul>
       </div>
    </div>   
</section>
<div class="modal" id="modal-reject">
    <form>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>
                        Reject Work Order <span id="faktur-wo-modal"></span>
                    </h4>    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label title="*Wajib diisi">Alasan Reject*</label>
                                <textarea name="cDeskripsi" id="cDeskripsi" class="form-control" row="20"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="cKode" id="cKode">
                        <input type="hidden" name="cFaktur" id="cFaktur">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-danger" id="cmdReject" onclick="bos.rptwo_read.cmdReject();"><i class="fa fa-times"></i> Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    <?=cekbosjs();?>
    var id = "<?=$cKode?>";

    bos.rptwo_read.cmdOpenRejectForm = function(cFaktur){
        $("#faktur-wo-modal").text(cFaktur);
        $("#cFaktur").val(cFaktur);
        $("#cKode").val(id);
        bos.rptwo_read.loadModalReject("show");
    }

    bos.rptwo_read.loadModalReject       = function(l){
        this.obj.find("#modal-reject").modal(l) ;
    }


    bos.rptwo_read.showSwalInfo = function(title,msg='',icon){
        Swal.fire({
            title: title,
            text: msg,
            icon: icon,
        });
    }
    
    bos.rptwo_read.showSwalConfirm = function(title,msg,icon,func='',params=''){
        Swal.fire({
            title: title,
            text: msg,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya yakin!',
            cancelButtonText: 'Batal!'
        }).then((result) => {
            if (result.value) {
                if(func !== "" && params !== ""){
                    bjs.ajax(this.url + func, params);
                }else{
                    bos.rptwo_read.showSwalInfo("Data Saved!","","success");
                }
            }
        });
    }

    bos.rptwo_read.initDetail            = function(){
        this.obj.find("#cKode").val("") ;;
        tinymce.activeEditor.setContent("");
    }
    
    bos.rptwo_read.initCallBack = function(){
        this.obj.on('remove', function(){
            tinymce.remove() ;
        }) ;
    }

    bos.rptwo_read.initTinyMCE = function(){
        tinymce.init({
            selector: '#cDeskripsi',
            height: 250,
            file_browser_callback_types: 'file image media',
            file_picker_types: 'file image media',   
            forced_root_block : "",
            force_br_newlines : true,
            force_p_newlines : false,
        });
    }

    bos.rptwo_read.cmdFinish = function(cFaktur){
        var title = "Apakah Anda Yakin?";
        var msg   = "Anda akan menyelesaikan WO ini";
        var cKode      = id;
        var cFaktur    = cFaktur;
        var cOpsi      = "finish";
        bos.rptwo_read.showSwalConfirm(title,msg,"warning","/saving","cKode="+cKode+"&cFaktur="+cFaktur+"&cOpsi="+cOpsi);
    }

    bos.rptwo_read.cmdReject = function(){
        var cDeskripsi = tinymce.get("cDeskripsi").getContent();
        if(cDeskripsi == ""){
            bos.rptwo_read.showSwalInfo("Alasan Reject Wajib Diisi","","warning");
        }else{
            var cKode      = $("#cKode").val();
            var cFaktur    = $("#cFaktur").val();
            var cOpsi      = "reject";
            var title = "Apakah Anda Yakin?";
            var msg   = "Anda akan me-reject WO ini";
            bos.rptwo_read.showSwalConfirm(title,msg,"warning","/saving","cDeskripsi="+cDeskripsi+"&cKode="+cKode+"&cFaktur="+cFaktur+"&cOpsi="+cOpsi);
            //bjs.ajax( bos.rptwo_read.base_url + '/saving', "cDeskripsi="+cDeskripsi+"&cKode="+cKode+"&cFaktur="+cFaktur+"&cOpsi="+cOpsi);
        }
    }

    bos.rptwo_read.backToMasterWO = function(){
        objForm    = "rptwo" ;
        locForm    = "admin/rpt/rptwo" ;
        setTimeout(function(){
            bjs.form({
                "module" : "Administrator",
                "name"   : "",
                "obj"    : objForm, 
                "loc"    : locForm
            });
        }, 1);
    }

    bos.rptwo_read.initFunc     = function(){
       
    }
    
    bos.rptwo_read.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
              
        this.initTinyMCE() ;
        bjs.ajax(this.url + '/init') ;
    }
    $(function(){
        bos.rptwo_read.initComp();
        bos.rptwo_read.initCallBack() ;
        bos.rptwo_read.initFunc() ;
        bos.rptwo_read.initDetail();
    })
</script>