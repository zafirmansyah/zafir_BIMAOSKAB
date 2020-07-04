<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                <?php
                    $cIDSurat        = getsession($this,"ss_ID_M02PRINSIP_") ;
                    $cKODEDISPO      = getsession($this,"ss_KODEDISPO_M02PRINSIP_") ;
                    $cPERIHALSurat   = getsession($this,"ss_PERIHAL_M02PRINSIP_") ;
                    $cDARISurat      = getsession($this,"ss_DARI_M02PRINSIP_") ;
                    $cDATETIMESurat  = getsession($this,"ss_DATETIME_M02PRINSIP_") ;
                    $cNOSURATSurat   = getsession($this,"ss_NOSURAT_M02PRINSIP_") ;
                    $cDETAILM02      = getsession($this,"ss_DETAIL_M02PRINSIP_") ;
                    $dTANGGALSurat   = getsession($this,"ss_TANGGAL_M02PRINSIP_") ;
                    $vaFileListSurat = getsession($this,"ss_FILEITEM_M02PRINSIP_") ;
                    
                    $cUserNameOL     = getsession($this,"username") ;
                    $cKodeKaryawanOL = getsession($this,"KodeKaryawan") ;
                ?>
                <b><h3>Detail M.02 Persetujuan Prinsip No. <?=$cNOSURATSurat?></h3></b>
                </div>
                <div class="box-body no-padding">
                    <div class="mailbox-read-info">
                        <h3><?=$cPERIHALSurat?></h3>
                        <h5>From: <?=$cDARISurat?>
                        <span class="mailbox-read-time pull-right"><?=$cDATETIMESurat?></span></h5>
                    </div>
                    <div class="mailbox-read-message">
                        <?=$cDETAILM02?>
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
                                    <a href="<?=$cPATHSurat?>" class="btn btn-default btn-xs pull-right" title="Download" download><i class="fa fa-cloud-download"></i></a>
                                    </span>
                                </div>
                            </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
                <div class="box-footer">
                    <?php
                        if($cUserNameOL !== $cDARISurat){
                            ?>
                                <div class="pull-left">
                                    <button type="button" class="btn btn-danger" onclick="bos.rptm02_prinsip_read.cmdReject('<?=$cIDSurat?>','<?=$cKODEDISPO?>','<?=$cKodeKaryawanOL?>')"><i class="fa fa-times"></i> Tolak</button>
                                    <button type="button" class="btn btn-success" onclick="bos.rptm02_prinsip_read.cmdAccept('<?=$cIDSurat?>','<?=$cKODEDISPO?>','<?=$cKodeKaryawanOL?>')"><i class="fa fa-check"></i> Setujui</button>
                                </div>      
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>   
</section>

<div class="modal fade" id="modalReject" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="wm-title">Alasan Penolakan</h4>
                </div>
                <div class="modal-body" style="margin-bottom: 10px;">
                    <textarea name="cPenolakan" id="cPenolakan" class="form-control col-md-12" placeholder="Alasan penolakan..."></textarea><br>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <input type="hidden" name="cFakturDokumen" id="cFakturDokumen">
                        <input type="hidden" name="cKodeDispo" id="cKodeDispo">
                        <input type="hidden" name="cKodeKaryawan" id="cKodeKaryawan">
                        <button class="btn btn-danger" id="cmdActReject"><i class="fa fa-times"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAccept" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="wm-title">Upload Dokumen Persetujuan</h4>
                </div>
                <div class="modal-body" style="margin-bottom: 10px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Upload File</label>
                            <div id="idcUplFile">
                                <input style="width:100%" type="file" class="form-control cUplFile" id="cUplFile" name="cUplFile[]" multiple>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <input type="text" name="cFakturDokumenAcc" id="cFakturDokumenAcc">
                        <input type="text" name="cKodeDispoAcc" id="cKodeDispoAcc">
                        <input type="text" name="cKodeKaryawanAcc" id="cKodeKaryawanAcc">
                        <button class="btn btn-danger" id="cmdActAccept"><i class="fa fa-check"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    <?=cekbosjs();?>
    var id = "<?=$cIDSurat?>";
    
    bos.rptm02_prinsip_read.cmdReject = function(cFaktur,cKodeDispo,cKodeKaryawan){
        $("#cFakturDokumen").val(cFaktur);
        $("#cKodeDispo").val(cKodeDispo);
        $("#cKodeKaryawan").val(cKodeKaryawan);
        bos.rptm02_prinsip_read.loadModalReject("show");
    }

    bos.rptm02_prinsip_read.cmdAccept = function(cFaktur,cKodeDispo,cKodeKaryawan){
        $("#cFakturDokumenAcc").val(cFaktur);
        $("#cKodeDispoAcc").val(cKodeDispo);
        $("#cKodeKaryawanAcc").val(cKodeKaryawan);
        bos.rptm02_prinsip_read.loadModalAccept("show");
    }

    bos.rptm02_prinsip_read.cmdPilih      = function(kode){
        bjs.ajax(this.url + '/selectTargetDisposisi', 'kode=' + kode);
    }

    bos.rptm02_prinsip_read.loadModalAccept      = function(l){
        this.obj.find("#modalAccept").modal(l) ;
    }
    
    bos.rptm02_prinsip_read.loadModalReject       = function(l){
        this.obj.find("#modalReject").modal(l) ;
    }
    
    bos.rptm02_prinsip_read.initCallBack = function(){
        this.obj.on('remove', function(){
            // bos.rptm02_prinsip_read.gridDisposisi_destroy() ;
            // bos.rptm02_prinsip_read.grid3_destroy() ;
        }) ;
    }

    bos.rptm02_prinsip_read.cmdActReject  = bos.rptm02_prinsip_read.obj.find("#cmdActReject") ;
    bos.rptm02_prinsip_read.cmdActAccept  = bos.rptm02_prinsip_read.obj.find("#cmdActAccept") ;
    bos.rptm02_prinsip_read.initFunc     = function(){
        this.obj.find("#cmdDisposisi").on("click", function(e){
            bos.rptm02_prinsip_read.loadModalDisposisi("show");
            bos.rptm02_prinsip_read.grid3_reloaddata() ;
        }) ;

        this.obj.find('#cmdActReject').on("click",function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                cPenolakan      = $('#cPenolakan').val() ;
                cFakturDokumen  = $('#cFakturDokumen').val() ;
                cKodeDispo      = $('#cKodeDispo').val() ;
                cKodeKaryawan   = $('#cKodeKaryawan').val() ;
                bjs.ajax( bos.rptm02_prinsip_read.base_url + '/actReject', 'cPenolakan='+cPenolakan+
                                                                            '&cFakturDokumen='+cFakturDokumen+
                                                                            '&cKodeDispo='+cKodeDispo+
                                                                            '&cKodeKaryawan='+cKodeKaryawan
                        , bos.rptm02_prinsip_read.cmdActReject) ;
            }
        });

        this.obj.find('#cmdActAccept').on("click",function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                cFakturDokumen  = $('#cFakturDokumenAcc').val() ;
                cKodeDispo      = $('#cKodeDispoAcc').val() ;
                cKodeKaryawan   = $('#cKodeKaryawanAcc').val() ;
                bjs.ajax( bos.rptm02_prinsip_read.base_url + '/actAccept', 'cPenolakan='+cPenolakan+
                                                                            '&cFakturDokumen='+cFakturDokumen+
                                                                            '&cKodeDispo='+cKodeDispo+
                                                                            '&cKodeKaryawan='+cKodeKaryawan
                        , bos.rptm02_prinsip_read.cmdActAccept) ;
            }
        });

        this.obj.find("#cUplFile").on("change", function(e){
            e.preventDefault() ;
            bos.rptm02_prinsip_read.uname       = $(this).attr("id") ;
            bos.rptm02_prinsip_read.fal         = $("#cUplFile")[0].files;
            bos.rptm02_prinsip_read.gfal        = new FormData() ;
            for(var i = 0; i < bos.rptm02_prinsip_read.fal.length; i++){
                bos.rptm02_prinsip_read.gfal.append("cUplFile[]",bos.rptm02_prinsip_read.fal[i]);
            }
            bos.rptm02_prinsip_read.obj.find("#idl" + bos.rptm02_prinsip_read.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.rptm02_prinsip_read.base_url + "/savingFile" , bos.rptm02_prinsip_read.gfal, this) ;
            
        }) ;
    }
    
    bos.rptm02_prinsip_read.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        
        // this.gridDisposisi_load() ;
        // this.gridDisposisi_reload() ;

        // // this.grid3_loaddata() ;
        // this.grid3_load() ;
        $("#gridDisposisi").css("display","none") ;        
        bjs.ajax(this.url + '/init') ;
        bjs.ajax(this.url + '/getData', 'cKode=' + id);
    }
    $(function(){
        bos.rptm02_prinsip_read.initComp();
        bos.rptm02_prinsip_read.initCallBack() ;
        bos.rptm02_prinsip_read.initFunc() ;
    })
</script>