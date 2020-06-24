<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false"  onclick="bos.tcwo_form.init()">Daftar Data</a></li>
        <li class="disabled"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="cursor: not-allowed;">Data Form</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:500px"></div>
        </div>
        <div class="tab-pane" id="tab_2">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-secondary">
                    <div class="box-header with-border">
                    <?php
                        $cKODEWO         = getsession($this,"ss_KODE_WO_") ;
                        $cSUBJECTWO      = getsession($this,"ss_SUBJECT_WO_") ;
                        $cDESKRIPSIWO    = getsession($this,"ss_DESKRIPSI_WO_") ;
                        $cDATETIMEWO     = getsession($this,"ss_DATETIME_WO_") ;
                        $dTANGGALWO      = getsession($this,"ss_TANGGAL_WO_") ;
                        $cDARIWO         = getsession($this,"ss_DARI_WO_") ;
                        $vaFILEWO        = getsession($this,"ss_FILEITEM_WO_") ;
                    ?>
                    <h3 class="box-title">Kode Work Order : <?=$cKODEWO?></h3>
                    </div>
                    <div class="box-body no-padding">
                    <div class="mailbox-read-info">
                        <h3><?=$cSUBJECTWO?></h3>
                        <h5>From: <?=$cDARIWO?>
                        <span class="mailbox-read-time pull-right"><?=$cDATETIMEWO?></span></h5>
                    </div>
                    <div class="mailbox-read-message">
                        <!-- Detail WO -->
                        <?=$cDESKRIPSIWO?>
                    </div>
                    </div>
                    <div class="box-footer">
                    <?php if(count($vaFILEWO) > 0){?>
                        <ul class="mailbox-attachments clearfix">
                            <?php
                                foreach($vaFILEWO as $key => $value){
                                    $cPATHWO     = $value['FilePath'];
                                    $cFileSize   = "0.00";
                                    $cNAMAFILEWO = "File Not Found";
                                    if(file_exists($cPATHWO)){
                                        $nFileSize      = filesize($cPATHWO);
                                        $vaPATHWO       = explode("/",$cPATHWO);
                                        $cNAMAFILEWO    = end($vaPATHWO); 
                                        $cFileSize      = formatSizeUnits($nFileSize);
                                    }
                            ?>
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="fa fa-cubes"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="<?=$cPATHWO?>" class="mailbox-attachment-name" title="<?=$cNAMAFILEWO?>" target="_blank"><i class="fa fa-paperclip"></i>&nbsp;<?=substr($cNAMAFILEWO,0,22).".."?></a>
                                        <span class="mailbox-attachment-size">
                                        <?=$cFileSize?>
                                        <a href="<?=$cPATHWO?>" class="btn btn-default btn-xs pull-right" title="Download" download><i class="fa fa-cloud-download"></i></a>
                                        </span>
                                    </div>
                                </li>
                            <?php
                                }
                            ?>
                        </ul>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <form>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form Work Order</h3>                    
                        </div>
                        <div class="box-body no-padding">
                            <div class="mailbox-read-message">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="cDeskripsi" id="cDeskripsi" class="form-control" placeholder="Deskripsi" row="20">
                                        Permasalahan  :<br>
                                        Detail Solusi : 
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Upload File</label>
                                        <div id="idcUplFileFormWO">
                                            <input style="width:100%" type="file" class="form-control cUplFileFormWO" id="cUplFileFormWO" name="cUplFileFormWO[]" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="nNo" id="nNo" value="0">
            <input type="hidden" name="cKode" id="cKode">
            <input type="hidden" name="cFaktur" id="cFaktur">
            <input type="hidden" name="cLastPath" id="cLastPath">
            <button type="button" class="btn btn-primary" id="cmdFinish" onclick="bos.tcwo_form.cmdFinish();">Finish</button>
            <button type="button" class="btn btn-warning" id="cmdPending" onclick="bos.tcwo_form.cmdPending();">Pending</button>
        </form>
        </div>
    </div>
</div>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcwo_form.grid1_data    = null ;
    bos.tcwo_form.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }  
  
    bos.tcwo_form.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcwo_form.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Daftar Form WO',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'Kode', caption: 'Kode', size: '100px', sortable: false},
                { field: 'TujuanUserName', caption: 'Tujuan User', size: '250px', sortable: false},
                { field: 'Subject', caption: 'Judul', size: '150px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'UserName', caption: 'Petugas Entry', size: '100px', sortable: false},
                { field: 'cmdDetail', caption: 'Aksi', size: '100px', sortable: false, style:'text-align:center'},
                { field: 'Status', caption: 'Status', size: '50px', sortable: false},
            ]
        });
    }

    bos.tcwo_form.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }

    bos.tcwo_form.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcwo_form.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcwo_form.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcwo_form.grid1_reloaddata   = function(){
        this.grid1_setdata() ;
    }

    /******************************************** */


    /********************************************** */

    bos.tcwo_form.cmdStartWO      = function(id){
        if(confirm("Apakah anda yakin ingin mengambil WO ini?")){
            this.obj.find(".nav-tabs li:eq(1)").removeClass("disabled");
            bjs.ajax(this.url + '/startWO', 'cKode=' + id);
        }
    }
    
    bos.tcwo_form.cmdContinueWO   = function(id){
        if(confirm("Apakah anda yakin ingin mengambil WO ini?")){
            this.obj.find(".nav-tabs li:eq(1)").removeClass("disabled");
            bjs.ajax(this.url + '/startWO', 'cFaktur=' + id);
        }
    }
    bos.tcwo_form.init         = function(){
        this.obj.find('#cDeskripsi').val("");
        tinymce.activeEditor.setContent("");
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cFaktur").val("") ;
        this.obj.find("#nNo").val("0") ;
        this.obj.find("#cUplFileFormWO").val("");
        bjs.ajax(this.url + '/init') ;
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bos.tcwo_form.grid1_loaddata() ;
        bos.tcwo_form.grid1_reload() ;
    }

    bos.tcwo_form.initTinyMCE = function(){
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

    bos.tcwo_form.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;

        this.initTinyMCE() ;
        this.grid1_loaddata() ;
        this.grid1_load() ;

        bjs.ajax(this.url + '/init') ;
    }


    bos.tcwo_form.tabsaction    = function(n){
        bos.tcwo_form.grid1_render() ;
        bos.tcwo_form.init() ;
    }

    bos.tcwo_form.initCallBack = function(){
        this.obj.on("bos:tab", function(e){
            bos.tcwo_form.tabsaction( e.i )  ;
        });
        this.obj.on('remove', function(){
            bos.tcwo_form.grid1_destroy() ;
            tinymce.remove() ;
        }) ;
    }

    bos.tcwo_form.cmdFinish       = bos.tcwo_form.obj.find("#cmdFinish") ;
    bos.tcwo_form.cmdPending      = bos.tcwo_form.obj.find("#cmdPending") ;
    

    bos.tcwo_form.cmdFinish = function(){
        //e.preventDefault();
        var cDeskripsi = tinymce.get("cDeskripsi").getContent();
        var cKode      = $("#cKode").val();
        var cFaktur    = $("#cFaktur").val();
        var cOpsi      = "finish";
        bjs.ajax( bos.tcwo_form.base_url + '/saving', "cDeskripsi="+cDeskripsi+"&cKode="+cKode+"&cFaktur="+cFaktur+"&cOpsi="+cOpsi);
    }

    bos.tcwo_form.cmdPending = function(){
        //e.preventDefault();
        var cDeskripsi = tinymce.get("cDeskripsi").getContent();
        var cKode      = $("#cKode").val();
        var cFaktur    = $("#cFaktur").val();
        var cOpsi      = "pending";
        bjs.ajax( bos.tcwo_form.base_url + '/saving', "cDeskripsi="+cDeskripsi+"&cKode="+cKode+"&cFaktur="+cFaktur+"&cOpsi="+cOpsi);
    }

    bos.tcwo_form.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcwo_form.grid1_reloaddata() ;
            }
        });

        this.obj.find("#cUplFileFormWO").on("change", function(e){
            e.preventDefault() ;
            bos.tcwo_form.uname       = $(this).attr("id") ;
            bos.tcwo_form.fal         = $("#cUplFileFormWO")[0].files;//e.target.files;
            bos.tcwo_form.gfal        = new FormData() ;
            for(var i = 0; i < bos.tcwo_form.fal.length; i++){
                bos.tcwo_form.gfal.append("cUplFileFormWO[]",bos.tcwo_form.fal[i]);
            }
            bos.tcwo_form.obj.find("#idl" + bos.tcwo_form.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.tcwo_form.base_url + "/savingFile" , bos.tcwo_form.gfal, this) ;
            
        }) ;

        this.obj.find(".nav li.disabled a").click(function() {
            return false;
        });

        /*this.obj.find("#cmdFinish").on("click", function(e){
            e.preventDefault()
            bos.tcwo_form.submitForm(bos.tcwo_form.cmdFinish,"finish");
        });

        this.obj.find("#cmdPending").on("click", function(e){
            e.preventDefault()
            bos.tcwo_form.submitForm(bos.tcwo_form.cmdPending,"pending");
        });
        bos.tcwo_form.submitForm = function(cmdBtn,opsi){
            var form = bos.tcwo_form.obj.find('form').submit();
            if( bjs.isvalidform(form) ){
                bjs.ajax( bos.tcwo_form.base_url + '/saving', bjs.getdataform(form) +"&cOpsi="+ opsi, cmdBtn) ;
            }
        }*/
    }
    
    $(function(){
        bos.tcwo_form.initComp() ;
        bos.tcwo_form.initCallBack() ;
        bos.tcwo_form.initFunc() ;
    })

</script>