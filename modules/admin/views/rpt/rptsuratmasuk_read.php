<section class="content">
    <div class="row">
        <!--div class="col-md-3">
            <?php $this->load->view('rptlistfolder_suratmasuk');?>
        </div-->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                <?php
                    $cIDSurat        = getsession($this,"ss_ID_SuratMasuk_") ;
                    $cPERIHALSurat   = getsession($this,"ss_PERIHAL_SuratMasuk_") ;
                    $cDARISurat      = getsession($this,"ss_DARI_SuratMasuk_") ;
                    $cDATETIMESurat  = getsession($this,"ss_DATETIME_SuratMasuk_") ;
                    $cNOSURATSurat   = getsession($this,"ss_NOSURAT_SuratMasuk_") ;
                    $dTANGGALSurat   = getsession($this,"ss_TANGGAL_SuratMasuk_") ;
                    $cDESKRIPSISURAT = getsession($this,"ss_DESKRIPSI_SuratMasuk_");
                    $vaFileListSurat = getsession($this,"ss_FILEITEM_SuratMasuk_") ;
                    $vaDispoListSurat = getsession($this,"ss_DISPOSISILIST_SuratMasuk_") ;
                ?>
                <h3 class="box-title">Kode Surat : <?=$cIDSurat?></h3>
                </div>
                <div class="box-body no-padding">
                <div class="mailbox-read-info">
                    <h3><b><?=$cPERIHALSurat?></b></h3>
                    <h5>Dari: <b><?=$cDARISurat?></b>
                    <span class="mailbox-read-time pull-right"><?=$cDATETIMESurat?></span></h5>
                    <h5>
                        Sudah Terdisposisi :
                        <?php
                            if(isset($vaDispoListSurat) && count($vaDispoListSurat) > 0){
                                foreach($vaDispoListSurat as $key => $value){
                                    $cFullName  = $value['fullname'];
                                    ?>
                                        <span class="label label-info"><?=$cFullName?></span>
                                    <?php
                                }
                            }
                        ?>
                    </h5>
                </div>
                <div class="mailbox-read-message">
                    <!-- Detail Surat -->
                    <?=$cDESKRIPSISURAT?>
                </div>
                </div>
                <div class="box-footer">
                <ul class="mailbox-attachments clearfix">
                    <?php
                        if(isset($vaFileListSurat) && count($vaFileListSurat) > 0){
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
                        }else{
                            echo "File Not Found :(";
                        }
                    ?>
                </ul>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" onclick="bos.rptsuratmasuk_read.cmdForward('<?=$cIDSurat?>')"><i class="fa fa-share"></i> Forward</button>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</section>
<div class="modal fade" id="modal-forward">
    <form>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>
                        Forward Surat <span id="kode-surat-modal"></span>
                    </h4>    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Disposisi</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="cDisposisi" name="cDisposisi" class="form-control" placeholder="Klik tombol pencarian untuk memasukkan data disposisi..." readonly>
                                <span class="input-group-btn">
                                    <button class="form-control btn btn-info" type="button" id="cmdDisposisi"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary" id="cmdOK">OK</button>
                        </div>
                        <div class="col-md-12">
                            &nbsp;
                        </div>
                        <div class="col-md-12">
                            <div id="gridDisposisi" class="full-height" style="height: 120px;"></div>
                        </div>
                        <input type="hidden" name="nNo" id="nNo" value="0">
                        <input type="hidden" name="cKodeKaryawan" id="cKodeKaryawan">
                        <input type="hidden" name="dTgl" id="dTgl" value="<?= date('Y-m-d');?>">
                        <input type="hidden" name="cKode" id="cKode">
                        <input type="hidden" name="cLastPath" id="cLastPath">
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="cDeskripsi" id="cDeskripsi" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button class="btn btn-default" id="cmdSend"><i class="fa fa-share"></i> Forward as</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modalDisposisi" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="wm-title">Daftar User</h4>
            </div>
            <div class="modal-body">
                <div id="grid3" style="height:250px"></div>
            </div>
            <div class="modal-footer">
                *Pilih User
            </div>
        </div>
    </div>
</div>
<script>
    <?=cekbosjs();?>
    var id = "<?=$cIDSurat?>";

    bos.rptsuratmasuk_read.cmdForward = function(cKode){
        $("#kode-surat-modal").text(cKode);
        $("#cKode").val(cKode);
        bos.rptsuratmasuk_read.loadModalForward("show");
        bos.rptsuratmasuk_read.gridDisposisi_reload() ;
    }

    /******************************************** */

    bos.rptsuratmasuk_read.gridDisposisi_load    = function(){
        this.obj.find("#gridDisposisi").w2grid({
            name    : this.id + '_gridDisposisi',
            show: {
                footer      : true,
                toolbar     : false,
                toolbarColumns  : false,
                lineNumbers: true
            },
            columns: [
                { field: 'level', caption: 'Urutan Tujuan', size: '100px', sortable: false },
                { field: 'kode', caption: 'Kode Karyawan', size: '150px', sortable: false },
                { field: 'disposisi', caption: 'Nama Karyawan', size: '200px', sortable: false },
                { field: 'cmdDeleteGr', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.rptsuratmasuk_read.gridDisposisi_destroy     = function(){
        if(w2ui[this.id + '_gridDisposisi'] !== undefined){
            w2ui[this.id + '_gridDisposisi'].destroy() ;
        }
    }

    bos.rptsuratmasuk_read.gridDisposisi_reload      = function(){
        w2ui[this.id + '_gridDisposisi'].reload() ;
    }

    bos.rptsuratmasuk_read.gridDisposisi_append    = function(no,kodekaryawan,disposisi){
        var datagrid  = w2ui[this.id + '_gridDisposisi'].records;
        var recid     = "";
        if(no <= datagrid.length){
            recid = no;
            w2ui[this.id + '_gridDisposisi'].set(recid,{level: no, 
                                                        kode:kodekaryawan, 
                                                        disposisi: disposisi});
        }else{
            recid = no;
            var Hapus = "<button type='button' onclick = 'bos.rptsuratmasuk_read.gridDisposisi_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridDisposisi'].add([
                {   recid:recid,
                    level: no,
                    kode:kodekaryawan,
                    disposisi:disposisi,
                    cmdDeleteGr:Hapus}
            ]) ;
        }
        bos.rptsuratmasuk_read.initDetail();
        bos.rptsuratmasuk_read.obj.find("#cmdDisposisi").focus() ;
    }

    bos.rptsuratmasuk_read.gridDisposisi_deleterow = function(recid){
        if(confirm("Anda yakin untuk menghilangkan data pada nomor "+ recid +" ini ???")){
            w2ui[this.id + '_gridDisposisi'].select(recid);
            w2ui[this.id + '_gridDisposisi'].delete(true);
            bos.rptsuratmasuk_read.gridDisposisi_urutkan();
            bos.rptsuratmasuk_read.initDetail();

        }
    }

    bos.rptsuratmasuk_read.gridDisposisi_render  = function(){
        this.obj.find("#gridDisposisi").w2render(this.id + '_gridDisposisi') ;
    }

    bos.rptsuratmasuk_read.gridDisposisi_clear   = function(){
        w2ui[this.id + '_gridDisposisi'].clear();
    }

    bos.rptsuratmasuk_read.gridDisposisi_urutkan = function(){
        var datagrid = w2ui[this.id + '_gridDisposisi'].records;
        w2ui[this.id + '_gridDisposisi'].clear();
        for(i=0;i<datagrid.length;i++){
            var no = i+1;
            datagrid[i]["recid"] = no;
            var recid = no;
            var Hapus = "<button type='button' onclick = 'bos.rptsuratmasuk_read.gridDisposisi_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridDisposisi'].add({recid:recid,level: recid, 
                                                              kode: datagrid[i]["kode"],
                                                              disposisi: datagrid[i]["disposisi"],
                                                              cmdDeleteGr:Hapus});
        }
    }

    /******************************************** */
    /******************************************** */
    //grid3 Disposisi
    bos.rptsuratmasuk_read.grid3_data    = null ;
    bos.rptsuratmasuk_read.grid3_loaddata= function(){
        this.grid3_data         = {} ;
    }

    bos.rptsuratmasuk_read.grid3_load    = function(){
        this.obj.find("#grid3").w2grid({
            name    : this.id + '_grid3',
            limit   : 100 ,
            url     : bos.rptsuratmasuk_read.base_url + "/loadGridDataUserDisposisi",
            postData: this.grid3_data ,
            show: {
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false
            },
            multiSearch     : false,
            columns: [
                { field: 'fullname', caption: 'Nama', size: '200px', sortable: false },
                { field: 'unit', caption: 'Satuan Unit', size: '100px', sortable: false },
                { field: 'cmdPilih', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.rptsuratmasuk_read.grid3_setdata = function(){
        w2ui[this.id + '_grid3'].postData   = this.grid3_data ;
    }
    bos.rptsuratmasuk_read.grid3_reload      = function(){
        w2ui[this.id + '_grid3'].reload() ;
    }
    bos.rptsuratmasuk_read.grid3_destroy     = function(){
        if(w2ui[this.id + '_grid3'] !== undefined){
            w2ui[this.id + '_grid3'].destroy() ;
        }
    }

    bos.rptsuratmasuk_read.grid3_render  = function(){
        this.obj.find("#grid3").w2render(this.id + '_grid3') ;
    }

    bos.rptsuratmasuk_read.grid3_reloaddata  = function(){
        this.grid3_loaddata() ;
        this.grid3_setdata() ;
        this.grid3_reload() ;
    }
    /*********************************************/
    bos.rptsuratmasuk_read.cmdPilih      = function(kode){
        bjs.ajax(this.url + '/selectTargetDisposisi', 'kode=' + kode);
    }

    bos.rptsuratmasuk_read.loadModalDisposisi      = function(l){
        this.obj.find("#modalDisposisi").modal(l) ;
    }
    
    bos.rptsuratmasuk_read.loadModalForward       = function(l){
        this.obj.find("#modal-forward").modal(l) ;
    }

    bos.rptsuratmasuk_read.initDetail            = function(){
        var datagrid = w2ui[this.id + '_gridDisposisi'].records;
        tinymce.activeEditor.setContent("");
        this.obj.find("#nNo").val(datagrid.length+1) ;
        this.obj.find("#cDisposisi").val("") ;
        this.obj.find("#cKodeKaryawan").val("") ;;
    }
    
    bos.rptsuratmasuk_read.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptsuratmasuk_read.gridDisposisi_destroy() ;
            bos.rptsuratmasuk_read.grid3_destroy() ;
            tinymce.remove() ;
        }) ;
    }

    bos.rptsuratmasuk_read.cmdSend       = bos.rptsuratmasuk_read.obj.find("#cmdSend") ;
    bos.rptsuratmasuk_read.initFunc     = function(){
        this.gridDisposisi_reload() ;
        this.obj.find("#cmdDisposisi").on("click", function(e){
            bos.rptsuratmasuk_read.loadModalDisposisi("show");
            bos.rptsuratmasuk_read.grid3_reloaddata() ;
        }) ;

        this.obj.find("#cmdOK").on("click", function(e){
            var no                  = bos.rptsuratmasuk_read.obj.find("#nNo").val();
            var kodekaryawan        = bos.rptsuratmasuk_read.obj.find("#cKodeKaryawan").val();
            var disposisi           = bos.rptsuratmasuk_read.obj.find("#cDisposisi").val();
            $("#gridDisposisi").css("display","block") ;
            if(disposisi !== ""){
                bos.rptsuratmasuk_read.gridDisposisi_reload() ;
                bos.rptsuratmasuk_read.gridDisposisi_append(no,kodekaryawan,disposisi);
            }else{
                Swal.fire({
                    icon    : "error",
                    title   : "Error",
                    html    : "Data Disposisi Harus Dipilih terlebih dahulu"
                });    
            }
        }) ;

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                var dataGridDisposisi   = w2ui['bos-form-rptsuratmasuk_read_gridDisposisi'].records;
                dataGridDisposisi       = JSON.stringify(dataGridDisposisi);
                var cDeskripsi          = $("#cDeskripsi").val();
                bjs.ajax( bos.rptsuratmasuk_read.base_url + '/saving', bjs.getdataform(this)+"&dataDisposisi="+dataGridDisposisi, bos.rptsuratmasuk_read.cmdSend) ;
            }
        }) ;
    }
    bos.rptsuratmasuk_read.initTinyMCE = function(){
        tinymce.init({
            selector: '#cDeskripsi',
            height: 150,
            file_browser_callback_types: 'file image media',
            file_picker_types: 'file image media',   
            forced_root_block : "",
            force_br_newlines : true,
            force_p_newlines : false,
        });
    }

    bos.rptsuratmasuk_read.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        
        this.gridDisposisi_load() ;
        this.gridDisposisi_reload() ;

        this.initTinyMCE() ;
        this.grid3_loaddata() ;
        this.grid3_load() ;
        $("#gridDisposisi").css("display","none") ;        
        bjs.ajax(this.url + '/init') ;
        bjs.ajax(this.url + '/getData', 'cKode=' + id);
    }
    $(function(){
        bos.rptsuratmasuk_read.initComp();
        bos.rptsuratmasuk_read.initCallBack() ;
        bos.rptsuratmasuk_read.initFunc() ;
        bos.rptsuratmasuk_read.initDetail();
    })
</script>